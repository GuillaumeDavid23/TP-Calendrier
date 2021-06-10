<?php
    $host = 'localhost';
    $dbname = 'calendar';
    $username = 'calendar';
    $password = 'jj8_XPRqanXwKu0d';
 
    $dsn = "mysql:host=$host;dbname=$dbname"; 
    // récupérer tous les utilisateurs
    $sql = "SELECT * FROM birthdays";
     
    try{
     $pdo = new PDO($dsn, $username, $password);
     $stmt = $pdo->query($sql);
     
     if($stmt === false){
      die("Erreur");
     }
     
    }catch (PDOException $e){
      echo $e->getMessage();
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
<h1>Liste des utilisateurs</h1>
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
     <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
     <tr>
       <td><?php echo htmlspecialchars($row['day']); ?></td>
       <td><?php echo htmlspecialchars($row['month']); ?></td>
       <td><?php echo htmlspecialchars($row['year']); ?></td>
       <td><?php echo $row['event']; ?></td>
     </tr>
     <?php endwhile; ?>
   </tbody>
 </table>
</body>
</html>