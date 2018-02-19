<?php
ob_start();
	session_start();
	if (!isset($_SESSION["pracownicy"])){
	#session_destroy();
	$_SESSION["pracownicy"] = array();
	}

?>
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN "http://www.w3.org/TR/html4/loose.dtd">

<html>
 <head>
  <title>Tytul</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-2" />
    <meta name="language" content="pl" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="style.css" rel="stylesheet" type="text/css" />

 </head>

 <body style="background-color: #bdc3c7">

  <div id="main">
	<div id="gora">
	<a href="http://si.moziero.xaa.pl"><h1>SYSTEMY INTERNETOWE</h1></a>
	</div>
	<div id="lewa">
	<ul>
        <li><a href="index.php?id=1">Home</a></li>
	<?php if ($_SESSION['auth'] == TRUE) {
          if($_SESSION['prem']>=1)    {echo '<li><a href="index.php?id=2">Formularz</a></li>';}
	if($_SESSION['prem']>=1) {echo '<li><a href="index.php?id=3">Wyswietl z sesji</a></li>';}
	if($_SESSION['prem']>=1){echo '<li><a href="index.php?id=4">Wyswietl z bazy</a></li>';}
	if($_SESSION['prem']>=2){echo '<li><a href="index.php?id=5">Edycja pracownika</a></li>';}
	if($_SESSION['prem']>=3){echo '<li><a href="index.php?id=6">Usuniecie pracownika</a></li>';}
		echo"</br>";
	if($_SESSION['prem']>=1){
	echo '<li><a href="index.php?id=7&login=';
	$tmp=$_SESSION['user'];
	mysql_connect("localhost", "moziero_si", "haslo1234q");
        @mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
        $zapytanie = "SELECT * FROM uzytkownicy WHERE login='$tmp'";
   	$result = mysql_query($zapytanie);
    	mysql_close();
       	$wiersz=mysql_fetch_row($result);
	echo "$wiersz[0]";
       echo "&imie=";
       echo "$wiersz[3]";
       echo "&nazwisko=";
       echo "$wiersz[4]";
	echo '">Zmien dane</a></li>';}
          if($_SESSION['prem']>=4){echo '<li><a href="index.php?id=8">Zmien poziom dostepu</a></li>';}
            if($_SESSION['prem']>=4){echo '<li><a href="index.php?id=9">Usun uzytkownika</a></li>';}
        } ?>
        </ul>
	</div>
	<div id="srodek">
	<?php
	if(!isset($_GET["id"]))
	$str=1;
	else
	$str=$_GET["id"];
	if($str==1){
	echo'<center><b>STRONA GLOWNA!</b></center>';
	
      }

###################################################################################################################
	else if ($str==2){
	include "form.php";
}
	
####################################################################################################################
	else if ($str==3){
if ($_SESSION['auth'] == TRUE & $_SESSION['prem']>=1) {
	echo "<b> Pracownicy: </b>";
	echo "</br>";
	echo "</br>";
	
	for($i=0;$i<count($_SESSION["pracownicy"]);$i++){
           echo 'Imie: '.$_SESSION["pracownicy"][$i]["imie"].' </br>';
           echo 'Nazwisko: '.$_SESSION["pracownicy"][$i]["nazwisko"].' </br>';
           echo 'Plec: '.$_SESSION["pracownicy"][$i]["plec"].'</br>';
           echo 'Nazwisko panienskie: '.$_SESSION["pracownicy"][$i]["nazwiskopanienskie"].' </br>';
           echo 'E-mail: '.$_SESSION["pracownicy"][$i]["email"].'</br>';
           echo 'Kod pocztowy: '.$_SESSION["pracownicy"][$i]["kodpocztowy"].'</br>';
	echo "</br>";
 
	}
}else{
echo "Nie masz uprawnien do ogladania tej strony";
}
}
###################################################################################################################
else if ($str==4){
if ($_SESSION['auth'] == TRUE & $_SESSION['prem']>=1) {

	mysql_connect("localhost", "moziero_si", "haslo1234q");
	@mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
	$query="SELECT * FROM pracownicy";
	$result=mysql_query($query);

	$liczba_wyn=mysql_num_rows($result);
	$liczba_na_str=10;
	$liczba_str=$liczba_wyn/$liczba_na_str;
	$liczba_str=ceil($liczba_str);
	if (isset($_GET['str'])) $str=$_GET['str'];
	else $str=1;
	$pomin=($str-1)*$liczba_na_str;
       	$zapytanie="SELECT * FROM pracownicy LIMIT $pomin, $liczba_na_str";
	$wyniki=mysql_query($zapytanie);
	echo "<center><b>Tabela pracownikow w bazie danych!</b></center></br>";
	echo '<table border="1" align="center"  >';
echo '<th>ID</th><th>Imie</th><th>Nazwisko</th><th>Plec</th><th>Naz. pan.</th><th>Email</th><th>Kod pocz.</th></th>';

	while ($wiersz=mysql_fetch_row($wyniki))
	{
	echo '<tr><td>'. $wiersz[0] .'</td><td>'. $wiersz[1] .'</td><td>'. $wiersz[2] .'</td><td>'. $wiersz[3] .'</td><td>'. $wiersz[4] .'</td><td>'. $wiersz[5] .'</td><td>'. $wiersz[6] .'</td></tr>';
	}
	echo '</table>';
$my=4;
	$linki=' ';
	if ($str>1) {
	$linki=$linki. '<a href="'.$_SERVER['PHP_SELF'].'?id='.$my. '&str='.($str-1).'"><-</a>'; }
	else { $linki=$linki. '<-'; }
	for($i=1; $i<=$liczba_str; $i++) {
	if ($str==$i) { $linki=$linki.' '.$i; }
	else {
	$linki=$linki. '<a href="'.$_SERVER['PHP_SELF'].'?id='.$my. '&str='.$i.'">'.$i.'</a>'; }}
	if ($str<$liczba_str) {
	$linki=$linki. '<a href="'.$_SERVER['PHP_SELF'].'?id='.$my. '&str='.($str+1).'">-></a>'; }
	else { $linki=$linki. '->'; }
echo '</br><center>';
echo $linki;
echo '</center>';
	mysql_close();
	}else{
echo "Nie masz uprawnien do ogladania tej strony!";
}
}
##############################################################################################################
else if ($str==5){
if ($_SESSION['auth'] == TRUE & $_SESSION['prem']>=2) {

	mysql_connect("localhost", "moziero_si", "haslo1234q");
	@mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
	$query="SELECT * FROM pracownicy";
	$result=mysql_query($query);

	$liczba_wyn=mysql_num_rows($result);
	$liczba_na_str=10;
	$liczba_str=$liczba_wyn/$liczba_na_str;
	$liczba_str=ceil($liczba_str);
	if (isset($_GET['str'])) $str=$_GET['str'];
	else $str=1;
	$pomin=($str-1)*$liczba_na_str;
       	$zapytanie="SELECT * FROM pracownicy LIMIT $pomin, $liczba_na_str";
	$wyniki=mysql_query($zapytanie);
	echo "<center><b>Tabela pracownikow w bazie danych!</b></center></br>";
	echo '<table border="1" align="center"  >';
echo '<th>Edycja</th><th>ID</th><th>Imie</th><th>Nazwisko</th><th>Plec</th><th>Naz. pan.</th><th>Email</th><th>Kod pocz.</th></th>';

	while ($wiersz=mysql_fetch_row($wyniki))
	{
	echo '<tr><td><a href="'.$_SERVER['PHP_SELF'].'?id=edycja&imie='.$wiersz[1].'&nazwisko='.$wiersz[2].'&plec='.$wiersz[3].'&n_panienskie='.$wiersz[4].'&email='.$wiersz[5].'&kodpocztowy='.$wiersz[6].'&rekord='.$wiersz[0].'">Edycja</a></td><td>'. $wiersz[0] .'</td><td>'. $wiersz[1] .'</td><td>'. $wiersz[2] .'</td><td>'. $wiersz[3] .'</td><td>'. $wiersz[4] .'</td><td>'. $wiersz[5] .'</td><td>'. $wiersz[6] .'</td></tr>';
	}
	echo '</table>';
$my=5;
	$linki=' ';
	if ($str>1) {
	$linki=$linki. '<a href="'.$_SERVER['PHP_SELF'].'?id='.$my. '&str='.($str-1).'"><-</a>'; }
	else { $linki=$linki. '<-'; }
	for($i=1; $i<=$liczba_str; $i++) {
	if ($str==$i) { $linki=$linki.' '.$i; }
	else {
	$linki=$linki. '<a href="'.$_SERVER['PHP_SELF'].'?id='.$my. '&str='.$i.'">'.$i.'</a>'; }}
	if ($str<$liczba_str) {
	$linki=$linki. '<a href="'.$_SERVER['PHP_SELF'].'?id='.$my. '&str='.($str+1).'">-></a>'; }
	else { $linki=$linki. '->'; }
echo '</br><center>';
echo $linki;
echo '</center>';
	mysql_close();
	}else{
echo "Nie masz uprawnien do ogladania tej strony!";
}
}
##########################################################################################################
else if ($str==6){
if ($_SESSION['auth'] == TRUE & $_SESSION['prem']>=3) {
	mysql_connect("localhost", "moziero_si", "haslo1234q");
	@mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
	$query="SELECT * FROM pracownicy";
	$result=mysql_query($query);

	$liczba_wyn=mysql_num_rows($result);
	$liczba_na_str=10;
	$liczba_str=$liczba_wyn/$liczba_na_str;
	$liczba_str=ceil($liczba_str);
	if (isset($_GET['str'])) $str=$_GET['str'];
	else $str=1;
	$pomin=($str-1)*$liczba_na_str;
       	$zapytanie="SELECT * FROM pracownicy LIMIT $pomin, $liczba_na_str";
	$wyniki=mysql_query($zapytanie);
	echo "<center><b>Tabela pracownikow w bazie danych!</b></center></br>";
	echo '<table border="1" align="center"  >';
echo '<th>Usun</th><th>ID</th><th>Imie</th><th>Nazwisko</th><th>Plec</th><th>Naz. pan.</th><th>Email</th><th>Kod pocz.</th></th>';

	while ($wiersz=mysql_fetch_row($wyniki))
	{
	echo '<tr><td><a href="'.$_SERVER['PHP_SELF'].'?id=usun&rekord='.$wiersz[0].'">Usun</a></td><td>'. $wiersz[0] .'</td><td>'. $wiersz[1] .'</td><td>'. $wiersz[2] .'</td><td>'. $wiersz[3] .'</td><td>'. $wiersz[4] .'</td><td>'. $wiersz[5] .'</td><td>'. $wiersz[6] .'</td></tr>';
	}
	echo '</table>';
$my=6;
	$linki=' ';
	if ($str>1) {
	$linki=$linki. '<a href="'.$_SERVER['PHP_SELF'].'?id='.$my. '&str='.($str-1).'"><-</a>'; }
	else { $linki=$linki. '<-'; }
	for($i=1; $i<=$liczba_str; $i++) {
	if ($str==$i) { $linki=$linki.' '.$i; }
	else {
	$linki=$linki. '<a href="'.$_SERVER['PHP_SELF'].'?id='.$my. '&str='.$i.'">'.$i.'</a>'; }}
	if ($str<$liczba_str) {
	$linki=$linki. '<a href="'.$_SERVER['PHP_SELF'].'?id='.$my. '&str='.($str+1).'">-></a>'; }
	else { $linki=$linki. '->'; }
echo '</br><center>';
echo $linki;
echo '</center>';
	mysql_close();
	}else{
echo "Nie masz uprawnien do ogladania tej strony";
}
}
#################################################################################################################
else if ($str==Szukaj){

if ($_SESSION['auth'] == TRUE & $_SESSION['prem']>=1) {

        $szukaj = $_GET['keyword'];
        if(empty($szukaj)){echo "</br><center><b>Nie podano frazy do wyszukania!</b></center></br>";
echo '
        <form action = "index.php?id=5" method = "GET">
        <table align="center">
            <td>
                Podaj fraze do wyszukania:&nbsp
                    <input type="text" name="keyword" value=""/>
                    <input type="submit" name="id" value="Szukaj"/> 
            </td>
            </table>
</form>
';

}else{
        $wyyniki=explode(" ",$szukaj); 
	$warunki=" (nazwisko LIKE '%$wyyniki[0]%')"; 
	for ($i=1;$i<count($wyyniki);$i++) 
	{ 
	$warunki.=" or (nazwisko LIKE '%$wyyniki[$i]%')"; 
	} 

	mysql_connect("localhost", "moziero_si", "haslo1234q");
	@mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
	$query="SELECT * FROM pracownicy WHERE $warunki";
	$result=mysql_query($query);

	$liczba_wyn=mysql_num_rows($result);
	if($liczba_wyn<1){echo "</br><center><b>Nie znaleziono rekordu/ow!</b></center></br>";
echo '
        <form action = "index.php?id=5" method = "GET">
        <table align="center">
            <td>
                Podaj fraze do wyszukania:&nbsp
                    <input type="text" name="keyword" value=""/>
                    <input type="submit" name="id" value="Szukaj"/> 
            </td>
            </table>
</form>
';




}else{
	$liczba_na_str=10;
	$liczba_str=$liczba_wyn/$liczba_na_str;
	$liczba_str=ceil($liczba_str);
        
	if (isset($_GET['str'])) $str=$_GET['str'];
	else $str=1;
	$pomin=($str-1)*$liczba_na_str;
       	$zapytanie="SELECT * FROM pracownicy WHERE $warunki LIMIT $pomin, $liczba_na_str";
	$wyniki=mysql_query($zapytanie);
	echo "<center>Wyniki wyszukiwania dla:<b> $szukaj</b></center></br>";
	echo '<table border="1" align="center" >';
echo '<th>ID</th><th>Imie</th><th>Nazwisko</th><th>Plec</th><th>Naz. pan.</th><th>Email</th><th>Kod pocz.</th></th>';
	while ($wiersz=mysql_fetch_row($wyniki))
	{
	echo '<tr><td>'. $wiersz[0] .'</td><td>'. $wiersz[1] .'</td><td>'. $wiersz[2] .'</td><td>'. $wiersz[3] .'</td><td>'. $wiersz[4] .'</td><td>'. $wiersz[5] .'</td><td>'. $wiersz[6] .'</td></tr>';
	}
	echo '</table>';
$my="Szukaj";
	$linki=' ';
	if ($str>1) {
	$linki=$linki. '<a href="'.$_SERVER['PHP_SELF'].'?id='.$my. '&str='.($str-1).'&keyword='.$szukaj. '"><- </a>'; }
	else { $linki=$linki. '<- '; }
	for($i=1; $i<=$liczba_str; $i++) {
	if ($str==$i) { $linki=$linki.' '.$i; }
	else {
	$linki=$linki. '<a href="'.$_SERVER['PHP_SELF'].'?id='.$my. '&str='.$i.'&keyword='.$szukaj. '">'.$i.'</a>'; }}
	if ($str<$liczba_str) {
	$linki=$linki. '<a href="'.$_SERVER['PHP_SELF'].'?id='.$my. '&str='.($str+1).'&keyword='.$szukaj. '"> -></a>'; }
	else { $linki=$linki. ' ->'; }
echo '</br><center>';
echo $linki;
echo '</center>';
	mysql_close();}}
}else{
echo "Nie masz uprawnien do ogladania tej strony!";}
	}


################################################################################################################
else if ($str=="edycja"){
if ($_SESSION['auth'] == TRUE & $_SESSION['prem']>=2) {
	if(isset($_POST["cofnij"])){
header("Location: index.php?id=5");
}

if(isset($_POST["wyslij"]))
{
    $imie = $_POST['imie']; // przypisanie zmiennych formularza
    $nazwisko = $_POST['nazwisko'];
    $plec = $_POST['plec'];
    $n_panienskie = $_POST['n_panienskie'];
    $email = $_POST['email'];
    $kod = $_POST['kod_pocztowy'];
    
    
    if(empty($imie) || empty($nazwisko) || empty($n_panienskie) || empty($plec) || !preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email) || !preg_match("/^([0-9]{2})-([0-9]{3})$/", $kod))
    {
        ?>
<center><b>Edycja danych!</b></center>
        <form action = "index.php?id=edycja&rekord=<?php $ss=$_GET['rekord']; echo"$ss"; ?>" method = "POST">
        <table align="center">
            <td width="170">
                Imie:</br>
                Nazwisko:</br></br>
                Plec:</br></br>
                Nazwisko panienskie:</br>
                Email:</br>
                Kod pocztowy:</br></br>
            </td>
            <td>
        <?php

        if(empty($imie))
        {
            ?>
         <input type="text" name="imie" value="<?php echo $imie ?>"><?php echo "&nbsp&nbsp <b>Wpisz imie!</b>"; ?></br><?php
        }
        else
        {
            ?>
        <input type="text" name="imie" value="<?php echo $imie ?>"></br>
            <?php
        }


        if(empty($nazwisko))
        {
            ?>
    <input type="text" name="nazwisko" value="<?php echo $nazwisko ?>"> <?php echo "&nbsp&nbsp <b>Wpisz nazwisko!</b>";?> </br>
            <?php
        }
        else
        {
            ?>
    <input type="text" name="nazwisko" value="<?php echo $nazwisko ?>"></br>
            <?php
        }


        if(empty($plec))
        {
            ?>
           <input type="radio" name="plec" value="Kobieta">Kobieta</br>
        <input type="radio" name="plec" value="Mezczyzna">Mezczyzna                  
        <?php echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <b>Wybierz Plec!</b>";?></br><?php 
        }
        else
        {
        if($plec == "Kobieta")
        {
            ?>
            <input type="radio" name="plec" value="Kobieta" checked="checked">Kobieta</br>
            <input type="radio" name="plec" value="Mezczyzna">Mezczyzna</br>
            <?php
        }
        else
        {
            ?>
            <input type="radio" name="plec" value="Kobieta">Kobieta</br>
        <input type="radio" name="plec" value="Mezczyzna" checked="checked">Mezczyzna</br>
            <?php
        }
        }

                    if(empty($n_panienskie))
        {
            ?>
    <input type="text" name="n_panienskie" value="<?php echo $n_panienskie ?>"><?php echo "&nbsp&nbsp <b>Wpisz nazwisko panienskie!</b>"; ?></br> <?php 
        }
        else
        {
            ?>
    <input type="text" name="n_panienskie" value="<?php echo $n_panienskie ?>"></br>
            <?php
        }
        
        
        if(!empty($email))
        {
                    if(!preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email))
                    {
                        ?>
                        <input type="text" name="email"> <?php echo '&nbsp&nbsp <b>Bledny e-mail!</b>'; ?> </br> 
                        <?php
                    }
                    else
                    {
                        ?>
                    <input type="text" name="email" value="<?php echo $email ?>"></br>
                        <?php
                    }
        }
        else if(empty($email))
        {
                    ?>
        <input type="text" name="email"> <?php echo '&nbsp&nbsp <b>Wpisz e-mail!</b>'; ?> </br> 
                    <?php 
        }
        else 
        {
            ?>
        <input type="text" name="email" value="<?php echo $email ?>"></br>
            <?php
        }
        
               
        
        if(!empty($kod))
        {
            if(!preg_match("/^([0-9]{2})-([0-9]{3})$/", $kod))
            {
                ?>
    <input type="text" name="kod_pocztowy"> <?php echo "&nbsp&nbsp <b>Bledny kod pocztowy!</b>"; ?> </br> 
                <?php
            }
            else
            {
                ?>
         <input type="text" name="kod_pocztowy" value="<?php echo $kod ?>"></br>
                <?php
            }
        }
        else if(empty($kod))
        {
            ?>
        <input type="text" name="kod_pocztowy"> <?php echo "&nbsp&nbsp <b>Wpisz kod pocztowy!</b>"; ?></br>  
            <?php 
        }       
        else
        {
            ?>
        <input type="text" name="kod_pocztowy" value="<?php echo $kod ?>"></br>
            <?php
        }
        
        
        ?>
            </td>
            </table>
            <center>  <input type="submit" name="wyslij" value="Potwierdz zmiany"/> 
                    <input type="submit" name="cofnij" value="Odrzoc zmiany"/> </center>
</form>
        
        <?php
        
    }
    
      
    else
    {?>
      
     
    <?php   
            
        $tmp=$_GET['rekord'];
        mysql_connect("localhost", "moziero_si", "haslo1234q");
        @mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
           
   
    $zapytanie = "UPDATE pracownicy SET imie = '$imie', nazwisko = '$nazwisko', plec = '$plec', nazpan = '$n_panienskie', email = '$email', kodpocztowy = '$kod' WHERE id = '$tmp'";
    $result = mysql_query($zapytanie);
    mysql_close();
 
    header("Location: index.php?id=5");
}
}
else
{
?>
<center><b>Edycja danych!</b></center>
<form action = "index.php?id=edycja&rekord=<?php $ss=$_GET['rekord']; echo"$ss"; ?>" method = "POST">
        <table align="center">
            <td width="170">
                Imie:</br>
                Nazwisko:</br></br>
                Plec:</br></br>
                Nazwisko panienskie:</br>
                Email:</br>
                Kod pocztowy:</br></br>
            </td>
            <td>
        
                    <input type="text" name="imie" value="<?php echo $imie ?>"/></br>
                    
                    <input type="text" name="nazwisko" value="<?php echo $nazwisko ?>"/></br>

<?php
        if($plec == "Kobieta")
        {
          echo' 
            <input type="radio" name="plec" value="Kobieta" checked="checked">Kobieta</br>
            <input type="radio" name="plec" value="Mezczyzna">Mezczyzna</br>
            ';
        }
        else
        {
          echo '<input type="radio" name="plec" value="Kobieta">Kobieta</br>
        <input type="radio" name="plec" value="Mezczyzna" checked="checked">Mezczyzna</br>
        ';
    }
?>

                    <input type="text" name="n_panienskie" value="<?php echo $n_panienskie ?>"/></br>
                    <input type="text" name="email" value="<?php echo $email ?>"/></br>
                    <input type="text" name="kod_pocztowy" value="<?php echo $kodpocztowy ?>"/></br>
            </td>
            </table>
             <center>  <input type="submit" name="wyslij" value="Potwierdz zmiany"/> 
                    <input type="submit" name="cofnij" value="Odrzoc zmiany"/> </center>
</form>
<?php }
}else{
echo "Nie masz uprawnien do ogladania strony!";
}
}
###############################################################################################################
else if ($str=="usun"){
if ($_SESSION['auth'] == TRUE & $_SESSION['prem']>=3){

if(isset($_POST["tak"]))
{
$tmp=$_GET['rekord'];

mysql_connect("localhost", "moziero_si", "haslo1234q");
@mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
           
   
$zapytanie = "DELETE FROM pracownicy WHERE id='$tmp'";
$result = mysql_query($zapytanie);
mysql_close();
 
header("Location: index.php?id=6");
}
if(isset($_POST["nie"]))
{
header("Location: index.php?id=6");
}
echo '<form action = "index.php?id=usun&rekord=';
$tmp=$_GET["rekord"];
echo "$tmp";
echo '" method = "POST">
		<center>Czy chcesz usunac pracownika z bazy danych?</br></center>
		<center>  <input type="submit" name="tak" value="Tak"/> 
                    <input type="submit" name="nie" value="Nie"/> </center></form>';
}else{
echo "Nie masz uprawnien do ogladania strony!";
}
   }

##############################################################################################################3
else if ($str=="remuser"){
if ($_SESSION['auth'] == TRUE & $_SESSION['prem']>=4){

if(isset($_POST["tak"]))
{
$tmp=$_GET['rekord'];

mysql_connect("localhost", "moziero_si", "haslo1234q");
@mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
           
   
$zapytanie = "DELETE FROM uzytkownicy WHERE login='$tmp'";
$result = mysql_query($zapytanie);
mysql_close();
 
header("Location: index.php?id=9");
}
if(isset($_POST["nie"]))
{
header("Location: index.php?id=9");
}
echo '<form action = "index.php?id=remuser&rekord=';
$tmp=$_GET["rekord"];
echo "$tmp";
echo '" method = "POST">
		<center>Czy chcesz usunac uzytkownika z bazy danych?</br></center>
		<center>  <input type="submit" name="tak" value="Tak"/> 
                    <input type="submit" name="nie" value="Nie"/> </center></form>';
}else{
echo "Nie masz uprawnien do ogladania strony!";
}
   }
################################################################################################################	
	else if ($str=="logowanie"){

if ($_SESSION['auth'] == TRUE){
	echo "Jestes zalogowany/a !";
	
}else{

	if(isset($_POST["loguj"])){
	
	$user = $_POST['user']; 
    	$password = $_POST['password'];
        $password = md5($password);
	mysql_connect("localhost", "moziero_si", "haslo1234q");
        @mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
        $zapytanie = "SELECT * FROM uzytkownicy WHERE login='$user' and haslo='$password'";
   	$result = mysql_query($zapytanie);
   	$liczba_wyn=mysql_num_rows($result);
    	mysql_close();
	if($liczba_wyn>0){
       	$wiersz=mysql_fetch_row($result);
	echo "Witaj $wiersz[3] $wiersz[4]!";
		$_SESSION['user'] = $login;
		$_SESSION['prem'] = $wiersz[2];
                $_SESSION['auth'] = TRUE;
    echo '<meta http-equiv="refresh" content="1; URL=index.php?id=logowanie">';
	}else{
      echo '
        <form action = "index.php?id=logowanie" method = "POST">
		<center>Podano bledne dane! Podaj poprawny login i haslo:</br></center>
        <table align="center">
            <td>Login:</br>Haslo:</td><td>
                    <input type="text" name="user" value=""/></br>
		    <input type="password" name="password" value=""/></br>
            </td>
            </table>
			<center><input type="submit" name="loguj" value="Zaloguj"/> </center>
	</form>';}
	}else{
	echo '
        <form action = "index.php?id=logowanie" method = "POST">
		<center>Podaj login i haslo:</br></center>
        <table align="center">
            <td>Login:</br>Haslo:</td><td>
                    <input type="text" name="user" value=""/></br>
					<input type="password" name="password" value=""/></br>
            </td>
            </table>
			<center><input type="submit" name="loguj" value="Zaloguj"/> </center>
	</form>';}
}
}
################################################################################################################
else if ($str=="rejestracja"){
if(isset($_POST["cofnij"])){
header("Location: index.php?id=5");
}

if(isset($_POST["wyslij"]))
{
   $login = $_POST['login'];
    $haslo = $_POST['haslo'];
    $haslo1 = $_POST['haslo1'];
    $imie = $_POST['imie']; // przypisanie zmiennych formularza
    $nazwisko = $_POST['nazwisko'];
$tmp=0;

if (!empty($login)){
mysql_connect("localhost", "moziero_si", "haslo1234q");
        @mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
        $zapytanie = "SELECT * FROM uzytkownicy WHERE login='$login'";
   	$result = mysql_query($zapytanie);
   	$liczba_wyn=mysql_num_rows($result);
    	mysql_close();
	if($liczba_wyn!=0){$tmp=1;}
} 
    
    if(empty($imie) || empty($nazwisko) || empty($login) || empty($haslo) || empty($haslo1) || strlen ($haslo)<6 || strlen($haslo1)<6|| strcmp($haslo,$haslo1)!=0 || $tmp==1 || strlen ($login)<6 )
    {
        ?>
<center><b>Rejestracja!</b></center>
        <form action = "index.php?id=rejestracja" method = "POST">
        <table align="center">
            <td width="170">
                Login:</br>
                Haslo:</br>
                Powtorz haslo:</br>
                Imie:</br>
                Nazwisko:</br>
              
            </td>
            <td>
        <?php

        if(!empty($login))
        {
                    if(strlen ($login)<6)
                    {
                        ?>
                        <input type="text" name="login"> <?php echo '&nbsp&nbsp <b>Login jest za krotki!</b>'; ?> </br> 
                        <?php
                    }
                    else
                    {
        mysql_connect("localhost", "moziero_si", "haslo1234q");
        @mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
        $zapytanie = "SELECT * FROM uzytkownicy WHERE login='$login'";
   	$result = mysql_query($zapytanie);
   	$liczba_wyn=mysql_num_rows($result);
    	mysql_close();
	if($liczba_wyn!=0){

      echo '<input type="text" name="login" value="';
 #echo "$login"; 
echo '">&nbsp&nbsp <b>Jest juz taki uzytkownik!</b></br>';


		}else{
                        
                      echo '<input type="text" name="login" value="';
       echo "$login";
 echo '"></br>';
                       }
                    }
        }
        else if(empty($login))
        {
                    ?>
        <input type="text" name="login"> <?php echo '&nbsp&nbsp <b>Wpisz login!</b>'; ?> </br> 
                    <?php 
        }
        else 
        {
            
       echo '<input type="text" name="login" value="';
       echo "$login";
 echo '"></br>';
            
        }

        
if(!empty($haslo))
        {
                    if(strlen ($haslo)<6)
                    {
                        ?>
                        <input type="password" name="haslo"> <?php echo '&nbsp&nbsp <b>Haslo jest za krotkie!</b>'; ?> </br> 
                        <?php
                    }
                    else
                    {
                        ?>
                    <input type="password" name="haslo" value="<?php echo $haslo ?>"></br>
                        <?php
                    }
        }
        else if(empty($haslo))
        {
                    ?>
        <input type="password" name="haslo"> <?php echo '&nbsp&nbsp <b>Wpisz haslo!</b>'; ?> </br> 
                    <?php 
        }
        else 
        {
            ?>
        <input type="password" name="haslo" value="<?php echo $haslo ?>"></br>
            <?php
        }


if(!empty($haslo1))
        {
                    if(strlen ($haslo1)<6)
                    {
                        ?>
                        <input type="password" name="haslo1"> <?php echo '&nbsp&nbsp <b>Haslo jest za krotkie!</b>'; ?> </br> 
                        <?php
                    }
                    else
                    {
                     if(strcmp($haslo,$haslo1)!=0){   
                   echo '<input type="password" name="haslo1" value="<?php echo $haslo1 ?>">&nbsp&nbsp <b>Hasla sie nie zgadzaja!</b></br>';
                     }else{
                   echo '<input type="password" name="haslo1" value="';
 echo "$haslo1";
echo '"></br>';
                     }   
                    }
        }
        else if(empty($haslo1))
        {
                    ?>
        <input type="password" name="haslo1"> <?php echo '&nbsp&nbsp <b>Wpisz haslo!</b>'; ?> </br> 
                    <?php 
        }
        else 
        {
            ?>
        <input type="password" name="haslo1" value="<?php echo $haslo1 ?>"></br>
            <?php
        }





                    if(empty($imie))
        {
            ?>
    <input type="text" name="imie" value="<?php echo $imie ?>"><?php echo "&nbsp&nbsp <b>Wpisz imie!</b>"; ?></br> <?php 
        }
        else
        {
            ?>
    <input type="text" name="imie" value="<?php echo $imie ?>"></br>
            <?php
        }
        
                    if(empty($nazwisko))
        {
            ?>
    <input type="text" name="nazwisko" value="<?php echo $nazwisko ?>"><?php echo "&nbsp&nbsp <b>Wpisz nazwisko!</b>"; ?></br> <?php 
        }
        else
        {
            ?>
    <input type="text" name="nazwisko" value="<?php echo $nazwisko ?>"></br>
            <?php
        }
        
        
        
        ?>
            </td>
            </table>
            <center>  <input type="submit" name="wyslij" value="Rejestracja"/> 
</form>
        
        <?php
        
    }
    
      
    else
    {?>
      
     
    <?php  
$tmp2=md5($haslo); 
    mysql_connect("localhost", "moziero_si", "haslo1234q");
	@mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
           
    $zapytanie = "INSERT INTO uzytkownicy VALUES('$login','$tmp2','0','$imie','$nazwisko')";
    $result = mysql_query($zapytanie) or die("BŁĄD: Nie mozna dodac rekordu do bazy danych!");
    
    mysql_close();
echo "Rejestracja przebiegla prawidlowo!";
}
}
else
{
?>
<center><b>Rejestracja!</b></center>
<form action = "index.php?id=rejestracja" method = "POST">
        <table align="center">
            <td width="170">
                Login:</br>
                Haslo:</br>
                Powtorz haslo:</br>
                Imie:</br>
                Nazwisko:</br>
            </td>
            <td>
        
                    <input type="text" name="login" value="<?php echo $login ?>"/></br>
                    
                    <input type="password" name="haslo" value="<?php echo $haslo ?>"/></br>

                    <input type="password" name="haslo1" value="<?php echo $haslo ?>"/></br>
                    <input type="text" name="imie" value="<?php echo $imie ?>"/></br>
                    <input type="text" name="nazwisko" value="<?php echo $nazwisko ?>"/></br>
			
            </td>
            </table>
<center><input type="submit" name="wyslij" value="Zarejestruj"/> </center>
             
</form>
<?php }	
}
#################################################################################################################
else if ($str=="wylogowanie"){
if ($_SESSION['auth'] == TRUE) {
	session_destroy();
        echo '<p style="padding-top:10px;"><strong>Wylogowano!</strong>';
	echo '<meta http-equiv="refresh" content="1; URL=index.php">';
}else{
echo "Nie masz uprawnien do ogladania strony!";
}
}
###################################################################################################################
else if ($str==7){
	if ($_SESSION['auth'] == TRUE & $_SESSION['prem']>=1) {
	


if(isset($_POST["cofnij"])){
header("Location: index.php?id=1");
}

if(isset($_POST["wyslij"]))
{
   $login = $_POST['login'];
    $haslo = $_POST['haslo'];
    $haslo1 = $_POST['haslo1'];
    $imie = $_POST['imie']; // przypisanie zmiennych formularza
    $nazwisko = $_POST['nazwisko'];
$tmp=0;

if (!empty($login)){
mysql_connect("localhost", "moziero_si", "haslo1234q");
        @mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
        $zapytanie = "SELECT * FROM uzytkownicy WHERE login='$login'";
   	$result = mysql_query($zapytanie);
   	$liczba_wyn=mysql_num_rows($result);
    	mysql_close();
	if($liczba_wyn!=0){$tmp=1;}
} 
    
    if(empty($imie) || empty($nazwisko) || empty($login) || empty($haslo) || empty($haslo1) || strlen ($haslo)<6 || strlen($haslo1)<6|| strcmp($haslo,$haslo1)!=0 ||  strlen ($login)<6 )
    {
        ?>
<center><b>Edycja danych!</b></center>
        <form action = "index.php?id=7" method = "POST">
        <table align="center">
            <td width="170">
                Login:</br>
                Haslo:</br>
                Powtorz haslo:</br>
                Imie:</br>
                Nazwisko:</br>
              
            </td>
            <td>
        <?php

        if(!empty($login))
        {
                    if(strlen ($login)<6)
                    {
                        ?>
                        <input type="text" name="login"> <?php echo '&nbsp&nbsp <b>Login jest za krotki!</b>'; ?> </br> 
                        <?php
                    }
                    else
                    {
        if(strcmp($login,$_SESSION['user'])!=0){
        mysql_connect("localhost", "moziero_si", "haslo1234q");
        @mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
        $zapytanie = "SELECT * FROM uzytkownicy WHERE login='$login'";
   	$result = mysql_query($zapytanie);
   	$liczba_wyn=mysql_num_rows($result);
    	mysql_close();
	if($liczba_wyn!=0){

      echo '<input type="text" name="login" value="';
      echo "$login"; 
      echo '">&nbsp&nbsp <b>Jest juz taki uzytkownik!</b></br>';


		}else{
                        
                    echo '<input type="text" name="login" value="';
 echo "$login";
 echo '"></br>';
                       }}
else{
echo '<input type="text" name="login" value="';
echo "$login";
 echo '"></br>';

}
                    }
        }
        else if(empty($login))
        {
                    ?>
        <input type="text" name="login"> <?php echo '&nbsp&nbsp <b>Wpisz login!</b>'; ?> </br> 
                    <?php 
        }
        else 
        {
            ?>
        <input type="text" name="haslo" value="<?php echo $login ?>"></br>
            <?php
        }

        
if(!empty($haslo))
        {
                    if(strlen ($haslo)<6)
                    {
                        ?>
                        <input type="password" name="haslo"> <?php echo '&nbsp&nbsp <b>Haslo jest za krotkie!</b>'; ?> </br> 
                        <?php
                    }
                    else
                    {
                        ?>
                    <input type="password" name="haslo" value="<?php echo $haslo ?>"></br>
                        <?php
                    }
        }
        else if(empty($haslo))
        {
                    ?>
        <input type="password" name="haslo"> <?php echo '&nbsp&nbsp <b>Wpisz haslo!</b>'; ?> </br> 
                    <?php 
        }
        else 
        {
            ?>
        <input type="password" name="haslo" value="<?php echo $haslo ?>"></br>
            <?php
        }


if(!empty($haslo1))
        {
                    if(strlen ($haslo1)<6)
                    {
                        ?>
                        <input type="password" name="haslo1"> <?php echo '&nbsp&nbsp <b>Haslo jest za krotkie!</b>'; ?> </br> 
                        <?php
                    }
                    else
                    {
                     if(strcmp($haslo,$haslo1)!=0){   
                   echo '<input type="password" name="haslo1" value="<?php echo $haslo1 ?>">&nbsp&nbsp <b>Hasla sie nie zgadzaja!</b></br>';
                     }else{
                   echo '<input type="password" name="haslo1" value="';
 echo "$haslo1";
echo '"></br>';
                     }   
                    }
        }
        else if(empty($haslo1))
        {
                    ?>
        <input type="password" name="haslo1"> <?php echo '&nbsp&nbsp <b>Wpisz haslo!</b>'; ?> </br> 
                    <?php 
        }
        else 
        {
            ?>
        <input type="password" name="haslo1" value="<?php echo $haslo1 ?>"></br>
            <?php
        }





                    if(empty($imie))
        {
            ?>
    <input type="text" name="imie" value="<?php echo $imie ?>"><?php echo "&nbsp&nbsp <b>Wpisz imie!</b>"; ?></br> <?php 
        }
        else
        {
            ?>
    <input type="text" name="imie" value="<?php echo $imie ?>"></br>
            <?php
        }
        
                    if(empty($nazwisko))
        {
            ?>
    <input type="text" name="nazwisko" value="<?php echo $nazwisko ?>"><?php echo "&nbsp&nbsp <b>Wpisz nazwisko!</b>"; ?></br> <?php 
        }
        else
        {
            ?>
    <input type="text" name="nazwisko" value="<?php echo $nazwisko ?>"></br>
            <?php
        }
        
        
        
        ?>
            </td>
            </table>
           <center>  <input type="submit" name="wyslij" value="Potwierdz zmiany"/> 
                    <input type="submit" name="cofnij" value="Odrzoc zmiany"/> </center>
</form>
        
        <?php
        
    }
    
      
    else
    {?>
      
     
    <?php  
$tmp2=md5($haslo); 
   mysql_connect("localhost", "moziero_si", "haslo1234q");
        @mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
        $tmp=$_SESSION['user'];   
   
    $zapytanie = "UPDATE uzytkownicy SET imie = '$imie', nazwisko = '$nazwisko', haslo = '$tmp2', login = '$login' WHERE login = '$tmp'";
    $result = mysql_query($zapytanie);
    mysql_close();
echo "Edycja przebiegla prawidlowo!";
echo '<meta http-equiv="refresh" content="1; URL=index.php?id=7&login=';
$tmp=$login;
$_SESSION['user']=$login;
	mysql_connect("localhost", "moziero_si", "haslo1234q");
        @mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
        $zapytanie = "SELECT * FROM uzytkownicy WHERE login='$tmp'";
   	$result = mysql_query($zapytanie);
    	mysql_close();
       	$wiersz=mysql_fetch_row($result);
	echo "$wiersz[0]";
       echo "&imie=";
       echo "$wiersz[3]";
       echo "&nazwisko=";
       echo "$wiersz[4]";
echo'">';
}
}
else
{
?>
<center><b>Edycja danych!</b></center>
<form action = "index.php?id=7" method = "POST">
        <table align="center">
            <td width="170">
                Login:</br>
                Haslo:</br>
                Powtorz haslo:</br>
                Imie:</br>
                Nazwisko:</br>
            </td>
            <td>
        
                    <input type="text" name="login" value="<?php echo $login ?>"/></br>
                    
                    <input type="password" name="haslo" value="<?php echo $haslo ?>"/></br>

                    <input type="password" name="haslo1" value="<?php echo $haslo ?>"/></br>
                    <input type="text" name="imie" value="<?php echo $imie ?>"/></br>
                    <input type="text" name="nazwisko" value="<?php echo $nazwisko ?>"/></br>
			
            </td>
            </table>
<center>  <input type="submit" name="wyslij" value="Potwierdz zmiany"/> 
                    <input type="submit" name="cofnij" value="Odrzoc zmiany"/> </center>
             
</form>
<?php }












}else{
echo "Nie masz uprawnien do ogladania tej strony!";}
}
###################################################################################################################
else if ($str==8){
	if ($_SESSION['auth'] == TRUE & $_SESSION['prem']>=4) {
        if(isset($_POST["zmien"])){
        $tmp=$_GET['rekord'];
        mysql_connect("localhost", "moziero_si", "haslo1234q");
        @mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
           
   	$tmp1=$_POST["nazwa"];
    	$zapytanie = "UPDATE uzytkownicy SET uprawnienia = '$tmp1' WHERE login = '$tmp'";
    	$result = mysql_query($zapytanie);
    	mysql_close();
 
  	header("Location: index.php?id=8");

        }
	mysql_connect("localhost", "moziero_si", "haslo1234q");
	@mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
	$query="SELECT * FROM uzytkownicy";
	$result=mysql_query($query);

	$liczba_wyn=mysql_num_rows($result);
	$liczba_na_str=10;
	$liczba_str=$liczba_wyn/$liczba_na_str;
	$liczba_str=ceil($liczba_str);
	if (isset($_GET['str'])) $str=$_GET['str'];
	else $str=1;
	$pomin=($str-1)*$liczba_na_str;
       	$zapytanie="SELECT * FROM uzytkownicy LIMIT $pomin, $liczba_na_str";
	$wyniki=mysql_query($zapytanie);
	echo "<center><b>Tabela uzytkownikow w bazie danych!</b></center></br>";
	echo '<table border="1" align="center">';
	echo '<th>Zmien</th><th>Imie</th><th>Nazwisko</th><th>Login</th><th>Poziom</th>';

	while ($wiersz=mysql_fetch_row($wyniki))
	{
	echo '<tr><td>';
$opcja=0;
if($wiersz[0]==$_SESSION['user'] || $wiersz[2]>=4 ){

 $opcja=1;
 echo "$wiersz[0]";

}else{
	echo '<form action = "index.php?id=8&rekord=';

         echo "$wiersz[0]";
        echo '" method = "POST"><center><input type="submit" name="zmien" value="Zmien"/></center>';}
	echo '</td><td>'. $wiersz[3] .'</td><td>'. $wiersz[4] .'</td><td>'. $wiersz[0] .'</td>';

echo '<td>';
if($opcja==1){echo "$wiersz[2]";}else{

	echo '<select name="nazwa" >';

	if($wiersz[2]==0){
        echo'
		<option selected="selected">'. $wiersz[2] .'</option>
		<option>1</option>
		<option>2</option>
		<option>3</option>
                <option>4</option>
	</select>';

	}
	if($wiersz[2]==1){
	echo '	<option>0</option>
		<option selected="selected">'. $wiersz[2] .'</option>
		<option>2</option>
		<option>3</option>
                <option>4</option>
	</select>';

	}
	if($wiersz[2]==2){
	echo '	<option>0</option>
		<option>1</option>
		<option selected="selected">'. $wiersz[2] .'</option>
		<option>3</option>
                <option>4</option>
	</select>';

	}
	if($wiersz[2]==3){
	echo '	<option>0</option>
		<option>1</option>
		<option>2</option>
		<option selected="selected">'. $wiersz[2] .'</option>
                <option>4</option>
	</select>';

	}
	if($wiersz[2]==4){
	echo '	<option>0</option>
		<option>1</option>
		<option>2</option>
                <option>3</option>
		<option selected="selected">'. $wiersz[2] .'</option>
	</select>';
	}
 
	echo'</form>';}

echo '</td></tr>';
	}
	echo '</table>';
	$my=8;
	$linki=' ';
	if ($str>1) {
	$linki=$linki. '<a href="'.$_SERVER['PHP_SELF'].'?id='.$my. '&str='.($str-1).'"><-</a>'; }
	else { $linki=$linki. '<-'; }
	for($i=1; $i<=$liczba_str; $i++) {
	if ($str==$i) { $linki=$linki.' '.$i; }
	else {
	$linki=$linki. '<a href="'.$_SERVER['PHP_SELF'].'?id='.$my. '&str='.$i.'">'.$i.'</a>'; }}
	if ($str<$liczba_str) {
	$linki=$linki. '<a href="'.$_SERVER['PHP_SELF'].'?id='.$my. '&str='.($str+1).'">-></a>'; }
	else { $linki=$linki. '->'; }
echo '</br><center>';
echo $linki;
echo '</center>';
	mysql_close();
	}else{
echo "Nie masz uprawnien do ogladania tej strony";
}
}
####################################################################################################################
else if ($str==9){
if ($_SESSION['auth'] == TRUE & $_SESSION['prem']>=4) {
	mysql_connect("localhost", "moziero_si", "haslo1234q");
	@mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
	$query="SELECT * FROM uzytkownicy";
	$result=mysql_query($query);

	$liczba_wyn=mysql_num_rows($result);
	$liczba_na_str=10;
	$liczba_str=$liczba_wyn/$liczba_na_str;
	$liczba_str=ceil($liczba_str);
	if (isset($_GET['str'])) $str=$_GET['str'];
	else $str=1;
	$pomin=($str-1)*$liczba_na_str;
       	$zapytanie="SELECT * FROM uzytkownicy LIMIT $pomin, $liczba_na_str";
	$wyniki=mysql_query($zapytanie);
	echo "<center><b>Tabela uzytkownikow w bazie danych!</b></center></br>";
	echo '<table border="1" align="center"  >';
echo '<th>Usun</th><th>Imie</th><th>Nazwisko</th><th>Login</th><th>Poziom</th>';

	while ($wiersz=mysql_fetch_row($wyniki))
	{
	echo '<tr><td>';
	if($wiersz[2]==4 || $_SESSION['user']==$wiersz[0]){echo "Usun";
	}else{
	echo '<a href="'.$_SERVER['PHP_SELF'].'?id=remuser&rekord='.$wiersz[0].'">Usun</a>';
	}
	echo '</td><td>'. $wiersz[3] .'</td><td>'. $wiersz[4] .'</td><td>'. $wiersz[0] .'</td><td>'. $wiersz[2] .'</td></tr>';
	}
	echo '</table>';
	$my=9;
	$linki=' ';
	if ($str>1) {
	$linki=$linki. '<a href="'.$_SERVER['PHP_SELF'].'?id='.$my. '&str='.($str-1).'"><-</a>'; }
	else { $linki=$linki. '<-'; }
	for($i=1; $i<=$liczba_str; $i++) {
	if ($str==$i) { $linki=$linki.' '.$i; }
	else {
	$linki=$linki. '<a href="'.$_SERVER['PHP_SELF'].'?id='.$my. '&str='.$i.'">'.$i.'</a>'; }}
	if ($str<$liczba_str) {
	$linki=$linki. '<a href="'.$_SERVER['PHP_SELF'].'?id='.$my. '&str='.($str+1).'">-></a>'; }
	else { $linki=$linki. '->'; }
echo '</br><center>';
echo $linki;
echo '</center>';
	mysql_close();
	}else{
echo "Nie masz uprawnien do ogladania tej strony";
}
}
###################################################################################################################
?>
	</div>
	<div id="prawa">
<?php if ($_SESSION['auth'] == TRUE & $_SESSION['prem']>=1) {
              echo '<form action = "index.php?id=5" method = "GET">
        <table align="center">
            <td width="170">
                Wyszukiwarka:</br>
                    <input type="text" name="keyword" value=""/></br>
                    <input type="submit" name="id" value="Szukaj"/> 
            </td>
            </table>
</form>';} ?>
<ul>
	<?php if ($_SESSION['auth'] == TRUE) {
              echo '<li><a href="index.php?id=wylogowanie">Wyloguj</a></li>';
        }else{
              echo '<li><a href="index.php?id=logowanie">Zaloguj</a></li>';
} ?>
        <li><a href="index.php?id=rejestracja">Rejestracja</a></li>
        </ul>
	</div>
	<div id="dol">
	<?php  if ($_SESSION['auth'] == TRUE & $_SESSION['prem']>=1){$counter=count($_SESSION["pracownicy"]); if ($counter !=0){echo "Ilosc pracownikow: $counter";}}    ob_end_flush(); ?>
	 &nbsp &nbsp Wykonal: Michal Oziero 
	</div>
  </div>
  
 </body>
</html>

