<?php
include("db.php");
if (isset($_POST['btnSubmit'])) {
    $name = mysqli_real_escape_string($con, $_POST['txtName']);
    $email = mysqli_real_escape_string($con, $_POST['txtEmail']);
    $contact = mysqli_real_escape_string($con, $_POST['txtPhone']);
    $message = mysqli_real_escape_string($con, $_POST['txtMsg']);
    $query = "INSERT INTO contact(name, email, contact, message) VALUES ('$name','$email','$contact','$message')";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Message sent successfully!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - Tamaraw Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">Tamaraw Hospital</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="index.php">Home</a>
            <a class="nav-link" href="about.php">About Us</a>
            <a class="nav-link active" href="contact.php">Contact</a>
        </div>
    </div>
</nav>
<div class="container mt-5 col-md-6 bg-white p-4 rounded shadow">
    <h3>Drop Us a Message</h3>
    <form method="POST">
        <div class="mb-3"><input type="text" name="txtName" class="form-control" placeholder="Your Name *" required></div>
        <div class="mb-3"><input type="email" name="txtEmail" class="form-control" placeholder="Your Email *" required></div>
        <div class="mb-3"><input type="text" name="txtPhone" class="form-control" placeholder="Your Phone Number *" required></div>
        <div class="mb-3"><textarea name="txtMsg" class="form-control" rows="4" placeholder="Your Message *" required></textarea></div>
        <button type="submit" name="btnSubmit" class="btn btn-primary">Send Message</button>
    </form>
</div>
</body>
</html>