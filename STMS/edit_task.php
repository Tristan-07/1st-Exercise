<?php
require_once 'config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $data = [
        'task_name' => trim($_POST['task_name']),
        'subject' => trim($_POST['subject']),
        'due_date' => $_POST['due_date'],
        'priority' => $_POST['priority'],
        'status' => $_POST['status']
    ];
    
    if ($id <= 0 || empty($data['task_name']) || empty($data['subject']) || empty($data['due_date'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }
    
    $response = update_task($id, $data);
    echo json_encode(['success' => $response['status'] >= 200, 'message' => $response['status'] >= 200 ? 'Updated' : 'Failed']);
}
?>
