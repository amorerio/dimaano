<?php
include('db.php');

if (isset($_POST['add_dept'])) {
    $name = mysqli_real_escape_string($conn, $_POST['dept_name']);
    mysqli_query($conn, "INSERT INTO departments (name) VALUES ('$name')");
    header("Location: dep_pos.php");
}

if (isset($_POST['edit_dept'])) {
    $id = $_POST['dept_id'];
    $name = mysqli_real_escape_string($conn, $_POST['dept_name']);
    mysqli_query($conn, "UPDATE departments SET name='$name' WHERE id='$id'");
    header("Location: dep_pos.php");
}

if (isset($_GET['del_dept'])) {
    $id = $_GET['del_dept'];
    mysqli_query($conn, "DELETE FROM departments WHERE id='$id'");
    header("Location: dep_pos.php");
}

if (isset($_POST['add_pos'])) {
    $name = mysqli_real_escape_string($conn, $_POST['pos_name']);
    mysqli_query($conn, "INSERT INTO positions (name) VALUES ('$name')");
    header("Location: dep_pos.php");
}

if (isset($_POST['edit_pos'])) {
    $id = $_POST['pos_id'];
    $name = mysqli_real_escape_string($conn, $_POST['pos_name']);
    mysqli_query($conn, "UPDATE positions SET name='$name' WHERE id='$id'");
    header("Location: dep_pos.php");
}

if (isset($_GET['del_pos'])) {
    $id = $_GET['del_pos'];
    mysqli_query($conn, "DELETE FROM positions WHERE id='$id'");
    header("Location: dep_pos.php");
}
?>