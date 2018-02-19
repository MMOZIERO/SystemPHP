<?php
if ($_SESSION['auth'] == TRUE & $_SESSION['prem']>=1){
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
<center><b>Uzupelnij formularz!</b></center>
        <form action = "index.php?id=2" method = "POST">
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
 <input type="submit" name="wyslij" value="Wyslij"/> 
            </td>
            </table>
</form>
        
        <?php
        
    }
    
      
    else
    {?>
      
     
    <?php 	echo "<center>";
            echo "Imie: $imie</br>";
            echo "Nazwisko: $nazwisko</br>";
            echo "Plec: $plec</br>";
            echo "Nazwisko panienskie: $n_panienskie</br>";
            echo "E-mail: $email</br>";
            echo "Kod pocztowy: $kod</br>";
            echo "</center>";
			
			$zm=count($_SESSION["pracownicy"]);
			$_SESSION["pracownicy"][$zm]["imie"]=$imie;
			$_SESSION["pracownicy"][$zm]["nazwisko"]=$nazwisko;
			$_SESSION["pracownicy"][$zm]["plec"]=$plec;
			$_SESSION["pracownicy"][$zm]["nazwiskopanienskie"]=$n_panienskie;
			$_SESSION["pracownicy"][$zm]["email"]=$email;
			$_SESSION["pracownicy"][$zm]["kodpocztowy"]=$kod;

       
		mysql_connect("localhost", "moziero_si", "haslo1234q");
		@mysql_select_db("moziero_si") or die("Nie znaleziono bazy danych");
           
    $zapytanie = "INSERT INTO pracownicy VALUES('','$imie','$nazwisko','$plec','$n_panienskie','$email','$kod')";
    $result = mysql_query($zapytanie) or die("BŁĄD: Nie mozna dodac rekordu do bazy danych!");
    
    mysql_close();
}
}
else
{
?>
<center><b>Uzupelnij formularz!</b></center>
<form action = "index.php?id=2" method = "POST">
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

                    <input type="radio" name="plec" value="Kobieta"/>Kobieta</br>
                    <input type="radio" name="plec" value="Mezczyzna"/>Mezczyzna</br>

                    <input type="text" name="n_panienskie" value="<?php echo $n_panienskie ?>"/></br>
                    <input type="text" name="email" value="<?php echo $email ?>"/></br>
                    <input type="text" name="kod_pocztowy" value="<?php echo $kodpocztowy ?>"/></br>
                    <input type="submit" name="wyslij" value="Wyslij"/> 
            </td>
            </table>
</form>
<?php }
}else{
echo "Nie masz uprawnien do ogladania tej strony!";
}
?>			
