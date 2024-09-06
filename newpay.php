
<?php
include "connection.php";

$transaction_id = "";
$emp_gross = "";
$reimbursement_date = "";
$emp_id = "";

$success_message = "";
$error_message = "";

# Add new Payroll transaction
if (isset($_POST["button_add"])) {
    $transaction_id = mysqli_real_escape_string($conn, $_POST["transaction_id"]);
    $emp_id = mysqli_real_escape_string($conn, $_POST["emp_id"]);
    $emp_gross = mysqli_real_escape_string($conn, $_POST["emp_gross"]);
    $reimbursement_date = mysqli_real_escape_string($conn, $_POST["reimbursement_date"]);

    // Calculate emp_net_sal, emp_year_sal, and emp_month_sal based on emp_gross
    $emp_net_sal = 0.9 * $emp_gross;
    $emp_year_sal = $emp_net_sal - ($emp_net_sal * 0.05);
    $emp_month_sal = $emp_year_sal / 12;

    $query_payroll = mysqli_query($conn, "INSERT INTO payroll (transaction_id, emp_id, emp_net_sal, emp_month_sal, emp_sal_year, reimbursement_date, emp_gross) 
                                   VALUES('$transaction_id', '$emp_id', '$emp_net_sal', '$emp_month_sal', '$emp_year_sal', '$reimbursement_date', '$emp_gross') ")
        or die("Cannot Query With Database!");

    // Calculate tax_deduction and pf
    $tax_deduction = $emp_gross - $emp_net_sal;x
    $pf = 2000;

    // Insert data into the salary table
    $query_salary = mysqli_query($conn, "INSERT INTO salary (emp_id, tax_deduction, tax_type, pf, travel_allowance, reimbursement_date) 
                                   VALUES('$emp_id', '$tax_deduction', 'Income Tax', '$pf', '4250', '$reimbursement_date') ")
        or die("Cannot Query With Database!");

    if ($query_payroll && $query_salary) {
        $success_message = "New Payroll Transaction and Salary Record Added Successfully!";
    } else {
        $error_message = "Failed to Add Payroll Transaction and Salary Record!";
    }
}

# Edit existing Payroll transaction
elseif (isset($_POST["button_edit"])) {
    $transaction_id = mysqli_real_escape_string($conn, $_POST["transaction_id"]);
    $emp_id = mysqli_real_escape_string($conn, $_POST["emp_id"]);
    $emp_gross = mysqli_real_escape_string($conn, $_POST["emp_gross"]);
    $reimbursement_date = mysqli_real_escape_string($conn, $_POST["reimbursement_date"]);

    // Calculate emp_net_sal, emp_year_sal, and emp_month_sal based on emp_gross
    $emp_net_sal = 0.9 * $emp_gross;
    $emp_year_sal = $emp_net_sal - ($emp_net_sal * 0.05);
    $emp_month_sal = $emp_year_sal / 12;

    $query_payroll = "UPDATE payroll SET emp_id='$emp_id', emp_net_sal='$emp_net_sal', emp_month_sal='$emp_month_sal', emp_sal_year='$emp_year_sal', 
                                  reimbursement_date='$reimbursement_date', emp_gross='$emp_gross'
                                  WHERE transaction_id='$transaction_id'";

    $result_payroll = mysqli_query($conn, $query_payroll);

    // Calculate tax_deduction and pf
    $tax_deduction = $emp_gross - $emp_net_sal;
    $pf = 2000;

    // Update data in the salary table
    $query_salary = "UPDATE salary SET tax_deduction='$tax_deduction', pf='$pf', travel_allowance='4250', reimbursement_date='$reimbursement_date' WHERE emp_id='$emp_id'";
    $result_salary = mysqli_query($conn, $query_salary);

    if ($result_payroll && $result_salary) {
        $success_message = "Edit Done Successfully!";
    } else {
        $error_message = "Failed to Edit Payroll Transaction!";
    }
}

# Edit the contents of the Payroll transaction
if (isset($_GET["edit"])) {
    $transaction_id = mysqli_real_escape_string($conn, $_GET["edit"]);

    $query_payroll = "SELECT * FROM payroll WHERE transaction_id = '$transaction_id'";
    $result_payroll = mysqli_query($conn, $query_payroll);

    while ($row = mysqli_fetch_array($result_payroll, MYSQLI_ASSOC)) {
        $transaction_id = $row["transaction_id"];
        $emp_id = $row["emp_id"];
        $emp_gross = $row["emp_gross"];
        $reimbursement_date = $row["reimbursement_date"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Management</title>
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
            top:

 50%;
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
        <h2>Payroll Management</h2>
        <input type="text" name="transaction_id" placeholder="Transaction ID" required>
        <input type="text" name="emp_id" placeholder="Employee ID" required>
        <input type="text" name="emp_gross" placeholder="Gross Salary">
        <!-- <input type="text" name="reimbursement_date" placeholder="Reimbursement Date"> -->
        <input  type="text" placeholder="Reimbursement Date" name="reimbursement_date" onfocus="this.type='date'" onblur="this.type='text'">
        <input type="submit" name="button_add" value="Add" onclick="showSuccessMessage('<?php echo $success_message; ?>', 'success-popup')">
    </form>

    <div id="success-popup" class="success-popup"><?php echo $success_message; ?></div>
    <div id="error-popup" class="error-popup"><?php echo $error_message; ?></div>

    <script>
        function showSuccessMessage(message, popupId) {
            document.getElementById(popupId).innerHTML = message;
            document.getElementById(popupId).style.display = 'block';
            setTimeout(function() {
                document.getElementById(popupId).style.display = 'none';
                location.reload(); // Reload the page
            }, 3000);
        }
    </script>
</body>

</html>
