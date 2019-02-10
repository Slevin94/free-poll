<?php
# Referenz materialien
# https://stackoverflow.com/questions/3866524/mysql-update-column-1
# UPDATE categories SET posts = posts + 1 WHERE category_id = 42;
# Die checkboxen haben die id option1, option2, ...

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = "andreas";
$password = "yF1K^R6Jqh8IbK9";
$dbname = "freepoll";
$servername = "localhost";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$con=mysqli_connect("localhost","$username","$password","$dbname");
session_start();
$id_des_polls = $_SESSION["poll-id"];

$sql = "SELECT * FROM poll_vote WHERE poll_id = '$id_des_polls'";
$result = mysqli_query($con, $sql);
error_reporting( error_reporting() & ~E_NOTICE );
# die ?? '' beseitigen die fehlermeldung die aufkommt wenn option1 nicht gewählt wurde.
# echo $_POST['option' . $i] ?? '';
# Kommt aber nicht vor wenn es mit einen isset() vorher getestet wird.

$id_des_polls2 = $_SESSION["poll-id"];
if(!empty($_SERVER["HTTP_CLIENT_IP"])) {
    $ip = $_SERVER["HTTP_CLIENT_IP"];
} else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
    $ip = $_SERVER["HTTP_X_FORWARD_FOR"];
} else {
    $ip = $_SERVER["REMOTE_ADDR"];
}

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo $row["ip_used"] . " hat " . $row["id"] . "<br>";
        $ip_used_for_vote = $row["ip_used"];
    }
}

if(isset($_POST['enter'])) {
    #if (($row["poll_id"] = $_SESSION["poll-id"]) && ($ip = $row["ip_used"])){
    for ($i = 1; $i <= $_SESSION['max']; $i++) {
        $neu = $_POST['option' . $i];
        if (isset($neu)) {
            $sql = "UPDATE poll_option SET count = count + 1 WHERE id = '$neu'";
            $conn->query($sql);
            $sql2 = "UPDATE poll_vote SET ip_vote_used = '$ip'";
            $conn->query($sql2);
            echo "Du hast deine Stimme abgegeben! " . "<br>";
            echo $_POST['option' . $i] . "<br>";
        }
    }
}

header('Location: https://asmir.free-poll.de/vote_pres.php'."?=" . $id_des_polls2);
?>
