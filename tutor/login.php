<?php
session_start();
include '../connection/database.php';

if (isset($_SESSION['tutor_id'])) {
    header('Location: ../index.php');
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $select_user = $conn->prepare("SELECT * FROM `tbl_tutor` WHERE username = ? AND password = ?");
    $select_user->execute([$username, $password]);

    if ($select_user->rowCount() > 0) {
        $user = $select_user->fetch(PDO::FETCH_ASSOC);

        if ($user['is_verified'] == 1) {
            $_SESSION['tutor_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('location: dashboard.php');
            exit();
        } else {
            $_SESSION['error_message'] = 'Please wait for the admin approval';
            header('location: login.php');
            exit();
        }
    } else {
        $_SESSION['error_message'] = 'Incorrect username or password';
        header('location: login.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Registration - Tutoring System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>

    <div class="container text-center login-container">
        <img src="https://static.vecteezy.com/system/resources/previews/005/389/395/non_2x/tutor-logo-design-template-free-vector.jpg" alt="Municipality Seal" class="login-seal">
        <h3 class="mt-3 mb-3" style="font-weight: 900;">Login as tutor, <br> Welcome back!</h3>

        <form class="needs-validation" method="POST" action="" novalidate> <!-- ✅ Added method and action -->
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $_SESSION['error_message'];
                    unset($_SESSION['error_message']); ?> <!-- ✅ Display error -->
                </div>
            <?php endif; ?>

            <div class="form-group position-relative mb-3 text-start">
                <input type="text" class="form-control rounded-pill px-4" style="font-weight: 900"
                    id="username" name="username" placeholder="Username" required> <!-- ✅ Added name -->
                <div class="invalid-feedback ms-2">
                    Please enter your username.
                </div>
            </div>

            <div class="form-group position-relative mb-3 text-start">
                <input type="password" class="form-control rounded-pill px-4" style="font-weight: 900"
                    id="password" name="password" placeholder="Password" required> <!-- ✅ Added name -->
                <div class="invalid-feedback ms-2">
                    Please enter your password.
                </div>
            </div>

            <button class="btn btn-primary w-100 rounded-pill mt-3 mb-3" style="font-weight: 900;" name="login" type="submit">
                Login ➜
            </button>

            <div class="d-flex justify-content-center align-items-center">
                <div>
                    <small class="small text-center">
                        Don't have an account yet?
                        <a class="fw-bold text-primary" href="register.php" style="text-decoration: none;">Register</a> </small>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <div>
                    <small class="small text-center">
                        Go back to homepage
                        <a class="fw-bold text-primary" href="../index.php" style="text-decoration: none;">click here</a> </small>
                </div>
            </div>


        </form>
    </div>


    <div class="relative flex items-center justify-center d-md-none">
        <img class="mt-0 img-fluid" src="images/city-mobile.png" alt="" style="max-width: 100%; height: auto; color: transparent;">
    </div>
    <div class="relative flex items-center justify-center d-none d-md-block">
        <img class="mt-0 img-fluid" src="images/city-desktop.png" alt="" style="max-width: 100%; height: auto; color: transparent;">
    </div>

    <?php include '../components/footer.php' ?>
    <script src="../assets/js/time.js"></script>
    <script>
        (function() {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>


</body>

</html>