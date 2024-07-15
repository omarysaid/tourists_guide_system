<?php
session_start();
include("../connection/connection.php");

// Fetch regions with attractions from the database
$sql = "SELECT r.region_id, r.name AS region_name, r.description AS region_description, r.image_name AS region_image, 
               a.district, a.name AS attraction_name, a.description AS attraction_description, a.image AS attraction_image
        FROM regions r
        LEFT JOIN attractions a ON r.region_id = a.region_id";
$result = $connect->query($sql);

$regions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $regions[$row['region_id']]['region_name'] = $row['region_name'];
        $regions[$row['region_id']]['region_description'] = $row['region_description'];
        $regions[$row['region_id']]['region_image'] = $row['region_image'];
        if (!isset($regions[$row['region_id']]['attractions'])) {
            $regions[$row['region_id']]['attractions'] = [];
        }
        if (!empty($row['attraction_name'])) {
            $regions[$row['region_id']]['attractions'][] = [
                'district' => $row['district'],
                'attraction_name' => $row['attraction_name'],
                'attraction_description' => $row['attraction_description'],
                'attraction_image' => $row['attraction_image']
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Tourists Guide System</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body style="background-color: beige">
    <!-- ======= Header ======= -->
    <header class="fixed-top  shadow" style="background-color: beige;">
        <div class="container">

            <div class="row">
                <div class="col-md-1" style="margin-left:200px"> <img src="./assets/img/logo1.png"
                        style="height: 80px;"></div>
                <div class="col-md-6">
                    <h1 class="logo me-auto"
                        style="font-size:40px; margin-top:30px; font-family:Georgia, 'Times New Roman', Times, serif">
                        <a>Tourists Guide System</a>
                    </h1>
                </div>
                <div class="col-md-1"> <img src="./assets/img/tanzanialogo.png"
                        style="height: 80px; width: 100px; border-radius: 30px;">
                </div>
                <div class="col-md-2"> <a href="../index.php" class="appointment-btn scrollto" style="margin-top:30px">
                        <b
                            style="color: white;"><?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : ''; ?></b>
                    </a></div>
            </div>
        </div>
    </header><!-- End Header -->
    <main id="main">
        <section id="departments" class="departments" style="margin-top: 40px">
            <div class="container" style="margin-top:30px">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="container shadow" style="background-color: cornsilk;">
                            <div class="section-title">
                                <h2 style="margin-top:30px; font-family:Georgia, 'Times New Roman', Times, serif">
                                    Regions with impressive Tourism attractions</h2>
                                <p>Welcome dear tourists</p>
                            </div>
                            <div class="row gy-4">
                                <div class="col-lg-3">
                                    <ul class="nav nav-tabs flex-column">
                                        <h3 style="font-family:Georgia, 'Times New Roman', Times, serif">Regions</h3>
                                        <?php
                                            $first = true;
                                            foreach ($regions as $region_id => $region) {
                                                echo '<li class="nav-item">';
                                                echo '<a class="nav-link' . ($first ? ' active show' : '') . '" data-bs-toggle="tab" href="#tab-' . $region_id . '">' . htmlspecialchars($region['region_name']) . '</a>';
                                                echo '</li>';
                                                $first = false;
                                            }
                                        ?>
                                    </ul>
                                </div>
                                <div class="col-lg-9">
                                    <div class="tab-content">
                                        <?php
                                            $first = true;
                                            foreach ($regions as $region_id => $region) {
                                                echo '<div class="tab-pane' . ($first ? ' active show' : '') . '" id="tab-' . $region_id . '">';
                                                echo '<div class="row gy-4">';
                                                echo '<div class="col-lg-12 details order-2 order-lg-1">';
                                                echo '<h3>' . htmlspecialchars($region['region_name']) . '</h3>';
                                                echo '<p>' . nl2br(htmlspecialchars($region['region_description'])) . '</p>';
                                                echo '</div>';
                                                echo '<div class="col-lg-12 text-center order-1 order-lg-2">';
                                                echo '<img src="../System/img_uploads/' . htmlspecialchars($region['region_image']) . '" alt="' . htmlspecialchars($region['region_name']) . '" class="img-fluid" style="height:300px; width:650px; border-radius:10px">';
                                                echo '</div>';
                                                echo '</div>' ;
                                                echo '<hr>' ;
                                                echo '<h2> The Attractions from its District</h2>' ;
                                                if (!empty($region['attractions'])) {
                                                    foreach ($region['attractions'] as $attraction) {
                                                        echo '<div class="row gy-4">';
                                                        echo '<div class="col-lg-12 details order-2 order-lg-1">';
                                                        echo '<h3>  District: ' .   htmlspecialchars    (     $attraction['district']) . '</h3>';
                                                        echo '<h4>  Attraction:' . htmlspecialchars($attraction['attraction_name']) . '</h4>';
                                                        echo '<p> ' . nl2br(htmlspecialchars($attraction['attraction_description'])) . '</p>';
                                                        echo '</div>';
                                                        echo '<div class="col-lg-12 text-center order-1 order-lg-2">';
                                                        echo '<img src="../System/attract_uploads/' . htmlspecialchars($attraction['attraction_image']) . '" alt="' . htmlspecialchars($attraction['attraction_name']) .'" class="img-fluid" style="height:300px; width:650px; border-radius:10px">';
                                                        echo '</div>';
                                                        echo '</div>';
                                                        echo '<hr>' ;
                                                    }
                                                } else {
                                                    echo '<p>No attractions</p>';
                                                }
                                                echo '</div>';
                                                $first = false;
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ======= Footer ======= -->
                        <footer id="footer">

                            <div class="footer-top" style="background-color:antiquewhite">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-1 col-md-6 footer-contact"></div>
                                        <div class="col-lg-4 col-md-6 footer-contact">
                                            <h3>Tourists guide</h3>
                                            <p>
                                                Dar es salaam <br>

                                                Tanzania <br><br>
                                                <strong>Phone:</strong> +255 672488849<br>
                                                <strong>Email:</strong> omollogivenality@gmail.com<br>
                                            </p>
                                        </div>

                                        <div class="col-lg-3 col-md-6 footer-links">
                                            <h4>Follow Us Via</h4>
                                            <ul>
                                                <li><i class="bx bx-chevron-right"></i> <a>Facebook</a></li>
                                                <li><i class="bx bx-chevron-right"></i> <a>Linked In</a></li>
                                                <li><i class="bx bx-chevron-right"></i> <a>Tweeter</a></li>
                                                <li><i class="bx bx-chevron-right"></i> <a>Instagram</a>
                                                </li>

                                            </ul>
                                        </div>

                                        <div class="col-lg-4 col-md-6 footer-links">
                                            <h4>Our Services</h4>
                                            <ul>
                                                <li><i class="bx bx-chevron-right"></i> <a href="#">Tour guide
                                                        operations</a></li>
                                                <li><i class="bx bx-chevron-right"></i> <a href="#">Hospitality</a>
                                                </li>

                                            </ul>
                                        </div>



                                    </div>
                                </div>
                            </div>


                        </footer><!-- End Footer -->
                    </div>
                    <div class="col-md-2"></div>


                </div>




            </div>
        </section>
    </main>

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
</body>

</html>