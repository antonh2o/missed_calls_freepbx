<?php
function mins($allsec)
{
 $minutes = floor($allsec / 60); // Считаем минуты
 $hours = floor($minutes / 60); // Считаем количество полных часов
 $min = $minutes - ($hours * 60);  // Считаем количество оставшихся минут
 $sec=$allsec - ($minutes*60);

  if ($hours > 0)
    {return $hours . " ч. " . $min ." мин." . $sec . " сек." ; }
    else //менее часа
        {
          if ($minutes > 0 ) //больше минуты
            {
             return $minutes ." мин. " . $sec . " сек." ;
            }
            else //менее минуты
            {
            $sec = $allsec;
            return $sec . " сек." ;
            }
        }
}
function phoneBlocks($sPhone)
{
    if (strlen($sPhone) == 7 ) {
    $sArea = substr($sPhone, 0,3);
    $sNumber = substr($sPhone,3,2);
    $sNumber2 = substr($sPhone,5,2);
    $sPhone = $sArea."-".$sNumber."-".$sNumber2;
    }
    elseif (strlen($sPhone) ==10 ) {
    $sArea = substr($sPhone, 0,3);
    $sPrefix = substr($sPhone,3,3);
    $sNumber = substr($sPhone,6,2);
    $sNumber2 = substr($sPhone,8,2);
    $sPhone = "(".$sArea.")".$sPrefix."-".$sNumber."-".$sNumber2;
    }
    elseif (strlen($sPhone) ==11 ) {
    $sMG = substr($sPhone, 0,1);
    $sArea = substr($sPhone, 1,3);
    $sPrefix = substr($sPhone,4,3);
    $sNumber = substr($sPhone,7,2);
    $sNumber2 = substr($sPhone,9,2);
    $sPhone = "$sMG"."(".$sArea.")".$sPrefix."-".$sNumber."-".$sNumber2;
    }
    return($sPhone);
}

   $NA="0"; $na_color='#FF2D00';
   $BS='0'; $bs_color='#FFF700'; $all_sec=0;
   $NB='0'; $a_color='white'; $pa_color='#00C9FF';

$days = array( 1 => "Понедельник" , "Вторник" , "Среда" , "Четверг" , "Пятница" , "Суббота" , "Воскресенье" );
$today = date("Y-m-d");
$yestoday  = date("Y-m-d", strtotime("yesterday"));
$Start=$today; $End=$today;
$Start_time="00:00"; $End_time="23:59";
$starthour="00"; $startmin="00";
$endhour="23"; $endmin="59";

$arr['DA'] ??= '';
$arr['ftel'] ??= '';
$arr['tel'] ??= '';
$arr['from'] ??= '';
$arr['to'] ??= '';
$arr['starthour'] ??= '';
$arr['startmin'] ??= '';
$arr['endhour'] ??= '';
$arr['endmin'] ??= '';
$cond_ans='';
if(!empty($_GET  ['from'])) {
$Start =    $_GET  ['from'];
}
if(!empty($_GET  ['to'])) {
$End =    $_GET  ['to'];
}
if( (!empty($_GET  ['starthour'])) or (!empty($_GET  ['startmin'])) ) {
$starthour=($_GET['starthour']);
$startmin=($_GET ['startmin']);
$Start_time = $starthour.":".$startmin;
}

if( (!empty($_GET['endhour'])) or (!empty($_GET['endmin'])) ) 
{
 $endhour=($_GET['endhour']);
 $endmin=($_GET ['endmin']);
 $End_time = $endhour.":".$endmin;
}

if (!empty($_GET  ['e_time']))  {
$End_time = $_GET  ['e_time'];
}

if(!empty($_GET  ['tel']))
    {
     $tel = $_GET  ['tel'];
     $tel = (implode(',',(array)$tel));
     $q_tel = "AND asteriskcdrdb.cdr.dst IN ($tel)";
    }
    else // незаполнен кому
    {
     $q_tel = "";
     if (!empty($_GET ['TP'])) //выбрано только в техподдержку
     {
      $tel='100,250,389,907,908,909,2260780';
      $q_tel = "AND asteriskcdrdb.cdr.dst IN ($tel)";
     }
     else { $tel_name='Все'; } //не выбрано только в техподдержку
    }

if(!empty($_GET  ['ftel'])) //Кто не пустой
    {
     $ftel = $_GET  ['ftel'];
     $ftel = (implode(',',(array)$ftel));
     $query_tel = "$q_tel AND asteriskcdrdb.cdr.cnum IN ($ftel)";
     $ftel_title=$ftel;
    }
    else if (empty($tel) AND empty($_GET ['TP'])) { //пустой запрос
     $query_tel = "";
     $ftel_title="Все";
    }
    else 
     {
        $query_tel = "$q_tel" ;
        $ftel_title="Все";
        $tel_name='Техподдержки';
     } //TP вкл

if ($Start_time > $End_time)
    {      $Start=date($End, strtotime("yesterday"));    }

if(!empty($_GET['DA']))
 {
  $answered = ($_GET['DA']);
  $cond_ans = "AND (disposition != 'ANSWERED')";
 }

if(!empty($_GET['limit']))
 {
  $limit = ($_GET['limit']);
 }
 else {$limit=1000;}

if (empty($tel_name))
{
$tel_name =$tel;
}

?>