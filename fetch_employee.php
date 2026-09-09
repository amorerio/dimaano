<?php
session_start();
include('db.php');

if (!isset($_SESSION['admin']) || !isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$emp_id = intval($_GET['id']);

// Fetch main employee data
$emp_query = mysqli_query($conn, "SELECT * FROM employees WHERE id = $emp_id");
$employee = mysqli_fetch_assoc($emp_query);

if (!$employee) {
    echo json_encode(['success' => false, 'message' => 'Employee not found']);
    exit;
}

// Fetch emergency contacts
$emergency = [];
$emerg_query = mysqli_query($conn, "SELECT * FROM employee_emergency WHERE emp_id = $emp_id");
if ($emerg_query) {
    while ($row = mysqli_fetch_assoc($emerg_query)) {
        $emergency[] = $row;
    }
}

// Fetch dependents
$dependents = [];
$depend_query = mysqli_query($conn, "SELECT * FROM employee_dependents WHERE emp_id = $emp_id");
if ($depend_query) {
    while ($row = mysqli_fetch_assoc($depend_query)) {
        $dependents[] = $row;
    }
}

// Fetch education
$education = [];
$edu_query = mysqli_query($conn, "SELECT * FROM employee_education WHERE emp_id = $emp_id");
if ($edu_query) {
    while ($row = mysqli_fetch_assoc($edu_query)) {
        $education[] = $row;
    }
}

// Fetch references
$references = [];
$ref_query = mysqli_query($conn, "SELECT * FROM employee_references WHERE emp_id = $emp_id");
if ($ref_query) {
    while ($row = mysqli_fetch_assoc($ref_query)) {
        $references[] = $row;
    }
}

echo json_encode([
    'success' => true,
    'employee' => $employee,
    'emergency' => $emergency,
    'dependents' => $dependents,
    'education' => $education,
    'references' => $references
]);
?>
