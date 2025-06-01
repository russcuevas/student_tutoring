<?php
include '../connection/database.php';

$subjects = $conn->query("SELECT id, subject_name FROM tbl_subject")->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['username'])) {
    $username         = $_POST['username'];
    $email            = $_POST['email'];
    $first_name       = $_POST['first_name'];
    $last_name        = $_POST['last_name'];
    $bio              = $_POST['bio'];
    $qualifications   = $_POST['qualifications'];
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $picture          = $_FILES['picture'];

    $available_date = $_POST['available_date'];
    $start_time     = $_POST['start_time'];
    $end_time       = $_POST['end_time'];
    $subjects       = $_POST['subjects'];

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
    } elseif (strlen($password) < 6) {
        echo "<script>alert('Password must be at least 6 characters long.');</script>";
    } else {
        $hashed_password = md5($password);

        $upload_dir = "../uploads/tutor_validation/";
        $picture_name = time() . "_" . basename($picture["name"]);
        $target_file = $upload_dir . $picture_name;

        if (move_uploaded_file($picture["tmp_name"], $target_file)) {
            $sql = "INSERT INTO tbl_tutor (username, password, email, first_name, last_name, bio, qualifications, created_at, picture, is_verified)
                    VALUES (:username, :password, :email, :first_name, :last_name, :bio, :qualifications, NOW(), :picture, 0)";

            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':username'       => $username,
                ':password'       => $hashed_password,
                ':email'          => $email,
                ':first_name'     => $first_name,
                ':last_name'      => $last_name,
                ':bio'            => $bio,
                ':qualifications' => $qualifications,
                ':picture'        => $picture_name
            ]);

            $tutor_id = $conn->lastInsertId();

            $sql_avail = "INSERT INTO tbl_tutor_availability_subjects (available_date, tutor_id, subject_id, start_time, end_time)
                          VALUES (:available_date, :tutor_id, :subject_id, :start_time, :end_time)";
            $stmt_avail = $conn->prepare($sql_avail);

            foreach ($subjects as $subject_id) {
                $stmt_avail->execute([
                    ':available_date' => $available_date,
                    ':tutor_id'       => $tutor_id,
                    ':subject_id'     => $subject_id,
                    ':start_time'     => $start_time,
                    ':end_time'       => $end_time
                ]);
            }

            echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Failed to upload picture.');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Registration - Tutoring System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* CSS remains the same as in your original code */
        :root {
            --primary-color: black;
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
            background: linear-gradient(135deg, #f5f7ff 0%, #e6f0ff 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--dark-color);
            line-height: 1.6;
        }

        .register-container {
            width: 100%;
            max-width: 600px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 20px;
            animation: fadeInUp 0.5s ease;
        }

        .register-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .register-header h2 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .register-header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .register-header::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 0;
            width: 100%;
            height: 30px;
            background: white;
            clip-path: polygon(0 0, 100% 0, 50% 100%);
        }

        .register-body {
            padding: 40px;
        }

        .welcome-message {
            text-align: center;
            margin-bottom: 30px;
        }

        .welcome-message h3 {
            color: var(--primary-color);
            font-size: 22px;
            margin-bottom: 10px;
        }

        .welcome-message p {
            color: var(--gray-color);
            font-size: 15px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-color);
            font-size: 15px;
        }

        .form-control {
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            background-color: #f8f9fa;
        }

        .form-control:focus {
            border-color: var(--primary-light);
            background-color: white;
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
            outline: none;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .error-message {
            color: var(--error-color);
            font-size: 13px;
            margin-top: 5px;
            display: flex;
            align-items: center;
        }

        .error-message i {
            margin-right: 5px;
        }

        .form-note {
            font-size: 13px;
            color: var(--gray-color);
            margin-top: 5px;
        }

        .btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(63, 55, 201, 0.2);
        }

        .btn i {
            margin-right: 10px;
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            color: var(--gray-color);
            font-size: 15px;
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .name-fields {
            display: flex;
            gap: 15px;
        }

        .name-fields .form-group {
            flex: 1;
        }

        .subject-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .subject-option {
            display: flex;
            align-items: center;
        }

        .subject-option input {
            margin-right: 5px;
        }

        @media (max-width: 768px) {
            .name-fields {
                flex-direction: column;
                gap: 0;
            }
        }

        @media (max-width: 480px) {
            .register-container {
                margin: 10px;
                border-radius: 15px;
            }

            .register-header {
                padding: 25px 20px;
            }

            .register-body {
                padding: 30px 20px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="register-container">
        <div class="register-header">
            <h2>Join as a Tutor</h2>
            <p>Share your knowledge and help students succeed</p>
        </div>

        <div class="register-body">
            <div class="welcome-message">
                <h3>Tutor Application</h3>
                <p>Fill in your details to apply as a tutor</p>
            </div>



            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="picture">ID Picture (Required for verification)</label>
                    <input type="file" id="picture" name="picture" class="form-control" accept="image/*" required>
                    <div class="form-note">Upload a clear photo of your government-issued ID for verification</div>
                </div>

                <div class="form-group">
                    <label for="available_date">Available Date</label>
                    <input type="date" id="available_date" name="available_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="start_time">Start Time</label>
                    <input type="time" id="start_time" name="start_time" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="end_time">End Time</label>
                    <input type="time" id="end_time" name="end_time" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" value="" placeholder="Choose a username">
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" value="" placeholder="Your email address">
                </div>

                <div class="name-fields">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" value="" placeholder="First name" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control" value="" placeholder="Last name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Create a password">
                    <div class="form-note">Minimum 6 characters</div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Repeat your password">
                </div>

                <div class="form-group">
                    <label>Subjects You Can Teach</label>
                    <div class="subject-options">
                        <?php foreach ($subjects as $subject): ?>
                            <div class="subject-option">
                                <input type="checkbox" id="subject_<?= $subject['id'] ?>" name="subjects[]" value="<?= $subject['id'] ?>">
                                <label for="subject_<?= $subject['id'] ?>"><?= htmlspecialchars($subject['subject_name']) ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>


                <div class="form-group">
                    <label for="qualifications">Qualifications</label>
                    <textarea id="qualifications" name="qualifications" class="form-control" placeholder="List your degrees, certifications, and relevant experience"></textarea>
                    <div class="form-note">Please be detailed about your teaching experience and qualifications</div>
                </div>

                <div class="form-group">
                    <label for="bio">About You</label>
                    <textarea id="bio" name="bio" class="form-control" placeholder="Tell us about your teaching philosophy and approach"></textarea>
                    <div class="form-note">This helps students understand your teaching style</div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Submit Application
                </button>

                <div class="login-link">
                    Already have an account? <a href="login.php">Sign in here</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>