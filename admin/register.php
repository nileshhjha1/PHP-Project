<?php
// session_start();
require_once('../config.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $username = $conn->real_escape_string($_POST['username']);
    // Hash the password for security
    $password = md5($_POST['password']);

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, username, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstname, $lastname, $username, $password);

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        $_SESSION['message'] = "New record created successfully";
        adminRedirect("login.php");
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: blue;
        }

        .container {
            max-width: 500px;
            margin-top: 50px;
        }

        .card {
            border: 0;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-light p-3">
                <h2 class="card-title text-center mb-4 ">Budget management system</h2>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['message'])) : ?>
                    <div class="alert alert-<?php echo strpos($_SESSION['message'], 'Error') !== false ? 'danger' : 'success'; ?>" role="alert">
                        <?php echo $_SESSION['message']; ?>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>
                <form action="register.php" method="post">
                    <div class="form-group">
                        <label for="firstname">First Name:</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name:</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>
            </div>
        </div>
    </div>

</body>
<script>
        // Fade out the alert after 5 seconds
        setTimeout(function() {
            $(".alert").fadeOut("slow");
        }, 3000);
    </script>

</html>
