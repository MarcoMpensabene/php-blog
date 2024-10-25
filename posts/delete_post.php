<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    die("Accesso non autorizzato");
}

$mysqli = new mysqli("localhost", "root", "root", "php_blog");

if ($mysqli->connect_error) {
    die("Errore connessione: " . $mysqli->connect_error);
}

$id = $_GET['id'];
$query = $mysqli->prepare("DELETE FROM posts WHERE id = ? AND author_id = ?");
$query->bind_param("ii", $id, $_SESSION['id']);

if ($query->execute()) {
    echo "Post eliminato";
} else {
    echo "Errore nell'eliminazione";
}

$mysqli->close();
