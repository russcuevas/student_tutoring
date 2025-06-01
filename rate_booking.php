<?php
session_start();
include 'connection/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['booking_id'])) {
    echo "No booking specified.";
    exit();
}

$booking_id = intval($_GET['booking_id']);

$stmt = $conn->prepare("
    SELECT b.*, s.subject_name, CONCAT(t.first_name, ' ', t.last_name) AS tutor_name
    FROM tbl_booking b
    JOIN tbl_subject s ON b.subject_id = s.id
    JOIN tbl_tutor t ON b.tutor_id = t.id
    WHERE b.book_id = ? AND b.user_id = ?
");
$stmt->execute([$booking_id, $user_id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    echo "Invalid booking or you don't have permission to rate.";
    exit();
}

if ($booking['status'] !== 'end session') {
    echo "You can only rate bookings with status 'end session'.";
    exit();
}

if (!is_null($booking['rating']) || !is_null($booking['feedback'])) {
    echo "<script>alert('You already submitted a feedback!'); window.location.href='my_bookings.php';</script>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = intval($_POST['rating']);
    $feedback = trim($_POST['feedback']);

    // Validate rating value
    if ($rating < 1 || $rating > 5) {
        $error = "Rating must be between 1 and 5.";
    } elseif (empty($feedback)) {
        $error = "Please provide feedback.";
    } else {
        // Update booking with rating and feedback
        $updateStmt = $conn->prepare("UPDATE tbl_booking SET rating = ?, feedback = ? WHERE book_id = ?");
        $updateStmt->execute([$rating, $feedback, $booking_id]);

        echo "<script>alert('Thank you for your feedback!'); window.location.href='my_bookings.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Rate Booking - Tutoring System</title>
    <link rel="stylesheet" href="assets/css/my_bookings.css" />
    <style>
        body {
            font-family: Poppins, sans-serif;
            padding: 20px;
        }

        .form-container {
            max-width: 500px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 6px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
        }

        select,
        textarea,
        button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        button {
            background-color: #1a49cb;
            color: white;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            border: none;
        }

        button:hover {
            background-color: rgb(0, 0, 0);
        }

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Rate & Provide Feedback</h2>
        <p><strong>Tutor:</strong> <?= htmlspecialchars($booking['tutor_name']) ?></p>
        <p><strong>Subject:</strong> <?= htmlspecialchars($booking['subject_name']) ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($booking['date']) ?></p>

        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="rating">Rating (1 to 5):</label>
            <select name="rating" id="rating" required>
                <option value="" disabled selected>-- Select Rating --</option>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
            </select>

            <label for="feedback">Feedback:</label>
            <textarea name="feedback" id="feedback" rows="5" placeholder="Write your feedback here..." required></textarea>

            <button type="submit">Submit Feedback</button>
        </form>
    </div>
</body>

</html>