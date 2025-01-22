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

// SQL query to fetch all items
$sql = "SELECT item_id, type, category, description, unit, life_span FROM tbl_items";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Items List</title>
    <style>
        input[type="text"] {
            width: 90%;
        }
    </style>
    <script>
        // JavaScript function to filter table rows based on input values
        function filterTable() {
            // Get all rows except the header and filter row
            var rows = document.querySelectorAll("#itemsTable tbody tr");
            rows.forEach(row => {
                let showRow = true;
                // Get all input values
                document.querySelectorAll("#itemsTable thead input").forEach((input, index) => {
                    let cell = row.cells[index].innerText.toLowerCase();
                    if (input.value && !cell.includes(input.value.toLowerCase())) {
                        showRow = false;
                    }
                });
                row.style.display = showRow ? "" : "none";
            });
        }
    </script>
</head>
<body>
    <h2>Items List</h2>

    <?php
    if ($result->num_rows > 0) {
        echo "<table id='itemsTable' border='1'>
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Unit</th>
                        <th>Life Span (Months)</th>
                        <th>Action</th>
                    </tr>
                    <tr>";
        // Adding filter row with input fields
        for ($i = 0; $i < 6; $i++) {
            echo "<th><input type='text' onkeyup='filterTable()'></th>";
        }
        echo "<th></th></tr></thead><tbody>";

        // Output data for each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["item_id"] . "</td>
                    <td>" . $row["type"] . "</td>
                    <td>" . $row["category"] . "</td>
                    <td>" . $row["description"] . "</td>
                    <td>" . $row["unit"] . "</td>
                    <td>" . $row["life_span"] . "</td>
                    <td>
                        <a href='edit_item.php?id=" . $row["item_id"] . "'>Edit</a> | 
                        <a href='delete_item.php?id=" . $row["item_id"] . "' onclick=\"return confirm('Are you sure you want to delete this item?');\">Remove</a>
                    </td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "No items found.";
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
