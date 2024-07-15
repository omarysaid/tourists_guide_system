<?php
session_start();
include("./connection/connection.php");

$message = ""; // Variable to store messages

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Basic validation
    if (empty($email) || empty($password)) {
        // Handle empty fields
        $message = "Please enter both email and password.";
    } else {
        // Sanitize email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Handle invalid email format
            $message = "Invalid email format.";
        } else {
            $password = md5($password);

            $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
            $result = mysqli_query($connect, $sql);
            $number = mysqli_num_rows($result);
            if ($number > 0) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['fullname'] = $row['fullname'];
                $_SESSION['usertype'] = $row['usertype'];

                if ($row['usertype'] == "Tour_guider") {
                    $redirectUrl = './System/admin/dashboard.php';
                } else {
                    // Redirect to a default page if role is null or any other unknown role
                    $redirectUrl = './frontpage/index.php';
                }

                header("Location: $redirectUrl"); // Redirect immediately
                exit;
            } else {
                $message = "Wrong username or password. Please try again.";
            }
        }
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Tourist Attraction System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="./assets/css/style.css">

    <style>
    .error-message {
        margin-top: 10px;
        color: red;
    }
    </style>

</head>

<body style="background-image: url(./assets/images/ki.jpg); background-repeat:no-repeat">

    <div class="container" style="margin-top:50px">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-1">
                <h2 class="heading-section">TOURISTS GUIDE SYSTEM</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-wrap p-4 p-md-5">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-user-o"></span>
                    </div>
                    <h3 class="text-center mb-4">login here</h3>

                    <?php if (!empty($message)) : ?>
                    <div class="<?php echo $loginSuccess ? 'success-message' : 'error-message'; ?>"
                        style="text-align:center">
                        <?php echo $message; ?>
                    </div>
                    <?php endif; ?>

                    <form class="login-form" method="POST">
                        <div class="form-group">
                            <input type="text" name="email" class="form-control rounded-left" placeholder="Email"
                                required>
                        </div>

                        <div class="form-group d-flex">
                            <input type="password" name="password" class="form-control rounded-left"
                                placeholder="Password" required>
                        </div>
                        <div class="form-group d-md-flex">

                            <div class="w-30 text-md-right">
                                <a href="./register.php">Don't you have an account</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="login" class="btn btn-success rounded submit p-3 px-5">SIGN
                                IN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </section>

    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/popper.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./assets/js/main.js"></script>

</body>

</html>