<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Item</title>
</head>
<body>
    <h2>Add New Item</h2>
    
    <?php
    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the data from the form
        $type = $_POST['type'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $unit = $_POST['unit'];
        $life_span = $_POST['life_span'];

        // Database configuration
        $servername = "localhost"; // Change to your server name
        $username = "root"; // Change to your database username
        $password = ""; // Change to your database password
        $dbname = "inventory"; // Change to your database name

        // Create a new connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("INSERT INTO tbl_items (type, category, description, unit, life_span) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $type, $category, $description, $unit, $life_span);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to list_items.php after successful insertion
            header("Location: list_items.php");
            exit();
        } else {
            echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }

        // Close the connection
        $stmt->close();
        $conn->close();
    }
    ?>

    <form action="add_item.php" method="post">
        <label for="type">Type:</label><br>
        <input type="text" id="type" name="type" required><br><br>

        <label for="category">Category:</label><br>
        <input type="text" id="category" name="category" required><br><br>

        <label for="description">Description:</label><br>
        <input type="text" id="description" name="description" required><br><br>

        <label for="unit">Unit:</label><br>
        <input type="text" id="unit" name="unit" required><br><br>

        <label for="life_span">Life Span (in months):</label><br>
        <input type="number" id="life_span" name="life_span"><br><br>

        <input type="submit" value="Add Item">
    </form>
    <button onclick="window.location.href='list_item.php';">Add New Item</button>
</body>
</html>
