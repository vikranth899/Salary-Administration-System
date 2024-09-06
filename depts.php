
<?php

include "connection.php";
$dept_id = "";
$dept_name = "";
$success_message = "";

# Add new Department function
if (isset($_POST["button_add"])) {
    $query = mysqli_query($conn, "INSERT INTO dept VALUES('" . $_POST["dept_id"] . "','" . $_POST["dept_name"] . "') ") or die("Cannot Query With Database!");

    if ($query) {
        $success_message = "Department added successfully!";
    }
}

# Edit existing Department function
elseif (isset($_POST["button_edit"])) {
    $query = "UPDATE dept SET dept_id ='" . $_POST["dept_id"] . "',dept_name='" . $_POST["dept_name"] . "' where dept_id='" . $_POST["dept_id"] . "'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $success_message = "Department edit done successfully!";
    }
}

# Delete existing Department function
if (isset($_GET["delete"])) {
    $query = "DELETE FROM dept WHERE dept_id = '" . $_GET["delete"] . "' ";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $success_message = 'Department deleted successfully!';
    }
}

# Edit the contents of the department
if (isset($_GET["edit"])) {
    $query = "SELECT * FROM dept WHERE dept_id = '" . $_GET["edit"] . "' ";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $dept_id = $row["dept_id"];
        $dept_name = $row["dept_name"];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Management</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .success-popup,
        .error-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #2ecc71;
            color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 999;
        }

        .error-popup {
            background-color: #e74c3c;
        }
    </style>
</head>

<body>

    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
    <h2>Departments</h2>
        <input type="text" name="dept_id" placeholder="Dept ID" value="<?php echo $dept_id; ?>" required>
        <input type="text" name="dept_name" placeholder="Dept Name" value="<?php echo $dept_name; ?>" required>

        <input type="submit" name="button_add" value="Add">
    </form>

    <div id="success-popup" class="success-popup"><?php echo $success_message; ?></div>
    <div id="error-popup" class="error-popup"><?php echo $error_message; ?></div>

    <script>
    <?php
        if(isset($success_message) && !empty($success_message)) {
            echo "showSuccessMessage('$success_message', 'success-popup');";
        } elseif(isset($error_message) && !empty($error_message)) {
            echo "showSuccessMessage('$error_message', 'error-popup');";
        }
    ?>

    function showSuccessMessage(message, popupId) {
        document.getElementById(popupId).innerHTML = message;
        document.getElementById(popupId).style.display = 'block';
        setTimeout(function() {
            document.getElementById(popupId).style.display = 'none';
        }, 3000);
    }
</script>

</body>

</html>
