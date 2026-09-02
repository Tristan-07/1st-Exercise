<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Task Manager - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="home-container">
            <header class="home-header">
                <h1>📚 Student Task Manager</h1>
                <p class="subtitle">Organize your academic tasks efficiently</p>
            </header>

            <div class="home-content">
                <div class="welcome-card">
                    <h2>Welcome!</h2>
                    <p>Manage your school assignments, projects, and deadlines all in one place.</p>
                </div>

                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">📋</div>
                        <h3>Track Tasks</h3>
                        <p>Add and manage all your academic tasks</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📅</div>
                        <h3>Set Deadlines</h3>
                        <p>Never miss a due date again</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🎯</div>
                        <h3>Priority Levels</h3>
                        <p>Organize by High, Medium, or Low priority</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">✅</div>
                        <h3>Track Progress</h3>
                        <p>Mark tasks as completed and see your progress</p>
                    </div>
                </div>

                <div class="cta-section">
                    <a href="dashboard.php" class="btn btn-primary btn-large">
                        Go to Dashboard →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .home-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .home-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .home-header h1 {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .welcome-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .welcome-card h2 {
            font-size: 2rem;
            margin-bottom: 15px;
            color: #333;
        }

        .welcome-card p {
            font-size: 1.1rem;
            color: #666;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
            max-width: 1000px;
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .feature-card h3 {
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: #333;
        }

        .feature-card p {
            color: #666;
            font-size: 0.95rem;
        }

        .cta-section {
            text-align: center;
        }

        .btn-large {
            padding: 15px 40px;
            font-size: 1.2rem;
        }

        @media (max-width: 768px) {
            .home-header h1 {
                font-size: 2rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</body>
</html>
