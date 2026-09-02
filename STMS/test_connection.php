<?php
require_once 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Testing Supabase Connection</h2>";

// Test 1: Basic connection
echo "<h3>1. Testing basic connection to 'tasks' table:</h3>";
$result = supabase_request('tasks');
echo "Status: " . $result['status'] . "<br>";
echo "Data: <pre>" . print_r($result['data'], true) . "</pre>";

if ($result['status'] == 200) {
    echo "<p style='color:green'>✓ Table exists and is accessible</p>";
} elseif ($result['status'] == 404) {
    echo "<p style='color:red'>✗ Table NOT FOUND</p>";
} else {
    echo "<p style='color:orange'>Status: " . $result['status'] . "</p>";
}

// Test 2: Try to add a test task
echo "<h3>2. Testing task creation:</h3>";
$testData = [
    'task_name' => 'Test Task',
    'subject' => 'Test Subject',
    'due_date' => date('Y-m-d'),
    'priority' => 'Medium',
    'status' => 'Pending'
];
$createResult = create_task($testData);
echo "Create Status: " . $createResult['status'] . "<br>";
echo "Create Response: <pre>" . print_r($createResult['data'], true) . "</pre>";

if ($createResult['status'] >= 200 && $createResult['status'] < 300) {
    echo "<p style='color:green'>✓ Task creation works</p>";
} else {
    echo "<p style='color:red'>✗ Task creation failed</p>";
}

// Test 3: Try to get tasks again
echo "<h3>3. Testing task retrieval after creation:</h3>";
$getResult = get_tasks();
echo "Get Status: " . $getResult['status'] . "<br>";
echo "Tasks: <pre>" . print_r($getResult['data'], true) . "</pre>";
echo "Total tasks: " . count($getResult['data']) . "<br>";
?>
