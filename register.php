<?php
session_start();
include("db.php");

if (isset($_POST['patsub'])) {
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $check = mysqli_query($con, "SELECT email FROM patreg WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Email already registered!');</script>";
    } else {
        $query = "INSERT INTO patreg(fname, lname, gender, email, contact, password) VALUES ('$fname','$lname','$gender','$email','$contact','$password')";
        if (mysqli_query($con, $query)) {
            $_SESSION['pid'] = mysqli_insert_id($con);
            $_SESSION['username'] = $fname . " " . $lname;
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['gender'] = $gender;
            $_SESSION['contact'] = $contact;
            $_SESSION['email'] = $email;
            echo "<script>alert('Account created successfully!'); window.location.href='patient_dashboard.php';</script>";
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Registration - Tamaraw Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">Tamaraw Hospital</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="index.php">Home</a>
            <a class="nav-link" href="about.php">About Us</a>
            <a class="nav-link" href="contact.php">Contact</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 bg-white p-4 rounded shadow">
            <h4 class="mb-3">Create Patient Account</h4>
            <form method="POST">
                <div class="row mb-3">
                    <div class="col"><input type="text" name="fname" class="form-control" placeholder="First Name *" required></div>
                    <div class="col"><input type="text" name="lname" class="form-control" placeholder="Last Name *" required></div>
                </div>
                <div class="row mb-3">
                    <div class="col"><input type="email" name="email" class="form-control" placeholder="Your Email *" required></div>
                    <div class="col"><input type="text" name="contact" class="form-control" placeholder="Your Phone *" required></div>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password *" required>
                </div>
                <div class="mb-3">
                    <label class="me-3"><input type="radio" name="gender" value="Male" checked> Male</label>
                    <label><input type="radio" name="gender" value="Female"> Female</label>
                </div>
                <button type="submit" name="patsub" class="btn btn-primary w-100">Register</button>
            </form>
            <hr class="my-3">
            <div class="text-center">
                <span class="text-muted">Already have an account?</span>
                <a href="index.php" class="btn btn-outline-secondary btn-sm ms-2">Back to Login</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>