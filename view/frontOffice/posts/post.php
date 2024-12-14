<?php
include '../../../Controller/PostController.php';
include '../../../Controller/CommentController.php';

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
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
    animation: backgroundSlide 80s infinite;
    color: #fff;
}

@keyframes backgroundSlide {
    0% {
        background: url('images/85.jpeg') center center / cover no-repeat fixed;
    }
    16.67% {
        background: url('images/86.jpeg') center center / cover no-repeat fixed;
    }
    33.33% {
        background: url('images/87.jpeg') center center / cover no-repeat fixed;
    }
    50% {
        background: url('images/88.jpeg') center center / cover no-repeat fixed;
    }
    66.67% {
        background: url('images/89.jpeg') center center / cover no-repeat fixed;
    }
    83.33% {
        background: url('images/90.jpeg') center center / cover no-repeat fixed;
    }
    100% {
        background: url('images/85.jpeg') center center / cover no-repeat fixed;
    }
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

        /* Image styling */
        .post-image img {
            width: 100%; /* Make sure the image fits the container */
            height: auto; /* Maintain the aspect ratio */
            object-fit: cover; /* Ensure the image covers the space without distortion */
            border-radius: 8px; /* Optional: Rounded corners for the image */
        }

        .like-info {
    display: inline-flex;  /* استخدام inline-flex لضمان أن تكون العناصر في نفس السطر */
    align-items: center;   /* لمحاذاة العناصر عموديًا في المنتصف */
    gap: 10px;  /* المسافة بين النص والصورة */
}

.like-button {
    display: inline-block;
    padding: 3px 7px;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.like-button:hover {
    background-color: #0056b3;
}

.likes-count {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.likes-count span {
    margin-left: 10px;
    font-size: 20px;
    color: #007bff;
    font-weight: normal;
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
                    
                    <!-- Display Image if Exists -->
                    <?php if (!empty($post['image_path'])): ?>
                        <div class="post-image">
                            <img src="../../uploads/<?php echo basename($post['image_path']); ?>" alt="Post Image">
                        </div>
                    <?php endif; ?>

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
                    
                    <div class="like-info">
                    <p class="likes-count">Likes: <span><?php echo htmlspecialchars($post['likes']); ?></span></p>
    <a href="posts/increaseLikes.php?post_id=<?php echo urlencode($post['id']); ?>" class="like-button">
        <img src="images/like1.png" alt="like image" class="like-button-img">
    </a>
</div>

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
