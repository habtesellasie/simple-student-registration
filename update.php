<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "section3";


try {
    $pdo = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $searches = $_POST['sid'];
    $query = $pdo->prepare("SELECT * FROM student WHERE SID = :sid");
    $query->bindValue(':sid', $searches);
    $query->execute();
    $searches = $query->fetchAll(PDO::FETCH_ASSOC);
    if (isset($_POST['update'])) {
        $sid = $_POST['sid'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $department = $_POST['dep'];
        $year = $_POST['year'];
        $address = $_POST['address'];

        $photo = $_FILES['photo']['name'];
        $targetDirectory = "./uploads/";
        $targetFilePath = $targetDirectory . $photo;

        if ($_FILES['photo']['size'] > 0) {
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFilePath)) {
                $statement = $pdo->prepare("UPDATE student SET photo = :photo WHERE SID = :sid");
                $statement->bindValue(":photo", $targetFilePath);
                $statement->bindValue(":sid", $sid);
                $statement->execute();
            } else {
                echo "Failed to upload the photo.";
            }
        }

        $statement = $pdo->prepare("UPDATE student SET first_name = :first_name, last_name = :last_name, gender = :gender, department = :department, year = :year, address = :address WHERE SID = :sid");
        $statement->bindValue(":first_name", $first_name);
        $statement->bindValue(":last_name", $last_name);
        $statement->bindValue(":gender", $gender);
        $statement->bindValue(":department", $department);
        $statement->bindValue(":year", $year);
        $statement->bindValue(":address", $address);
        $statement->bindValue(":sid", $sid);
        $statement->execute();

        header("Location: index.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>

<?php require_once "./include/header.php" ?>

<div class="container">
    <form action="update.php" method="POST" enctype="multipart/form-data">
        <h2 class="register-title">UPDATE FORM</h2>
        <?php foreach ($searches as $search) : ?>
            <div class="photo-upload" style="gap: 10px; align-items: flex-end;">
                <div class="photo-hold">
                    <img src="<?php echo $search['photo'] ?>" style='width: 127px;' alt="">
                </div>
                <div>
                    <label for="photo" style="margin-left: .5rem;">PHOTO</label>
                    <input type="file" name="photo" value="">

                </div>
            </div>
            <input type="hidden" name="sid" value="<?php echo $search['SID'] ?>">
            <label for="first_name">FIRST NAME</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo $search['first_name'] ?>" required>
            <label for="last_name">LAST NAME</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $search['last_name'] ?>" required>
            <label for="gender">GENDER: </label>
            <label>
                <input type="radio" name="gender" value="Male" id="male" <?php echo $search['gender'] == 'Male' ? 'checked' : ''; ?> required>
                Male
            </label>
            <label>
                <input type="radio" name="gender" value="Female" id="female" <?php echo $search['gender'] == 'Female' ? 'checked' : ''; ?> required>
                Female
            </label>
            <label for="dep">DEPARTMENT</label>
            <select name="dep" id="select" required>
                <option value="Information Technology" <?php echo $search['department'] == "Information Technology" ? 'selected' : ''; ?>>Information Technology</option>
                <option value="Architectural Design" <?php echo $search['department'] == "Architectural Design" ? 'selected' : ''; ?>>Architectural Design</option>
                <option value="Electric Control" <?php echo $search['department'] == "Electric Control" ? 'selected' : ''; ?>>Electric Control</option>
                <option value="Electric Automation" <?php echo $search['department'] == "Electric Automation" ? 'selected' : ''; ?>>Electric Automation</option>
                <option value="Civil Technology" <?php echo $search['department'] == "Civil Technology" ? 'selected' : ''; ?>>Civil Technology</option>
                <option value="Automotive Technology" <?php echo $search['department'] == "Automotive Technology" ? 'selected' : ''; ?>>Automotive Technology</option>
                <option value="Garment Technology" <?php echo $search['department'] == "Garment Technology" ? 'selected' : ''; ?>>Garment Technology</option>
                <option value="Manufacturing" <?php echo $search['department'] == "Manufacturing" ? 'selected' : ''; ?>>Manufacturing</option>
                <option value="Welding" <?php echo $search['department'] == "Welding" ? 'selected' : ''; ?>>Welding</option>
                <option value="Food Technology" <?php echo $search['department'] == "Food Technology" ? 'selected' : ''; ?>>Food Technology</option>
            </select>

            <label for="year">YEAR</label>
            <input type="number" name="year" id="year" value="<?php echo $search['year'] ?>" required>

            <label for="address">ADDRESS</label>
            <input type="text" name="address" required value="<?php echo $search['address'] ?>" required>

            <div class="btns">
                <input type="submit" name="update" value="UPDATE">
            </div>
        <?php endforeach; ?>
    </form>
</div>

<?php require_once "./include/footer.php" ?>