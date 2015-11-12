<?php
// Includo il file che contiene la funzione di connessione al database
require('config.php');


// Se il modulo viene inviato 
//(se la variabile è piena)
if(isset($_POST['login']))
{
    
    // Dati Inviati dal modulo
    $email = (isset($_POST['email'])) ? trim($_POST['email']) : '';    // Metto nella variabile 'email' il dato inviato dal modulo, se non viene inviato dò di default ''
    $pass = (isset($_POST['pass'])) ? trim($_POST['pass']) : '';    // Metto nella variabile 'pass' il dato inviato dal modulo, se non viene inviato dò di default ''
    
    // Filtro i dati inviati se i magic_quotes del server sono disabilitati per motivi di sicurezza
    if (!get_magic_quotes_gpc()) {
        $email = addslashes($email);
        $pass = addslashes($pass);
    }
    
    // Crypto la password e la confronto con quella nel database
    $pass = md5($pass);
    

	  
    // Controllo l'utente esiste
    $query= "SELECT * FROM utenti WHERE email = '$email' AND pass = '$pass' AND attivato = '1' LIMIT 1";    
    
	/* Select queries return a resultset */
	$result = mysqli_query($link, $query);
	
	if ($result) {
		
		//se ha trovato la riga...
		if( mysqli_num_rows($result) == 1 ){    
	
	
        		//se l'utente è responsabile...
				/* associative array */
					$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				
				if($row["responsabile"] == 1){
					$_SESSION['login'] = $email;
				}
					
        		if($row["responsabile"] == 0){
        	   	$_SESSION['login_ammesso'] = $email;
            }
            
        		//Reindirizzamento nell'area privata
        		echo '<script type="text/javascript">';
				echo 'window.location.href="../area_riservata.php";';
				echo '</script>';
        
    	  		/* free result set */
    	  		mysqli_free_result($result);
       	
    			}

      else {
     /* close connection */
		mysqli_close($link);

       echo "<script type=\"text/javascript\">alert(\"Il Nome Utente o la Password sono errati oppure il tuo account non e' attivo.\");</script> ";             
	   echo "<script type=\"text/javascript\">window.location = \"http://www.pdluniba.netsons.org\"</script>";

	   }
   }
}
?>