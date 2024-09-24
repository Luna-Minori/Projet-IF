<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Manager</title>
    <link rel="stylesheet" href="Main.css">
    <script>
        function Create_user() {
            // Redirige vers le script PHP
            window.location.href = 'Create_user.php'; // Changez 'traitement.php' pour votre script
        }
    </script>
</head>

 
    <!-- Top -->
    <header>
        <!-- <div>
            <input type="text" name="nom"/>
            <button type="submit">Envoyer text</button>
       <?php
        session_start();
        $nom = $_POST['nom'];
        $test_tableau = ['aa', 'aaa',35];
        $recipes = [
            ['Cassoulet','[...]','mickael.andrieu@exemple.com',true,],
            ['Couscous','[...]','mickael.andrieu@exemple.com',false,],
        ];        
        ?>
        <ul>
        <?php for ($lines = 0; $lines <= 1; $lines++): ?>
            <li><?php echo $recipes[$lines][0] . ' (' . $recipes[$lines][2] . ')'; ?></li>
        <?php endfor; ?>
        </ul>
        <?php
        echo 'Hello' . htmlspecialchars($nom);
        try {
            $ID = $_SESSION['ID'];
            $sql = new PDO ("mysql:host=localhost;dbname=Base_data;charset=utf8", "root", "");
            if($_server["REQUEST_METHOD"] == "POST"){
                $nom = $_POST['nom'];
                echo 'hello' . $nom;
            }
        } catch (PDOException $e) { // affiche message erreure si la connexion avec la base de donnée n'a pas marcher
            echo 'Erreur : ' . $e->getMessage();
        }
        ?>

        <select name="game">
            $rep = $sql->prepar("SELECT game.name, player_id");
        </select> -->
        <h1>Tournament Manager</h1>
        <p>Create your tournaments and manage them easily!</p>
        <div class="profile">
            <img class="Profile_picture" scr="Image\Profile_picture.jpg"></img>
            <button onclick="Create_user()">Create New Account</button>
        </div>
        
        </div>
    </header>

    <!-- Tournament Details Section -->
    <section id="tournament-details">
        <h2>Tournament Details</h2>
        <p><strong>Name:</strong> Summer Championship 2024</p>
        <p><strong>Date:</strong> September 20, 2024</p>
        <p><strong>Location:</strong> Virtual Arena</p>
    </section>

    <!-- Participants Section -->
    <section id="participants">
        <h2>Participants</h2>
        <ul>
            <li>Player 1</li>
            <li>Player 2</li>
            <li>Player 3</li>
            <li>Player 4</li>
            <!-- Add more participants -->
        </ul>
    </section>

    <!-- Matches Section -->
    <section id="matches">
        <h2>Upcoming Matches</h2>
        <ul>
            <li>Player 1 vs Player 2 - 12:00 PM</li>
            <li>Player 3 vs Player 4 - 1:00 PM</li>
            <!-- Add more matches -->
        </ul>
    </section>

    <!-- Leaderboard Section -->
    <section id="leaderboard">
        <h2>Leaderboard</h2>
        <table>
            <tr>
                <th>Rank</th>
                <th>Player</th>
                <th>Wins</th>
                <th>Losses</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Player 1</td>
                <td>3</td>
                <td>0</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Player 2</td>
                <td>2</td>
                <td>1</td>
            </tr>
            <!-- Add more players -->
        </table>
    </section>

</body>
</html>
