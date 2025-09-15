<?php
require_once 'functions.php';

$date_from = date('Y-m-d 00:00:00', strtotime('-30 days'));
$date_to = date('Y-m-d 23:59:59');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!empty($_GET['date_from'])) {
        $date_from = $_GET['date_from'] . ' 00:00:00';
    }
    if (!empty($_GET['date_to'])) {
        $date_to = $_GET['date_to'] . ' 23:59:59';
    }
}

$data = [
        'date_from' => $date_from,
        'date_to'   => $date_to,
        'page'      => 0,
        'limit'     => 100
];

$all = apiRequest('https://crm.belmar.pro/api/v1/getstatuses', $data);

$leads = [];
if (isset($all['status']) && $all['status'] === true && !empty($all['data'])) {
    $leads = $all['data'];
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
                <a class="nav-link" href="index.php">Send</a>
                <a class="nav-link active" href="statuses.php">Get</a>
            </div>
        </div>
    </div>
</nav>
<div class="container mt-4">
    <h4>All Leads</h4>

    <form method="get" class="row g-3 mb-2">
        <div class="col-auto">
            <input type="date" name="date_from" class="form-control" value="<?= htmlspecialchars(substr($date_from,0,10)) ?>">
        </div>
        <div class="col-auto">
            <input type="date" name="date_to" class="form-control" value="<?= htmlspecialchars(substr($date_to,0,10)) ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Email</th>
                <th>Status</th>
                <th>FTD</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($leads)) {
                foreach ($leads as $lead) {
                    echo '<tr>';
                    echo '<td>'. htmlspecialchars($lead['id']) .'</td>';
                    echo '<td>'. htmlspecialchars($lead['email']) .'</td>';
                    echo '<td>'. htmlspecialchars($lead['status']) .'</td>';
                    echo '<td>'. htmlspecialchars($lead['ftd']) .'</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4">No leads found</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
