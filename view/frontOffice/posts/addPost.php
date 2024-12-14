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
        .chatgpt-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
        .chatgpt-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .chatgpt-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<?php
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../../../Controller/PostController.php';

    $title = htmlspecialchars(trim($_POST['title']));
    $content = htmlspecialchars(trim($_POST['content']));
    $imagePath = null;

    
    $bannedWords = ['damn', 'hell', 'idiot', 'stupid', 'fool', 'crap', 'bastard', 'jerk', 'moron', 'asshole', 'dumb', 'shit', 'bitch', 'f***', 'a**', 'c***', 'slut', 'whore'];

    foreach ($bannedWords as $word) {
        if (stripos($title, $word) !== false || stripos($content, $word) !== false) {
            $error = "The input contains inappropriate words. Please revise your text.";
            break;
        }
    }

    
    if (!$error && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $uploadDir = '../../../uploads/';
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;

        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            $error = "Invalid image type. Only JPG, PNG, and GIF are allowed.";
        } elseif (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        } elseif (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $error = "Failed to upload image.";
        }
    }

    
    if (!$error) {
        if (!preg_match('/^[A-Za-z0-9\s.,!?()-]+$/', $title)) {
            $error = "Invalid title: Only letters, numbers, spaces, and basic punctuation are allowed.";
        } elseif (strlen($title) < 5 || strlen($title) > 100) {
            $error = "Title must be between 5 and 100 characters.";
        } elseif (strlen($content) < 10) {
            $error = "Content must be at least 10 characters long.";
        } else {
            
            $post = new Post(null, $title, $content, $imagePath);
            $postController = new PostController();
            $postController->addPost($post);

            
            header('Location: ../post.php');
            exit;
        }
    }
}
?>

<form action="" method="POST" enctype="multipart/form-data">
    <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <label for="title">Title</label>
    <input type="text" id="title" name="title" 
           value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>" 
           minlength="5" maxlength="100" 
           pattern="^[A-Za-z0-9\s.,!?()-]+$" 
           title="Only letters, numbers, spaces, and basic punctuation are allowed."
           required>

    <label for="content">Content</label>
    <textarea id="content" name="content" 
              minlength="10" 
              required><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>

    <label for="image">Image</label>
    <input type="file" id="image" name="image" accept="image/*">

    <button type="submit">Add Post</button>
</form>

<div class="chatgpt-link">
    <p>Need help writing your post? Visit <a href="https://chat.openai.com/" target="_blank">ChatGPT</a> for assistance.</p>
</div>

</body>
</html>
