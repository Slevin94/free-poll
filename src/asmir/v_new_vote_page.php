<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $username = "andreas";
    $password = "yF1K^R6Jqh8IbK9";
    $dbname = "freepoll";
    $servername = "localhost";

    # Session start muss auf jeder page vorhanden sein. Es reicht nicht wenn es auf einer einzigen ist.
    session_start();
    $id_poll_id = $_SESSION["id_poll"];
    # Display der frage selbst in der aller ersten Zeile
    $die_frage_who = $_SESSION["die_frage"];
    echo "Frage des Tages! : " . $die_frage_who . "<br>" . "<br>";
    $con = mysqli_connect("localhost", "$username", "$password", "$dbname");
    $sql = "SELECT * FROM poll_option WHERE poll_id = '$id_poll_id'";
    $result = mysqli_query($con, $sql);
    $i = 0;
    $counter = 0;

# Die form action MUSS als aller erstes kommen. Wenn form action und checkboxes getrennt vorkommen so kann
# die nächste page vote_result nicht die checkboxen lesen.
    ?>
    <form action="vote_result.php" method="post">
        <input type="submit" name="enter" value="Wahl abgeben">
        <a href="vote_press.php?id=<?php echo $id_poll_id;?>">Klicke hier um die Ergebnisse zu sehen</a>
        <?php
        if (mysqli_num_rows($result) > 0) {
            # Ausgabe der inhalte in jeder Zeile
            while ($row = mysqli_fetch_assoc($result)) {
                $_SESSION["poll-id"] = $row["poll_id"];
                $i++;
                $counter++;
                echo "<br>";
                # $row[" name der abfrage tabelle "]
                echo "Antwortmöglichkeit " . $i . ": " . $row["option_name"];
                # zur referenz https://stackoverflow.com/questions/17135192/php-how-can-i-create-variable-names-within-a-loop
                # Um .... ----
                # es werden hier variablen mit den namen option 1-n erstellt. Diese werden mit den optionsnamen gefüllt.
                # echo $$whatever gibt $option1-n aus. $whatever gibt option1-n aus.
                $whatever = "option{$i}";
                $$whatever = $row["id"];
                $class = "checkbox";
                ?>
                <input name="<?php echo $whatever ?>" type="<?php echo $class ?>" value="<?php echo $$whatever?>">
                <?php
            }
        }
        $_SESSION['max'] = $counter;
        ?>
    </form>
<?php
    
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$con->close();
?>