<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';

// Handle filters
$status_filter = $_GET['status'] ?? '';
$priority_filter = $_GET['priority'] ?? '';

$filters = [];
if ($status_filter) {
    $filters['status'] = $status_filter;
}
if ($priority_filter) {
    $filters['priority'] = $priority_filter;
}

// Get tasks and stats
$tasks = [];
$stats = ['total' => 0, 'pending' => 0, 'completed' => 0, 'high_priority' => 0];

try {
    $tasks_response = get_tasks($filters);
    $tasks = $tasks_response['data'] ?? [];
    $stats = get_dashboard_stats();
} catch (Exception $e) {
    // Keep default values on error
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Task Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="header-nav">
                <a href="home.php" class="btn btn-secondary btn-small">← Back to Home</a>
            </div>
            <h1>📚 Student Task Manager</h1>
            <p class="subtitle">Organize your academic tasks efficiently</p>
        </header>

        <!-- Dashboard Stats -->
        <div class="dashboard">
            <div class="stat-card">
                <div class="stat-icon total">📋</div>
                <div class="stat-info">
                    <h3>Total Tasks</h3>
                    <p class="stat-number"><?php echo $stats['total']; ?></p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon pending">⏳</div>
                <div class="stat-info">
                    <h3>Pending</h3>
                    <p class="stat-number"><?php echo $stats['pending']; ?></p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon completed">✅</div>
                <div class="stat-info">
                    <h3>Completed</h3>
                    <p class="stat-number"><?php echo $stats['completed']; ?></p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon high">🔥</div>
                <div class="stat-info">
                    <h3>High Priority</h3>
                    <p class="stat-number"><?php echo $stats['high_priority']; ?></p>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="action-bar">
            <button class="btn btn-primary" id="addTaskBtn">+ Add New Task</button>
            
            <div class="filters">
                <select class="filter-select" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="Pending" <?php echo $status_filter === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="Completed" <?php echo $status_filter === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                </select>
                
                <select class="filter-select" id="priorityFilter">
                    <option value="">All Priority</option>
                    <option value="High" <?php echo $priority_filter === 'High' ? 'selected' : ''; ?>>High</option>
                    <option value="Medium" <?php echo $priority_filter === 'Medium' ? 'selected' : ''; ?>>Medium</option>
                    <option value="Low" <?php echo $priority_filter === 'Low' ? 'selected' : ''; ?>>Low</option>
                </select>
                
                <button class="btn btn-secondary" id="clearFiltersBtn">Clear Filters</button>
            </div>
        </div>

        <!-- Tasks List -->
        <div class="tasks-container">
            <?php if (empty($tasks)): ?>
                <div class="empty-state">
                    <p>No tasks found. Click "Add New Task" to get started!</p>
                </div>
            <?php else: ?>
                <div class="tasks-grid">
                    <?php foreach ($tasks as $task): ?>
                        <div class="task-card <?php echo $task['status'] === 'Completed' ? 'completed' : ''; ?>">
                            <div class="task-header">
                                <h3><?php echo htmlspecialchars($task['task_name']); ?></h3>
                                <span class="priority-badge priority-<?php echo strtolower($task['priority']); ?>">
                                    <?php echo $task['priority']; ?>
                                </span>
                            </div>
                            <div class="task-details">
                                <p><strong>Subject:</strong> <?php echo htmlspecialchars($task['subject']); ?></p>
                                <p><strong>Due Date:</strong> <?php echo date('M d, Y', strtotime($task['due_date'])); ?></p>
                                <p><strong>Status:</strong> 
                                    <span class="status-badge status-<?php echo strtolower($task['status']); ?>">
                                        <?php echo $task['status']; ?>
                                    </span>
                                </p>
                            </div>
                            <div class="task-actions">
                                <?php if ($task['status'] === 'Pending'): ?>
                                    <button class="btn btn-success toggle-status-btn" data-id="<?php echo $task['id']; ?>">
                                        ✓ Complete
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-warning toggle-status-btn" data-id="<?php echo $task['id']; ?>">
                                        ↺ Mark Pending
                                    </button>
                                <?php endif; ?>
                                <button class="btn btn-edit edit-task-btn" data-id="<?php echo $task['id']; ?>">
                                    ✎ Edit
                                </button>
                                <button class="btn btn-delete delete-task-btn" data-id="<?php echo $task['id']; ?>">
                                    🗑 Delete
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Add/Edit Task Modal -->
    <div id="taskModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Add New Task</h2>
            <form id="taskForm" onsubmit="saveTask(event)">
                <input type="hidden" id="taskId" name="id">
                
                <div class="form-group">
                    <label for="taskName">Task Name *</label>
                    <input type="text" id="taskName" name="task_name" required>
                </div>
                
                <div class="form-group">
                    <label for="subject">Subject *</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                
                <div class="form-group">
                    <label for="dueDate">Due Date *</label>
                    <input type="date" id="dueDate" name="due_date" required>
                </div>
                
                <div class="form-group">
                    <label for="priority">Priority *</label>
                    <select id="priority" name="priority" required>
                        <option value="Low">Low</option>
                        <option value="Medium" selected>Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="status">Status *</label>
                    <select id="status" name="status" required>
                        <option value="Pending" selected>Pending</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save Task</button>
                    <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Define functions
        function openModal() {
            console.log('openModal called');
            const modal = document.getElementById('taskModal');
            if (modal) {
                modal.style.display = 'block';
                document.getElementById('modalTitle').textContent = 'Add New Task';
                document.getElementById('taskForm').reset();
                document.getElementById('taskId').value = '';
            }
        }

        function closeModal() {
            console.log('closeModal called');
            const modal = document.getElementById('taskModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }

        function filterTasks(type, value) {
            const url = new URL(window.location);
            if (value) {
                url.searchParams.set(type, value);
            } else {
                url.searchParams.delete(type);
            }
            window.location = url;
        }

        function clearFilters() {
            window.location = window.location.pathname;
        }

        function editTask(id) {
            fetch('get_task.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const modal = document.getElementById('taskModal');
                        if (modal) {
                            modal.style.display = 'block';
                            document.getElementById('modalTitle').textContent = 'Edit Task';
                            document.getElementById('taskId').value = data.task.id;
                            document.getElementById('taskName').value = data.task.task_name;
                            document.getElementById('subject').value = data.task.subject;
                            document.getElementById('dueDate').value = data.task.due_date;
                            document.getElementById('priority').value = data.task.priority;
                            document.getElementById('status').value = data.task.status;
                        }
                    }
                });
        }

        function deleteTask(id) {
            if (confirm('Are you sure you want to delete this task?')) {
                fetch('delete_task.php?id=' + id)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Error: ' + (data.message || 'Failed to delete task'));
                        }
                    });
            }
        }

        function toggleStatus(id) {
            fetch('toggle_status.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Failed to update status'));
                    }
                });
        }

        // Attach event listeners
        document.getElementById('addTaskBtn').addEventListener('click', openModal);
        document.getElementById('statusFilter').addEventListener('change', function() {
            filterTasks('status', this.value);
        });
        document.getElementById('priorityFilter').addEventListener('change', function() {
            filterTasks('priority', this.value);
        });
        document.getElementById('clearFiltersBtn').addEventListener('click', clearFilters);

        // Event delegation for task buttons
        document.querySelector('.tasks-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('toggle-status-btn')) {
                toggleStatus(e.target.dataset.id);
            } else if (e.target.classList.contains('edit-task-btn')) {
                editTask(e.target.dataset.id);
            } else if (e.target.classList.contains('delete-task-btn')) {
                deleteTask(e.target.dataset.id);
            }
        });

        // Form submit handler
        document.getElementById('taskForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const id = formData.get('id');
            const url = id ? 'edit_task.php' : 'add_task.php';
            
            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeModal();
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Failed to save task'));
                }
            });
        });

        // Close modal button
        document.querySelector('.close').addEventListener('click', closeModal);
        document.getElementById('cancelBtn').addEventListener('click', closeModal);

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('taskModal');
            if (event.target === modal) {
                closeModal();
            }
        };
    </script>
</body>
</html>
