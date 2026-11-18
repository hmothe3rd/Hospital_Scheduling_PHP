<?php
session_start();
include("db.php");
if (!isset($_SESSION['admin'])) { header("Location: index.php"); exit(); }

// Add Doctor
if (isset($_POST['docsub'])) {
    $doctor = mysqli_real_escape_string($con, $_POST['doctor']);
    $dpassword = mysqli_real_escape_string($con, $_POST['dpassword']);
    $demail = mysqli_real_escape_string($con, $_POST['demail']);
    $docFees = mysqli_real_escape_string($con, $_POST['docFees']);
    $query = "INSERT INTO doctreg(username, password, email, docFees) VALUES ('$doctor','$dpassword','$demail','$docFees')";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Doctor added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding doctor (Email may already exist).');</script>";
    }
}

// Delete Doctor
if (isset($_POST['docdel'])) {
    $demail = mysqli_real_escape_string($con, $_POST['demail']);
    mysqli_query($con, "DELETE FROM doctreg WHERE email='$demail'");
    if (mysqli_affected_rows($con) > 0) {
        echo "<script>alert('Doctor removed successfully!');</script>";
    } else {
        echo "<script>alert('Doctor email not found.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Tamaraw Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <span class="navbar-brand">Tamaraw Hospital | Welcome Admin</span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#doctors">Doctor List</a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#patients">Patient List</a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#appointments">Appointment Details</a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#add-doc">Add Doctor</a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#del-doc">Delete Doctor</a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#queries">Queries</a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content bg-white p-4 rounded shadow">
                <!-- 1. Doctor List -->
                <div class="tab-pane fade show active" id="doctors">
                    <form method="POST" class="d-flex mb-3">
                        <input type="text" name="doc_email" class="form-control me-2" placeholder="Enter Email ID">
                        <button type="submit" name="search_doc" class="btn btn-primary">Search</button>
                    </form>
                    <table class="table table-bordered">
                        <thead><tr><th>Doctor Name</th><th>Password</th><th>Email</th><th>Fees</th></tr></thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM doctreg";
                            if (isset($_POST['search_doc']) && !empty($_POST['doc_email'])) {
                                $doc_email = mysqli_real_escape_string($con, $_POST['doc_email']);
                                $sql .= " WHERE email='$doc_email'";
                            }
                            $res = mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_assoc($res)) {
                                echo "<tr><td>{$row['username']}</td><td>{$row['password']}</td><td>{$row['email']}</td><td>{$row['docFees']}</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- 2. Patient List -->
                <div class="tab-pane fade" id="patients">
                    <form method="POST" class="d-flex mb-3">
                        <input type="text" name="pat_contact" class="form-control me-2" placeholder="Enter Contact Number">
                        <button type="submit" name="search_pat" class="btn btn-primary">Search</button>
                    </form>
                    <table class="table table-bordered">
                        <thead><tr><th>Patient ID</th><th>First Name</th><th>Last Name</th><th>Gender</th><th>Email</th><th>Contact</th><th>Password</th></tr></thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM patreg";
                            if (isset($_POST['search_pat']) && !empty($_POST['pat_contact'])) {
                                $pat_contact = mysqli_real_escape_string($con, $_POST['pat_contact']);
                                $sql .= " WHERE contact='$pat_contact'";
                            }
                            $res = mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_assoc($res)) {
                                echo "<tr><td>{$row['pid']}</td><td>{$row['fname']}</td><td>{$row['lname']}</td><td>{$row['gender']}</td><td>{$row['email']}</td><td>{$row['contact']}</td><td>{$row['password']}</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- 3. Appointment List -->
                <div class="tab-pane fade" id="appointments">
                    <table class="table table-bordered">
                        <thead><tr><th>Patient</th><th>Email</th><th>Contact</th><th>Doctor</th><th>Fees</th><th>Date</th><th>Time</th><th>Status</th></tr></thead>
                        <tbody>
                            <?php
                            $res = mysqli_query($con, "SELECT * FROM appointmenttb");
                            while ($row = mysqli_fetch_assoc($res)) {
                                if ($row['userStatus'] == 1 && $row['doctorStatus'] == 1) $status = "Active";
                                elseif ($row['userStatus'] == 0 && $row['doctorStatus'] == 1) $status = "Deleted by Patient";
                                else $status = "Deleted by Doctor";
                                echo "<tr><td>{$row['fname']} {$row['lname']}</td><td>{$row['email']}</td><td>{$row['contact']}</td><td>{$row['doctor']}</td><td>{$row['docFees']}</td><td>{$row['appdate']}</td><td>{$row['apptime']}</td><td>$status</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- 4. Add Doctor -->
                <div class="tab-pane fade" id="add-doc">
                    <form method="POST">
                        <div class="mb-3"><input type="text" name="doctor" class="form-control" placeholder="Doctor Name" required></div>
                        <div class="mb-3"><input type="email" name="demail" class="form-control" placeholder="Email ID" required></div>
                        <div class="mb-3"><input type="password" name="dpassword" class="form-control" placeholder="Password" required></div>
                        <div class="mb-3"><input type="number" name="docFees" class="form-control" placeholder="Consultancy Fees" required></div>
                        <button type="submit" name="docsub" class="btn btn-primary">Add Doctor</button>
                    </form>
                </div>

                <!-- 5. Delete Doctor -->
                <div class="tab-pane fade" id="del-doc">
                    <form method="POST">
                        <div class="mb-3"><input type="email" name="demail" class="form-control" placeholder="Enter Doctor Email ID" required></div>
                        <button type="submit" name="docdel" class="btn btn-danger">Delete Doctor</button>
                    </form>
                </div>

                <!-- 6. Queries / Feedback -->
                <div class="tab-pane fade" id="queries">
                    <table class="table table-bordered">
                        <thead><tr><th>User Name</th><th>Email</th><th>Contact</th><th>Message</th></tr></thead>
                        <tbody>
                            <?php
                            $res = mysqli_query($con, "SELECT * FROM contact");
                            while ($row = mysqli_fetch_assoc($res)) {
                                echo "<tr><td>{$row['name']}</td><td>{$row['email']}</td><td>{$row['contact']}</td><td>{$row['message']}</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>