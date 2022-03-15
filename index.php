<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>История Звонков</title>
    <link rel="stylesheet" type="text/css" href="stylez.css">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
</head>
<body>
<div align=center style="width: 90%; margin-left:auto; margin-right:auto;">
<?php

$before_conn = microtime(true);
include 'config.php';
echo "<table align=center border='0' >
    <form id='inputform' method='GET' >
  <tr>
    <td>
    <input type='checkbox' id='R' name='R' ><label for='R'>Автообновление страницы ежеминутно
    <input type='checkbox' id='TP' name='TP'><label for='TP'>Выбрать звонки только в техподдержку
</label></br>";
include 'functions.php';

echo "<h2 align=center>История Звонков с телефонов $ftel_title </br>на телефоны $tel_name.</h2>
 с <input type='date' id='from' name='from' value=$Start onchange={$_GET['from']} = this.value;/>
<input type='text' name='starthour' value=$starthour id='starthour' size='2' maxlength='2' onchange={$_GET['starthour']} = this.value/>:
<input type='text' name='startmin' id='startmin' size='2' maxlength='2' value=$startmin onchange={$_GET['starmin']} = this.value/>
 по <input type='date' id='to' name='to' value=$End onchange={$_GET['to']} = this.value/>
<input type='text' name='endhour' id='endhour' size='2' maxlength='2' value=$endhour onchange={$_GET['endhour']} = this.value/>:
<input type='text' name='endmin' id='endmin' size='2' maxlength='2' value=$endmin onchange={$_GET['endmin']} = this.value/></br>
</br>Кто звонил: <input value=$ftel '' name='ftel' onchange={$_GET['ftel']} = this.value;/>
    Кому звонил: <input value=$tel '' name='tel' onchange={$_GET['tel']} = this.value;/>   <button>Применить</button></br>
 ";

if(!empty($_GET['R']))
 {
    $R = $_GET['R'];
    header('refresh: 60;');
    echo "</br> Страница обновлена ". date('d.m.Y H:i:s') . "</form></br>";
 }
     $sql =    "SELECT
    cdr.disposition as `disposition`,
    cdr.calldate as `calldate`,
    cdr.clid as `clid`,
    cdr.cnum as `src`,
    cdr.dst as `dst`,
    users_src.name as `name`,
    users_dst.name as `name_dst`,
    cdr.dstchannel as `dstchannel`,
    cdr.duration as `duration`
FROM asteriskcdrdb.cdr as `cdr`
LEFT JOIN asterisk.users as users_src ON users_src.extension = cdr.cnum
LEFT JOIN asterisk.users as users_dst ON users_dst.extension = cdr.dst
WHERE (cdr.calldate > '$Start $Start_time') AND (cdr.calldate < '$End $End_time')
$query_tel
$cond_ans
ORDER BY calldate DESC, dst ASC
LIMIT $limit";

if($result = $conn->query($sql)){
    $rowsCount = $result->num_rows; // количество полученных строк#var_dump($rowsCount);

echo "За выбраный интервал c $Start $Start_time по $End $End_time
 Всего звонков: $rowsCount  </br>
 </td>
</tr>
</table> ";

if (!empty($rowsCount))

include 'table.php';

    $result->free();
    } else{
    echo "Ошибка SQL: " . $conn->error;
    }
$conn->close();
$after_conn = microtime(true); $NB=$NA+$BS; $dur=mins($all_sec);
echo "<p align=center> $NA Неотвеченных + $BS Занято Итого $NB нехороших звонков. Всего $dur разговоров";

$t_conn=round(($after_conn - $before_conn), 2);
echo("<br/> Запрос выполнен за ". $t_conn). " сек., Лимит запроса 
<input type='text' name='limit' id='limit' size='4' maxlength='4' value=$limit onchange={$_GET['limit']} = this.value/>
строк. </p></tr></table></div>";
//</br> sql=$sql $Start $Start_time $End $End_time 
?>
</body>
</html>
