<?php
session_start();
$mysqli = new mysqli("localhost", "root", "root", "php_blog");

if ($mysqli->connect_error) {
    die("Errore connessione: " . $mysqli->connect_error);
}

$query = "SELECT posts.*, users.username FROM posts JOIN users ON posts.author_id = users.id ORDER BY created_at DESC";
$result = $mysqli->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
    echo "<p>Autore: " . htmlspecialchars($row['username']) . "</p>";
    echo "<p>" . htmlspecialchars($row['content']) . "</p>";
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        echo "<a href='edit_post.php?id=" . $row['id'] . "'>Modifica</a> ";
        echo "<a href='delete_post.php?id=" . $row['id'] . "'>Elimina</a>";
    }
    echo "<hr>";
}

$mysqli->close();
