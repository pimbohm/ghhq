<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";

try {
//Creating connection for mysql
    $conn = new PDO("mysql:host=$servername;dbname=login", $username, $password);
// set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Title </title>
    <link rel="stylesheet" href="css/stijling.css" type="text/css">
</head>
<body>
<div id="alles">
    <div class="mip">
        <h2>Kies een icoon voor uw applicatie</h2>
        <p>U kunt alleen .jpeg, .jpg en .png bestanden uploaden.<br> U kunt geen grotere bestanden dan 2mb uploaden. <br></p>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="file">
            <input type="hidden" name="date">
            <input type="submit" name="submit" value="upload"><br>
        </form>
        <hr>
        <?php
        if(isset($_POST['submit'])) {

            $file = $_FILES['file'];
            //print_r($file);
            $fileName = $_FILES['file']['name'];
            $fileTmpName = $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];
            $fileError = $_FILES['file']['error'];
            $fileType = $_FILES['file']['type'];

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allowed = array('mp4');

            if (false == in_array($fileActualExt, $allowed)) {

                echo 'U kunt gekozen afbeelding ' . $fileName . ' niet uploaden omdat het niet het juiste type bestand is.<br>';
                $_SESSION['wrong_filetype'] = 1;
                $_SESSION['error'] = 1;
            }
//
//            if ($fileError !== 0) {
//                echo 'U kunt gekozen afbeelding ' . $fileName . ' niet uploaden omdat er een error is opgetreden.<br>';
//                $_SESSION['file_error'] = 1;
//                $_SESSION['error'] = 1;
//            }

            if ($fileSize >= 100000000000000000) {
                echo 'U kunt gekozen afbeelding ' . $fileName . ' niet uploaden omdat het niet het juiste type bestand is.<br>';
                $_SESSION['to_large_file'] = 1;
            } // we passed all tests, continue processing the image

            if (false == isset($_SESSION['wrong_filetype']) && false == isset($_SESSION['wrong_filetype'])) { // don't upload a file if the file gives an error
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = 'upload/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                $_SESSION['app_icoon'] = $fileDestination;
            }
            $stmt = $conn->prepare("INSERT INTO images (file_name)
    VALUES (:vid)");
            $stmt->bindParam(':vid', $_SESSION['app_icoon']);

            $stmt->execute();
        }
        if (isset($_SESSION['app_icoon'])) {
            unset($_SESSION['app_icoon']);
            header("Refresh: 0; url= video.php");
            echo '<script type="text/javascript">alert("Uw bestand is geupload!");</script>';
        }

        ?>
    </div>
</div>
<a href="hoofdpagina.php">home</a>
<a href="video.php">video</a>
</body>

</html>
