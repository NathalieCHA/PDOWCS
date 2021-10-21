<?php

require_once 'connect.php';
$pdo = new \PDO(HOST, USER, PASSWORD);

if($_SERVER['REQUEST_METHOD'] === "POST"){

    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);

    if($firstname === ""){
        $errors['firstname'] = "Ce champ est obligatoire.";
    }

    if(strlen($firstname) > 45){
        $errors['firstname'] = "Ce champ ne doit pas dépasser 45 caractères.";
    }

    if($lastname === ""){
        $errors['lastname'] = "Ce champ est obligatoire.";
    }

    if(strlen($lastname) > 45){
        $errors['lastname'] = "Ce champ ne doit pas dépasser 45 caractères.";
    }

    if(empty($errors)){
        $query = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)";

        $statement = $pdo->prepare($query);
    
        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
    
        $statement->execute();

        header("Location: /");
    }

  
}

$statement = $pdo->query("SELECT * FROM friend");
$friends = $statement->fetchAll();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <ul>
        <?php  
            foreach($friends as $friend){
                echo "<li>".$friend['firstname'] . ' ' . $friend['lastname']."<li>";   
            }
        ?>
    </ul>

    <form action="" method="POST">
        <div class="field">
            <label for="firstname">Prénom</label>
            <input type="text" id="firstname" name="firstname" value="<?= $_POST['firstname'] ?? '' ?>">
            <?= $errors['firstname'] ?? "" ?>
        </div>    
            
        <div class="field">
            <label for="lastname">Nom</label>
            <input type="text" id="lastname" name="lastname" value="<?= $_POST['lastname'] ?? '' ?>""> 
            <?= $errors['lastname'] ?? "" ?>  
        </div>

        <input type="submit" value="Ajouter un Friend">

    
</body>
</html>