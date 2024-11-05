<?php

    session_start();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Manager</title>
    <link rel="stylesheet" href="Main.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li class="logo_container">
                    <img class="logo" src="Image/logo.png">
                <nav>
                    <ul>
                        <li class="deroulant_Main"><a href="#"> Profile &ensp;</a>
                            <ul class="deroulant_Second">
                               <li> 
                                    <?php  
                                        if (!empty($_SESSION['username'])) {
                                            echo '<a href="Profile_user.php">My Profile</a>';
                                        } else 
                                            echo '<a href="Login_user.php">My Profile</a>';
                                    ?>
                               <li><a href="Create_user.php"> Account creation </a></li>
                               <li><a href="Create_user.php"> Tournament creation </a></li>
                            </ul>
                       </li>
                    <li class="deroulant_Main"><a href="#"> Team &ensp;</a>
                        <ul class="deroulant_Second">
                            <li><a href="Team_hub.php"> Team_hub </a></li>
                            <li><a href="Create_team.php"> Team creation </a></li>
                       </ul>
                    </li>
                    <li class="logo_container">
                        <img class="logo" src="Image/logo.png">
                    </li>
                    <li class="deroulant_Main"><a href="#"> Tournament &ensp;</a>
                            <ul class="deroulant_Second">
                                <li><a> Account creation </a></li>
                                <li><a> Team creation </a></li>
                                <li><a> Tournament creation </a></li>                                </ul>
                        </li>
                            <li class="deroulant_Main"><a href="#"> Players &ensp;</a>
                                <ul class="deroulant_Second">
                                   <li><a href="Login_user.php"> My Profile </a></li>
                                   <li><a href="Create_user.php"> Browse Players </a></li>
                                </ul>
                           </li>
                        <li class="deroulant_Main"><a href="#"> Teams &ensp;</a>
                            <ul class="deroulant_Second">
                                <li><a> My Teams </a></li>
                                <li><a> Join Teams </a></li>
                                <li><a> Browse Teams </a></li>
                           </ul>
                        </li>
                        <li class="deroulant_Main"><a href="#"> Games &ensp;</a>
                                <ul class="deroulant_Second">
                                    <li><a> Add game </a></li>
                                    <li><a> Browse games </a></li>
                                </ul>
                        <li class="deroulant_Main"><a href="#"> Tournaments &ensp;</a>
                                <ul class="deroulant_Second">
                                    <li><a> My tournaments </a></li>
                                    <li><a> Join tournament </a></li>
                                    <li><a> Browse tournaments </a></li>    
                                </ul>
                            </li>
                         </li>
                    </ul>
                </nav>
                <div class = "content">
                    <section id="welcome">
                        <h2>WELCOME TO GAME ARENA</h2>
                        <p>Manage your tournaments, teams, and players all in one place!</p>
                    </section>
                    <section id="tournaments-info">
                        <h2>Upcoming Tournaments</h2> 
                            <table id="upcoming-tournaments">
                                <tr>
                                    <th> Name </th>
                                    <th> Game </th>
                                    <th> Date </th>
                                    <th> Location </th>
                                </tr>
                                <tr>
                                    <td> Summer Championship 2024 </td>
                                    <td> Chess </td>
                                    <td> September 20, 2024 </td>
                                    <td> Virtual Arena </td>
                                </tr>
                                <tr>
                                    <td> Winter Championship 2024 </td>
                                    <td> Uno </td>
                                    <td> December 20, 2024 </td>
                                    <td> Virtual Arena </td>
                                </tr>
                                <tr>
                                    <td> Spring Championship 2025 </td>
                                    <td> Poker </td>
                                    <td> March 20, 2025 </td>
                                    <td> Virtual Arena </td>
                                </tr>
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
