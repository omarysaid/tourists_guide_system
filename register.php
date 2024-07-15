<?php
session_start();
include("./connection/connection.php");

// Initialize variable to hold role addition status
$userAddStatus = "";

if (isset($_POST["add_user"])) {
    $fullname = $_POST['fullname'];
     $gender = $_POST['gender'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Using MD5 for password hashing
    $usertype = isset($_POST['usertype']) ? $_POST['usertype'] : '';

    // If there are no errors in file upload, proceed with insertion
    if (empty($errors)) {
        $insert_new_user = "INSERT INTO users (fullname,gender, country, phone,email, password, usertype) 
                            VALUES ('$fullname', '$gender',  '$country', '$phone','$email', '$password', '$usertype')";

        if (mysqli_query($connect, $insert_new_user)) {
            // Set role addition status
            $userAddStatus = "you are successfully registered";
        } else {
            // Set role addition status
            $userAddStatus = "Error occurred while adding user";
        }
    } else {
        // If there are errors, display them
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
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

</head>

<body style="background-image: url(./assets/images/ki.jpg); background-repeat:no-repeat">

    <div class="container" style="margin-top:30px">
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
                    <h3 class="text-center mb-4">Register here</h3>

                    <div class="alert <?php echo !empty($userAddStatus) && strpos($userAddStatus, 'successfully') !== false ? 'alert-success' : ''; ?>"
                        id="successMessage">
                        <?php echo $userAddStatus; ?>
                    </div>
                    <form class="login-form" method="POST">
                        <div class="form-group">
                            <input type="text" name="fullname" class="form-control rounded-left" placeholder="Fullname"
                                required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="genderMale"
                                            value="Male" required>
                                        <label class="form-check-label" for="genderMale">Male</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="genderFemale"
                                            value="Female" required>
                                        <label class="form-check-label" for="genderFemale">Female</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="genderOther"
                                            value="Other" required>
                                        <label class="form-check-label" for="genderOther">Other</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group d-flex">
                                    <input type="text" name="country" class="form-control rounded-left"
                                        placeholder="Country" required>
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group d-flex">
                                    <input type="number" name="phone" class="form-control rounded-left"
                                        placeholder="Phone" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group d-flex">
                                    <input type="email" name="email" class="form-control rounded-left"
                                        placeholder="Email" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group d-flex">
                            <input type="password" name="password" class="form-control rounded-left"
                                placeholder="Password" required>
                        </div>

                        <div class="form-group d-flex">
                            <input type="hidden" name="usertype" value="Normal_user" class="form-control rounded-left"
                                placeholder="Password" required>
                        </div>
                        <div class="form-group d-md-flex">

                            <div class="w-50 text-md-right">
                                <a href="./index.php">Already have an account</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="add_user" class="btn btn-success rounded submit p-3 px-5">SIGN
                                UP</button>
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