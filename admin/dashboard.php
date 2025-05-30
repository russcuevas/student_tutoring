<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #1a49cb;
            --primary-light: #4895ef;
            --secondary-color: #3f37c9;
            --accent-color: #f72585;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4cc9f0;
            --warning-color: #f8961e;
            --error-color: #ef233c;
            --gray-color: #adb5bd;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: var(--dark-color);
            line-height: 1.6;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: var(--primary-color);
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100%;
            transition: all 0.3s;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h3 {
            color: white;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            color: var(--gray-color);
            font-size: 14px;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu h4 {
            color: var(--gray-color);
            font-size: 12px;
            text-transform: uppercase;
            padding: 0 20px;
            margin-bottom: 15px;
        }

        .sidebar-menu ul {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: block;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.1);
            border-left: 3px solid var(--accent-color);
        }

        .sidebar-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }

        .header h2 {
            color: var(--primary-color);
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .card-header h3 {
            color: var(--primary-color);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
        }

        .btn-success {
            background-color: var(--success-color);
            color: white;
        }

        .btn-danger {
            background-color: var(--error-color);
            color: white;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-success {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success-color);
        }

        .badge-warning {
            background-color: rgba(248, 150, 30, 0.1);
            color: var(--warning-color);
        }

        .badge-primary {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .tab-container {
            margin-bottom: 20px;
        }

        .tabs {
            display: flex;
            border-bottom: 1px solid #eee;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 2px solid transparent;
        }

        .tab.active {
            border-bottom: 2px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 500;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3>Admin Panel</h3>
                <p>admin</p>
            </div>

            <div class="sidebar-menu">
                <h4>Navigation</h4>
                <ul>
                    <li><a href="#" class="active" data-tab="dashboard"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li><a href="manage_students.php" data-tab="users"><i class="fas fa-users"></i> Users</a></li>
                    <li><a href="manage_tutors.php" data-tab="tutors"><i class="fas fa-chalkboard-teacher"></i> Tutors</a></li>
                    <li><a href="pending_students.php" data-tab="pending_students"><i class="fas fa-user-clock"></i> Pending Students</a></li>
                </ul>

                <h4>Account</h4>
                <ul>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h2>Admin Dashboard</h2>
                <div class="user-info">
                    <span>Welcome, Izziah Bayani</span>
                </div>
            </div>

            <div class="tab-container">
                <div class="tabs">
                    <div class="tab active" data-tab="dashboard">Dashboard</div>
                    <div class="tab" data-tab="users" onclick="window.location.href = 'manage_students.php'">Users (0)</div>
                    <div class="tab" data-tab="tutors" onclick="window.location.href = 'manage_tutors.php'">Approved Tutors (0)</div>
                    <div class="tab" data-tab="pending" onclick="window.location.href = 'pending_tutors.php'">Pending Tutors (0)</div>
                </div>
            </div>

            <!-- Dashboard Tab -->
            <div class="tab-content active" id="dashboard">
                <div class="card">
                    <h3>System Overview</h3>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 20px;">
                        <div class="card" style="text-align: center;">
                            <h4>Total Users</h4>
                            <p style="font-size: 24px; font-weight: bold;">0</p>
                        </div>
                        <div class="card" style="text-align: center;">
                            <h4>Approved Tutors</h4>
                            <p style="font-size: 24px; font-weight: bold;">0</p>
                        </div>
                        <div class="card" style="text-align: center;">
                            <h4>Pending Tutors</h4>
                            <p style="font-size: 24px; font-weight: bold;">0</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Tab -->
            <div class="tab-content" id="pending_students">
                <div class="card">
                    <div class="card-header">
                        <h3>Pending Student Applications</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Photo</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Applied</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>32</td>
                                <td>
                                    <img src="uploads/profile_pics/profile_6835352bc6ca0.jpg" width="50" height="50" style="border-radius: 50%;">
                                </td>
                                <td>chill</td>
                                <td>cawjd jpwjdpw</td>
                                <td>chill@gmail.com</td>
                                <td>May 27, 2025</td>
                                <td>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="user_id" value="32">
                                        <button type="submit" name="approve_student" class="btn btn-success">Approve</button>
                                    </form>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="user_id" value="32">
                                        <button type="submit" name="reject_student" class="btn btn-danger">Reject</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td>34</td>
                                <td>
                                    <img src="uploads/profile_pics/profile_6835b8bacdf75.jpg" width="50" height="50" style="border-radius: 50%;">
                                </td>
                                <td>Gobert</td>
                                <td>awdkaowpk opfakwpoakpo</td>
                                <td>awdawdipjwpdjap@gmail.com</td>
                                <td>May 27, 2025</td>
                                <td>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="user_id" value="34">
                                        <button type="submit" name="approve_student" class="btn btn-success">Approve</button>
                                    </form>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="user_id" value="34">
                                        <button type="submit" name="reject_student" class="btn btn-danger">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tutors Tab -->
            <!-- Pending Tutors Tab -->
            <div class="tab-content" id="pending">
                <div class="card">
                    <div class="card-header">
                        <h3>Pending Tutor Applications</h3>
                    </div>
                    <p>No pending tutor applications.</p>
                </div>
            </div>

            <!-- Pending Tutors Tab -->
            <div class="tab-content" id="pending_students">
                <div class="card">
                    <div class="card-header">
                        <h3>Pending Student Applications</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ID Photo</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Applied</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>32</td>
                                <td>
                                    <a href="uploads/profile_pics/profile_6835352bc6ca0.jpg" target="_blank">
                                        <img src="uploads/profile_pics/profile_6835352bc6ca0.jpg" width="50" height="50" style="border-radius: 50%;">
                                    </a>
                                </td>
                                <td>chill</td>
                                <td>cawjd jpwjdpw</td>
                                <td>chill@gmail.com</td>
                                <td>May 27, 2025</td>
                                <td>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="user_id" value="32">
                                        <button type="submit" name="approve_student" class="btn btn-success">Approve</button>
                                    </form>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="user_id" value="32">
                                        <button type="submit" name="reject_student" class="btn btn-danger">Reject</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td>34</td>
                                <td>
                                    <a href="uploads/profile_pics/profile_6835b8bacdf75.jpg" target="_blank">
                                        <img src="uploads/profile_pics/profile_6835b8bacdf75.jpg" width="50" height="50" style="border-radius: 50%;">
                                    </a>
                                </td>
                                <td>Gobert</td>
                                <td>awdkaowpk opfakwpoakpo</td>
                                <td>awdawdipjwpdjap@gmail.com</td>
                                <td>May 27, 2025</td>
                                <td>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="user_id" value="34">
                                        <button type="submit" name="approve_student" class="btn btn-success">Approve</button>
                                    </form>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="user_id" value="34">
                                        <button type="submit" name="reject_student" class="btn btn-danger">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
</body>

</html>