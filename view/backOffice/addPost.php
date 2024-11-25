<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff; 
        }
        form {
            max-width: 500px;
            margin: 40px auto; 
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #fff; 
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        input, textarea, button {
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

    <?php
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include '../../Controller/PostController.php';

        
        $title = htmlspecialchars(trim($_POST['title']));
        $content = htmlspecialchars(trim($_POST['content']));

        
        if (!preg_match('/^[A-Za-z0-9\s.,!?()-]+$/', $title)) {
            $error = "Invalid title: Only letters, numbers, spaces, and basic punctuation are allowed.";
        } elseif (strlen($content) < 10) {
            $error = "Content must be at least 10 characters long.";
        } else {
            
            $post = new Post(null, $title, $content);
            $postController = new PostController();
            $postController->addPost($post);

            
            header('Location: listPosts.php');
            exit;
        }
    }
    ?>

    <form action="" method="POST">
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <label>Title</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>" required>

        <label>Content</label>
        <textarea name="content" required><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>

        <button type="submit">Add Post</button>
    </form>

</body>
</html>

