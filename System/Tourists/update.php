<?php
session_start();
include("../connection/connection.php");

if (isset($_POST['update_data'])) {
    $user_id = $_GET['user_id'];
    $fullname = $_POST['fullname'];
    $gender = $_POST['gender'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];
       $email = $_POST['email'];
          $password = md5($_POST['password']);
  
    $errors = array();


    if (empty($errors)) {
        $update = "UPDATE users SET fullname='$fullname', gender='$gender', country='$country', phone='$phone', email='$email', password='$password'
        WHERE user_id = '$user_id'";

        if (mysqli_query($connect, $update)) {
        
            $userStatus = "Student updated successfully";
        } else {
           
            $userStatus = "Error occurred while updating User";
        }
    } else {
  
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}
?>

<?php include('../include/header.php'); ?>
<?php include('../include/sidebar.php'); ?>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid shadow" style="background-color: black; margin-top:60px">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-dark shadow">
                        <div class="card-header shadow">
                            <h3 class="card-title">Regions Form</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="POST">
                            <?php if (!empty($userStatus)) : ?>
                            <div class="alert <?php echo strpos($userStatus, 'successfully') !== false ? 'alert-success' : 'alert-danger'; ?>"
                                id="successMessage" style="color:white">
                                <?php echo $userStatus; ?>
                            </div>
                            <?php endif; ?>

                            <!-- Added enctype attribute -->
                            <?php
                                        $select_user = "SELECT * FROM users WHERE user_id = '" . $_GET['user_id'] . "'";
                                        $result = mysqli_query($connect, $select_user);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                        ?>



                            <div class="card-body">
                                <div class="form-group">
                                    <label for="regionName">Fullname</label>
                                    <input type="text" value="<?php echo $row['fullname'] ?>" name="fullname"
                                        required="true" class="form-control" id="regionImage" style="height:50px">
                                </div>

                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select name="gender" required="true" class="form-control" id="gender"
                                        style="height:50px">
                                        <option value="" disabled>Select Gender</option>
                                        <option value="Male" <?php if ($row['gender'] == 'Male') echo 'selected'; ?>>
                                            Male</option>
                                        <option value="Female"
                                            <?php if ($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                                        <option value="Other" <?php if ($row['gender'] == 'Other') echo 'selected'; ?>>
                                            Other</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="regionName">Country</label>
                                    <input type="text" value="<?php echo $row['country'] ?>" name="country"
                                        required="true" class="form-control" id="regionImage" style="height:50px">
                                </div>

                                <div class="form-group">
                                    <label for="regionName">Phone</label>
                                    <input type="text" value="<?php echo $row['phone'] ?>" name="phone" required="true"
                                        class="form-control" id="regionImage" style="height:50px">
                                </div>

                                <div class="form-group">
                                    <label for="regionName">Email</label>
                                    <input type="email" value="<?php echo $row['email'] ?>" name="email" required="true"
                                        class="form-control" id="regionImage" style="height:50px">
                                </div>

                                <div class="form-group">
                                    <label for="regionName">Password</label>
                                    <input type="password" value="<?php echo $row['password'] ?>" name="password"
                                        required="true" class="form-control" id="regionImage" style="height:50px">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" name="update_data" class="btn btn-primary">Submit</button>
                            </div>
                            <?php
                                            }
                                        }
                                        ?>
                        </form>

                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include('../include/footer.php'); ?>