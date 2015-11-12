<?php
// Includo la connessione al database
require('functions/config.php');

   //Se non è stata definita la variabile, manda l'utente alla pag di registrazione
	 if( !isset($_SESSION['login']) ){
    header('Location: registrazione.php');
    exit;
	}
	
	
	if( isset($_GET['email']) )
	{	
		
		$emailEdit = $_GET['email'];
		$query= "UPDATE utenti SET attivato='1' WHERE email='$emailEdit'";
      mysqli_query($link, $query);
      
    	echo "<script type=\"text/javascript\">alert(\"Utente attivato!\");</script> ";             
    	
		mail($emailEdit, "Account attivato", "Complimenti! Il tuo account e' stato attivato. Accedi subito su http://pdluniba.netsons.org");    	
    	
   }
  
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<!-- File principale  -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<title>Private Digital Library</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />


</head>

<body>
<!-- body section -->
<div id="intestazione_home">
<?php include 'common/header.php'; ?>
</div>


<div id="contenuto">

		<div id="contenuto_left">
		
		<?php 
			include 'common/menu_sx.php';
		?>

		</div>
		
		<div id="contenuto_right">
		<h1>Attiva utenti</h1>
		
		
     <?php 
     


     $query= "SELECT nome, cognome, email FROM utenti where responsabile='0' AND attivato='0'";
     
	 $result = mysqli_query($link, $query);
	 
     if ($result) {

	  //Intestazione tabella
	  echo '<table class="tab_scheda"><th>Nome</th><th>Cognome</th><th>Email</th><th>Azione</th>';

	     while ($row = mysqli_fetch_row($result)) {      
         echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td>'.'<td><a href="attiva-utente.php?email='.$row[2].'">Attiva</a></td>'.'</tr>';
         }
    
      echo '</table><p>Se vuoi disabilitare un utente <a href="disattiva-utente.php">clicca qui.</a></p>';
	

      }

	

/* close connection */
mysqli_close($link);

  ?>

		</div>
		
</div>

<div id="footer">
<?php include 'common/footer.html'; ?>
</div>

</body>


</html>