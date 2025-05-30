<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Registration - Tutoring System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>

    <div class="container text-center login-container">
        <img src="https://static.vecteezy.com/system/resources/previews/005/389/395/non_2x/tutor-logo-design-template-free-vector.jpg" alt="Municipality Seal" class="login-seal">
        <h3 class="mt-3 mb-3" style="font-weight: 900;">Login as student, <br> Welcome back!</h3>

        <form class="needs-validation" novalidate>
            <div class="form-group position-relative mb-3 text-start">
                <input type="text" class="form-control rounded-pill px-4" style="font-weight: 900" id="username" placeholder="Username" required>
                <div class="invalid-feedback ms-2">
                    Please enter your username.
                </div>
            </div>

            <div class="form-group position-relative mb-3 text-start">
                <input type="password" class="form-control rounded-pill px-4" style="font-weight: 900" id="password" placeholder="Password" required>
                <div class="invalid-feedback ms-2">
                    Please enter your password.
                </div>
            </div>
            <button class="btn btn-primary w-100 rounded-pill mt-3 mb-3" style="font-weight: 900;" name="" type="submit">Login ➜</button>
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
                        <a class="fw-bold text-primary" href="index.php" style="text-decoration: none;">click here</a> </small>
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

    <?php include 'components/footer.php' ?>
    <script src="assets/js/time.js"></script>
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