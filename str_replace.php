<?php
$RG = "SELECT grpnum as `GN`, description as `DES` FROM asterisk.ringgroups";
if($RGres = $conn->query($RG))
    {
     $RGrowsCount = $RGres->num_rows;
     if (!empty($RGrowsCount)){
        foreach($RGres as $RGrow){
//        echo $RGrow["GN"]." = ".$RGrow["DES"];
            if ($row["dst"] == $RGrow["GN"])
            {
             $row["name_dst"] = "Гр.Вызова: ".$RGrow["DES"];
            }
	    //$RGres->free();
	    }
	}
    }

    if ($row["disposition"] == "NO ANSWER")
    {
     $NA=$NA+1; $b_color=$na_color; $t_color='white';
     $row_disposition="<td style='background-color:$b_color; color:$t_color'> Нет ответа";
            } else
    if ($row["disposition"] == "ANSWERED")
    {
     $b_color=$a_color; $t_color='black';
     $row["disposition"]='Отвечен';
     $row_disposition='<td> Отвечен';

            } else
    if ($row["disposition"] == "BUSY")
    {
     $row["disposition"]='Занято';
     $BS=$BS+1; $b_color=$bs_color; $t_color='black';
     $row_disposition="<td style='background-color:$b_color; color:$t_color'>Занято";
    }
            if ($row["src"] == "*68")
    { $row["src"]='Проверка переадресации';
      $row["name"]='Проверка переадресации';
if ($row["disposition"]=='Отвечен')
{
    $b_color=$a_color; $t_color='black';
}
 else
 {
  $b_color=$pa_color; $t_color='black';
 }
}

 
    if (strpos($row["dstchannel"], "89123456789"))
    {
    $row["dstchannel"]="Сотовый Фамилия Имя Отчество";
    }

     if ($row["name"] == "")
    {
     $row["name"]="Без имени";
    }
    if ($row["name_dst"] == "")
    {
     $row["name_dst"]="Без имени";
    }
