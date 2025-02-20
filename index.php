<?php
// Start session
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if username and password match
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :username AND password = :password");
    $stmt->execute(['username' => $username, 'password' => md5($password)]); // Using md5 for simplicity; consider using more secure hashing (e.g., bcrypt)
    
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: home.php');
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UHAS HR System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            background: url('bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Roboto', sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #fff;
            font-size: 2rem;
            font-weight: 700;
        }
        .login-container {
            max-width: 400px;
            width: 90%;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .login-container h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }
        .login-container .form-label {
            font-weight: 500;
            text-align: left;
            display: block;
        }
        .login-container input {
            border-radius: 8px;
            padding: 12px;
            width: 100%;
        }
        .login-container button {
            border-radius: 8px;
            padding: 12px;
            width: 100%;
            font-weight: 600;
        }
        .login-container .alert {
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .footer {
            text-align: center;
            padding: 15px;
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: #4CAF50;
            color: white;
            font-size: 0.9rem;
        }
        .logo {
            max-width: 100px;
            display: block;
            margin: 0 auto 20px;
        }
        @media (max-width: 768px) {
            .header h1 {
                font-size: 1.5rem;
            }
            .login-container {
                padding: 15px;
            }
            .footer {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>

<!-- Header -->
<div class="header">
    <h1>UHAS HRIS</h1>
</div>

<!-- Logo -->
<img src="uhas_logo.png" alt="UHAS HR System Logo" class="logo">

<!-- Login Form -->
<div class="login-container">
    <h2>Login</h2>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" id="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>
        <button type="submit" class="btn btn-success">Login</button>
    </form>
</div>

<!-- Footer -->
<div class="footer">
    &copy; <?= date('Y') ?>  UHAS HRIS. POWERED BY: DICT.
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
