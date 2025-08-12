<?php
// Connect to the database
foreach (parse_ini_file('.env') as $key => $value) {
  $_ENV[$key] = $value;
}

$conn = new mysqli($_ENV["DB_HOST"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all sections added through admin
$sections = $conn->query("SELECT * FROM sections ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Web</title>
    <link rel="stylesheet" href="style1.css"> <!-- Link to your CSS in 'style' folder -->
</head>
<body>

    <header class="header">
        <h1>My Web</h1>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="admin.php">Admin Panel</a></li> <!-- Link to admin -->
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Welcome to My Web</h2>

            <!-- Static content -->
            <h3>Notebooks</h3>
            <p>
                A notebook is a simple yet powerful tool in every writer's arsenal. It’s more than just a place to jot down notes; it’s a space where creativity blooms and ideas come to life. Whether used for sketching, journaling, or writing, a notebook serves as a personal companion for thoughts, dreams, and reflections. The pages are like a blank canvas, waiting to capture your ideas, plans, and stories. In a world increasingly dominated by digital screens, there's something deeply satisfying about the tactile experience of writing on paper, making notebooks a cherished item for both professional and personal use.
            </p>

            <h3>Pencils</h3>
            <p>
                Pencils are the quiet instruments that help shape our thoughts into written words or intricate designs. From the moment a pencil touches paper, it brings our ideas to life, whether we're drafting a letter, sketching a picture, or making a quick note. The feel of a pencil in your hand gives you control over every stroke, offering flexibility with the ability to erase mistakes and refine your work. Whether it’s a traditional wooden pencil for drawing or a mechanical pencil for writing, each type serves its purpose in turning thoughts into tangible creations. Pencils are essential tools that fuel creativity, expression, and precision in countless forms.
            </p>

            <hr>

            <!-- Dynamic content from database -->
            <h2>More Sections</h2>

            <?php
            if ($sections->num_rows > 0) {
                while ($row = $sections->fetch_assoc()) {
                    echo "<div>";
                    echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                    echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                    echo "</div><hr>";
                }
            } else {
                echo "<p>No additional sections yet.</p>";
            }

            $conn->close();
            ?>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2025 My Web | All Rights Reserved</p>
    </footer>

</body>
</html>
