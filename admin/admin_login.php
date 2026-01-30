<?php
session_start();

if(isset($_POST['login'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if($user == "admin" && $pass == "admin123"){
        $_SESSION['admin'] = true;
        header("Location: admin_dashboard.php");
    } else {
        $error = "Invalid Login";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link rel="stylesheet" href="admin_style.css">
</head>
<body class="login-body">

<form method="POST" class="login-box">
    <h2>Admin Login</h2>
    <?php if(isset($error)) echo "<p>$error</p>"; ?>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button name="login">Login</button>
</form>

</body>
</html>
