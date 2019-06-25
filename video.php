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

$sql = $conn->prepare("SELECT * FROM images ORDER BY id ASC");
$sql->execute();
while ($result = $sql->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <video width="400" height="400" controls>
        <source src="<?php
        echo $result['file_name'];
        ?>"
        type="video/mp4">
    </video>
    <?php
    echo "<br/>";
    ?>
<?php
}
?>
<a href="hoofdpagina.php">home</a>
<a href="upload.php">videouploader</a>
