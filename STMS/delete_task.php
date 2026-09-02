<?php
require_once 'config.php';
header('Content-Type: application/json');

$id = intval($_GET['id'] ?? $_POST['id'] ?? 0);
if ($id > 0) {
    $response = delete_task($id);
    echo json_encode(['success' => $response['status'] >= 200, 'message' => $response['status'] >= 200 ? 'Deleted' : 'Failed']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid ID']);
}
?>
