<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
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
<!-- Intestazione -->
<div id="intestazione_home">
	<?php include 'common/header.php'; ?>
</div>


<!-- Inizio contenuto del sito  -->
<div id="contenuto">


		<div id="ricerca_home">
		
		<form id="cerca" action="search.php" method="get" >

		<p><img src="images/logo1.png" alt="Cerca con PDL" style="margin:20px;"/></p>
		<p><input type="text" name="key" id="search" class="barra" /></p>
		
		<!-- Checkbox filtri di ricerca -->
		<p>
		<input type="radio" name="filtro" value="libro" checked="checked" />Libri
		<input type="radio" name="filtro" value="atto" />Atti di Conferenza
		<input type="radio" name="filtro" value="doctecnico" />Rapporti Tecnici
		<input type="radio" name="filtro" value="rivista" />Riviste
		<input type="radio" name="filtro" value="capitolo" />Capitoli Di Libro
		</p>
		
		<p><input type="submit" value="Cerca con PDL" class="button_ricerca" /></p>
	
	   <p><img src="images/home.png" alt="immagine home page" style="margin-top: 20px; align:center; margin-left:20px;"/></p>
	   
	   </form>

		</div>


 
</div>



<!-- Fine contenuto  -->


<!-- Menu basso  -->
<div id="footer">

<?php include 'common/footer.html'; ?>

</div>

</body>


</html>