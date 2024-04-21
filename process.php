<?php

require_once './includes/connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['category'], $_POST['amount'], $_POST['date'])) {
        $category = htmlspecialchars($_POST['category']);
        $amount = floatval($_POST['amount']);
        $date = $_POST['date'];

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Escape special characters to prevent SQL injection
        $category = $conn->real_escape_string($category);
        $amount = $conn->real_escape_string($amount);
        $date = $conn->real_escape_string($date);

        // SQL query to insert data into expenses table
        $sql = "INSERT INTO expenses (category, amount, date) VALUES ('$category', '$amount', '$date')";

        if ($conn->query($sql) === TRUE) {
            echo "Expense added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "All fields are required";
    }
} else {
    echo "Form submission method not allowed";
}
?>
