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
                <div class="card shadow">
                    <div class="card-header">
                        <h3 class="card-title">Attractions details table</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Region Name</th>
                                    <th>District</th>
                                    <th>Attraction Name</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $cnt = 1; // Initialize the counter
                                    $query = "SELECT r.name as region_name, a.district, a.name as attraction_name, a.description, a.image, a.attraction_id, r.region_id 
                                              FROM regions r 
                                              INNER JOIN attractions a ON r.region_id = a.region_id";
                                    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
                                    $number = mysqli_num_rows($result);
                                    if ($number > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $cnt++; ?></td>
                                    <td><?php echo $row['region_name']; ?></td>
                                    <td><?php echo $row['district']; ?></td>
                                    <td><?php echo $row['attraction_name']; ?></td>
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
                                    <td><img src="../attract_uploads/<?php echo $row['image']; ?>" alt="Image"
                                            style="width: 350px;height:200px"></td>
                                    <td>
                                        <span>
                                            <a href="./update.php?attraction_id=<?php echo $row['attraction_id'];?>">
                                                <button class="btn btn-primary">
                                                    <i class="fa fa-pen"></i>
                                                </button>
                                            </a>
                                        </span>

                                        <span>
                                            <button class="btn btn-danger"
                                                onclick="confirmDelete(<?php echo $row['attraction_id'] ?>)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </span>
                                    </td>
                                </tr>
                                <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>No results found</td></tr>";
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
function confirmDelete(id) {
    if (confirm("Are you sure you want to delete?")) {
        window.location.href = "./delete.php?attraction_id=" + id;
    }
}
</script>