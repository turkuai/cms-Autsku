<?php
// Connect to the database
foreach (parse_ini_file('.env') as $key => $value) {
  $_ENV[$key] = $value;
}

$conn = new mysqli($_ENV["DB_HOST"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';

    if ($title !== '' && $description !== '') {
        $title = $conn->real_escape_string($title);
        $description = $conn->real_escape_string($description);

        $sql = "INSERT INTO sections (title, description) VALUES ('$title', '$description')";
        if ($conn->query($sql) === TRUE) {
            $message = "Section added successfully.";
        } else {
            $message = "Error: " . $conn->error;
        }
    } else {
        $message = "Please fill in all fields.";
    }
}

// Fetch all sections to show below the form
$sections = $conn->query("SELECT * FROM sections ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - My Web</title>
    <link rel="stylesheet" href="style1.css"> 
</head>
<body>

    <header class="header">
        <h1>Admin Panel</h1>
        <nav>
            <ul>
                <li><a href="index.php">Back to Website</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Add New Section</h2>

            <?php if ($message): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>

            <form action="" method="POST">
                <label for="title">Title:</label><br>
                <input type="text" name="title" id="title" required><br><br>

                <label for="description">Description:</label><br>
                <textarea name="description" id="description" rows="4" required></textarea><br><br>

                <button type="submit">Add Section</button>
            </form>

            <hr>

            <h2>All Sections</h2>
            <?php if ($sections->num_rows > 0): ?>
                <?php while ($row = $sections->fetch_assoc()): ?>
                    <div>
                        <h3><?= htmlspecialchars($row['title']) ?></h3>
                        <p><?= htmlspecialchars($row['description']) ?></p>
                    </div>
                    <hr>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No sections found.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2025 My Web | Admin Panel</p>
    </footer>

</body>
</html>
