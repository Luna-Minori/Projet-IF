<?php
session_start();

// Vérifier si l'utilisateur est connecté
// if (!isset($_SESSION['username'])) {
//     header('Location: login_user.php');
//     exit();
// }
?>

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
<body>
    <header>
        <nav>
            <ul>
                <li class="logo_container">
                    <img class="logo" src="Image/logo.png">
                        </li>
                            <li class="deroulant_Main"><a href="#"> Profile &ensp;</a>
                                <ul class="deroulant_Second">
                                   <li><a href="Login_user.php"> My Profile </a></li>
                                   <li><a href="Create_user.php"> Account creation </a></li>
                                   <li><a href="Create_user.php"> Tournament creation </a></li>
                                </ul>
                           </li>
                        <li class="deroulant_Main"><a href="#"> Team &ensp;</a>
                            <ul class="deroulant_Second">
                                <li><a> Account creation </a></li>
                                <li><a> Team creation </a></li>
                                <li><a> Tournament creation </a></li>
                           </ul>
                        </li>
                        <li class="deroulant_Main"><a href="#"> Tournament &ensp;</a>
                                <ul class="deroulant_Second">
                                    <li><a> Account creation </a></li>
                                    <li><a> Team creation </a></li>
                                    <li><a> Tournament creation </a></li>    
                                </ul>
                            </li>
                        <li class="deroulant_Main"><a href="#"> Account Creation &ensp;</a>
                                <ul class="deroulant_Second">
                                    <li><a> Account creation </a></li>
                                    <li><a> Team creation </a></li>
                                    <li><a> Tournament creation </a></li>
                                </ul>
                         </li>
                    </ul>
                </nav>
                <div class = "content">
                    <section id="upcoming-tournaments">
                        <h2>Upcoming Tournaments</h2> 
                        <p><strong>Name:</strong> Summer Championship 2024</p>
                        <p><strong>Date:</strong> September 20, 2024</p>
                        <p><strong>Location:</strong> Virtual Arena</p>
                    </section>
                </div>
            </ul>
        </nav>
    </header>



    <!-- Tournament Details Section -->
    <!-- <section id="tournament-details">
        <h2>Tournament Details</h2>
        <p><strong>Name:</strong> Summer Championship 2024</p>
        <p><strong>Date:</strong> September 20, 2024</p>
        <p><strong>Location:</strong> Virtual Arena</p>
    </section> -->

    <!-- Participants Section -->
    <!-- <section id="participants">
        <h2>Participants</h2>
        <ul class ="test">
            <li class="testli">Player 1</li>
            <li class="testli">Player 2</li>
            <li class="testli">Player 3</li>
            <li class="tetsli">Player 4</li>
            <!-- Add more participants -->
        <!-- </ul>
    </section> -->

    <!-- Matches Section -->
    <!-- <section id="matches">
        <h2>Upcoming Matches</h2>
        <ul class ="test">
            <li class="testli">Player 1 vs Player 2 - 12:00 PM</li>
            <li class="testli">Player 3 vs Player 4 - 1:00 PM</li> -->
            <!-- Add more matches -->
        <!-- </ul>
    </section> -->

    <!-- Leaderboard Section -->
    <!-- <section id="leaderboard">
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
            </tr> -->
            <!-- Add more players -->
        <!-- </table>
    </section> -->
</body>
</html>
