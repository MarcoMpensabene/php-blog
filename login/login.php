<?php
session_start();
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connessione al DB
    $mysqli = new mysqli("localhost", "username", "password", "php_blog");

    if ($mysqli->connect_error) {
        die("Errore connessione: " . $mysqli->connect_error);
    }

    $query = $mysqli->prepare("SELECT id, password FROM users WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $query->store_result();

    if ($query->num_rows > 0) {
        $query->bind_result($id, $hashed_password);
        $query->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
        } else {
            echo "Password errata!";
        }
    } else {
        echo "Utente non trovato!";
    }

    $query->close();
    $mysqli->close();
}
