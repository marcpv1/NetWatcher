<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<h1>Net Watcher</h1></head>
<body>
<p></p>
<?php 
//--
$ip="";
if (isset($_GET['ip'])) {
    $ip=$_GET['ip'];
} else {
    // Fallback behaviour goes here
}

//--


   $con = mysql_connect('localhost:3306','root2','?mp:_64y(5W$');
   if (!$con)
   {
   die('Could not connect: ' . mysql_error());
   }

   mysql_select_db('netwatcher', $con) or die( 'Unable to select database');
   mysql_query("SET NAMES 'utf8'");
   $sql="SELECT Name FROM Machine WHERE MAC='@1'";

//exec("sudo nmap -sP -script=nbstat.nse 192.168.1.0/24",$ret_val);

if ($ip=="") {
exec("sudo nmap -sP -script=nbstat.nse 192.168.1.0/24",$ret_val); 
}
 else
{
echo "Info from " . $ip . "...";
exec("sudo nmap " . $ip,$ret_val);
//echo $ret_val;
}

$busca='Address';$busca2='report for';
$pos=0;$pos2=0;
foreach($ret_val as $out){
    
    $pos=strpos($out,$busca);$pos2=strpos($out,$busca2);
    
    //echo "POS:".$pos;
    if ($pos>0)
     {
      $mac=substr(str_replace("MAC Address: ","",$out),0,17);
           
      $ret=RetornaNom($con,$sql,$mac);

      if ($ret=="")
         {echo "<font color='red'><b>MAC: ".$mac." (NO TROBAT)</b></font>";
         }
         else
         {echo "<font color='green'><b>MAC: ".$mac." (".$ret.")</b></font>";
         }
      echo "</br>";
     }
    else
     {

       if ($pos2>0) {
        $ip=RetornaIP($out);
        echo $out;
        echo " <button onclick='scanner(\"". $ip ."\")'>SCAN</button>"."</br>";        
         
       } else
       {
         echo $out."</br>";
       }
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

function RetornaIP($out)
{
$arr = explode(" ", $out);
      $ip = $arr[count($arr)-1];
      $ip = str_replace("(","",$ip);
      $ip = str_replace(")","",$ip);
return $ip;
}

function CercaIP($ip)
{
 exec("sudo nmap " + ip,$ret_val); 
 return $ret_val;
}

?>
<br/><br/>

<?php
$ip=""; 
if (isset($_GET['ip'])) {
    $ip=$_GET['ip'];
}
if ($ip=="") {
echo("<input type=\"text\" id=\"ipscan\" name=\"ipscan\">");
echo("<button type=\"button\" onclick=\"scanip()\">Scan IP</button>");
} else {
echo("<br/>");
echo("<a href=\"scan.php\"> [ LLISTAT INICIAL ]</a>");
}?>
<p id="result"></p>

<br/>
</body>
</html>
<script>

 function scanner(ip) 
 {
  window.location.href = "scan.php?ip=" + ip;
 }

</script>

