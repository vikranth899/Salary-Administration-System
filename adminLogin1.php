
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .header-text {
            font-family: 'Arial', sans-serif;
            font-size: 35px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        .subheader-text {
            font-family: 'Arial', sans-serif;
            font-size: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .container {
            margin-top: 20px;
        }

        .login-container {
            border: 30px solid #3498db; 
            background-color: whitesmoke;
            border-radius: 10px;
            padding: 25px;
            text-align: center;
        }

        .input-field {
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
        }

        .login-button {
            background-color: #3498db;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .login-button:hover {
            background-color: #2980b9; 
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center">
            <h3 class="header-text">Login as Admin</h3>
            <p>&nbsp</p>
        </div>

        <div class="col-md-12 text-center">
            <div class="login-container">
                <form method="post" action="adminLogin1.php">
                    <input type="text" class="input-field" placeholder="Username" name="username" required>
                    <input type="password" class="input-field" placeholder="Password" name="password" required>
                    <input type='submit' class="login-button" name="login_admin" value="Login">
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<?php

$conn = mysqli_connect('localhost', 'root', '', 'employment');

if (isset($_POST["login_admin"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Use prepared statement to prevent SQL injection
    $query = "SELECT * FROM admin_table WHERE admin_Name=? AND admin_Password=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) >= 1) {
    
        session_start();

        header("Location: adminHome.php");


        
    }
    else {
        ?> 
        <!DOCTYPE html>
        <html>
        <body>

        <div align="center">
            <p>
                <h4>Wrong Password/Username Combination</h4>
            </p>
        </div>

        </body>
        </html>
        <?php
        
    }
    
    mysqli_stmt_close($stmt);
}
?>
