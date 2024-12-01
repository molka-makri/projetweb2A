<?php
include '../../Controller/PostController.php';
include '../../Controller/CommentController.php';

$postController = new PostController();
$posts = $postController->listPosts();

function getCommentsByPostId($postId) {
    $commentController = new CommentController();
    return $commentController->getCommentsByPostId($postId); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Posts</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/Food.jpeg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            display: block;
            color: #fff;
        }

        header {
            background-color: #28a745;
            color: white;
            padding: 1rem;
            text-align: center;
            border-bottom: 3px solid #218838;
        }

        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 25px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .post {
            background: #fff;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .post h2 {
            margin-top: 0;
            color: #333;
            font-size: 1.5rem;
        }

        .post p {
            color: #555;
            line-height: 1.6;
        }

        .comments {
            margin-top: 20px;
        }

        .post .actions {
            margin-top: 10px;
            text-align: center;
        }

        .post .actions a {
            text-decoration: none;
            color: #28a745;
            font-weight: bold;
            padding: 8px 15px;
            border: 2px solid #28a745;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .post .actions a:hover {
            background-color: #28a745;
            color: #fff;
        }

        .add-post-btn-container {
            text-align: left;
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 10;
        }

        .add-post-btn {
            display: inline-block;
            padding: 12px 18px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .add-post-btn:hover {
            background-color: #218838;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            header {
                font-size: 1.2rem;
            }

            .post {
                padding: 15px;
            }

            .add-post-btn {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Social Posts</h1>
    </header>
<!-- Navigation Bar -->
<div class="navigation">
    <ul class="nav-menu">
        <li><a href="home.html">Home</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="productPage.html">Products</a></li>
        <li><a href="eventsPage.html">Events</a></li>
    </ul>
</div>

<style>
    /* Navigation Bar Styling */
    .navigation {
        background-color: #333; 
        padding: 10px 0;
        text-align: center;
    }

    .nav-menu {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        gap: 20px; 
    }

    .nav-menu li {
        display: inline;
    }

    .nav-menu a {
        text-decoration: none;
        color: #fff; 
        font-weight: bold;
        padding: 10px 15px;
        border-radius: 5px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .nav-menu a:hover {
        background-color: #28a745;
        color: #fff; 
    }
</style>

    <main>

        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h2><?php echo htmlspecialchars($post['content']); ?></h2>
                    <p><small>Posted on: <?php echo htmlspecialchars($post['created_at']); ?></small></p>
                    
                    <div class="comments">
                        <?php 
                        $postComments = getCommentsByPostId($post['id']);
                        if (!empty($postComments)): ?>
                            <?php foreach ($postComments as $comment): ?>
                                <p><strong>Comment:</strong> <?php echo htmlspecialchars($comment['content']); ?></p>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No comments for this post.</p>
                        <?php endif; ?>
                    </div>

                    <div class="actions">
                        <a href="posts/addComment.php?post_id=<?php echo urlencode($post['id']); ?>">Add Comment</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center;">No posts available.</p>
        <?php endif; ?>
    </main>
    
    <div class="add-post-btn-container">
        <a href="posts/addPost.php" class="add-post-btn">Add New Post</a>
    </div>
</body>
</html>
