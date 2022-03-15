<?php
{     echo "<table class='calls'>";
     echo "    <tr class='header'>
     <td class='header'>День недели</td>
     <td class='header'>Дата Время</td>
     <td class='header'>Кто Звонил, №тел</td>
     <td class='header'>Состояние звонка</td>
     <td class='header'>Кому Звонил, №тел</td>
     <td class='header'>Длительность</td>
     <td class='header'>Набранный канал</td>
    </tr>";
    }
    foreach($result as $row){
    echo "<tr class='calls'>";
include 'str_replace.php';
    $all_sec += $row["duration"]; $cdur= mins($row["duration"]);
    echo "
    <td class='calls'>" . $days[date('N', strtotime($row['calldate']))] . " </td>
    <td class='calls'>" . $row["calldate"] . " </td>
    <td class='calls'>" . $row["name"] . ", №" . phoneBlocks($row["src"]) . " </td>
    ". $row_disposition . " </td>
    <td class='calls'> " . $row["name_dst"].", №" . phoneBlocks($row["dst"]) . " </td>
    <td class='calls'> " . $cdur . "</td>
    <td class='calls'> " . $row["dstchannel"] . " </td>";
}
?>