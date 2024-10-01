<?php
if (isset($_POST['condition']) == "1"){
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    print("<center>Bonjour $prenom $nom</center>");
}
?>

<a href=Main.php> Retour Main</a>