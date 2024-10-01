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
        <h1>Tournament Manager</h1>
        <p>Create your tournaments and manage it easily!</p>
        <nav>
            <ul>
                <li class="déroulant_Main"><a href="#"> Creation</a>
                    <ul class="déroulant_Second">
                        <li><a> Account creation </a></li>
                        <li><a> Team creation </a></li>
                        <li><a> Tournament creation </a></li>
                    </ul>
                </li>
            </ul>
                <li class="déroulant_Main"><a href="#"> Creation</a>
                        <ul class="déroulant_Second">
                            <li><a> Account creation </a></li>
                            <li><a> Team creation </a></li>
                            <li><a> Tournament creation </a></li>
                        </ul>
                 </li>




        </nav>
        <a href="Create_user.php"><img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.istockphoto.com%2Ffr%2Fphotos%2Fimage-en-couleur&psig=AOvVaw2GkuW_LHP2yye1XpwYkYf7&ust=1727873580357000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCPC4weqc7YgDFQAAAAAdAAAAABAE"></img></a>

        <form method="post" action="Creation_Team.php">
            <p> Name of the team </p>
            <input type="text" name="nom" size="12" required>
            <br>
            <p> game </p>
            <select required>
            <option value="Osu">Osu</option>
            <option value="Mc">Mc</option>
            <option value="Apex">Apex</option>
            <option value="Célantix">Célantix</option>
            </select>

            <br>
            <p> Team member </p>
            <input type="text" name="Team_member" size="12" required>
            <br>
            <p>Description</p>
            <input type="Text" name="Description" size="12">
            <br>
            <p> Accepter vous les conditions générale utilisation de Tournament Manager</p>
            <input type="radio" name="eail" size="12">
            <br>
            <input type="submit" value="OK">
            <input type="reset" value="Reset">

       <?php
        session_start();
        echo 'Prénom : '.$_POST["prenom"].'<br>';        
        ?>
        <ul>
        <?php for ($lines = 0; $lines <= 1; $lines++): ?>
            <li><?php echo $lines;?></li>
        <?php endfor; ?>
        </ul>
        <?php
        $nom = "aa";
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

        </select>
        <div class="profile">
            <img class="Profile_picture" scr="Image\Profile_picture.jpg"></img>
            <button onclick="Create_user()">Exécuter le script PHP</button>
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
