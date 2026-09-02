<?php
require_once 'config.php';
header('Content-Type: application/json');

$id = intval($_GET['id'] ?? 0);
$task = get_task($id)['data'][0] ?? null;
echo json_encode(['success' => $task !== null, 'task' => $task]);
?>
