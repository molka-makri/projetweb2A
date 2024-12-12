<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="tabler.min.css"> 
    <link rel="stylesheet" href="admin-style.css"> 
</head>
<body>
    <div class="page">
        <!-- Sidebar -->
        <aside class="navbar navbar-vertical navbar-expand-lg">
            <div class="container-fluid">
                <h3 class="navbar-brand">Admin Panel</h3>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#posts-management">Manage Posts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#comments-management">Manage Comments</a>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Main content -->
        <div class="page-wrapper">
            <div class="container">
                <!-- Manage Posts -->
                <section id="posts-management">
                    <h2>Manage Posts</h2>
                    <?php
include '../../Controller/PostController.php';
$postController = new PostController();
$posts = $postController->listPosts();
?>
                    <table border="1">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($posts as $post): ?>
                            <tr>
                                <td><?php echo $post['id']; ?></td>
                                <td><?php echo $post['title']; ?></td>
                                <td><?php echo $post['content']; ?></td>
                                <td>
                                    <a href="deletePost.php?id=<?php echo $post['id']; ?>">Delete</a>
                                </td>
                                <td>
                                    <a href="updatePost.php?id=<?php echo $post['id']; ?>">update</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </section>

                <!-- Manage Comments -->
                <section id="comments-management">
                    <h2>Manage Comments</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Comment</th>
                                <th>Post ID</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="comments-table-body">
                            <!-- Comments will be dynamically added here -->
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>

    <script src="tabler.min.js"></script>
    <script src="admin.js"></script>
</body>
</html>
