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
    if (!empty($_POST['dateEvent']) && !empty($_POST['eventName'])) {
        $fullDate = $_POST['dateEvent'];
        $eventName = $_POST['eventName'];
        $dateCut = explode("-", $fullDate);
        $eventDay = $dateCut[2];
        $eventMonth = $arrayTestOfMonth[(int)$dateCut[1]-1];
        $eventYear = $dateCut[0];
        $sql = "INSERT INTO events(day,month,year,message) 
            VALUES($eventDay,'$eventMonth',$eventYear,'$eventName')";
        $pdo->exec($sql);
        header("Location: index.php");
    }
    
    $empty = false;//Test du select
    if (empty($_POST['month'])) {
        echo "<h2 style:'color:red;'>Veuillez renseigner votre date !</h2>";
        $empty = true;
    }
    else{
        function CreateCalendar()
        {
            //définition de la langue.
            setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
            
            //Déclaration des variables
            $arrayTestOfMonth = array('January','February', 'March', "April", 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'); //Tableau de test des mois
            $date = $_POST['month']; //Récupération des valeurs du select dans un array
            $cut = explode('-', $date); //Découpage du tableau $date pour séparer les valeurs
            $year = $cut[0]; //Année choisie
            $month = ltrim($cut[1], '0')-1; //mois choisi en enlevant les zéros 07(juillet) => 7
            $numberOfDay = date('t',mktime(0,0,0,$month+1,1,$year)); // le nombre de jour dans le mois selectionné
            $keyOfFirstDay = strftime('%w', strtotime("1 $arrayTestOfMonth[$month] $year")). '<br>'; // le nom du premier jour en entier (lundi = 1, diamanche = 7)
            $endCalendar = false; //Test De la fin du calendrier
            $endCalendar = true;//Test de la fin du calendrier
            $empty = false;//Test du select
            $emptyCase = '<td class="empty"></td>';

            //INFO BDD
            $host = 'localhost';
            $dbname = 'calendar';
            $username = 'calendar';
            $password = 'jj8_XPRqanXwKu0d';
            $connect = "mysql:host=$host;dbname=$dbname"; 
            // récupérer tous les events
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
            
            $dataDB = $stmt -> fetchAll();
            
            

              //Attribution du premier jour.
            if((int)$keyOfFirstDay == 0){
                $keyOfFirstDay = 7;
            }
            $week = (int)$keyOfFirstDay;
            
            //Boucle principale
            for ($count = 1;$count <= $numberOfDay; $count++){
                
                $fillCase = "<td><span>$count</span>";
                
                if ($week == $keyOfFirstDay) {
                    echo '<tr>';
                    for($space = 1; $space < $keyOfFirstDay; $space++){
                        echo $emptyCase;
                    }
                    
                    if ($count == 1 && $arrayTestOfMonth[$month] == 'May') {
                        echo "<td><span>$count</span> <br>Fête du travail</td>";
                    }
                    elseif ($count == 1 && $arrayTestOfMonth[$month] == 'January') {
                        echo "<td><span>$count</span> <br>Jour de l'an</td>";
                    }
                    elseif ($count == 1 && $arrayTestOfMonth[$month] == 'November') {
                        echo "<td><span>$count</span> <br>La Toussaint</td>";
                    }
                    else{
                        echo "$fillCase</td>";
                    }
                    
                    $week++;
                    $keyOfFirstDay = 10;
                }
                elseif ($week > 7) {
                    $week = 1;
                    $count--;
                    echo '</tr><tr>';
                }
                else{
                    
                    if ($count == 14 && $arrayTestOfMonth[$month] == 'July') {
                        echo "<td><span>$count</span> <br>Fête Nationale";
                    }
                    elseif ($count == 8 && $arrayTestOfMonth[$month] == 'May') {
                        echo "<td><span>$count</span> <br>Fête de la victoire";
                    }
                    elseif ($count == 15 && $arrayTestOfMonth[$month] == 'August') {
                        echo "<td><span>$count</span> <br>Assomption";
                    }
                    elseif ($count == 11 && $arrayTestOfMonth[$month] == 'November') {
                        echo "<td><span>$count</span> <br>Armistice";
                    }
                    elseif ($count == 25 && $arrayTestOfMonth[$month] == 'December') {
                        echo "<td><span>$count</span> <br>Noël";
                    }
                    else{
                        echo $fillCase;
                    }
                    foreach($dataDB as $row)
                    {
                        if($row['month'] == $arrayTestOfMonth[$month] && $row['year'] == $year && $row['day'] == $count){
                            echo '<br>'.$row['message'];
                        }
                    }
                    echo "</td>";
                    $week++;
                }
            }
            
            if($endCalendar == true){
                $endCalendar = false;
                for($count2 = $week; $count2 <= 7; $count2++){
                    echo $emptyCase;
                }
            }
            
        }
        function CreateDays()
        {
            $arrayOfDaysForTable = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
            foreach ($arrayOfDaysForTable as $key => $value) {
                echo "<th class='day'>$value</th>";
            }
        }

        function titleMonthAndYear()
        {   
            $date = $_POST['month'];
            $cut = explode("-", $date);
            $year = $cut[0];
            $month = ltrim($cut[1], "0")-1;
            $arrayOfMonthForTable = array('Janvier','Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
            echo $arrayOfMonthForTable[$month].' '.$year;
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Calendar : Informations sur la date de votre choix</title>
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" id="formToCreateCalendar">
        <label for="date">Choisissez un mois et une année</label>
        <input type="month" name="month" id="date" required>
        <button type="submit">Envoyer</button>
    </form>
    <h1 id="monthAndYear">
        <?php
            if (!$empty){
                titleMonthAndYear();
            }
        ?>
    </h1>
    <div class="calendar">
        <table>
            <thead>
                <tr>
                    <?php
                        if (!$empty) {
                            CreateDays();
                        }
                    ?>
                </tr>

            </thead>
            <tbody id="calendarTable">
                <?php
                    if (!$empty) {
                        CreateCalendar();
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="add">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <label for="eventName">Ajouter un événement</label>
        <input type="date" name="dateEvent" id="dateEvent" required>
        <input type="text" name="eventName" id="eventName" required>
        <button type="submit">Ajouter l'évènement</button>
    </form>
    </div>
    <script src="app.js"></script>
</body>
</html>