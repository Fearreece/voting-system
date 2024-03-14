// function confirmDelete(postId) {
//     if (confirm("Are you sure you want to delete this post?")) {
//       // Send a DELETE request to delete the post
//       $.ajax({
//         type: "DELETE",
//         url: "./action/deletepost.php",
//         data: { id: postId },
//         success: function(response) {
//           // Handle the response from the server
//           console.log("Post deleted successfully", response);
//           // Reload the page to show the updated list of posts
//           location.reload();
//         },
//         error: function(xhr, textStatus, errorThrown) {
//           // Handle any errors that occur during the request
//           console.error("Error deleting post:", textStatus, errorThrown);
//         }
//       });
//     }
//   }