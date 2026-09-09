<?php
session_start();
include('db.php');
if (isset($_POST['login'])) {
    $u = $_POST['username']; $p = $_POST['password'];
    $res = mysqli_query($conn, "SELECT * FROM users WHERE username='$u' AND password='$p'");
    if (mysqli_num_rows($res) > 0) { $_SESSION['admin'] = $u; header("Location: dashboard.php"); }
    else { echo "<script>alert('Invalid Access');</script>"; }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>LCC Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">
    <div class="login-container">
        <h2>ADMIN PORTAL</h2>
        <p>Lipa City Colleges Payroll System</p>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" class="btn-yellow" style="width:100%; margin-top:10px;">SIGN IN</button>
        </form>
    </div>
</body>
</html>