<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find a Tutor - Tutoring System</title>
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
            transition: background-color 0.3s;
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

        .tutor-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .tutor-info {
            margin-bottom: 15px;
        }

        .subject-selector {
            margin-bottom: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        select,
        input {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .availability-container {
            margin-top: 20px;
        }

        .availability-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .availability-table th,
        .availability-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .availability-table th {
            background-color: #1a49cb;
            color: white;
        }

        .availability-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .availability-table tr:hover {
            background-color: #f1f1f1;
        }

        .tutor-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            align-items: center;
        }

        .tutor-main-info {
            flex: 2;
        }

        .tutor-stats {
            flex: 1;
            text-align: right;
        }

        .rate {
            font-size: 1.3em;
            color: #27ae60;
            font-weight: bold;
        }

        .experience {
            color: #7f8c8d;
            font-style: italic;
        }

        .no-tutors {
            padding: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border-radius: 8px;
            text-align: center;
        }

        .subject-name {
            color: #1a49cb;
            font-weight: bold;
        }

        .book-btn {
            background-color: #2ecc71;
            padding: 8px 15px;
            font-size: 14px;
        }

        .book-btn:hover {
            background-color: #27ae60;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Find a Tutor</h1>
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
                    <li><a href="find_tutor.php" class="active">Find a Tutor</a></li>
                    <li><a href="my_bookings.php">My Bookings</a></li>
                    <li><a href="my_profile.php">My Profile</a></li>
                </ul>
            </div>

            <div class="main-content">
                <h2 class="section-title">Find a Tutor</h2>

                <form method="GET" action="find_tutor.php" class="subject-selector">
                    <label for="subject" style="font-weight: bold; margin-right: 10px;">Select Subject:</label>
                    <select name="subject" id="subject" required style="min-width: 200px;">
                        <option value="">-- Select a Subject --</option>
                        <option value="6">
                            PHP </option>
                        <option value="7">
                            HTML </option>
                        <option value="8">
                            CSS </option>
                        <option value="9">
                            JavaScript </option>
                    </select>
                    <button type="submit" class="btn" style="margin-left: 10px;">Search</button>
                </form>

                <p style="text-align: center; color: #666;">Please select a subject to find available tutors.</p>
            </div>
        </div>
    </div>
</body>

</html>