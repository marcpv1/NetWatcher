<html>
<head><h1>Llista de IPs</h1></head>
<body>
<p></p>
<?php 
   $con = mysql_connect('localhost:3306','root2','xxxxxxxxxxx');
   if (!$con)
   {
   die('Could not connect: ' . mysql_error());
   }

   mysql_select_db('netwatcher', $con) or die( 'Unable to select database');
   mysql_query("SET NAMES 'utf8'");
   $sql="SELECT Name FROM Machine WHERE MAC='@1'";

exec("sudo nmap -sP -script=nbstat.nse 192.168.1.0/24",$ret_val); 

$busca='Address';
$pos=0;
foreach($ret_val as $out){
    
    $pos=strpos($out,$busca);
    //echo "POS:".$pos;
    if ($pos>0)
     {
      $mac=substr(str_replace("MAC Address: ","",$out),0,17);
           
      $ret=RetornaNom($con,$sql,$mac);

      if ($ret=="")
         {echo "<font color='red'><b>MAC: ".$mac." (NO TROBAT)</b></font>";}
         else
         {echo "<font color='green'><b>MAC: ".$mac." (".$ret.")</b></font>";}
      echo "</br>";
     }
    else
     {
      echo $out."</br>";
     }
  }  

function RetornaNom($con,$sql,$mac)
   {
    $sql=str_replace("@1",$mac,$sql);
    //echo $sql.";";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $ret=$row['Name'];

    return $ret;
   }

?>
</body>
</html>

