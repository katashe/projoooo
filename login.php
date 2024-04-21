<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 300px;
            margin: 0 auto;
            padding-top: 100px;
        }
        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Login">
            <tr>
                <td>
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">Don't have an account&#63; </label>
                    <a href="signup.php" class="hover-link1 non-style-link">Sign Up</a>
                    <br><br><br>
                </td>
            </tr>
        </form>
        <?php
        require_once './includes/connection.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST['username'];
                $userpassword = $_POST['password'];

                $username = mysqli_real_escape_string($conn, $username);
                $password = mysqli_real_escape_string($conn, $password);

                $sql = "SELECT * FROM users WHERE username = '$username'";

                $result = mysqli_query($conn, $sql);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);

                        if ($password == $row['password']) {
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $row['user_id'];
                            $_SESSION["username"] = $row['username'];

                            header("location: index.php");
                            exit; 
                        } else {
                            echo "<p>Password is incorrect.</p>";
                        }
                    } else {
                        echo "<p>No account found with that username.</p>";
                    }
                } else {
                    echo "<p>Oops! Something went wrong. Please try again later.</p>";
                    error_log("Database Error: " . mysqli_error($conn));
                }            
            }
                mysqli_close($conn);
?>

    </div>
</body>
</html>
