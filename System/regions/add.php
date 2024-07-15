<?php
session_start();
include("../connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["post_data"])) {

    $name = $_POST["region"];
    $targetDir = "../img_uploads/";
    $fileName = basename($_FILES["image_name"]["name"]); 
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $description = $_POST["description"];

    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array($fileType, $allowTypes)) {
        if (move_uploaded_file($_FILES["image_name"]["tmp_name"], $targetFilePath)) {
            
            $sql = "INSERT INTO regions (name, image_name, description) VALUES (?, ?, ?)";
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("sss", $name, $fileName, $description);
            if ($stmt->execute()) {
               
                $_SESSION['success_message'] = "Region details added successfully.";
                header("location: add.php");
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

                            <!-- Added enctype attribute -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="regionName">Region</label>
                                    <select name="region" class="form-control" style="height:50px" id="regionName">
                                        <option value="" aria-readonly="">Select a Region</option>
                                        <option value="Arusha">Arusha</option>
                                        <option value="Dar es Salaam">Dar es Salaam</option>
                                        <option value="Dodoma">Dodoma</option>
                                        <option value="Geita">Geita</option>
                                        <option value="Iringa">Iringa</option>
                                        <option value="Kagera">Kagera</option>
                                        <option value="Katavi">Katavi</option>
                                        <option value="Kigoma">Kigoma</option>
                                        <option value="Kilimanjaro">Kilimanjaro</option>
                                        <option value="Lindi">Lindi</option>
                                        <option value="Manyara">Manyara</option>
                                        <option value="Mara">Mara</option>
                                        <option value="Mbeya">Mbeya</option>
                                        <option value="Morogoro">Morogoro</option>
                                        <option value="Mtwara">Mtwara</option>
                                        <option value="Mwanza">Mwanza</option>
                                        <option value="Njombe">Njombe</option>
                                        <option value="Pemba North">Pemba North</option>
                                        <option value="Pemba South">Pemba South</option>
                                        <option value="Pwani">Pwani</option>
                                        <option value="Rukwa">Rukwa</option>
                                        <option value="Ruvuma">Ruvuma</option>
                                        <option value="Shinyanga">Shinyanga</option>
                                        <option value="Simiyu">Simiyu</option>
                                        <option value="Singida">Singida</option>
                                        <option value="Tabora">Tabora</option>
                                        <option value="Tanga">Tanga</option>
                                        <option value="Zanzibar North">Zanzibar North</option>
                                        <option value="Zanzibar South and Central">Zanzibar South and Central</option>
                                        <option value="Zanzibar Urban West">Zanzibar Urban West</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="regionImage">Image</label>
                                    <input type="file" name="image_name" class="form-control" id="regionImage"
                                        accept="image/*" style="height:50px">
                                </div>

                                <div class="form-group">
                                    <label for="regionDescription">Description</label>
                                    <textarea name="description" class="form-control" id="regionDescription"
                                        style="height:150px" placeholder="Enter Description"></textarea>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" name="post_data" class="btn btn-primary">Submit</button>
                            </div>
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

<script>
function validateForm() {
    var region = document.getElementById('regionName').value;
    var image = document.getElementById('regionImage').value;
    var description = document.getElementById('regionDescription').value;
    var errorMessages = "";

    if (region === "") {
        errorMessages += "<p>Please select a region.</p>";
    }
    if (image === "") {
        errorMessages += "<p>Please upload an image.</p>";
    }
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if (image !== "" && !allowedExtensions.exec(image)) {
        errorMessages += "<p>Please upload a file having extensions .jpeg/.jpg/.png/.gif only.</p>";
    }
    if (description === "") {
        errorMessages += "<p>Please enter a description.</p>";
    }

    if (errorMessages !== "") {
        var errorDiv = document.getElementById('errorMessages');
        errorDiv.innerHTML = errorMessages;
        errorDiv.style.display = "block";
        return false;
    }

    return true;
}
</script>