<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Tutoring System</title>
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

        .profile-container {
            display: flex;
            gap: 30px;
        }

        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #1a49cb;
        }

        .profile-info {
            flex: 1;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .error {
            color: #e74c3c;
            margin-bottom: 15px;
        }

        .success {
            color: #2ecc71;
            margin-bottom: 15px;
        }

        .file-input-container {
            position: relative;
            margin-top: 10px;
        }

        .file-input-label {
            display: inline-block;
            padding: 8px 12px;
            background-color: #1a49cb;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .file-input-label:hover {
            background-color: #2980b9;
        }

        .file-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .cooldown-message {
            margin-top: 5px;
            font-size: 0.9em;
            color: #e74c3c;
        }

        .active {
            background-color: #1a49cb;
            color: white;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>My Profile</h1>
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
                    <li><a href="my_bookings.php">My Bookings</a></li>
                    <li><a href="my_profile.php" class="active" style="color: white;">My Profile</a></li>
                </ul>
            </div>

            <div class="main-content">
                <h2 class="section-title">My Profile</h2>



                <form action="my_profile.php" method="post" enctype="multipart/form-data">
                    <div class="profile-container">
                        <div>
                            <img src="profile_6837b4ab807dc.png" alt="Profile Picture" class="profile-pic">

                            <div class="form-group">
                                <label>Change Profile Picture</label>
                                <div class="file-input-container">
                                    <label for="profile_pic" class="file-input-label">
                                        Choose Image
                                        <input type="file" id="profile_pic" name="profile_pic" accept="image/*" class="file-input">
                                    </label>
                                </div>
                                <div id="file-name" style="margin-top: 5px; font-size: 0.9em;"></div>
                            </div>
                        </div>

                        <div class="profile-info">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" id="username" value="russelcvs" readonly>
                            </div>

                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" value="Russel Vincent" required>
                            </div>

                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" value="Cuevas" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" value="russelcuevas0@gmail.com" required>
                            </div>

                            <div class="form-group">
                                <label>Role</label>
                                <input type="text" value="student" readonly>
                            </div>

                            <button type="submit" class="btn">Update Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('profile_pic').addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : 'No file chosen';
            document.getElementById('file-name').textContent = 'Selected: ' + fileName;
        });
    </script>
</body>

</html>