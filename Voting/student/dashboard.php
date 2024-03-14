<?php
include('connect.php');

session_start(); // Start the session

// Retrieve the matric number of the logged-in user from the session
$matric_no = $_SESSION['matric'];

// Prepare the SQL query to retrieve the voter name for the logged-in matric number
$query = "SELECT voter_name FROM voters WHERE matric_no = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "s", $matric_no);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

// Function to retrieve available posts
function getAvailablePosts($con) {
    $query = "SELECT * FROM post";
    $result = mysqli_query($con, $query);
    $posts = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }
    return $posts;
}

// Function to retrieve candidates and their pictures for a selected post
function getCandidatesForPost($con, $postName) {
    $query = "SELECT cand_name, cand_pix FROM candidates WHERE post_name = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $postName);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $candidates = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $candidates[] = $row; // Store candidate data
    }
    return $candidates;
}

// Check if post_name is set in the request
if(isset($_GET['post_name'])) {
    $postName = $_GET['post_name'];
    // Retrieve candidates and pictures for the selected post
    $candidates = getCandidatesForPost($con, $postName);

    // Return candidate data as JSON response
    header('Content-Type: application/json');
    echo json_encode($candidates);
    exit; // Stop further execution
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting System - Student Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <style>
        .candidate.voted {
            filter: grayscale(100%);
            pointer-events: none;
        }
        
        .confirmation-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        
        .confirmation-box {
            background-color: white;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        
        .confirmation-box p {
            margin: 0;
            font-size: 18px;
        }
        
        .btn-container {
            margin-top: 20px;
        }
        
        .btn-yes, .btn-no {
            padding: 10px 20px;
            margin: 0 10px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        
        .btn-yes:hover, .btn-no:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Navigation and logout button -->
        <nav class="navbar">
            <a href="../index.php" class="logout-btn">Logout</a>
        </nav>

        <!-- User information section -->
        <section class="user-section">
            <h1>Welcome, <span>
            <?php 
            // Check if $row is set and not null
            if (isset($row['voter_name']) && !is_null($row['voter_name'])) {
                // Display user's name directly from $row['voter_name']
                echo $row['voter_name']; 
            } else {
                // If $row is not set or null, fallback to a default message
                echo "[User's Name]";
            }
            ?>
            </span></h1>
            <!-- Display user profile information here -->
            <div class="profile-info">
                <!-- User profile details such as name, ID, etc. -->
                <div class="profile-detail">
                    <label>Name:</label>
                    <?php
                    // Check if $row is set and not null
                    if (isset($row['voter_name']) && !is_null($row['voter_name'])) {
                        // Display user's name directly from $row['voter_name']
                        echo '<span>' . $row['voter_name'] . '</span>';
                    } else {
                        // If $row is not set or null, fallback to default message
                        echo '<span>[User\'s Name]</span>';
                    }
                    ?>
                </div>
                <div class="profile-detail">
                    <label>Matric Number:</label>
                    <span><?php echo isset($_SESSION['matric']) ? $_SESSION['matric'] : "[User's ID]"; ?></span>
                </div>
                <!-- Add more profile details as needed -->
            </div>
        </section>

        <!-- Voting information section -->
        <section class="voting-section">
            <h2>Voting Information</h2>
            <!-- Display voting information here -->
            <div class="voting-info">
                <!-- Display available posts as a dropdown selector -->
                <div class="available-posts">
                    <h3>Available Posts</h3>
                    <select class="post-dropdown">
                        <option value="">Select a Post</option>
                        <?php
                        $posts = getAvailablePosts($con);
                        foreach ($posts as $post) {
                            echo '<option value="' . $post['post_name'] . '">' . $post['post_name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <!-- Display candidates for selected post -->
                <div class="candidates-for-post">
                    <h3>Candidates</h3>
                    <!-- This section will be populated dynamically based on the post selected -->
                </div>
            </div>
        </section>
    </div>

    <!-- Confirmation overlay -->
    <div class="confirmation-overlay" style="display: none;">
        <div class="confirmation-box">
            <p>Are you sure you want to continue?</p>
            <div class="btn-container">
                <button class="btn-yes">Yes</button>
                <button class="btn-no">No</button>
            </div>
        </div>
    </div>

    <script>
// JavaScript to handle post dropdown change and retrieve candidates for the selected post
const postDropdown = document.querySelector('.post-dropdown');
const candidatesForPost = document.querySelector('.candidates-for-post');

// Load voted candidates from the server-side
let votedCandidates = {};

// Function to retrieve voted candidates from the server-side
function loadVotedCandidates() {
    fetch('get_voted_candidates.php')
        .then(response => response.json())
        .then(data => {
            votedCandidates = data;
            console.log('Voted candidates:', votedCandidates);
        })
        .catch(error => console.error('Error loading voted candidates:', error));
}

// Call the function to load voted candidates when the page loads
window.addEventListener('load', loadVotedCandidates);

postDropdown.addEventListener('change', () => {
    const postName = postDropdown.value;
    if (postName) {
        // AJAX request to retrieve candidates and pictures for the selected post
        fetch('?post_name=' + encodeURIComponent(postName))
            .then(response => response.json())
            .then(data => {
                // Clear previous candidates
                candidatesForPost.innerHTML = '';
                // Display candidates
                data.forEach(candidate => {
                    const candidateDiv = document.createElement('div');
                    candidateDiv.classList.add('candidate');
                    // Create an image element for the candidate picture
                    const img = document.createElement('img');
                    img.src = '../actions/uploads/' + candidate.cand_pix;
                    img.alt = candidate.cand_name;
                    img.classList.add('candidate-image');
                    candidateDiv.appendChild(img);
                    // Create a paragraph element for the candidate name
                    const namePara = document.createElement('p');
                    namePara.textContent = candidate.cand_name;
                    namePara.classList.add('candidate-name');
                    candidateDiv.appendChild(namePara);
                    // Create vote button
                    const voteButton = document.createElement('button');
                    // Check if candidate is already voted
                    if (votedCandidates[postName] && votedCandidates[postName].includes(candidate.cand_name)) {
                        voteButton.textContent = 'Voted';
                        voteButton.disabled = true;
                    } else {
                        voteButton.textContent = 'Vote';
                        voteButton.onclick = function() {
                            confirmVote(candidate.cand_name, voteButton, postName);
                        };
                    }
                    voteButton.classList.add('vote-button'); // Add vote button class
                    voteButton.setAttribute('data-candidate', candidate.cand_name); // Set data attribute for candidate name
                    candidateDiv.appendChild(voteButton);
                    // Append the candidate div to the candidatesForPost container
                    candidatesForPost.appendChild(candidateDiv);
                });
            })
            .catch(error => console.error('Error fetching candidates:', error));
    } else {
        // Clear candidates if no post is selected
        candidatesForPost.innerHTML = '';
    }
});

let alertDisplayed = false; // Flag to track if the alert has been displayed

function confirmVote(candidateName, voteButton, postName) {
    // Check if the user has already voted for a candidate for this post
    if (votedCandidates[postName] && votedCandidates[postName].includes(candidateName)) {
        // User has already voted for a candidate for this post, return
        alert('You have already voted for a candidate running for this post.');
        return;
    }

    // Show confirmation overlay
    const confirmationOverlay = document.querySelector('.confirmation-overlay');
    confirmationOverlay.style.display = 'flex';

    // Add event listeners to Yes and No buttons
    const btnYes = document.querySelector('.btn-yes');
    const btnNo = document.querySelector('.btn-no');

    btnYes.addEventListener('click', () => {
        // Logic to vote for the candidate

        // Hide confirmation overlay
        confirmationOverlay.style.display = 'none';

        // Update voted candidates in session
        votedCandidates[postName] = votedCandidates[postName] || [];
        votedCandidates[postName].push(candidateName);

        // AJAX request to update the database
        const formData = new FormData();
        formData.append('candidate_name', candidateName);
        formData.append('post_name', postName); // Add post name to the request
        fetch('update_vote.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            return response.json(); // Parse response as JSON
        })
        .then(data => {
            if (data.success) {
                // Update the UI to reflect the vote
                voteButton.textContent = 'Voted';
                voteButton.disabled = true;

                // Show success message
                alert('You have successfully voted for ' + candidateName);
                window.location.reload()
            } else {
                // Display error message as an alert
                alert(data.error);
                window.location.reload()
            }
        })
        .catch(error => console.error('Error updating vote:', error));
    });

    btnNo.addEventListener('click', () => {
        // Hide confirmation overlay
        confirmationOverlay.style.display = 'none';
    });
}


    </script>
</body>
</html>
