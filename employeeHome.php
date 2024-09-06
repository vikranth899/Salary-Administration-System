
<!DOCTYPE html>
<html lang="en">

<head>
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
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        h4 {
            font-size: 24px;
            margin-top: 20px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: slideIn 1s ease-in-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
            }
            to {
                transform: translateY(0);
            }
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
            font-size: 18px;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }
    </style>
</head>

<body>
    <?php
    include "connection.php";
    session_start();

    // Check if the username is set in the session
    if (isset($_SESSION['username'])) {
        // Retrieve the username
        $username = $_SESSION['username'];

        // SQL query to retrieve data from both tables using a JOIN
        $query = "SELECT salary.emp_id, payroll.transaction_id, payroll.emp_net_sal, payroll.emp_month_sal, payroll.emp_sal_year, salary.tax_deduction, salary.tax_type, salary.pf, salary.travel_allowance, salary.reimbursement_date, payroll.emp_gross
        FROM salary
        INNER JOIN payroll ON salary.emp_id = payroll.emp_id AND salary.reimbursement_date = payroll.reimbursement_date
        WHERE salary.emp_id = '$username'
        ORDER BY salary.reimbursement_date DESC";

        $result = mysqli_query($conn, $query);

        if ($result) {
            // Display the combined data in a table
            echo "<h4>Welcome, $username</h4>";
            echo "<table>
                <tr>
                    <th>Employee ID</th>
                    <th>Transaction ID</th>
                    <th>Net Salary</th>
                    <th>Month Salary</th>
                    <th>Salary Year</th>
                    <th>Tax Deduction</th>
                    <th>Tax Type</th>
                    <th>PF</th>
                    <th>Travel Allowance</th>
                    <th>Reimbursement Date</th>
                    <th>Gross Salary</th>
                </tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$row['emp_id']}</td>
                    <td>{$row['transaction_id']}</td>
                    <td>{$row['emp_net_sal']}</td>
                    <td>{$row['emp_month_sal']}</td>
                    <td>{$row['emp_sal_year']}</td>
                    <td>{$row['tax_deduction']}</td>
                    <td>{$row['tax_type']}</td>
                    <td>{$row['pf']}</td>
                    <td>{$row['travel_allowance']}</td>
                    <td>{$row['reimbursement_date']}</td>
                    <td>{$row['emp_gross']}</td>
                </tr>";
            }

            echo "</table>";
        } else {
            echo "Error in query: " . mysqli_error($conn);
        }
    } else {
        echo "<h4>Session username not set.</h4>";
    }
    ?>
</body>

</html>
