<?php
include '../../Controller/CommentController.php';

$commentController = new CommentController();
$comments = $commentController->getAllComments();

if (!$comments) {
    echo "No comments available.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Comments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff; 
        }
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

<h1>All Comments</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Post ID</th>
        <th>Content</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($comments as $comment): ?>
        <tr>
            <td><?php echo htmlspecialchars($comment['id']); ?></td>
            <td><?php echo htmlspecialchars($comment['post_id']); ?></td>
            <td><?php echo htmlspecialchars($comment['content']); ?></td>
            <td><?php echo htmlspecialchars($comment['created_at']); ?></td>
            <td>
                <a href="deleteComment.php?id=<?php echo urlencode($comment['id']); ?>">Delete</a>
                <a href="Update Comment.php?id=<?php echo urlencode($comment['id']); ?>">Update</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
