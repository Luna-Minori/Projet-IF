<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: Login_user.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Manager</title>
    <link rel="stylesheet" href="Profile_user.css">
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
            <div class="Title_nav">
                <h1>Tournament Manager</h1>
            </div>
            <ul>
                <li class="deroulant_Main"><a href="#"> Creation &ensp;</a>
                    <ul class="deroulant_Second">
                        <li><a href="Create_user.php"> Account creation </a></li>
                        <li><a href="Create_user.php"> Team creation </a></li>
                        <li><a href="Create_user.php"> Tournament creation </a></li>
                    </ul>
                </li>
                
                <li class="deroulant_Main"><a href="#"> Profile &ensp;</a>
                        <ul class="deroulant_Second">
                            <li><a> Account creation </a></li>
                            <li><a> Team creation </a></li>
                            <li><a> Tournament creation </a></li>
                        </ul>
                 </li>
            </ul>
        </nav>
    </header>
    <br>
    <div class="Box_section">
    <section class="Profile_Main">
        <div class="Title">
            <?php echo "Hii  " . $_SESSION['username']; ?>
        </div>
        <br>

        <?php   $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                $sql = "SELECT * FROM players";
                $rep = $conn->prepare($sql);
                $rep->execute();
                $user = $rep->fetch(PDO::FETCH_ASSOC);
                    
        ?>
        <div class="information">
            <div class="sub_Title">
                <p> Information </p>
            </div>
                <div class="Username">
                    <?php echo "Username : " . $user['username']; ?>
                </div>
                <div class="email">
                    <?php  echo "email : " . $user['email'];?>
                </div>
        </div>
    </section>
    <section class="Your game">
        <div class="sub_Title">
                <p> Your game </p>
        </div>
        <?php   $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                $sql = "SELECT * FROM players";
                $rep = $conn->prepare($sql);
                $rep->execute();
                $user = $rep->fetch(PDO::FETCH_ASSOC);
                    
        ?>
        <div class="information">
            <div class="sub_Title">
                <p> Information </p>
            </div>
                <div class="Username">
                    <?php echo "Username : " . $user['username']; ?>
                </div>
                <div class="email">
                    <?php  echo "email : " . $user['email'];?>
                </div>
        </div>
    </section>
    <section class="Profile_Main">
        <h1>Profile</h1>

    </section>
    <section class="Newgame">
        <div class="information">
            <div class="Menu_info">
                <div class="sub_Title">Newgame</div>
                    <form method="post" action="login_user.php">
                        <div class="bo">
                                <div class="arena_text">
                                <input class="left-space" type="text" name="Name_newgame" size="12" required>
                                    <label>Name</label>
                                    <span>Name</span>
                                </div>
                                <div class="arena_text">
                                <input class="left-space" type="text" name="Rules_newgame" size="12" required>
                                    <label>Rules</label>
                                    <span>Rules</span>
                                </div>
                                <div class="arena_text">
                                <input class="left-space" type="text" name="Name_newgame" size="12" required>
                                    <label>Name</label>
                                    <span>Name</span>
                                </div>
                                <input class="button" type="submit" name="add_newgame" value="Connexion" value="1" required>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </section>
    </div>

        <a href=Main.php> Retour Main</a>
    </body>

</html>