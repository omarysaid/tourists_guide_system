<?php
session_start();
include("../connection/connection.php");
?>

<?php include('../include/header.php'); ?>
<?php include('../include/sidebar.php'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">wellcome!.. </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <hr style="background-color:green; height:10px">
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content" style="margin-top:50px">
        <div class="container-fluid shadow">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info" style="height:140px">
                        <?php
                                    $sql = "SELECT COUNT(*) AS total_users FROM users WHERE usertype <> 'Tour_guider'";
                                    $result = $connect->query($sql);
                                    $total_users = 0;
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $total_users = $row["total_users"];
                                    }
                                    ?>
                        <div class="inner">
                            <h3> 0<?php echo $total_users; ?></h3>
                            <p>TOTAL TOURISTS</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success" style="height:140px">
                        <div class="inner">
                            <?php
                                    $sql = "SELECT COUNT(*) AS total_regions FROM regions";
                                    $result = $connect->query($sql);
                                    $total_regions = 0;
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $total_regions = $row["total_regions"];
                                    }
                                    ?>
                            <h3> 0<?php echo $total_regions; ?></h3>
                            <p>REGIONS</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-chart-pie"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning" style="height:140px">
                        <?php
                                    $sql = "SELECT COUNT(*) AS total_attraction FROM attractions";
                                    $result = $connect->query($sql);
                                    $total_attractions = 0;
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $total_attraction = $row["total_attraction"];
                                    }
                                    ?>
                        <div class="inner">
                            <h3> 0<?php echo $total_attraction; ?></h3>
                            <p>ATTRACTIVES</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-chart-pie"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <!-- Main row -->

            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<?php include('../include/footer.php'); ?>