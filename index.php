<?php
session_start();
include("db.php");

// Patient Login
if (isset($_POST['patlogin'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $res = mysqli_query($con, "SELECT * FROM patreg WHERE email='$email' AND password='$password'");
    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['pid'] = $row['pid'];
        $_SESSION['username'] = $row['fname'] . " " . $row['lname'];
        $_SESSION['fname'] = $row['fname'];
        $_SESSION['lname'] = $row['lname'];
        $_SESSION['gender'] = $row['gender'];
        $_SESSION['contact'] = $row['contact'];
        $_SESSION['email'] = $row['email'];
        header("Location: patient_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid Patient Credentials');</script>";
    }
}

// Doctor Login
if (isset($_POST['doclogin'])) {
    $dname = mysqli_real_escape_string($con, $_POST['dname']);
    $dpass = mysqli_real_escape_string($con, $_POST['dpass']);
    $res = mysqli_query($con, "SELECT * FROM doctreg WHERE username='$dname' AND password='$dpass'");
    if (mysqli_num_rows($res) == 1) {
        $_SESSION['dname'] = $dname;
        header("Location: doctor_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid Doctor Credentials');</script>";
    }
}

// Admin Login
if (isset($_POST['admlogin'])) {
    $aname = mysqli_real_escape_string($con, $_POST['aname']);
    $apass = mysqli_real_escape_string($con, $_POST['apass']);
    $res = mysqli_query($con, "SELECT * FROM admin WHERE username='$aname' AND password='$apass'");
    if (mysqli_num_rows($res) == 1) {
        $_SESSION['admin'] = $aname;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid Admin Credentials');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tamaraw Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">Tamaraw Hospital</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link active" href="index.php">Home</a>
            <a class="nav-link" href="about.php">About Us</a>
            <a class="nav-link" href="contact.php">Contact</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 bg-white p-4 rounded shadow">
            <ul class="nav nav-pills nav-fill mb-4" id="pills-tab" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#patient">Patient</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#doctor">Doctor</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#admin">Admin</button></li>
            </ul>

            <div class="tab-content">
                <!-- Patient Login -->
                <div class="tab-pane fade show active" id="patient">
                    <h4 class="mb-3">Patient Login</h4>
                    <form method="POST">
                        <div class="mb-3"><input type="email" name="email" class="form-control" placeholder="Email ID *" required></div>
                        <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password *" required></div>
                        <button type="submit" name="patlogin" class="btn btn-primary w-100">Login</button>
                    </form>
                    <hr class="my-3">
                    <div class="text-center">
                        <span class="text-muted">Don't have an account?</span>
                        <a href="register.php" class="btn btn-outline-primary btn-sm ms-2">Create Account</a>
                    </div>
                </div>

                <!-- Doctor Login -->
                <div class="tab-pane fade" id="doctor">
                    <h4 class="mb-3">Login as Doctor</h4>
                    <form method="POST">
                        <div class="mb-3"><input type="text" name="dname" class="form-control" placeholder="User Name *" required></div>
                        <div class="mb-3"><input type="password" name="dpass" class="form-control" placeholder="Password *" required></div>
                        <button type="submit" name="doclogin" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>

                <!-- Admin Login -->
                <div class="tab-pane fade" id="admin">
                    <h4 class="mb-3">Login as Admin</h4>
                    <form method="POST">
                        <div class="mb-3"><input type="text" name="aname" class="form-control" placeholder="User Name *" required></div>
                        <div class="mb-3"><input type="password" name="apass" class="form-control" placeholder="Password *" required></div>
                        <button type="submit" name="admlogin" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>