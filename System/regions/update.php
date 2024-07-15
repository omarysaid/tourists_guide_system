<?php
session_start();
include("../connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["region_id"])) {
    $region_id = $_GET["region_id"];
    $sql = "SELECT * FROM regions WHERE region_id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $region_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row["name"];
        $image = $row["image_name"];
        $description = $row["description"];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $region_id = $_POST["region_id"];
    $name = $_POST["name"];
    $description = $_POST["description"];
 

    if ($_FILES["image_name"]["name"]) {
        $image_name = $_FILES["image_name"]["name"];
        $temp_image_name = $_FILES["image_name"]["tmp_name"];
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");

        if (in_array($image_extension, $allowed_extensions)) {
            $unique_image_name = uniqid("region_") . "." . $image_extension;

            if (move_uploaded_file($temp_image_name, "../img_uploads/" . $unique_image_name)) {
                // Update the database with the new image name using a prepared statement
                $sql = "UPDATE regions SET name=?, image_name=?, description=? WHERE region_id=?";
                $stmt = $connect->prepare($sql);
                $stmt->bind_param("sssi", $name, $unique_image_name, $description, $region_id);
                if ($stmt->execute()) {
                    echo "Record updated successfully. <a href='allSymbols.php'>Go back</a>";
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
        $sql = "UPDATE regions SET name=?, description=? WHERE region_id=?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("ssi", $name, $description, $region_id);
        if ($stmt->execute()) {
            echo "Record updated successfully. <a href='allSymbols.php'>Go back</a>";
        } else {
            echo "Error updating record: " . $connect->error;
        }
    }
    $_SESSION['success_message'] = "Record updated successfully.";
    header("Location: {$_SERVER['PHP_SELF']}?region_id=$region_id");
    exit();
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
                        <form role="form" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                            <?php
                            // Display success message if it exists
                            if (isset($_SESSION['success_message'])) {
                                echo '<div class="alert alert-success" style="color:white">' . $_SESSION['success_message'] . '</div>';
                                unset($_SESSION['success_message']); // Clear the success message
                            }
                            ?>
                            <!-- Error messages -->
                            <div id="errorMessages" class="alert alert-danger" style="display:none;"></div>

                            <?php
                            $select_user = "SELECT * FROM regions WHERE region_id = '" . $_GET['region_id'] . "'";
                            $result = mysqli_query($connect, $select_user);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>

                            <input type="hidden" name="region_id" value="<?php echo $region_id; ?>" />

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="regionName">Region</label>
                                    <select name="name" class="form-control" style="height:50px" id="regionName">
                                        <option value="" aria-readonly="">Select a Region</option>
                                        <option value="Arusha" <?php echo $name == 'Arusha' ? 'selected' : ''; ?>>Arusha
                                        </option>
                                        <option value="Dar es Salaam"
                                            <?php echo $name == 'Dar es Salaam' ? 'selected' : ''; ?>>Dar es Salaam
                                        </option>
                                        <option value="Dodoma" <?php echo $name == 'Dodoma' ? 'selected' : ''; ?>>Dodoma
                                        </option>
                                        <option value="Geita" <?php echo $name == 'Geita' ? 'selected' : ''; ?>>Geita
                                        </option>
                                        <option value="Iringa" <?php echo $name == 'Iringa' ? 'selected' : ''; ?>>Iringa
                                        </option>
                                        <option value="Kagera" <?php echo $name == 'Kagera' ? 'selected' : ''; ?>>Kagera
                                        </option>
                                        <option value="Katavi" <?php echo $name == 'Katavi' ? 'selected' : ''; ?>>Katavi
                                        </option>
                                        <option value="Kigoma" <?php echo $name == 'Kigoma' ? 'selected' : ''; ?>>Kigoma
                                        </option>
                                        <option value="Kilimanjaro"
                                            <?php echo $name == 'Kilimanjaro' ? 'selected' : ''; ?>>Kilimanjaro</option>
                                        <option value="Lindi" <?php echo $name == 'Lindi' ? 'selected' : ''; ?>>Lindi
                                        </option>
                                        <option value="Manyara" <?php echo $name == 'Manyara' ? 'selected' : ''; ?>>
                                            Manyara</option>
                                        <option value="Mara" <?php echo $name == 'Mara' ? 'selected' : ''; ?>>Mara
                                        </option>
                                        <option value="Mbeya" <?php echo $name == 'Mbeya' ? 'selected' : ''; ?>>Mbeya
                                        </option>
                                        <option value="Morogoro" <?php echo $name == 'Morogoro' ? 'selected' : ''; ?>>
                                            Morogoro</option>
                                        <option value="Mtwara" <?php echo $name == 'Mtwara' ? 'selected' : ''; ?>>Mtwara
                                        </option>
                                        <option value="Mwanza" <?php echo $name == 'Mwanza' ? 'selected' : ''; ?>>Mwanza
                                        </option>
                                        <option value="Njombe" <?php echo $name == 'Njombe' ? 'selected' : ''; ?>>Njombe
                                        </option>
                                        <option value="Pemba North"
                                            <?php echo $name == 'Pemba North' ? 'selected' : ''; ?>>Pemba North</option>
                                        <option value="Pemba South"
                                            <?php echo $name == 'Pemba South' ? 'selected' : ''; ?>>Pemba South</option>
                                        <option value="Pwani" <?php echo $name == 'Pwani' ? 'selected' : ''; ?>>Pwani
                                        </option>
                                        <option value="Rukwa" <?php echo $name == 'Rukwa' ? 'selected' : ''; ?>>Rukwa
                                        </option>
                                        <option value="Ruvuma" <?php echo $name == 'Ruvuma' ? 'selected' : ''; ?>>Ruvuma
                                        </option>
                                        <option value="Shinyanga" <?php echo $name == 'Shinyanga' ? 'selected' : ''; ?>>
                                            Shinyanga</option>
                                        <option value="Simiyu" <?php echo $name == 'Simiyu' ? 'selected' : ''; ?>>Simiyu
                                        </option>
                                        <option value="Singida" <?php echo $name == 'Singida' ? 'selected' : ''; ?>>
                                            Singida</option>
                                        <option value="Tabora" <?php echo $name == 'Tabora' ? 'selected' : ''; ?>>Tabora
                                        </option>
                                        <option value="Tanga" <?php echo $name == 'Tanga' ? 'selected' : ''; ?>>Tanga
                                        </option>
                                        <option value="Zanzibar North"
                                            <?php echo $name == 'Zanzibar North' ? 'selected' : ''; ?>>Zanzibar North
                                        </option>
                                        <option value="Zanzibar South and Central"
                                            <?php echo $name == 'Zanzibar South and Central' ? 'selected' : ''; ?>>
                                            Zanzibar South and Central</option>
                                        <option value="Zanzibar Urban West"
                                            <?php echo $name == 'Zanzibar Urban West' ? 'selected' : ''; ?>>Zanzibar
                                            Urban West</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="regionImage">Image</label>
                                    <input type="file" name="image_name" class="form-control" id="regionImage"
                                        accept="image/*" style="height:50px">
                                    <?php if (isset($image) && !empty($image)) : ?>
                                    <img src="../img_uploads/<?php echo htmlspecialchars($image); ?>"
                                        alt="Current Image" style="max-width: 600px; max-height: 400px;">
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="regionDescription">Description</label>
                                    <textarea name="description" class="form-control" id="regionDescription"
                                        style="height:150px"
                                        placeholder="Enter Description"><?php echo isset($description) ? $description : ''; ?></textarea>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" name="update" class="btn btn-primary">Submit</button>
                            </div>
                            <?php
                                }
                            }
                            ?>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
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