<?php
// Include database connection
include('connect.php');

// Start the session
session_start();

// Check if candidate_name and post_name are set in the request
if(isset($_POST['candidate_name']) && isset($_POST['post_name'])) {
    // Get candidate name and post name from the request body
    $candidateName = $_POST['candidate_name'];
    $postName = $_POST['post_name'];

    // Retrieve the matric number of the logged-in user from the session
    $matric_no = $_SESSION['matric'];

    // Check if the candidate has already voted for the selected candidate in the current post
    $query = "SELECT * FROM votes WHERE matric_no = ? AND post_name = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ss", $matric_no, $postName);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    // Check if a record exists (i.e., if the candidate has already voted for a candidate for this post)
    if(mysqli_stmt_num_rows($stmt) > 0) {
        // Output JSON response indicating failure due to duplicate vote
        echo json_encode(array('success' => false, 'error' => 'You have already voted for a candidate for this position'));
    } else {
        // Prepare the SQL query to update the vote in the database
        $updateQuery = "UPDATE candidates SET votes = votes + 1 WHERE cand_name = ?";
        $updateStmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, "s", $candidateName);
        mysqli_stmt_execute($updateStmt);

        // Check if the query was successful
        if (mysqli_stmt_affected_rows($updateStmt) > 0) {
            // Insert the vote record into the votes table
            $insertQuery = "INSERT INTO votes (matric_no, candidate_name, post_name) VALUES (?, ?, ?)";
            $insertStmt = mysqli_prepare($con, $insertQuery);
            mysqli_stmt_bind_param($insertStmt, "sss", $matric_no, $candidateName, $postName);
            mysqli_stmt_execute($insertStmt);

            // Check if the insertion was successful
            if (mysqli_stmt_affected_rows($insertStmt) > 0) {
                // Output JSON response indicating success
                echo json_encode(array('success' => true, 'voted' => true)); // Add voted flag
            } else {
                // Output JSON response indicating failure to record vote
                echo json_encode(array('success' => false, 'error' => 'Failed to record your vote.'));
            }
        } else {
            // Output JSON response indicating failure to update vote count
            echo json_encode(array('success' => false, 'error' => 'Failed to update vote count.'));
        }
    }

    // Close the statements
    mysqli_stmt_close($stmt);
    if (isset($updateStmt)) {
        mysqli_stmt_close($updateStmt);
    }
    if (isset($insertStmt)) {
        mysqli_stmt_close($insertStmt);
    }
} else {
    // Output JSON response if candidate_name or post_name is not set
    echo json_encode(array('success' => false, 'error' => 'Candidate name or post name not provided.'));
}

// Close the connection
mysqli_close($con);
?>
