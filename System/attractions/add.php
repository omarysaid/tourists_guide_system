<?php
session_start();
include("../connection/connection.php");

$region_id = "";
$region_name = "";

// Check if 'region_id' is passed in the URL and fetch region details
if (isset($_GET['region_id']) && !empty($_GET['region_id'])) {
    $region_id = $_GET['region_id'];
    $select_region = "SELECT * FROM regions WHERE region_id = '$region_id'";
    $result = mysqli_query($connect, $select_region);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $region_name = $row['name'];
    } else {
        echo "Region not found.";
        exit();
    }
} else {
    echo "Region ID is not provided.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["post_data"])) {
    $district = $_POST["district"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $targetDir = "../attract_uploads/";
    $fileName = basename($_FILES["image"]["name"]); 
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (!empty($_FILES["image"]["name"])) {
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                $sql = "INSERT INTO attractions (region_id, district, name, description, image) VALUES (?, ?, ?, ?, ?)";
                $stmt = $connect->prepare($sql);
                $stmt->bind_param("sssss", $region_id, $district, $name, $description, $fileName);
                if ($stmt->execute()) {
                    $_SESSION['success_message'] = "Details added successfully.";
                    header("location: add.php?region_id=$region_id");
                    exit(); 
                } else {
                    echo "Error: " . $sql . "<br>" . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
    } else {
        echo "Please select a file to upload.";
    }
}
?>

<?php include('../include/header.php'); ?>
<?php include('../include/sidebar.php'); ?>

<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid shadow" style="background-color: black;margin-top:10px">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-dark shadow">
                        <div class="card-header shadow">
                            <h3 class="card-title">Attraction Form</h3>
                        </div>
                        <form role="form" method="POST" enctype="multipart/form-data">
                            <?php
                            if (isset($_SESSION['success_message'])) {
                                echo '<div class="alert alert-success" style="color:white">' . $_SESSION['success_message'] . '</div>';
                                unset($_SESSION['success_message']);
                            }
                            ?>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="regionName">Region</label>
                                    <input type="text" class="form-control" style="height:50px" id="regionName"
                                        value="<?php echo $region_name; ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <input type="hidden" name="region_id" class="form-control"
                                        value="<?php echo $region_id; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="districtName">District</label>
                                    <input type="text" name="district" class="form-control" style="height:50px"
                                        id="districtName" placeholder="Enter District Name">
                                </div>

                                <div class="form-group">
                                    <label for="attractionName">Name</label>
                                    <input type="text" name="name" class="form-control" style="height:50px"
                                        id="attractionName" placeholder="Enter Attraction Name">
                                </div>

                                <div class="form-group">
                                    <label for="regionDescription">Description</label>
                                    <textarea name="description" class="form-control" id="regionDescription"
                                        style="height:150px" placeholder="Enter Description"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="regionImage">Image</label>
                                    <input type="file" name="image" class="form-control" id="regionImage"
                                        accept="image/*" style="height:50px">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" name="post_data" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6"></div>
            </div>
        </div>
    </section>
</div>
<?php include('../include/footer.php'); ?>