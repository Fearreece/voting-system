function fetchPosts() {
  fetch("./actions/viewpost.php")
    .then((response) => {
      console.log("Response status:", response.status);
      console.log("Response headers:", response.headers); // log headers for debugging
      return response.json(); // parse response as JSON
    })
    .then((posts) => {
      console.log("Posts data:", posts);
      const postList = document.getElementById("postList");
      postList.innerHTML = ""; // Clear existing posts

      if (posts.length > 0) {
        posts.forEach((post) => {
          const row = document.createElement("tr");
          row.innerHTML = `
                  <td>${post.post_id}</td>
                  <td>${post.post_name}</td>
                  <td><button onclick="deletePost(${post.post_id})">Delete</button></td>
              `;
          postList.appendChild(row);
        });
      } else {
        const row = document.createElement("tr");
        row.innerHTML = "<td colspan='3'>No posts available</td>";
        postList.appendChild(row);
      }
    })
    .catch((error) => {
      console.error("Error fetching posts:", error);
    });
}