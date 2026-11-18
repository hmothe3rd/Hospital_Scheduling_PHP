<?php
session_start();
include("db.php");
if (!isset($_SESSION['pid'])) { header("Location: index.php"); exit(); }

$pid = $_SESSION['pid'];
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];
$gender = $_SESSION['gender'];
$email = $_SESSION['email'];
$contact = $_SESSION['contact'];

// Book Appointment
if (isset($_POST['app-submit'])) {
    $doctor = mysqli_real_escape_string($con, $_POST['doctor']);
    $docFees = mysqli_real_escape_string($con, $_POST['docFees']);
    $appdate = mysqli_real_escape_string($con, $_POST['appdate']);
    $apptime = mysqli_real_escape_string($con, $_POST['apptime']);

    $query = "INSERT INTO appointmenttb(pid, fname, lname, gender, email, contact, doctor, docFees, appdate, apptime, userStatus, doctorStatus) 
              VALUES ('$pid','$fname','$lname','$gender','$email','$contact','$doctor','$docFees','$appdate','$apptime','1','1')";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Your appointment successfully booked');</script>";
    }
}

// Cancel Appointment
if (isset($_GET['cancel']) && isset($_GET['ID'])) {
    $id = intval($_GET['ID']);
    mysqli_query($con, "UPDATE appointmenttb SET userStatus='0' WHERE ID='$id' AND pid='$pid'");
    echo "<script>alert('Your appointment successfully cancelled'); window.location.href='patient_dashboard.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Dashboard - Tamaraw Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <span class="navbar-brand">Tamaraw Hospital | Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#book">Book Appointment</a>
                <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#history">Appointment History</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content bg-white p-4 rounded shadow">
                <!-- Book Appointment -->
                <div class="tab-pane fade show active" id="book">
                    <h4>Create an Appointment</h4>
                    <form method="POST">
                        <div class="mb-3">
                            <label>Doctors</label>
                            <select name="doctor" id="doctor" class="form-control" onchange="updateFees()" required>
                                <option value="" disabled selected>Select Doctor</option>
                                <?php
                                $docs = mysqli_query($con, "SELECT * FROM doctreg");
                                while ($row = mysqli_fetch_assoc($docs)) {
                                    echo "<option value='{$row['username']}' data-fees='{$row['docFees']}'>{$row['username']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Consultancy Fees</label>
                            <input type="text" name="docFees" id="docFees" class="form-control" readonly required>
                        </div>
                        <div class="mb-3">
                            <label>Appointment Date</label>
                            <input type="date" name="appdate" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Appointment Time</label>
                            <input type="time" name="apptime" class="form-control" required>
                        </div>
                        <button type="submit" name="app-submit" class="btn btn-primary">Create new entry</button>
                    </form>
                </div>

                <!-- Appointment History -->
                <div class="tab-pane fade" id="history">
                    <h4>Appointment History</h4>
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Doctor Name</th>
                                <th>Consultancy Fees</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Current Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $res = mysqli_query($con, "SELECT * FROM appointmenttb WHERE pid='$pid'");
                            while ($row = mysqli_fetch_assoc($res)) {
                                echo "<tr>
                                    <td>{$row['doctor']}</td>
                                    <td>{$row['docFees']}</td>
                                    <td>{$row['appdate']}</td>
                                    <td>{$row['apptime']}</td>
                                    <td>";
                                if ($row['userStatus'] == 1 && $row['doctorStatus'] == 1) echo "Active";
                                elseif ($row['userStatus'] == 0 && $row['doctorStatus'] == 1) echo "Deleted by You";
                                elseif ($row['userStatus'] == 1 && $row['doctorStatus'] == 0) echo "Deleted by Doctor";
                                echo "</td><td>";
                                if ($row['userStatus'] == 1 && $row['doctorStatus'] == 1) {
                                    echo "<a href='patient_dashboard.php?ID={$row['ID']}&cancel=update' class='btn btn-danger btn-sm'>Cancel</a>";
                                } else {
                                    echo "Cancelled";
                                }
                                echo "</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateFees() {
    var select = document.getElementById("doctor");
    var fees = select.options[select.selectedIndex].getAttribute("data-fees");
    document.getElementById("docFees").value = fees;
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>