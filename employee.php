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

# Add new Employee function
if (isset($_POST["button_add"])) {
    echo "button_add is running! \n";

    $query = mysqli_query($conn, "INSERT INTO employee (emp_id, emp_state, emp_city, emp_doj, emp_dob, emp_name, dept_id, dept_name) VALUES('" . $_POST["emp_id"] . "','" . $_POST["emp_state"] . "','" . $_POST["emp_city"] . "','" . $_POST["emp_doj"] . "','" . $_POST["emp_dob"] . "','" . $_POST["emp_name"] . "','" . $_POST["dept_id"] . "','" . $_POST["dept_name"] . "') ") or die("Cannot Query With Database!");

    if ($query) {
        echo "New Employee Added Successfully To the Database!\n";
    }
}

# Edit existing Employee function
elseif (isset($_POST["button_edit"])) {
    echo "button_edit is running! \n";

    $query = "UPDATE employee SET emp_id ='" . $_POST["emp_id"] . "',emp_state='" . $_POST["emp_state"] . "',emp_city='" . $_POST["emp_city"] . "',emp_doj='" . $_POST["emp_doj"] . "',emp_dob='" . $_POST["emp_dob"] . "',emp_name='" . $_POST["emp_name"] . "',dept_id='" . $_POST["dept_id"] . "',dept_name='" . $_POST["dept_name"] . "' where emp_id='" . $_POST["emp_id"] . "'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Edit Done Successfully!";
    }
}

# Delete existing Employee function
if (isset($_GET["delete"])) {
    $query = "DELETE FROM employee WHERE emp_id = '" . $_GET["delete"] . "' ";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo 'Successfully Deleted Employee Id = ' . $_GET["delete"] . ' from Database!';
    }
}

# Edit the contents of the employee
if (isset($_GET["edit"])) {
    $query = "SELECT * FROM employee WHERE emp_id = '" . $_GET["edit"] . "' ";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $emp_id = $row["emp_id"];
        $emp_state = $row["emp_state"];
        $emp_city = $row["emp_city"];
        $emp_doj = $row["emp_doj"];
        $emp_dob = $row["emp_dob"];
        $emp_name = $row["emp_name"];
        $dept_id = $row["dept_id"];
        $dept_name = $row["dept_name"];
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Employee</title>
</head>

<body bgcolor="yellow">

    <br>

    <div name="employee_div" align="center">
        <table>
            <form action='<?php echo $_SERVER["PHP_SELF"]; ?>' method="post">
                <tr>
                    <td>Employee ID</td>
                    <td><input type="text" name="emp_id" value="<?php echo $emp_id; ?>"></td>
                </tr>
                <tr>
                    <td>Employee Name</td>
                    <td><input type="text" name="emp_name" value="<?php echo $emp_name; ?>"></td>
                </tr>
                <tr>
                    <td>State</td>
                    <td><input type="text" name="emp_state" value="<?php echo $emp_state; ?>"></td>
                </tr>
                <tr>
                    <td>City</td>
                    <td><input type="text" name="emp_city" value="<?php echo $emp_city; ?>"></td>
                </tr>
                <tr>
                    <td>Date of Joining</td>
                    <td><input type="text" name="emp_doj" value="<?php echo $emp_doj; ?>"></td>
                </tr>
                <tr>
                    <td>Date of Birth</td>
                    <td><input type="text" name="emp_dob" value="<?php echo $emp_dob; ?>"></td>
                </tr>
                <tr>
                    <td>Department ID</td>
                    <td><input type="text" name="dept_id" value="<?php echo $dept_id; ?>"></td>
                </tr>
                <tr>
                    <td>Department Name</td>
                    <td><input type="text" name="dept_name" value="<?php echo $dept_name; ?>"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="button_add" value="Add" />
                        <input type="submit" name="button_edit" value="Edit" />
                </tr>
                </td>
            </form>
        </table>
    </div>

</body>

</html>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>

    <div align="center">
        <table border="1">
            <!-- Row Headers -->
            <tr>
                <th>Employee Id</th>
                <th>Employee Name</th>
                <th>State</th>
                <th>City</th>
                <th>Date of Joining</th>
                <th>Date of Birth</th>
                <th>Department Id</th>
                <th>Department Name</th>
                <th>Action</th>
            </tr>
            <!-- Row Data -->
            <?php
$qry = mysqli_query($conn, "SELECT * FROM employee ORDER BY emp_id DESC");
while ($row = mysqli_fetch_array($qry, MYSQLI_ASSOC)) {
                echo '<tr><td>' . $row["emp_id"] . '</td>';
                echo '<td>' . $row["emp_name"] . '</td>';
                echo '<td>' . $row["emp_state"] . '</td>';
                echo '<td>' . $row["emp_city"] . '</td>';
                echo '<td>' . $row["emp_doj"] . '</td>';
                echo '<td>' . $row["emp_dob"] . '</td>';
                echo '<td>' . $row["dept_id"] . '</td>';
                echo '<td>' . $row["dept_name"] . '</td>';
                echo '<td> <a href="?edit=' . $row["emp_id"] . '"> EDIT | <a href="?delete=' . $row["emp_id"] . '">DELETE </td></tr>';
            }
            ?>
        </table>
    </div>

</body>

</html>
