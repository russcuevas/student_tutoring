<?php
session_start();
include 'connection/database.php'; // Must create $pdo

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? 'User';

$current_date = date('Y-m-d');
$current_time = date('H:i:s');

$sql = "SELECT b.*, t.first_name, t.last_name, s.subject_name
        FROM tbl_booking b
        JOIN tbl_tutor t ON b.tutor_id = t.id
        JOIN tbl_subject s ON b.subject_id = s.id
        WHERE b.user_id = :user_id
          AND (b.date > :current_date OR (b.date = :current_date AND b.start_time > :current_time))
          AND b.status = 'approved'
        ORDER BY b.date, b.start_time";


$stmt = $conn->prepare($sql);
$stmt->execute([
    ':user_id' => $user_id,
    ':current_date' => $current_date,
    ':current_time' => $current_time
]);

$upcoming_sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Student Dashboard - Tutoring System</title>
    <link rel="stylesheet" href="assets/css/student_dashboard.css" />
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 8px 12px;
            text-align: left;
        }

        .no-sessions {
            margin-top: 15px;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Student Dashboard</h1>
        <div>
            <span>Welcome, <?= htmlspecialchars($username) ?></span>
            <a href="logout.php" class="btn logout-btn">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="dashboard">
            <div class="sidebar">
                <ul class="nav-menu">
                    <li><a href="student_dashboard.php" class="active">Dashboard</a></li>
                    <li><a href="find_tutor.php">Find a Tutor</a></li>
                    <li><a href="my_bookings.php">My Bookings</a></li>
                    <li><a href="my_profile.php">My Profile</a></li>
                </ul>
            </div>

            <div class="main-content">
                <h2 class="section-title">Upcoming Sessions</h2>

                <?php if (count($upcoming_sessions) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Tutor</th>
                                <th>Subject</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($upcoming_sessions as $session): ?>
                                <tr>
                                    <td><?= htmlspecialchars($session['date']) ?></td>
                                    <td><?= htmlspecialchars($session['start_time']) ?></td>
                                    <td><?= htmlspecialchars($session['end_time']) ?></td>
                                    <td><?= htmlspecialchars($session['first_name'] . ' ' . $session['last_name']) ?></td>
                                    <td><?= htmlspecialchars($session['subject_name']) ?></td>
                                    <td><?= htmlspecialchars($session['status']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="no-sessions">
                        You have no upcoming tutoring sessions. <a href="find_tutor.php">Find a tutor now</a>.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>