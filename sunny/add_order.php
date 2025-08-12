<?php
// add_order.php
session_start();
header('Content-Type: application/json');
include "db.php";

if (!isset($_SESSION['serial'])) {
    echo json_encode(['status' => 'error', 'error' => 'NOT_LOGGED_IN']);
    exit;
}

$serial = $_SESSION['serial'];
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!isset($data['items']) || !is_array($data['items'])) {
    echo json_encode(['status' => 'error', 'error' => 'INVALID_PAYLOAD']);
    exit;
}

$insertSql = "INSERT INTO orders (serial, item, amount) VALUES (?, ?, ?)";
$stmt = $conn->prepare($insertSql);

foreach ($data['items'] as $it) {
    $name = $it['name'];
    $amount = floatval($it['total']);
    $stmt->bind_param("isd", $serial, $name, $amount);
    if (!$stmt->execute()) {
        echo json_encode(['status' => 'error', 'error' => $conn->error]);
        exit;
    }
}

echo json_encode(['status' => 'success']);
