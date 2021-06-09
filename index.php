<?php
    setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);

    $arrayOfDays = array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
    $arrayOfMonth = array("January","February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

    $arrayOfDaysForTable = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
    $arrayOfMonthForTable = array("Janvier","Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
    
    $date = $_POST['month'];
    $cut = explode("-", $date);
    $year = $cut[0];
    $month = ltrim($cut[1], "0")-1;

    $numberOfDay = date("t",mktime(0,0,0,$month+1,1,$year)); // le nombre de jour
    $keyOfFirstDay = strftime('%w', strtotime("1 $arrayOfMonth[$month] $year")). '<br>'; // le nom du jour
    $nameOfFirstDay = $arrayOfDays[(int)$keyOfFirstDay];
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


    <form action="#" method="post">
        <input type="month" name="month" id="month">
        <button type="submit">Envoyer</button>
    </form>

    <h1>
        <?php
            echo $arrayOfMonthForTable[$month].' '.$year;
        ?>
    </h1>
    <table>
        <thead>
            <tr>
                <?php
                    foreach ($arrayOfDaysForTable as $key => $value) {
                        echo "<th class='day'>$value</th>";
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
                if((int)$keyOfFirstDay == 0){
                    $keyOfFirstDay = 7;
                }
                $endCalendar = false;
                $week = (int)$keyOfFirstDay;
                for ($count = 1;$count <= $numberOfDay; $count++){
                    if ($week == (int)$keyOfFirstDay) {
                        echo "<tr>";
                        for($space = 1; $space < (int)$keyOfFirstDay; $space++){
                            echo '<td class="empty"></td>';
                        }
                        echo "<td>$count</td>";
                        $week++;
                        $keyOfFirstDay = 10;
                    }
                    elseif ($week > 7) {
                        
                        $week = 1;
                        echo "</tr>";
                        echo "<tr>";
                        $count--;
                    }
                    
                    else{
                        echo "<td>$count</td>";
                        $week++;
                    }
                }
                $endCalendar = true;
                if($endCalendar == true){
                    $endCalendar = false;
                    for($count2 = $week; $count2 <= 7; $count2++){
                        echo '<td class="empty"></td>';
                    }
                }

            ?>
        </tbody>
    </table>
</body>
</html>