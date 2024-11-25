<?php
include '../../Controller/PostController.php';
$postController = new PostController();
$posts = $postController->listPosts();


function getCommentsByPostId($postId) {
    include '../../Controller/CommentController.php';
    $commentController = new CommentController();
    return $commentController->getCommentsByPost($postId);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff; }
        h1 {
            text-align: center;
            margin: 20px 0;
            color: #333;
        }
        table {
            width: 80%;
            margin: 20px auto; 
            border-collapse: collapse;
            background-color: #fff; 
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4caf50; 
            color: white;
        }
        td {
            color: #333;
        }
        a {
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Post List</h1>

<?php if (!empty($posts)): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($posts as $post): ?>
            <tr>
                <td><?php echo htmlspecialchars($post['id']); ?></td>
                <td><?php echo htmlspecialchars($post['title']); ?></td>
                <td><?php echo htmlspecialchars($post['content']); ?></td>
                <td><?php echo htmlspecialchars($post['created_at']); ?></td>
                <td class="actions">
                    <a href="deletePost.php?id=<?php echo urlencode($post['id']); ?>">Delete</a>
                    <a href="updatePost.php?id=<?php echo urlencode($post['id']); ?>">Update</a>
                    <a href="addComment.php?post_id=<?php echo urlencode($post['id']); ?>">Add Comment</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p style="text-align: center; color: #333;">No posts available.</p>
<?php endif; ?>

</body>
</html>
