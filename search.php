<?php
include "functions/config.php";

$key = $_GET['key'];

$filtro = $_GET['filtro'];


$query = "SELECT scheda.id_scheda, scheda.titolo, scheda.descrizione FROM scheda, $filtro WHERE scheda.id_scheda=$filtro.id_scheda AND titolo like '%$key%'";

$result = mysqli_query($link, $query);

$trovato = mysqli_num_rows($result);


?>


<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<!-- File principale  -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<title>Private Digital Library - Search</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />


</head>

<body>
<!-- Intestazione -->
<div id="intestazione_home">
	<?php include 'common/header.php'; ?>
</div>


<!-- Inizio contenuto del sito  -->
<div id="contenuto">
		
			<div id="header_risultati_ricerca" >
			<p><a href="index.php"><img src="images/logo1.png" alt="Cerca con PDL" style="margin:5px;"/></a>
			
			<p><?php if($key!=""){ echo "Hai cercato: ".$key." | ";} ?>Categoria: <?php echo $filtro; ?></p>
			
			</div>
						
			<?php 
			
			if( $trovato > 0){
	
				while( $row=mysqli_fetch_array($result) ){
					echo "<ul id=\"result\"><li><a href=\"scheda-doc.php?codScheda=$row[id_scheda]&filtro=$filtro\"><strong>$row[titolo]</strong></a><br />$row[descrizione]<br /><em>Tipo documento: $filtro</em></li></ul>";
    		}  
			}else
				echo "<h4>Nessun risultato trovato</h4>";

			?>
			</div> 
<!-- Fine contenuto  -->


<!-- Menu basso  -->
<div id="footer">

<?php include 'common/footer.html'; ?>

</div>

</body>


</html>