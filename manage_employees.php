<?php
include('db.php');
if (isset($_POST['save_employee'])) {
    $photo = "default.png";
    if (!empty($_FILES["photo"]["name"])) { $photo = time()."_".$_FILES["photo"]["name"]; move_uploaded_file($_FILES["photo"]["tmp_name"], "images/".$photo); }
    $en = $_POST['emp_no']; $ps = $_POST['pass']; $ln = $_POST['lname']; $fn = $_POST['fname']; $mn = $_POST['mname']; $gn = $_POST['gender']; $em = $_POST['email']; $st = $_POST['status']; $nt = $_POST['nat']; $rl = $_POST['rel']; $bd = $_POST['bdate']; $pa = $_POST['p_addr']; $ca = $_POST['curr_addr']; $cn = $_POST['cont']; $ss = $_POST['sss']; $ph = $_POST['phil']; $pg = $_POST['pag']; $at = $_POST['atm']; $tn = $_POST['tin']; $dp = $_POST['dept']; $po = $_POST['pos']; $sd = $_POST['s_date']; $ed = $_POST['e_date']; $mp = $_POST['m_pay']; $dy = $_POST['d_pay']; $hy = $_POST['h_pay'];
    $sql = "INSERT INTO employees (photo, emp_no, portal_password, lname, fname, mname, gender, email, civil_status, nationality, religion, bdate, perm_address, pres_address, contact, sss, philhealth, pagibig, atm, tin, dept_id, pos_id, start_date, end_date, monthly_pay, daily_pay, hourly_pay) VALUES ('$photo','$en','$ps','$ln','$fn','$mn','$gn','$em','$st','$nt','$rl','$bd','$pa','$ca','$cn','$ss','$ph','$pg','$at','$tn','$dp','$po','$sd','$ed','$mp','$dy','$hy')";
    if (mysqli_query($conn, $sql)) { echo "<script>alert('Saved'); window.location='employees.php';</script>"; }
}
?>