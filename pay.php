
<?php

include "connection.php";

$transaction_id = "";
$emp_net_sal = "";
$emp_month_sal = "";
$emp_sal_year = "";
$reimbursement_date = "";
$emp_gross = "";
$grade_id = "";
$emp_id = "";

# Add new Payroll transaction
if (isset($_POST["button_add"])) {
    echo "button_add is running! \n";

    # To Query ( Insert the data from HTML form into the database using POST method )
    $transaction_id = mysqli_real_escape_string($conn, $_POST["transaction_id"]);
    $emp_id = mysqli_real_escape_string($conn, $_POST["emp_id"]);  // Assuming emp_id is selected from a dropdown or similar UI component
    $emp_net_sal = mysqli_real_escape_string($conn, $_POST["emp_net_sal"]);
    $emp_month_sal = mysqli_real_escape_string($conn, $_POST["emp_month_sal"]);
    $emp_sal_year = mysqli_real_escape_string($conn, $_POST["emp_sal_year"]);
    $reimbursement_date = mysqli_real_escape_string($conn, $_POST["reimbursement_date"]);
    $emp_gross = mysqli_real_escape_string($conn, $_POST["emp_gross"]);
    $grade_id = mysqli_real_escape_string($conn, $_POST["grade_id"]);

    $query = mysqli_query($conn, "INSERT INTO payroll (transaction_id, emp_id, emp_net_sal, emp_month_sal, emp_sal_year, reimbursement_date, emp_gross, grade_id) 
                                   VALUES('$transaction_id', '$emp_id', '$emp_net_sal', '$emp_month_sal', '$emp_sal_year', '$reimbursement_date', '$emp_gross', '$grade_id') ")
        or die("Cannot Query With Database!");

    if ($query) {
        echo "New Payroll Transaction Added Successfully To the Database!\n";
    }
}

# Edit existing Payroll transaction
elseif (isset($_POST["button_edit"])) {
    echo "button_edit is running! \n";

    $transaction_id = mysqli_real_escape_string($conn, $_POST["transaction_id"]);
    $emp_id = mysqli_real_escape_string($conn, $_POST["emp_id"]);
    $emp_net_sal = mysqli_real_escape_string($conn, $_POST["emp_net_sal"]);
    $emp_month_sal = mysqli_real_escape_string($conn, $_POST["emp_month_sal"]);
    $emp_sal_year = mysqli_real_escape_string($conn, $_POST["emp_sal_year"]);
    $reimbursement_date = mysqli_real_escape_string($conn, $_POST["reimbursement_date"]);
    $emp_gross = mysqli_real_escape_string($conn, $_POST["emp_gross"]);
    $grade_id = mysqli_real_escape_string($conn, $_POST["grade_id"]);

    $query = "UPDATE payroll SET emp_id='$emp_id', emp_net_sal='$emp_net_sal', emp_month_sal='$emp_month_sal', emp_sal_year='$emp_sal_year', 
                                  reimbursement_date='$reimbursement_date', emp_gross='$emp_gross', grade_id='$grade_id'
                                  WHERE transaction_id='$transaction_id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Edit Done Successfully!";
    }
}

# Delete existing Payroll transaction
if (isset($_GET["delete"])) {
    $transaction_id = mysqli_real_escape_string($conn, $_GET["delete"]);

    $query = "DELETE FROM payroll WHERE transaction_id = '$transaction_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo 'Successfully Deleted Payroll Transaction Id = ' . $transaction_id . ' from Database!';
    }
}

# Edit the contents of the Payroll transaction
if (isset($_GET["edit"])) {
    $transaction_id = mysqli_real_escape_string($conn, $_GET["edit"]);

    $query = "SELECT * FROM payroll WHERE transaction_id = '$transaction_id'";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $transaction_id = $row["transaction_id"];
        $emp_id = $row["emp_id"];
        $emp_net_sal = $row["emp_net_sal"];
        $emp_month_sal = $row["emp_month_sal"];
        $emp_sal_year = $row["emp_sal_year"];
        $reimbursement_date = $row["reimbursement_date"];
        $emp_gross = $row["emp_gross"];
        $grade_id = $row["grade_id"];
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Payroll Management</title>
    <style>
        body {
            background-color: #f0f8ff;
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 70%;
            margin: auto;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #3498db;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th

 {
            background-color: #3498db;
            color: white;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>

    <div align="center">
        <h2>Payroll Management</h2>
    </div>

    <div name="payroll_div" align="center">
        <form action='<?php echo $_SERVER["PHP_SELF"]; ?>' method="post">
            <table>
                <tr>
                    <td>Transaction ID</td>
                    <td><input type="text" name="transaction_id" value="<?php echo $transaction_id; ?>" required></td>
                </tr>
                <tr>
                    <td>Employee ID</td>
                    <td><input type="text" name="emp_id" value="<?php echo $emp_id; ?>"></td>
                </tr>
                <tr>
                    <td>Net Salary</td>
                    <td><input type="text" name="emp_net_sal" value="<?php echo $emp_net_sal; ?>"></td>
                </tr>
                <tr>
                    <td>Month Salary</td>
                    <td><input type="text" name="emp_month_sal" value="<?php echo $emp_month_sal; ?>"></td>
                </tr>
                <tr>
                    <td>Salary Year</td>
                    <td><input type="text" name="emp_sal_year" value="<?php echo $emp_sal_year; ?>"></td>
                </tr>
                <tr>
                    <td>Reimbursement Date</td>
                    <td><input type="text" name="reimbursement_date" value="<?php echo $reimbursement_date; ?>"></td>
                </tr>
                <tr>
                    <td>Gross Salary</td>
                    <td><input type="text" name="emp_gross" value="<?php echo $emp_gross; ?>"></td>
                </tr>
                <tr>
                    <td>Grade ID</td>
                    <td><input type="text" name="grade_id" value="<?php echo $grade_id; ?>"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php if (empty($transaction_id)) : ?>
                            <input type="submit" name="button_add" value="Add" />
                        <?php else : ?>
                            <input type="submit" name="button_edit" value="Edit" />
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <div align="center">
        <table>
            <!-- Row Headers -->
            <tr>
                <th>Transaction ID</th>
                <th>Employee ID</th>
                <th>Net Salary</th>
                <th>Month Salary</th>
                <th>Salary Year</th>
                <th>Reimbursement Date</th>
                <th>Gross Salary</th>
                <th>Grade ID</th>
                <th>Action</th>
            </tr>
            <!-- Row Data -->
            <?php
            $qry = mysqli_query($conn, "SELECT * FROM payroll ORDER BY transaction_id DESC");
            while ($row = mysqli_fetch_array($qry, MYSQLI_ASSOC)) {
                echo '<tr><td>' . $row["transaction_id"] . '</td>';
                echo '<td>' . $row["emp_id"] . '</td>';
                echo '<td>' . $row["emp_net_sal"] . '</td>';
                echo '<td>' . $row["emp_month_sal"] . '</td>';
                echo '<td>' . $row["emp_sal_year"] . '</td>';
                echo '<td>' . $row["reimbursement_date"] . '</td>';
                echo '<td>' . $row["emp_gross"] . '</td>';
                echo '<td>' . $row["grade_id"] . '</td>';
                echo '<td> <a href="?edit=' . $row["transaction_id"] . '"> EDIT | <a href="?delete=' . $row["transaction_id"] . '">DELETE </td></tr>';
            }
            ?>
        </table>
    </div>

</body>

</html>

