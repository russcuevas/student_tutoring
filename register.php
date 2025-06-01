<?php
include 'connection/database.php';

if (isset($_POST['username'])) {
    $username         = $_POST['username'];
    $email            = $_POST['email'];
    $first_name       = $_POST['first_name'];
    $last_name        = $_POST['last_name'];
    $bio              = $_POST['bio'];
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $picture          = $_FILES['picture'];

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {

        if (strlen($password) < 6) {
            echo "<script>alert('Password must be at least 6 characters long.');</script>";
        } else {
            $hashed_password = md5($password);

            $upload_dir = "uploads/student_validation/";
            $picture_name = time() . "_" . basename($picture["name"]);
            $target_file = $upload_dir . $picture_name;

            if (move_uploaded_file($picture["tmp_name"], $target_file)) {
                $sql = "INSERT INTO tbl_users (username, password, email, first_name, last_name, bio, created_at, picture, is_verified)
                        VALUES (:username, :password, :email, :first_name, :last_name, :bio, NOW(), :picture, 0)";

                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':username'    => $username,
                    ':password'    => $hashed_password,
                    ':email'       => $email,
                    ':first_name'  => $first_name,
                    ':last_name'   => $last_name,
                    ':bio'         => $bio,
                    ':picture'     => $picture_name
                ]);

                echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Failed to upload picture.');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - Tutoring System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="student-css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="register-container">
        <div class="register-header">
            <h2>Join Our Learning Community</h2>
            <p>Start your academic success journey today</p>
        </div>

        <div class="register-body">
            <div class="welcome-message">
                <h3>Student Registration</h3>
                <p>Fill in your details to create an account</p>
            </div>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="picture">ID Picture (Required for verification)</label>
                    <input type="file" id="picture" name="picture" class="form-control" accept="image/*" required>
                    <div class="form-note">Upload a clear photo of your government-issued ID for verification</div>
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
                    <label for="bio">About You (Optional)</label>
                    <textarea id="bio" name="bio" class="form-control" placeholder="Tell us about your academic interests, goals, and any subjects you need help with"></textarea>
                    <div class="form-note">This helps us match you with the right tutors</div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Register Now
                </button>


                <div class="login-link">
                    Already have an account? <a href="login.php">Sign in here</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>