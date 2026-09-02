# Student Task Management System

A clean and responsive task management system built with PHP and Supabase, designed specifically for students to organize their academic tasks efficiently.

## Features

- **Dashboard Statistics**: View total tasks, pending tasks, completed tasks, and high priority tasks at a glance
- **Task Management**: Add, edit, and delete tasks easily
- **Status Tracking**: Mark tasks as pending or completed with a single click
- **Filtering**: Filter tasks by status (Pending/Completed) and priority (Low/Medium/High)
- **Responsive Design**: Works seamlessly on desktop, tablet, and mobile devices
- **Modern UI**: Clean, student-friendly interface with smooth animations

## Task Fields

Each task includes:
- **Task Name**: The title or description of the task
- **Subject**: The subject or course related to the task
- **Due Date**: When the task is due
- **Priority**: Low, Medium, or High
- **Status**: Pending or Completed

## Setup Instructions

### 1. Database Setup

1. Log in to your Supabase dashboard at https://supabase.com/dashboard
2. Navigate to your project: `vsqqpzbznitmhukgxegs`
3. Go to the **SQL Editor** in the left sidebar
4. Copy and execute the SQL from `schema.sql` file:

```sql
-- Create tasks table for Student Task Management System
CREATE TABLE IF NOT EXISTS tasks (
    id SERIAL PRIMARY KEY,
    task_name VARCHAR(255) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    due_date DATE NOT NULL,
    priority VARCHAR(20) NOT NULL CHECK (priority IN ('Low', 'Medium', 'High')),
    status VARCHAR(20) NOT NULL DEFAULT 'Pending' CHECK (status IN ('Pending', 'Completed')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create index for faster queries
CREATE INDEX IF NOT EXISTS idx_tasks_status ON tasks(status);
CREATE INDEX IF NOT EXISTS idx_tasks_priority ON tasks(priority);
CREATE INDEX IF NOT EXISTS idx_tasks_due_date ON tasks(due_date);
```

5. Click **Run** to execute the SQL

### 2. Configure Row Level Security (RLS) - Optional

If you want to enable RLS for additional security:

1. Go to **Authentication** > **Policies** in Supabase
2. Click on the `tasks` table
3. Enable RLS and add policies as needed

### 3. Configure Supabase Connection

The `config.php` file is already configured with your Supabase credentials:
- URL: `https://vsqqpzbznitmhukgxegs.supabase.co`
- Key: `sb_publishable_IDIBw6eVVahQ8DPE0TEdrg_zw1hqJ1v`

### 4. Deploy the Application

1. Place all files in your XAMPP htdocs directory: `c:\xampp\htdocs\STMS\`
2. Start Apache server in XAMPP
3. Open your browser and navigate to: `http://localhost/STMS/`

## File Structure

```
STMS/
├── config.php           # Supabase configuration and helper functions
├── index.php            # Main dashboard and task list
├── add_task.php         # Endpoint for adding new tasks
├── edit_task.php        # Endpoint for editing tasks
├── delete_task.php      # Endpoint for deleting tasks
├── toggle_status.php    # Endpoint for toggling task status
├── get_task.php         # Endpoint for fetching single task
├── style.css            # Responsive CSS styling
├── schema.sql           # Database schema
└── README.md            # This file
```

## Usage

### Adding a Task
1. Click the **"+ Add New Task"** button
2. Fill in the task details:
   - Task Name (required)
   - Subject (required)
   - Due Date (required)
   - Priority (Low, Medium, High)
   - Status (Pending, Completed)
3. Click **Save Task**

### Editing a Task
1. Click the **"✎ Edit"** button on any task card
2. Modify the task details in the modal
3. Click **Save Task**

### Deleting a Task
1. Click the **"🗑 Delete"** button on any task card
2. Confirm the deletion in the popup

### Marking Task as Complete
1. Click the **"✓ Complete"** button on pending tasks
2. To mark as pending again, click **"↺ Mark Pending"**

### Filtering Tasks
- Use the **Status** dropdown to filter by Pending or Completed
- Use the **Priority** dropdown to filter by High, Medium, or Low
- Click **"Clear Filters"** to show all tasks

## Requirements

- PHP 7.4 or higher
- XAMPP (or any PHP server)
- Supabase account
- Modern web browser

## Troubleshooting

### Tasks not displaying
- Check that the `tasks` table exists in Supabase
- Verify your Supabase URL and key in `config.php`
- Check browser console for JavaScript errors

### API errors
- Ensure your Supabase project is active
- Verify the publishable key is correct
- Check that RLS policies allow access (if enabled)

### Connection issues
- Verify XAMPP Apache is running
- Check that files are in the correct directory
- Ensure PHP curl extension is enabled

## Security Notes

- The publishable key is exposed in the frontend - this is normal for Supabase
- For production, consider implementing authentication
- Enable Row Level Security (RLS) in Supabase for better data protection
- Never commit sensitive credentials to version control

## License

This project is open source and available for educational purposes.
