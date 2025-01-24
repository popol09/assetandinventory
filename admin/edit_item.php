<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted to update the item
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = $_POST["item_id"];
    $type = $_POST["type"];
    $category = $_POST["category"];
    $description = $_POST["description"];
    $unit = $_POST["unit"];
    $life_span = $_POST["life_span"];

    // Update query
    $sql = "UPDATE tbl_items SET type=?, category=?, description=?, unit=?, life_span=? WHERE item_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $type, $category, $description, $unit, $life_span, $item_id);

    if ($stmt->execute()) {
        echo "Item updated successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    header("Location: list_items.php"); // Redirect back to the list page
    exit();
} else {
    // Fetch the item details to populate the edit form
    $item_id = $_GET["id"];
    $sql = "SELECT * FROM tbl_items WHERE item_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Item</title>
</head>
<body>
    <h2>Edit Item</h2>
    <form action="edit_item.php" method="post">
        <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
        <label for="type">Type:</label><br>
        <input type="text" id="type" name="type" value="<?php echo $item['type']; ?>" required><br><br>

        <label for="category">Category:</label><br>
        <input type="text" id="category" name="category" value="<?php echo $item['category']; ?>" required><br><br>

        <label for="description">Description:</label><br>
        <input type="text" id="description" name="description" value="<?php echo $item['description']; ?>" required><br><br>

        <label for="unit">Unit:</label><br>
        <input type="text" id="unit" name="unit" value="<?php echo $item['unit']; ?>" required><br><br>

        <label for="life_span">Life Span (in months):</label><br>
        <input type="number" id="life_span" name="life_span" value="<?php echo $item['life_span']; ?>"><br><br>

        <input type="submit" value="Update Item">
    </form>
</body>
</html>
