<?php
define('SUPABASE_URL', 'https://vsqqpzbznitmhukgxegs.supabase.co');
define('SUPABASE_KEY', 'sb_publishable_IDIBw6eVVahQ8DPE0TEdrg_zw1hqJ1v');

function supabase_request($endpoint, $method = 'GET', $data = null) {
    $ch = curl_init(SUPABASE_URL . '/rest/v1/' . $endpoint);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => [
            'apikey: ' . SUPABASE_KEY,
            'Authorization: Bearer ' . SUPABASE_KEY,
            'Content-Type: application/json'
        ],
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 30
    ]);
    
    if ($data) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    
    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return ['data' => json_decode($response, true), 'status' => $status];
}

function get_tasks($filters = []) {
    $endpoint = 'tasks';
    if (!empty($filters['status'])) $endpoint .= '?status=eq.' . $filters['status'];
    if (!empty($filters['priority'])) $endpoint .= (strpos($endpoint, '?') ? '&' : '?') . 'priority=eq.' . $filters['priority'];
    return supabase_request($endpoint);
}

function get_task($id) { return supabase_request('tasks?id=eq.' . $id); }
function create_task($data) { return supabase_request('tasks', 'POST', $data); }
function update_task($id, $data) { return supabase_request('tasks?id=eq.' . $id, 'PATCH', $data); }
function delete_task($id) { return supabase_request('tasks?id=eq.' . $id, 'DELETE'); }

function get_dashboard_stats() {
    $tasks = get_tasks()['data'] ?? [];
    return [
        'total' => count($tasks),
        'pending' => count(array_filter($tasks, fn($t) => $t['status'] === 'Pending')),
        'completed' => count(array_filter($tasks, fn($t) => $t['status'] === 'Completed')),
        'high_priority' => count(array_filter($tasks, fn($t) => $t['priority'] === 'High'))
    ];
}
?>
