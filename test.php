<?php
    $host = 'localhost';
    $dbname = 'calendar';
    $username = 'calendar';
    $password = 'jj8_XPRqanXwKu0d';

    $arrayTestOfMonth = array('January','February', 'March', "April", 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'); //Tableau de test des mois
 
    $connect = "mysql:host=$host;dbname=$dbname"; 
    // récupérer tous les utilisateurs
    $sql = "SELECT * FROM events";
     
    //CONNEXION A LA BDD
    try{
     $pdo = new PDO($connect, $username, $password);
     $stmt = $pdo->query($sql);
     
     if($stmt === false){
      die("Erreur");
     }
     
    }catch (PDOException $e){
      echo $e->getMessage();
    }

    //AJOUT DANS LA BDD
    if (!empty($_GET['dateEvent']) && !empty($_GET['eventName'])) {
      $fullDate = $_GET['dateEvent'];
      $eventName = $_GET['eventName'];
      $dateCut = explode("-", $fullDate);
      $eventDay = $dateCut[2];
      $eventMonth = $arrayTestOfMonth[(int)$dateCut[1]-1];
      $eventYear = $dateCut[0];
      $sql = "INSERT INTO birthdays(day,month,year,message) 
            VALUES($eventDay,'$eventMonth',$eventYear,'$eventName')";
      $pdo->exec($sql);
      
      header("Location: test.php");
    }
    else{
      echo "Un champ n'est pas rempli";
    }

    
    
  ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>PHP partie 9</title>
</head>
<body>
  <form action="#" action="get">
        <label for="eventName">Ajouter un événement</label>
        <input type="date" name="dateEvent" id="dateEvent">
        <input type="text" name="eventName" id="eventName">
        <button type="submit">Ajouter l'évènement</button>
  </form>
 <table>
   <thead>
     <tr>
        <th>Jour</th>
        <th>Mois</th>
        <th>Année</th>
        <th>Event</th>
     </tr>
   </thead>
   <tbody>
     <?php while($row = $stmt->fetch()) : ?>

     <?php 
        if($row['month'] == "July"){
          echo 'YES';
        }
      ?>
      <tr>
       <td><?php echo htmlspecialchars($row['day']); ?></td>
       <td><?php echo htmlspecialchars($row['month']); ?></td>
       <td><?php echo htmlspecialchars($row['year']); ?></td>
       <td><?php echo $row['message']; ?></td>
     </tr>
     <?php endwhile; ?>
   </tbody>
 </table>
</body>
</html>