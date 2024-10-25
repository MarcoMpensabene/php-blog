<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    die("Accesso non autorizzato");
}

$mysqli = new mysqli("localhost", "root", "root", "php_blog");

if ($mysqli->connect_error) {
    die("Errore connessione: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $query = $mysqli->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ? AND author_id = ?");
    $query->bind_param("ssii", $title, $content, $id, $_SESSION['id']);

    if ($query->execute()) {
        echo "Post aggiornato";
    } else {
        echo "Errore nell'aggiornamento post";
    }
} else {
    $id = $_GET['id'];
    $query = $mysqli->prepare("SELECT * FROM posts WHERE id = ? AND author_id = ?");
    $query->bind_param("ii", $id, $_SESSION['id']);
    $query->execute();
    $result = $query->get_result();
    $post = $result->fetch_assoc();

    if (!$post) {
        die("Post non trovato");
    }
}

$mysqli->close();
