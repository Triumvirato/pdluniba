<?php
// Includo la connessione al database
require('functions/config.php');

   //Se non è stata definita la variabile, manda l'utente alla pag di registrazione
	 if( !isset($_SESSION['login']) && !isset($_SESSION['login_ammesso']) ) {
    header('Location: registrazione.php');
    exit;
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
	 if( $tipoUtente == "Responsabile" )   /* $tipoUtente è definita in /common/header.php */
		include 'common/menu_sx.php'; 
	 else if( $tipoUtente == "Ammesso" )
   	include 'common/menu_user.php'; 
		?>

		</div>
		
		<div id="contenuto_right">
		<h1>Area Riservata</h1>

		
		<p>Benvenuto nell'Area riservata di Private digital library. Utilizza il menù laterale per accedere a tutte le funzionalità del sistema.</p>

		</div>

</div>

<div id="footer">
<?php include 'common/footer.html'; ?>
</div>

</body>


</html>