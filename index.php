<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "section3";

try {
    $pdo = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['submit'])) {
        $search = $_GET['search'];
        $search = strip_tags($search);
        $search = htmlspecialchars($search);
        $query = $pdo->prepare("SELECT * FROM student WHERE first_name LIKE :search OR last_name LIKE :search OR department LIKE :search OR sid LIKE :search");
        $query->execute(array(':search' => "%$search%"));
        $students = $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $query = $pdo->query("SELECT * FROM student");
        $students = $query->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "<div class='p'>" .
        "<p style='margin-bottom: 1rem; color: red;'>Connection failed: {$e->getMessage()}" .
        "<p>For this website to work, you need to do the following:</p>
        <ul>
            <li>Make sure MySQL Database & Apache Web Server are running</li>
            <li>Go to Xampp folder</li>
            <li>Go to php folder</li>
            <li>Open php.ini</li>
            <li>Search for <code>;extension=php_pdo_mysql.dll</code></li>
            <li>Get rid of the ';' to uncomment</li>
            <li>Save the file</li>
            <li>Restart Apache Web Server & MySQL Database</li>
            <li>Finally, refresh the web page or open it again</li>
        </ul>
    </div>";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">
    <link rel="icon" href="plus.png" class="title-header" />
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Registration</title>
</head>

<body>

    <header>
        <nav class="nav-list">
            <ul class="navigation-hold">
                <li class="list-item"><a href="index.php">Home</a></li>
                <li class="list-item"><a href="register.php">Register</a></li>
                <!-- <li class="list-item"><a href="login.php">Login</a></li> -->
                <!-- <h3 class="logo"><a href="index.php">GROUP TWO</a></h3> -->
            </ul>
            <div class="search" style="padding: 0; margin: 0; margin-top: 1rem;">
                <form action="index.php" class="searching" method="GET">
                    <input type="text" placeholder="search" class="search-input" style="border-radius: 4px;border-color:rgba(255, 255, 255, 0.5); color: white;" name="search" id="search">
                    <button type="submit" name="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <li class="list-item" style="position: absolute; bottom: 1.4rem; left: 14rem; font-size: 18px;"><a href="register.php">+</a></li>
        </nav>
    </header>
    <div class="dashboard" style="margin-top: 6rem;">
        <h2 style=" margin-left: .5rem; color: black;">ADMINISTRATION DASHBOARD</h2>

    </div>
    <main class="main-index">
        <div class="all_content">
            <div class="table-wrapper" style="margin: 0rem .7rem;">
                <?php if (empty($students)) : ?>
                    <h3 class="no-match" style="">No match found for <strong><em><?php echo isset($_GET['search']) ? "'" . $_GET['search'] . "'" : header("Location: register.php"); ?></em> search again or </strong><a href="index.php" style="color: blue !important;">Go back</a></h3>
                <?php else : ?>
                    <div class="grid_container">
                        <?php foreach ($students as $student) : ?>
                            <div class="grid">
                                <div class="content">
                                    <div class="head">
                                        <span>Student ID: <span><?php echo $student['SID'] ?></span></span>
                                        <div class="button_container">
                                            <form action="update.php" method="POST">
                                                <input type="hidden" name="sid" value="<?php echo $student['SID'] ?>">
                                                <input type="submit" name="submit" value='Update' class="update-button">
                                            </form>
                                            <form action="delete.php" method="GET" class="delete">
                                                <input type="hidden" name="sid" value="<?php echo $student['SID']; ?>">
                                                <input type="submit" value="Delete" class="delete-button">
                                            </form>
                                        </div>
                                    </div>
                                    <div class="grid_contents">

                                        <div class="image_wrapper">
                                            <img src="<?php echo $student['photo'] ?>" alt="">
                                        </div>
                                        <div class="description">
                                            <p>First name: <?php echo $student['first_name']  ?> </p>
                                            <p>Last name: <?php echo $student['last_name'] ?> </p>
                                            <p>Gender: <?php echo $student['gender']  ?> </p>
                                            <p>Department: <?php echo $student['department']  ?> </p>
                                            <p>Year: <?php echo $student['year']  ?> </p>
                                            <p>Address: <?php echo $student['address']  ?> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="btn-add_wrapper">
                        <a href="register.php" class="add-student">Add New Student</a>
                    </div>
                <?php endif; ?>

                <style>
                    .logo {
                        position: absolute;
                        right: 1rem;
                        top: 39%;
                    }

                    .logo a {
                        text-decoration: none;
                        color: black;
                        font-weight: bold;
                    }

                    .nav-list {
                        display: flex;
                        flex-direction: column;
                        align-items: flex-start;
                    }

                    nav {
                        display: flex;
                        justify-content: flex-end;
                        padding: 15px 20px;
                        border-bottom: solid black 2px;
                        z-index: 99 !important;
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        background-color: rgba(4, 91, 123, 0.2);
                        backdrop-filter: blur(19px);
                        -webkit-backdrop-filter: blur(19px);
                    }

                    .list-item a {
                        border: solid white;
                        border-radius: 4px;
                        padding: 5px 18.5px;
                        border-color: rgba(255, 255, 255, 0.5);
                        color: white;
                    }

                    * p {
                        padding: .2rem 0;
                        font-size: clamp(16px, 3vw + 1rem, 18px);
                    }

                    .image_wrapper {
                        width: 220px;
                        height: 180px;
                        overflow: hidden;
                    }

                    .image_wrapper img {
                        border: solid rgba(4, 91, 123, 0.9) 1px;
                        border-radius: 5px;
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }

                    .btn-add_wrapper {
                        margin: 1rem !important;
                    }

                    .navigation-hold {
                        gap: 5px;
                    }

                    .main-index {
                        margin: 1rem 0;
                    }

                    nav {
                        z-index: 99;
                        justify-content: flex-start;
                    }

                    .grid_container {
                        display: grid;
                        gap: 20px;
                        grid-template-columns: repeat(3, 1fr);
                        grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
                        max-width: 1400px;
                        margin-inline: auto;
                    }

                    .grid {
                        max-width: 450px;
                        border: solid rgba(4, 91, 123, 0.9);
                        border-radius: 8px;
                        overflow: hidden;
                        /* margin-inline: auto; */
                        background-color: rgba(4, 91, 123, 0.4);
                        backdrop-filter: blur(2px);
                        -webkit-backdrop-filter: blur(2px);

                    }

                    .head {
                        display: flex;
                        color: white;
                        margin: 0;
                        box-sizing: border-box;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        max-width: 100%;
                        padding: 1rem .5rem;
                        background-color: rgba(4, 91, 123, 0.7);
                        backdrop-filter: blur(2px);
                        -webkit-backdrop-filter: blur(2px);

                    }

                    .button_container {
                        display: flex;
                        gap: 5px;
                    }

                    .description {
                        border-left: solid rgba(4, 91, 123, 0.5) 4px;
                        padding-left: 10px;
                        position: relative;
                    }

                    .description p {
                        color: white;
                    }

                    .grid_contents {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        gap: 10px;
                        padding: 1rem;
                    }
                </style>

                <!-- <div class="table-holder holder-one">
                    <table>
                        <tbody>
                            <tr>
                                <td colspan="2" class="dev">Developers</td>
                            </tr>
                            <tr>
                                <td class="th">Id</td>
                                <td class="th">Name</td>
                            </tr>
                            <tr>
                                <td>ETUBR/2057/13</td>
                                <td>Habtesellasie Fissha</td>
                            </tr>
                            <tr>
                                <td>TTR/0031/12</td>
                                <td>Ramzy Adle sebit</td>
                            </tr>
                            <tr>
                                <td>TTR/0022/12</td>
                                <td>Lia Wilson</td>
                            </tr>
                            <tr>
                                <td>TTR/0029/12</td>
                                <td>Moses David</td>
                            </tr>
                            <tr>
                                <td>TTR/0058/12</td>
                                <td>Malou Kuol Alol</td>
                            </tr>
                        </tbody>
                    </table>
                </div> -->

            </div>
        </div>
    </main>
    <?php require_once "./include/footer.php" ?>