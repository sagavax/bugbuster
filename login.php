<?php
session_start();
include("include/dbconnect.php");
$login = mysqli_real_escape_string($con,$_POST["username"]);
$heslo = mysqli_real_escape_string($con,$_POST["password"]);
$md5heslo = md5($heslo);/* funkce md5() heslo zahashujeme */

global $con;

$sql="select * from uzivatele where login = '$login' and heslo = '$md5heslo'";
//echo "$sql";
$result = mysqli_query($con,$sql);
$overeni = mysqli_num_rows($result);
echo "Pocet riadkov:".$overeni;
$row = mysqli_fetch_array($con,$result);
if($overeni == 1) {
    $_SESSION['login'] = stripslashes($login);
    $_SESSION['id'] = $row["id"];
    header("location:".$_SESSION['redirect_url']);
    //header("Location: serveris.php");
    //die();
} else {
   echo "<div style='padding-top: 10px; padding-left: 10px;height:40px; width:600px; border:1x #e1e1e1 solid;background-color: #FFF4B4; color:#333; font-size:15px; font:Helvetica;box-shadow: 0 2px 5px rgba(2,2,2,.62); font-size: 14px; font-weight: bold; font:Arial;'>ZLE UZIVATELSKE MENO ALEBO HESLO !!!!</div>";
}
?>
</div>
