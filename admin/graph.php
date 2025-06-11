<?php
// Connect to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expense_budget_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch balance data from categories table
$sql = "SELECT Category, Balance FROM categories";
$result = $conn->query($sql);

$categories = array();
$balances = array();

// Fetch data and store it in arrays
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['Category'];
        $balances[] = $row['Balance'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Balances Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="myChart" width="200" height="200"></canvas>

    <script>
        // PHP data passed to JavaScript
        var categories = <?php echo json_encode($categories); ?>;
        var balances = <?php echo json_encode($balances); ?>;

        // Create chart using Chart.js
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: categories,
                datasets: [{
                    label: 'Balance',
                    data: balances,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>

