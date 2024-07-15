<?php
session_start();
include("../connection/connection.php");
?>

<?php include('../include/header.php'); ?>
<?php include('../include/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="margin-top:70px">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">

                <!-- /.card -->

                <div class="card shadow">
                    <div class="card-header">
                        <h3 class="card-title">Tourists details table</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fullname</th>
                                    <th>Gender</th>
                                    <th>Country</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Registered Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                            $cnt = 1; // Initialize the counter
                                            $select_users = "SELECT * FROM users   WHERE usertype <> 'Tour_guider'";
                                            $result = mysqli_query($connect, $select_users) or die(mysqli_error($connect));
                                            $number = mysqli_num_rows($result);
                                            if ($number > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                            ?>


                                <tr>
                                    <td><?php echo $cnt++; ?></td> <!-- Incrementing counter -->
                                    <td><?php echo $row['fullname']; ?></td>
                                    <td><?php echo $row['gender']; ?></td>
                                    <td><?php echo $row['country']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['created']; ?></td>
                                    <td>
                                        <span>
                                            <a href="./update.php?user_id=<?php echo $row['user_id'] ?>">
                                                <button class="btn btn-primary">
                                                    <i class="fa fa-pen"></i>
                                                </button>
                                            </a>
                                        </span>
                                        <span>
                                            <button class="btn btn-danger"
                                                onclick="confirmDelete(<?php echo $row['user_id'] ?>)">
                                                <i class="fa fa-minus-circle"></i>
                                            </button>
                                        </span>
                                    </td>
                                </tr>

                                <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='5'>0 results</td></tr>";
                                            }
                                            ?>
                            </tbody>

                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<?php include('../include/tablefooter.php'); ?>


<script>
function confirmDelete(Id) {
    // Display confirmation dialog
    if (confirm("Are you sure you want to delete?")) {
        // If user confirms, redirect to delete script
        window.location.href = "./delete.php?user_id=" + Id;
    }
}
</script>
<script></script>