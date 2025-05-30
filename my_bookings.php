<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Tutoring System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .header {
            background-color: #1a49cb;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            background-color: #1a49cb;
            color: white;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .dashboard {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 20px;
        }

        .sidebar {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-menu li {
            margin-bottom: 10px;
        }

        .nav-menu a {
            display: block;
            padding: 10px;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .nav-menu a:hover {
            background-color: #1a49cb;
            color: white;
        }

        .btn {
            padding: 10px 15px;
            background-color: #1a49cb;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .logout-btn {
            background-color: #e74c3c;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        .section-title {
            border-bottom: 2px solid #1a49cb;
            padding-bottom: 10px;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .booking-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .status-pending {
            color: #f39c12;
        }

        .status-confirmed {
            color: #2ecc71;
        }

        .status-cancelled {
            color: #e74c3c;
        }

        .status-completed {
            color: #1a49cb;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>My Bookings</h1>
        <div>
            <span>Welcome, russelcvs</span>
            <a href="logout.php" class="btn logout-btn">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="dashboard">
            <div class="sidebar">
                <ul class="nav-menu">
                    <li><a href="student_dashboard.php">Dashboard</a></li>
                    <li><a href="find_tutor.php">Find a Tutor</a></li>
                    <li><a href="my_bookings.php" class="active">My Bookings</a></li>
                    <li><a href="my_profile.php">My Profile</a></li>
                </ul>
            </div>

            <div class="main-content">
                <h2 class="section-title">My Bookings</h2>

                <p>You have no bookings yet. <a href="find_tutor.php">Find a tutor now</a>.</p>
            </div>
        </div>
    </div>
</body>

</html>