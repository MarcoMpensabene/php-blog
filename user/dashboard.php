<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Crea un POST</h1>
    <form action="/posts/create_post.php" method="post">
        <label for="title">Titolo:</label>
        <input id="title" name="title" type="text" required>

        <label for="content">Contenuto:</label>
        <textarea id="content" name="content" required></textarea>

        <input type="submit" name="create_post" value="Crea Post">
    </form>

    <h1>EDIT POST</h1>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
        <label for="title">Titolo:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
        <label for="content">Contenuto:</label>
        <textarea id="content" name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>
        <input type="submit" value="Aggiorna Post">
    </form>

    <a href="read_posts.php">Visualizza tutti i post</a>
</body>
</body>

</html>