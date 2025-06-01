<?php
session_start();
include 'connection/database.php';

$subjects = $conn->query("SELECT * FROM tbl_subject")->fetchAll(PDO::FETCH_ASSOC);

$tutorResults = [];

if (isset($_GET['subject']) && $_GET['subject'] !== '') {
    $subject_id = $_GET['subject'];

    $stmt = $conn->prepare("
        SELECT tas.*, CONCAT(t.first_name, ' ', t.last_name) AS tutor_name
        FROM tbl_tutor_availability_subjects tas
        JOIN tbl_tutor t ON tas.tutor_id = t.id
        WHERE tas.subject_id = ? AND t.is_verified = 1
    ");
    $stmt->execute([$subject_id]);
    $tutorResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find a Tutor - Tutoring System</title>
    <link rel="stylesheet" href="assets/css/find_tutor.css">
</head>

<body>
    <div class="header">
        <h1>Find a Tutor</h1>
        <div>
            <span>Welcome, <?= $_SESSION['username'] ?? 'Guest' ?></span>
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
                        <?php foreach ($subjects as $subject): ?>
                            <option value="<?= $subject['id'] ?>" <?= isset($subject_id) && $subject_id == $subject['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($subject['subject_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn" style="margin-left: 10px;">Search</button>
                </form>

                <?php if (isset($_GET['subject']) && $_GET['subject'] !== ''): ?>
                    <h4 class="mt-4">Available Tutors:</h4>
                    <?php if (count($tutorResults) > 0): ?>
                        <table class="table mt-2" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Tutor Name</th>
                                    <th>Session Date</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tutorResults as $row): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['tutor_name']) ?></td>
                                        <td><?= htmlspecialchars($row['available_date']) ?></td>
                                        <td><?= date('h:i A', strtotime($row['start_time'])) ?></td>
                                        <td><?= date('h:i A', strtotime($row['end_time'])) ?></td>
                                        <td>
                                            <form action="book_tutor.php" method="POST">
                                                <input type="hidden" name="tutor_id" value="<?= $row['tutor_id'] ?>">
                                                <input type="hidden" name="subject_id" value="<?= $row['subject_id'] ?>">
                                                <input type="hidden" name="availability_id" value="<?= $row['id'] ?>">
                                                <button type="submit" class="btn" style="background-color: green; color: white;">Enroll Now</button>
                                            </form>

                                        </td>
                                    </tr>

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p style="color: red;">No available tutors found for this subject.</p>
                    <?php endif; ?>
                <?php else: ?>
                    <p style="text-align: center; color: #666;">Please select a subject to find available tutors.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>