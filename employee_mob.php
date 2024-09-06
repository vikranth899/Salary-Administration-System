
<?php
include "connection.php";
$emp_id = "";
$emp_state = "";
$emp_city = "";
$emp_doj = "";
$emp_dob = "";
$emp_name = "";
$dept_id = "";
$dept_name = "";
$emp_mob = "";
$success_message = ""; // Initialize success message variable

# Add new Employee function
if (isset($_POST["button_add"])) {
    $query_employee = mysqli_query($conn, "INSERT INTO employee (emp_id, emp_state, emp_city, emp_doj, emp_dob, emp_name, dept_id, dept_name) VALUES('" . $_POST["emp_id"] . "','" . $_POST["emp_state"] . "','" . $_POST["emp_city"] . "','" . $_POST["emp_doj"] . "','" . $_POST["emp_dob"] . "','" . $_POST["emp_name"] . "','" . $_POST["dept_id"] . "','" . $_POST["dept_name"] . "') ") or die("Cannot Query With Database!");
    
    $emp_mob = $_POST["emp_mob"];
    $query_employee_mob = mysqli_query($conn, "INSERT INTO employee_mob (emp_id, emp_mob) VALUES('" . $_POST["emp_id"] . "','" . $emp_mob . "') ") or die("Cannot Query With Database!");

    $query_employee_table = mysqli_query($conn, "INSERT INTO employee_table (emp_id, emp_password) VALUES ('" . $_POST["emp_id"] . "','" . $_POST["emp_dob"] . "') ") or die("Cannot Query With Database!");

    if ($query_employee && $query_employee_mob) {
        $success_message = "New Employee Added Successfully To the Database!";
    }
}

# Edit existing Employee function
elseif (isset($_POST["button_edit"])) {
    $query = "UPDATE employee SET emp_id ='" . $_POST["emp_id"] . "',emp_state='" . $_POST["emp_state"] . "',emp_city='" . $_POST["emp_city"] . "',emp_doj='" . $_POST["emp_doj"] . "',emp_dob='" . $_POST["emp_dob"] . "',emp_name='" . $_POST["emp_name"] . "',dept_id='" . $_POST["dept_id"] . "',dept_name='" . $_POST["dept_name"] . "' where emp_id='" . $_POST["emp_id"] . "'";
    $result = mysqli_query($conn, $query);

    $emp_mob = $_POST["emp_mob"];
    $query_employee_mob = mysqli_query($conn, "UPDATE employee_mob SET emp_mob='" . $emp_mob . "' WHERE emp_id='" . $_POST["emp_id"] . "'") or die("Cannot Query With Database!");

    if ($result && $query_employee_mob) {
        $success_message = "Edit Done Successfully!";
    }
}

# Delete existing Employee function
if (isset($_GET["delete"])) {
    $query = "DELETE FROM employee WHERE emp_id = '" . $_GET["delete"] . "' ";
    $result = mysqli_query($conn, $query);
    $query_employee_mob = mysqli_query($conn, "DELETE FROM employee_mob WHERE emp_id = '" . $_GET["delete"] . "' ");
    if ($result && $query_employee_mob) {
        $success_message = 'Successfully Deleted Employee Id = ' . $_GET["delete"] . ' from Database!';
    }
}

# Edit the contents of the employee
// if (isset($_GET["edit"])) {
//     $query = "SELECT * FROM employee WHERE emp_id = '" . $_GET["edit"] . "' ";
//     $result = mysqli_query($conn, $query);
//     while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
//         $emp_id = $row["emp_id"];
//         $emp_state = $row["emp_state"];
//         $emp_city = $row["emp_city"];
//         $emp_doj = $row["emp_doj"];
//         $emp_dob = $row["emp_dob"];
//         $emp_name = $row["emp_name"];
//         $dept_id = $row["dept_id"];
//         $dept_name = $row["dept_name"];
//     }
// }
    // $query_employee_mob = mysqli_query($conn, "SELECT * FROM employee_mob WHERE emp_id = '" . $_GET["edit"] . "' ");
    // while ($row_mob = mysqli_fetch_array($query_employee_mob, MYSQLI_ASSOC)) {
    //     $emp_mob = $row_mob["emp_mob"];
    // }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
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
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        input[type="tel"] {
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
        <h2>Employee Management</h2>
        <input type="text" name="emp_id" placeholder="Employee ID" required>
        <input type="text" name="emp_name" placeholder="Name">
        <input type="text" name="emp_state" placeholder="Employee State">
        <input type="text" name="emp_city" placeholder="City">
        <input  type="text" placeholder="Date of Join" name="emp_doj" onfocus="this.type='date'" onblur="this.type='text'">
        <input  type="text" placeholder="Date of birth" name="emp_dob" onfocus="this.type='date'" onblur="this.type='text'">
        <input type="text" name="dept_id" placeholder="Dept ID">
        <input type="text" name="dept_name" placeholder="Dept Name">
        <input  type="text" placeholder="Mobile Number" maxlength=10 name="emp_mob" onfocus="this.type='tel'" onblur="this.type='text'">
        <!-- <input type="text" name="emp_mob" placeholder="Mobile Number"> -->

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
