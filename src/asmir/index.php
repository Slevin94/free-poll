
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Umfrage erstellen</title>
    <link rel="stylesheet" href="style.css">
    <script>
        var number = 0;
        function createSatzfrage(question_number) {
            return '<label>\n' +
                '                Titel der Frage Nummer ' + question_number + ': <input type="text" class="bigger_width" name="question' + question_number + '">\n' +
                '            </label>';
        }


        function getNumber() {
            number++;
            return number;
        }

        function toggleAddQuestionPopup() {
            var popUp = document.getElementById('addQuestionPopup');
            if (popUp.style.display === 'inline-block') {
                popUp.style.display = 'none';
            } else {
                popUp.style.display = 'inline-block';
            }
        }

        function addSatzfrage() {
            toggleAddQuestionPopup();

            var question_number = getNumber();

            var satzfrage = document.createElement('div');
            satzfrage.setAttribute("id", "satzfrage" + question_number);
            satzfrage.setAttribute("class", "question");
            satzfrage.innerHTML = createSatzfrage(question_number);

            var before = document.getElementById('insert_questions_before_me');
            before.parentNode.insertBefore(satzfrage, before);
        }

    </script>
</head>
<body>

<form action="poll_create.php" method="post">

    <div class="center">
        <h1>
            <label>
                Frage? <input type="text" name="title" placeholder="Stell deine Fffrage hier">
            </label>
        </h1>
        <h4>
            <label>
                Untertitel: <input type="text" class="bigger_width" name="subtitle"
                                   placeholder="Dieses feld macht absolut nix gerade!">
            </label>
        </h4>

        <div class="question_container">
            <button id="button_toggleAddQuestionPopup" onclick="toggleAddQuestionPopup(); return false;">Frage hinzufügen</button>
        </div>

        <div id="insert_questions_before_me"></div>
        <div id="addQuestionPopup">
            <ul>
                <li><button onclick="addSatzfrage(); return false;">Satzfrage</button></li>
                <li><button>Wortfrage</button></li>
                <li><button>Binäre Frage</button></li>
                <li><button>Datum</button></li>
            </ul>
        </div>
        <input id="submit" type="submit" value="Umfrage erstellen!">


    </div>
</form>
</body>
</html>

