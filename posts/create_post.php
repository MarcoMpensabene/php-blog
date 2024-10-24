<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if (isset($_POST['create_post'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $author_id = $_SESSION['id'];

        $mysqli = new mysqli("localhost", "username", "password", "php_blog");

        if ($mysqli->connect_error) {
            die("Errore connessione: " . $mysqli->connect_error);
        }

        $query = $mysqli->prepare("INSERT INTO posts (title, content, author_id) VALUES (?, ?, ?)");
        $query->bind_param("ssi", $title, $content, $author_id);

        if ($query->execute()) {
            echo "Post creato con successo!";
        } else {
            echo "Errore nella creazione del post!";
        }

        $query->close();
        $mysqli->close();
    }
} else {
    echo "Devi essere loggato per creare un post.";
}
