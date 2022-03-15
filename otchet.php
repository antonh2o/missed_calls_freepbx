<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Отчет о звонках</title>
    <link rel="stylesheet" type="text/css" href="stylez.css">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
</head>
<body>
<div align=center style="width: 90%; margin-left:auto; margin-right:auto;">
<?php
$before_conn = microtime(true);
include 'config.php';
include 'functions.php';

     $sql =    "SELECT
    cdr.disposition as `disposition`,
    cdr.calldate as `calldate`,
    cdr.clid as `clid`,
    cdr.src as `src`,
    cdr.dst as `dst`,
    users_src.name as `name`,
    users_dst.name as `name_dst`,
    cdr.dstchannel as `dstchannel`,
    cdr.duration as `duration`
FROM asteriskcdrdb.cdr as `cdr`
LEFT JOIN asterisk.users as users_src ON users_src.extension = cdr.src
LEFT JOIN asterisk.users as users_dst ON users_dst.extension = cdr.dst
WHERE (cdr.calldate > '$Start $Start_time') AND (cdr.calldate < '$End $End_time')
$query_tel
$cond_ans
ORDER BY calldate DESC, dst ASC
LIMIT 500";

if($result = $conn->query($sql)){
    $rowsCount = $result->num_rows; // количество полученных строк
    echo "<h2 align=center>Отчет с $Start $Start_time по $End $End_time на телефон $tel. Отфильтровано звонков: $rowsCount  </br>
    </h2> ";
if (!empty($rowsCount))

 include 'table.php';

    $result->free();
} else{
    echo "Ошибка: " . $conn->error;
}
$conn->close();
$after_conn = microtime(true); $NB=$NA+$BS;
$dur=mins($all_sec);
echo "<p align=center> $NA Неотвеченных + $BS Занято Итого $NB нехороших звонков. </br>Всего $dur разговоров";
$t_conn=round(($after_conn - $before_conn), 2);
echo("</br>Запрос выполнен за ". $t_conn). " сек., Лимит запроса 500 строк";
?>
        </div>
    </body>

</html>
