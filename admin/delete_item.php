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

// Get item ID from query string and delete the item
if (isset($_GET["id"])) {
    $item_id = $_GET["id"];
    $sql = "DELETE FROM tbl_items WHERE item_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $item_id);

    if ($stmt->execute()) {
        echo "Item deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    header("Location: list_items.php"); // Redirect back to the list page
    exit();
}
?>
