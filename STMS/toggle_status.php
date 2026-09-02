<?php
require_once 'config.php';
header('Content-Type: application/json');

$id = intval($_GET['id'] ?? $_POST['id'] ?? 0);
if ($id > 0) {
    $task = get_task($id)['data'][0] ?? null;
    if ($task) {
        $new_status = $task['status'] === 'Pending' ? 'Completed' : 'Pending';
        $response = update_task($id, ['status' => $new_status]);
        echo json_encode(['success' => $response['status'] >= 200, 'message' => $response['status'] >= 200 ? 'Updated' : 'Failed']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid ID']);
}
?>
