<?php
require 'functions.php';

$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        "firstName"   => isset($_POST['firstName']) ? $_POST['firstName'] : '',
        "lastName"    => isset($_POST['lastName']) ? $_POST['lastName'] : '',
        "phone"       => isset($_POST['phone']) ? $_POST['phone'] : '',
        "email"       => isset($_POST['email']) ? $_POST['email'] : '',
        "countryCode" => "GB",
        "box_id"      => 28,
        "offer_id"    => 5,
        "landingUrl"  => isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost',
        "ip"          => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1',
        "password"    => "qwerty12",
        "language"    => "en"
    ];

    $result = apiRequest('https://crm.belmar.pro/api/v1/addlead', $data);
}
?>

<?php
if ($result) {
    if (isset($result['status']) && $result['status']) {
        $id = isset($result['id']) ? htmlspecialchars($result['id']) : 'Unknown';
        echo '<script>alert("✅ Success. ID: ' . $id . '");</script>';
    } else {
        $error = isset($result['error']) ? htmlspecialchars($result['error']) : 'Unknown';
        echo '<script>alert("❌ Error: ' . $error . '");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Leads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body data-bs-theme="dark">
<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Nav</a>
        <div class="collapse navbar-collapse">
            <div class="navbar-nav">
                <a class="nav-link active" href="index.php">Send</a>
                <a class="nav-link" href="statuses.php">Get</a>
            </div>
        </div>
    </div>
</nav>

<div class="mt-4 container">
    <h4>Send Leads</h4>

    <form method="post" action="index.php">
        <div class="row g-3">
            <div class="col-md-6">
                <input type="text" name="firstName" class="form-control" placeholder="First name" required>
            </div>
            <div class="col-md-6">
                <input type="text" name="lastName" class="form-control" placeholder="Last name" required>
            </div>
            <div class="col-md-6">
                <input type="tel" name="phone" class="form-control" placeholder="Phone" required pattern="^\+?\d{10,15}$">
            </div>
            <div class="col-md-6">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
        </div>
        <button type="submit" class="mt-4 btn btn-primary">Send</button>
    </form>
</div>
</body>
</html>
