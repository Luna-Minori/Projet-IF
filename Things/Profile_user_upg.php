<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: Login_user.php');
        exit();
    }

    $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
    $sql = "SELECT id FROM players WHERE username=:username";
    $rep = $conn->prepare($sql);
    $rep->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
    $rep->execute();
    $id = $rep->fetch(PDO::FETCH_ASSOC);


    if ($id) {
        $id = $id['id'];
    }
    else{
        echo "User not found";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $bio = $_POST['Bio'];

        $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
        $sql = "SELECT * FROM players";
        $rep = $conn->prepare($sql);
        $rep->execute();

        $bool = false;
        while ($Basedata = $rep->fetch(PDO::FETCH_ASSOC)) {
            echo $Basedata['username'];
            echo $username;
            echo $id;
            if($Basedata['id'] != $id){

                if( $Basedata['username'] == $username ){
                    echo "this username is already use";
                    $bool = true;
                    exit();
                }

                if($email == $Basedata['email'] ){
                    echo "this email is already use";
                    $bool = true;
                    exit();
                }
            }
        }
        if( $bool == false ){

            echo "coucou";
            $sql = "UPDATE players SET username = :username, email = :email, hashed_password = :hashed_password, bio = :bio WHERE id = :id";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':username', $username, PDO::PARAM_STR);
            $rep->bindParam(':email', $email, PDO::PARAM_STR);
            $rep->bindParam(':hashed_password', password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
            $rep->bindParam(':bio', $bio, PDO::PARAM_STR);
            $rep->bindParam(':id', $id, PDO::PARAM_STR);
            $rep->execute();

            $_SESSION['username'] = $username;
            $_SESSION['hashed_password'] = $password;
            $_SESSION['email'] = $email;
            $_SESSION['bio'] = $bio;
            header('Location: Profile_user.php');
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Manager</title>
    <link rel="stylesheet" href="Profile_user.css">
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
    <div class="Box_section">
        <section class="Profile_Main">
        <?php   $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                $sql = "SELECT * FROM players WHERE username = :session_username";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':session_username', $_SESSION['username'], PDO::PARAM_STR);
                $rep->execute();
                $user = $rep->fetch(PDO::FETCH_ASSOC);
                    
        ?>
        <div class="information">
            <div class="Menu_info">
                <div class="sub_Title">Information</div>
                    <div class="button">
                            <a href=""><img src="Image/Menu.png" class="img_button"></a>
                </div>
            </div>
            <div class="Update">
                <form method="post" action="Profile_user_upg.php">
                    <div class="text_form">
                        <br>
                        <div class="arena_text">
                            <div>Username</div>
                            <input class="left-space" type="text" id="username" name="username" size="12" value="<?php echo $user['username']; ?>" required>
                        </div>
                        <br>
                        <div class="arena_text">
                            <div class="sub_title">Password</div>
                            <input class="left-space" type="text" name="password" size="12" value="<?php echo $user['hashed_password'];?>"required>
                        </div>
                        <br>
                        <div class="arena_text">
                            <div class="sub_title">email</div>
                            <input class="left-space" type="text" name="email" size="12" value="<?php echo $user['email'];?>"required>
                        </div>
                        <br>
                    </div>
                    <div class="text_form_bio">
                        <div class="arena_text_bio">
                            <div class="sub_title">Bio</div>
                            <input class="left-space" type="text" name="Bio" size="12" value="<?php echo $user['bio'];?>"required>
                        </div>
                        <input class="button" type="submit" name="condition" value="Connexion" value="1" required>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <section class="Your_game">
        <div class="information">
            <div class="Menu_info">
                <div class="sub_Title">Your games</div>
            </div>
            <?php
                $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                $sql = "SELECT title FROM games WHERE id = (SELECT game_id FROM played_games WHERE player_id = :user_id)";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
                $rep->execute();
                $game = $rep->fetch(PDO::FETCH_ASSOC);
                ?>
            <div>
                <?php echo $game['title']; ?>
            </div>
        </div>
    </section>
    <section class="Team">
        <div class="information">
            <div class="Menu_info">
                <div class="sub_Title">Team</div>
            <div class="Menu_info">
            <?php
                $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                $sql = "SELECT title FROM teams WHERE id = (SELECT game_id FROM player_teams WHERE player_id = :user_id)";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
                $rep->execute();
                $Team = $rep->fetch(PDO::FETCH_ASSOC);
            ?>
                <div class="Username">
                    <?php echo "Username : " . $Team['Title']; ?>
                </div>  
        </div>
    </section>
    </div>

        <a href=Main.php> Retour Main</a>
    </body>

</html>