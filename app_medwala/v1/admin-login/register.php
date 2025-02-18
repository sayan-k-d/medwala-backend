<?php
session_start();
$envFile = __DIR__ . '/../../../.env';
if (file_exists($envFile)) {
    $env = parse_ini_file($envFile);
} else {
    $env = [];
}
$DATABASE_HOST = $env['DATABASE_SERVER'] ?? "localhost";
$DATABASE_USER = $env['DATABASE_USERNAME'] ?? 'grihoudy_medwala';
$DATABASE_PASS = $env['DATABASE_PASSWORD'] ?? 'zfws(&6Zx^J1';
$DATABASE_NAME = $env['DATABASE_NAME'] ?? 'grihoudy_medwala';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (! isset($_POST['username'], $_POST['password'], $_POST['conf_password'])) {
    // Could not get the data that should have been sent.
    exit('Please fill all the fields!');
}
if ($_POST['password'] != $_POST['conf_password']) {
    exit('Passwords do not match!');
}
if (! isset($_POST['terms'])) {
    exit('You must agree to the terms and conditions!');
}

if ($stmt = $con->prepare('SELECT id FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire('User Exists', 'Username Already Taken!', 'info').then(() => {
                                window.location.href = 'index.php';
                            });
                    });
                  </script>";
    } else {
        // Insert new user
        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)')) {
            $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
            $stmt->bind_param('sss', $_POST['username'], $hashed_password, $_POST['username']);
            $stmt->execute();
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Registration successful! Redirecting...',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'index.php';
                            });
                        });
                      </script>";
            // echo 'Registration successful! You can now <a href="login.php">login</a>';
        } else {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire('Error', 'Something Went Wrong, Couldn't register user!', 'error').then(() => {
                                window.location.href = 'index.php';
                            });
                    });
                  </script>";
            // echo 'Could not prepare statement!';
        }
    }
    $stmt->close();
} else {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire('Error', 'Something Went Wrong, Couldn't register user!', 'error').then(() => {
                                window.location.href = 'index.php';
                            });
            });
            </script>";
}
$con->close();
