<?php
session_start();
include("../connection/connection.php");

$attraction_id = "";
$region_name = "";

// Check if 'attraction_id' is passed in the URL and fetch attraction details
if (isset($_GET['attraction_id']) && !empty($_GET['attraction_id'])) {
    $attraction_id = $_GET['attraction_id'];
    $select_attraction = "SELECT * FROM attractions WHERE attraction_id = '$attraction_id'";
    $result = mysqli_query($connect, $select_attraction);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $region_name = $row['name'];
        $district = $row['district'];
        $name = $row['name'];
        $description = $row['description'];
        $image = $row['image'];
    } else {
        echo "Attraction not found.";
        exit();
    }
} else {
    echo "Attraction ID is not provided.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $district = $_POST["district"];

    if ($_FILES["image"]["name"]) {
        $image_name = $_FILES["image"]["name"];
        $temp_image_name = $_FILES["image"]["tmp_name"];
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");

        if (in_array($image_extension, $allowed_extensions)) {
            $unique_image_name = uniqid("attraction_") . "." . $image_extension;

            if (move_uploaded_file($temp_image_name, "../attract_uploads/" . $unique_image_name)) {
                // Update the database with the new image name using a prepared statement
                $sql = "UPDATE attractions SET district=?, name=?, description=?, image=? WHERE attraction_id=?";
                $stmt = $connect->prepare($sql);
                $stmt->bind_param("ssssi", $district, $name, $description, $unique_image_name, $attraction_id);
                if ($stmt->execute()) {
                    $_SESSION['success_message'] = "Record updated successfully.";
                    header("Location: update.php?attraction_id=$attraction_id");
                    exit();
                } else {
                    echo "Error updating record: " . $connect->error;
                }
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "Invalid file format. Please upload an image.";
        }
    } else {
        // If no new image uploaded, only update other details using a prepared statement
        $sql = "UPDATE attractions SET district=?, name=?, description=? WHERE attraction_id=?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("sssi", $district, $name, $description, $attraction_id);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Record updated successfully.";
            header("Location: update.php?attraction_id=$attraction_id");
            exit();
        } else {
            echo "Error updating record: " . $connect->error;
        }
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
                                    <label for="districtName">District</label>
                                    <input type="text" name="district" class="form-control" style="height:50px"
                                        id="districtName" value="<?php echo $district; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="attractionName">Name</label>
                                    <input type="text" name="name" class="form-control" style="height:50px"
                                        id="attractionName" value="<?php echo $name; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="regionDescription">Description</label>
                                    <textarea name="description" class="form-control" id="regionDescription"
                                        style="height:150px"><?php echo $description; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="regionImage">Image</label>
                                    <input type="file" name="image" class="form-control" id="regionImage"
                                        accept="image/*" style="height:50px">
                                    <?php if (isset($image) && !empty($image)) : ?>
                                    <img src="../attract_uploads/<?php echo htmlspecialchars($image); ?>"
                                        alt="Current Image" style="max-width: 600px; max-height: 400px;">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" name="update" class="btn btn-primary">Submit</button>
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