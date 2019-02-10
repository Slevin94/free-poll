<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
# Diese Felder hier dürfen nicht privat gesetzt werden. Sonst funktioniert nichts.
    $username = "andreas";
    $password = "yF1K^R6Jqh8IbK9";
    $dbname = "freepoll";
    $servername = "localhost";

# https://stackoverflow.com/questions/21066386/making-dynamic-straw-poll vorangehende DB logik hier festgelegt mit bsp.
# https://www.w3schools.com/php/php_mysql_insert.asp referenz material fürs einschreiben in die DB
# poll create hat id, poll_name welcher die frage selbst ist und timestamp_create was die Uhrzeit ist

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    # Erstellung einer einzigartigen ID für den Poll selbst, abgleichung mit datenbank muss nicht erfolgen
    # da uniqid(); absolut einzigartig ist. Ist zwar vorhersehbar aber einzigartig.
    # Hier kommt noch hin die IP Adressen erkennung welche noch auf dem Heimrechner hinterlegen ist
    $id_poll = uniqid();
    $id_vote = uniqid();
    $content_title = $_POST['title'];
    if(!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
          } else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $ip = $_SERVER["HTTP_X_FORWARD_FOR"];
            } else {
        $ip = $_SERVER["REMOTE_ADDR"];
        }

    # ---------------------------HIER WIRD DER POLL SELBST ERSTELLT----------------------------------------
    $placeholder = "platzalter für den Untertitel";
    $sql = "INSERT INTO poll (id, poll_name, subtitle)
    VALUES ('$id_poll', '$content_title', '$placeholder')";
    $conn->exec($sql);

    # ---------------------------HIER WERDEN DIE OPTIONEN HINZUGEFÜGT----------------------------------------
    #Die fragen selber sind questionN
    #Die antworten heißen answerN
    #Antworten können Binär, Text basierend und Datum basierend sein.
    for($i = 1; $i <= 30; $i++) {
    if(isset($_POST['question' . $i])) {
         $id_option = uniqid();
         $content_satzfrage = $_POST['question' . $i];
         $sql = "INSERT INTO poll_option (id, option_name, poll_id)
         VALUES ('$id_option', '$content_satzfrage', '$id_poll')";
         $conn->exec($sql);
    }
}

    # ---------------------------HIER WIRD DER VOTE HINTERLEGT----------------------------------------
    $sql = "INSERT INTO poll_vote (id, ip_used, poll_id)
    VALUES ('$id_vote', '$ip', '$id_poll')";
    $conn->exec($sql);

    #Diesen Teil gibt es nicht in der UI aber falls ein Custom link erwünscht ist dann:
    #$CustomLinkName = $_POST['CustomLink'];
    #if(isset($_POST['CustomLink']) {
    #   header('Location: https://asmir.free-poll.de/v_new_vote_page.php'."?=" . $CustomLinkName);
    #} else {
    #header('Location: https://asmir.free-poll.de/v_new_vote_page.php'."?=" . $id_poll);
    session_start();
    $_SESSION["id_poll"] = $id_poll;
    $_SESSION["die_frage"] = $content_title;
    header('Location: https://asmir.free-poll.de/v_new_vote_page.php'."?=" . $id_poll);
    }
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;
?>

<a href="v_new_vote_page.php?id=<?php echo $id_poll;?>">Klicke hier um zur Umfragepage zu kommen</a>

