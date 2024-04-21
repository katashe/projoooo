<?php
session_start();

$status = $_SESSION["loggedin"];
if ($status == null) {
    header("location: login.php");
    exit; // Stop further execution
}

$id = $_SESSION["user_id"];

require_once './includes/connection.php';

function fetchExpenses($conn, $id) {
    $sql = "SELECT * FROM expenses WHERE user_id = $id"; // Assuming expenses table has a user_id column

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["category"] . "</td>";
            echo "<td>" . $row["amount"] . "</td>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td><a href='delete.php?id=" . $row["id"] . "'>Delete</a></td>"; // Assuming you have a delete.php file
            echo "</tr>";
        }
    } else {
        echo "0 results";
    }
}

function filterTableData($conn, $id, $searchTerm) {
    // Implement your filter and search logic here
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["search"])) {
        $searchTerm = $_POST["search"];
        filterTableData($conn, $id, $searchTerm);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Expense Tracker App</title>
</head>
<body>
    <div>
        <h1>Expense Tracker App</h1>
        <a href="login.php" style="margin-left:20px;">Login</a>
    </div>

    <form action="process.php" method="POST">
        <div class="input-section">
            <label for="category-select">Category:</label>
            <select id="category-select" name="category"> 
                <option value="Food & Beverage">Food & Beverage</option>
                <option value="Insurance">Insurance</option>
                <option value="Housing">Housing</option>
                <option value="Healthcare">Healthcare</option>
                <option value="Education">Education</option>
                <option value="Utilities">Utilities</option>
                <option value="Investments">Investments</option>
                <option value="Personal Care">Personal Care</option>
                <option value="Debts & Loans">Debts & Loans</option>
                <option value="Savings">Savings</option>
                <option value="Relaxing">Relaxing</option>
            </select>
            <label for="amount-input">Amount:</label>
            <input type="number" id="amount-input" name="amount">
            <label for="date-input">Date:</label>
            <input type="date" id="date-input" name="date">
            <button id="add-btn" type="submit">Add</button>
        </div>
    </form>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="filter">Filter:</label>
        <input type="text" id="filter" name="search">
        <button type="submit">Search</button>
    </form>
    
    <div class="expenses-list">
        <h2>Expenses List</h2>

        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody id="expnese-table-body">
                <?php fetchExpenses($conn, $id); ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>Total:</td>
                    <td id="total-amount"></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <script src="script.js"></script>
</body>
</html>
