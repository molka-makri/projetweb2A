<?php
include '../../Controller/CommentController.php';


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid Comment ID.";
    exit;
}

$commentController = new CommentController();
$comment = $commentController->getComment($_GET['id']);

if (!$comment) {
    echo "Comment not found.";
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = htmlspecialchars(trim($_POST['content']));

    if (strlen($content) < 5) {
        $error = "Content must be at least 5 characters long.";
    } else {
        
        $updatedComment = new Comment(
            (int)$_GET['id'], 
            (int)$_GET['post_id'], 
            $content
        );
        $commentController->updateComment($updatedComment);

        
        header('Location: listComments.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Comment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; 
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-top: 40px;
        }
        form {
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        textarea, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Update Comment</h1>

    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <label for="content">Content</label>
        <textarea name="content" required><?php echo htmlspecialchars($comment['content']); ?></textarea>

        <button type="submit">Update Comment</button>
    </form>
</body>
</html>
