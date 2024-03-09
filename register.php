<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "section3";

try {
    $pdo = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['register'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $department = $_POST['dep'];
        $year = $_POST['year'];
        $address = $_POST['address'];

        $photo = $_FILES['photo']['name'];
        $targetDirectory = "./uploads/";
        $targetFilePath = $targetDirectory . $photo;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFilePath)) {
            $statement = $pdo->prepare("INSERT INTO student (first_name, last_name, gender, department, year, address, photo) VALUES (:first_name, :last_name, :gender, :department, :year, :address, :photo)");
            $statement->bindValue("first_name", $first_name);
            $statement->bindValue("last_name", $last_name);
            $statement->bindValue("gender", $gender);
            $statement->bindValue("department", $department);
            $statement->bindValue("year", $year);
            $statement->bindValue("address", $address);
            $statement->bindValue("photo", $targetFilePath);
            $statement->execute();

            header("Location: index.php");
            exit();
        } else {
            echo "Failed to upload the photo.";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<?php require "./include/header.php" ?>
<main class="main-index">
    <div class="container">
        <form action="register.php" method="POST" enctype="multipart/form-data">
            <h2 class="register-title">REGISTER FORM</h2>
            <label for="first_name">FIRST NAME</label>
            <input type="text" id="first_name" name="first_name" required>
            <label for="last_name">LAST NAME</label>
            <input type="text" id="last_name" name="last_name" required>
            <label for="gender">GENDER: </label>
            <label>
                <input type="radio" name="gender" value="Male" id="male" required>
                Male
            </label>
            <label>
                <input type="radio" name="gender" value="Female" id="female" required>
                Female
            </label>
            <label for="dep">DEPARTMENT</label>
            <select name="dep" id="select" required>
                <option value="Information Technology" selected>Information Technology</option>
                <option value="Architectural Design">Architectural Design</option>
                <option value="Electric Control">Electric Control</option>
                <option value="Electric Automation">Electric Automation</option>
                <option value="Civil Technology">Civil Technology</option>
                <option value="Automotive Technology">Automotive Technology</option>
                <option value="Garment Technology">Garment Technology</option>
                <option value="Manufacturing">Manufacturing</option>
                <option value="Welding">Welding</option>
                <option value="Food Technology">Food Technology</option>
            </select>
            <label for="year">YEAR</label>
            <input type="number" name="year" id="year" required>
            <label for="address">ADDRESS</label>
            <input type="text" name="address" id="address" required>
            <div class="photo-upload">
                <label for="photo">PHOTO</label>
                <input type="file" name="photo" required>
            </div>
            <div class="btns">
                <input type="submit" name="register" value="REGISTER">
            </div>
        </form>
    </div>
</main>
<script>
    const inputs = document.querySelectorAll('input');

    inputs.forEach(input => {
        console.log(input);
        input.addEventListener('input', function(event) {
            if (event.target.value) {
                input.classList.add('autofilled');
            } else {
                input.classList.remove('autofilled');

            }
        })
        input.addEventListener('animationstart', function(event) {
            if (event.animationName === 'onAutoFillStart') {
                input.classList.add('autofilled');
            }
        });

        input.addEventListener('animationend', function(event) {
            if (event.animationName === 'onAutoFillCancel') {
                input.classList.remove('autofilled');
            }
        });
    });
</script>
<?php require_once "./include/footer.php"; ?>