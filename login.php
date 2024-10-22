<?php session_start();
if (isset($_POST['login'])) {

    // Connect to the database 
    $mysqli = new mysqli("localhost", "username", "password", "login_system");

    // Check for errors 
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Prepare and bind the SQL statement 
    $query = $mysqli->prepare("SELECT id, password FROM users WHERE username = ?");
    $query->bind_param("s", $username);

    // Get the form data 
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Execute the SQL statement 
    $query->execute();
    $query->store_result();

    // Check if the user exists 
    if ($query->num_rows > 0) {

        // Bind the result to variables 
        $query->bind_result($id, $hashed_password);

        // Fetch the result 
        $query->fetch();

        // Verify the password 
        if (password_verify($password, $hashed_password)) {

            // Set the session variables 
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;

            // Redirect to the user's dashboard 
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "User not found!";
    }

    // Close the connection 
    $query->close();
    $mysqli->close();
}
?>
<form action="login.php" method="post">
    <label for="username">Username:</label>
    <input id="username" name="username" required="" type="text" />
    <label for="password">Password:</label> <input id="password" name="password" required="" type="password" />
    <input name="login" type="submit" value="Login" />
</form>