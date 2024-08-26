<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de gestion du chat</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #eef2f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
            animation: fadeIn 1s ease-in-out;
        }

        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
            margin-bottom: 20px;
            animation: slideUp 1s ease-out;
        }

        .form-container h1 {
            margin-bottom: 30px;
            font-size: 24px;
            color: #333;
            animation: fadeInDown 1s ease-out;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
            font-size: 16px;
        }

        .form-container input[type="text"]:focus,
        .form-container input[type="number"]:focus,
        .form-container select:focus {
            border-color: #007bff;
            outline: none;
        }

        .chrono-container {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: none;
            margin-bottom: 20px;
            animation: fadeInUp 0.8s ease-out;
        }

        .time {
            font-size: 48px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .buttons {
            margin-top: 20px;
        }

        .buttons button {
            padding: 12px 25px;
            font-size: 16px;
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .buttons button:hover {
            background-color: #0056b3;
        }

        .form-container input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-container input[type="submit"]:hover {
            background-color: #218838;
        }

        a {
            text-decoration: none;
            font-size: 18px;
            color: #007bff;
            margin-top: 20px;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
        }

        /* Animations */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            0% {
                transform: translateY(50px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h1>Formulaire de gestion du chat</h1>
        <form action="enregistrer.php" method="post">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
            <label for="dureeOption">Durée :</label>
            <select id="dureeOption" name="dureeOption" onchange="toggleDureeMode()">
                <option value="manuelle" selected>Manuelle</option>
                <option value="chronometre">Chronomètre</option>
            </select>
            <div id="dureeManuelle">
                <label for="duree">Durée (en minutes) :</label>
                <input type="number" id="duree" name="duree" step="1" min="0">
            </div>
            <div id="chronoSection" class="chrono-container">
                <div class="time" id="chrono">00:00:00</div>
                <div class="buttons">
                    <button type="button" onclick="startChrono()">Démarrer</button>
                    <button type="button" onclick="stopChrono()">Arrêter</button>
                    <button type="button" onclick="resetChrono()">Réinitialiser</button>
                </div>
                <input type="hidden" id="dureeChrono" name="dureeChrono">
            </div>
            <input type="submit" value="Envoyer">
        </form>
    </div>

    <a href="resultats.php">Voir les résultats</a>

    <script>
        let startTime, updatedTime, difference, tInterval;
        let running = false;

        function toggleDureeMode() {
            const mode = document.getElementById('dureeOption').value;
            if (mode === 'chronometre') {
                document.getElementById('dureeManuelle').style.display = 'none';
                document.getElementById('chronoSection').style.display = 'block';
                document.getElementById('duree').value = ''; // Efface la valeur du champ manuel
            } else {
                document.getElementById('dureeManuelle').style.display = 'block';
                document.getElementById('chronoSection').style.display = 'none';
                resetChrono(); // Réinitialise le chronomètre
            }
        }

        function startChrono() {
            if (!running) {
                startTime = new Date().getTime();
                tInterval = setInterval(updateTime, 1000);
                running = true;
            }
        }

        function stopChrono() {
            if (running) {
                clearInterval(tInterval);
                running = false;
            }
        }

        function resetChrono() {
            clearInterval(tInterval);
            running = false;
            document.getElementById('chrono').innerHTML = "00:00:00";
            document.getElementById('dureeChrono').value = ""; // Réinitialise la durée
        }

        function updateTime() {
            updatedTime = new Date().getTime();
            difference = updatedTime - startTime;

            let hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((difference % (1000 * 60)) / 1000);

            hours = (hours < 10) ? "0" + hours : hours;
            minutes = (minutes < 10) ? "0" + minutes : minutes;
            seconds = (seconds < 10) ? "0" + seconds : seconds;

            document.getElementById('chrono').innerHTML = hours + ":" + minutes + ":" + seconds;
            document.getElementById('dureeChrono').value = (hours * 60) + parseInt(minutes); // Enregistre la durée en minutes
        }

        window.onload = function () {
            toggleDureeMode(); // Initialise le mode par défaut
        };
    </script>

</body>

</html>
