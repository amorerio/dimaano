<?php
session_start();
include('db.php');
if (!isset($_SESSION['admin'])) { header("Location: index.php"); }
$recent = mysqli_query($conn, "SELECT lname, fname, emp_no FROM employees ORDER BY id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="main-content">
        <div class="top-bar">
            <h2 style="margin:0; color:#003366; font-size:18px;">LCC ADMIN DASHBOARD</h2>
            <div class="nav-icons">
                <a href="#" class="nav-icon-link">👤</a>
                <a href="logout.php" class="nav-icon-link" style="color:red;">🚪</a>
            </div>
        </div>
        <div class="container">
            <div class="content-card" style="padding:40px; border-left: 8px solid #FFCC00;">
                <h1 style="margin:0; color:#003366;">Welcome Back, <?php echo $_SESSION['admin']; ?>!</h1>
                <p>All payroll modules are currently operational.</p>
            </div>
            <div class="content-card">
                <div class="card-header">RECENTLY ADDED EMPLOYEES</div>
                <div class="card-body">
                    <?php while($r = mysqli_fetch_assoc($recent)) { ?>
                        <div style="padding:10px; border-bottom:1px solid #eee;">
                            <b><?php echo $r['fname']." ".$r['lname']; ?></b> (ID: <?php echo $r['emp_no']; ?>)
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>