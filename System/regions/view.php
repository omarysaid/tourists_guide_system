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
                        <h3 class="card-title">Regions details table</h3> <a href="./add.php"><button
                                class="btn btn-success" style="margin-left: 10px;"> <i
                                    class="fa fa-plus"></i></button></a>
                    </div>


                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>name</th>
                                    <th>descriptions</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                            $cnt = 1; // Initialize the counter
                                            $select_region = "SELECT * FROM regions";
                                            $result = mysqli_query($connect, $select_region) or die(mysqli_error($connect));
                                            $number = mysqli_num_rows($result);
                                            if ($number > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                            ?>

                                <tr>
                                    <td><?php echo $cnt++; ?></td>
                                    <td><?php echo $row['name']; ?></td>

                                    <td>
                                        <?php 
        $description = $row['description'];
        $words = explode(" ", $description);
        $wordCount = count($words);
        $lines = ceil($wordCount / 5);
        
        for ($i = 0; $i < $lines; $i++) {
            $start = $i * 5;
            $end = min(($i + 1) * 5, $wordCount);
            echo implode(" ", array_slice($words, $start, $end - $start));
            echo "<br>";
        }
    ?>
                                    </td>
                                    <td><img src="../img_uploads/<?php echo $row['image_name']; ?>" alt=" Image"
                                            style="width: 350px;height:200px"></td>

                                    <td>

                                        <span>
                                            <a href="./update.php?region_id=<?php echo $row['region_id'];?>">
                                                <button class="btn btn-primary">
                                                    <i class=" fa fa-pen"></i>
                                                    <!-- Eye icon for view -->
                                                </button>
                                            </a>
                                        </span>

                                        <span>
                                            <a href="../attractions/add.php?region_id=<?php echo $row['region_id'] ?>">
                                                <button class="btn btn-success">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </a>
                                        </span>


                                        <span>
                                            <button class="btn btn-danger"
                                                onclick="confirmDelete(<?php echo $row['region_id'] ?>)">
                                                <i class="fa fa-trash"></i>
                                                <!-- Trash icon for delete -->
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
        window.location.href = "./delete.php?region_id=" + Id;
    }
}
</script>
<script></script>