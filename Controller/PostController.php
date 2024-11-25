<?php
include(__DIR__ . '/../Model/Post.php');
include(__DIR__ . '/../config.php');

class PostController {
    public function listPosts() {
        $sql = "SELECT * FROM posts";
        $db = config::getConnexion();
        try {
            return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage()); 
            return false;
        }
    }

    public function addPost($post) {
        $sql = "INSERT INTO posts (title, content) VALUES (:title, :content)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':title', $post->getTitle(), PDO::PARAM_STR);
            $query->bindValue(':content', $post->getContent(), PDO::PARAM_STR);
            $query->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function deletePost($id) {
        $sql = "DELETE FROM posts WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getPost($id) {
        $sql = "SELECT * FROM posts WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    
    public function updatePost($post) {
        $sql = "UPDATE posts SET title = :title, content = :content WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':title', $post->getTitle(), PDO::PARAM_STR);
            $query->bindValue(':content', $post->getContent(), PDO::PARAM_STR);
            $query->bindValue(':id', $post->getId(), PDO::PARAM_INT);
            $query->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
?>

