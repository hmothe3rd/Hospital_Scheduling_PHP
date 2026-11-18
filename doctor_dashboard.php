<?php
session_start();
include("db.php");
if (!isset($_SESSION['dname'])) { header("Location: index.php"); exit(); }
$dname = $_SESSION['dname'];

// Cancel Appointment
if (isset($_GET['cancel']) && isset($_GET['ID'])) {
    $id = intval($_GET['ID']);
    mysqli_query($con, "UPDATE appointmenttb SET doctorStatus='0' WHERE ID='$id' AND doctor='$dname'");
    echo "<script>alert('Appointment cancelled'); window.location.href='doctor_dashboard.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Dashboard - Tamaraw Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <span class="navbar-brand">Tamaraw Hospital | Welcome Dr. <?php echo htmlspecialchars($dname); ?></span>
        <form class="d-flex" method="POST">
            <input class="form-control me-2" type="search" name="search_contact" placeholder="Enter Contact Number">
            <button class="btn btn-light me-3" type="submit" name="search_submit">Search</button>
            <a href="logout.php" class="btn btn-outline-light">Logout</a>
        </form>
    </div>
</nav>

<div class="container mt-4 bg-white p-4 rounded shadow">
    <h4>Appointments</h4>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Patient ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Current Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM appointmenttb WHERE doctor='$dname'";
            if (isset($_POST['search_submit']) && !empty($_POST['search_contact'])) {
                $contact = mysqli_real_escape_string($con, $_POST['search_contact']);
                $sql .= " AND contact='$contact'";
            }
            $res = mysqli_query($con, $sql);
            while ($row = mysqli_fetch_assoc($res)) {
                echo "<tr>
                    <td>{$row['pid']}</td>
                    <td>{$row['fname']}</td>
                    <td>{$row['lname']}</td>
                    <td>{$row['gender']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['contact']}</td>
                    <td>{$row['appdate']}</td>
                    <td>{$row['apptime']}</td>
                    <td>";
                if ($row['userStatus'] == 1 && $row['doctorStatus'] == 1) echo "Active";
                elseif ($row['userStatus'] == 0 && $row['doctorStatus'] == 1) echo "Deleted by Patient";
                elseif ($row['userStatus'] == 1 && $row['doctorStatus'] == 0) echo "Deleted by You";
                echo "</td><td>";
                if ($row['userStatus'] == 1 && $row['doctorStatus'] == 1) {
                    echo "<a href='doctor_dashboard.php?ID={$row['ID']}&cancel=update' class='btn btn-danger btn-sm'>Cancel</a>";
                } else {
                    echo "Cancelled";
                }
                echo "</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>