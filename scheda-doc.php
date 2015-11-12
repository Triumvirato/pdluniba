<?php
// Includo la connessione al database
require('functions/config.php');


	$codScheda = $_GET['codScheda'];
	$filtro = $_GET['filtro'];
	
	if( $codScheda=="" || $filtro==""  )
	header('location: index.php');

    
   $query= "SELECT * FROM scheda,$filtro WHERE $filtro.id_scheda=scheda.id_scheda AND scheda.id_scheda='$codScheda'";

    
	/* Select queries return a resultset */
	$result = mysqli_query($link, $query);
	
	if ($result) {
		
		//se ha trovato la riga...
		if( mysqli_num_rows($result) == 1 ){      

	/* associative array */
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
		$titolo = $row['titolo'];  
			
		//Controllo sicurezza
   	$privato = $row['privato'];
      if($privato==1 && !(isset($_SESSION['login']) || isset($_SESSION['login_ammesso']))) {	
		$notifica=1;
		
      }
      else {
		
	$notifica=0;
	
	//carico dati generici nelle variabili	
	$titolo = $row['titolo'];    
   $autore = $row['autore']; 
	$keywords = $row['keywords'];
	$utente = $row['email_utente'];
	$anno = $row['anno'];
	$url = $row['url'];
	$descrizione = $row['descrizione'];
	
	
	 //carico dati generici su XML
	 $scheda = new SimpleXMLElement('<SCHEDA/>');
	
    $scheda->addChild('AUTORE_DOC', "$autore");
    $scheda->addChild('TITOLO_DOC', "$titolo");
    $scheda->addChild('ANNO', "$anno");
    $scheda->addChild('COMMENTO', "$descrizione");
    $scheda->addChild('KEYWORDS', "$keywords");
    $scheda->addChild('SECURITY', "$privato");
    $scheda->addChild('URL', "$url");

	
	if($filtro == "libro"){
		$casaEditrice = $row['casa_editrice'];  
		$edizione = $row['edizione'];
		

		$libro = $scheda->addChild('LIBRO');
    	$libro->addChild('CASAEDITRICE', "$casaEditrice");
	 	$libro->addChild('EDIZIONE', "$edizione"); 
				
		
	}
	else if($filtro == "capitolo"){
		$titoloLibro = $row['titolo_libro']; 
		$curatore = $row['curatore']; 
		$casaEditrice = $row['casa_editrice']; 
		$inizio = $row['inizio']; 
		$fine = $row['fine']; 
		
		
		//carico dati capitolo su XML
		$capitolo = $scheda->addChild('CAPLIBRO');
    	$capitolo->addChild('CASAEDITRICE', "$casaEditrice");
	 	$capitolo->addChild('CURATORI', "$curatore"); 
	 	$capitolo->addChild('PAGFIN', "$fine");
	 	$capitolo->addChild('PAGIN', "$inizio");
	 	$capitolo->addChild('TITOLOLIB', "$titoloLibro");		
		
	}
	else if($filtro == "atto"){
	$nomeConf = $row['nome'];  
	$dataConf = $row['data']; 
	$luogoConf = $row['luogo']; 
	$paginaIniziale = $row['inizio']; 
	$paginaFinale = $row['fine']; 
		
		
		$atto = $scheda->addChild('ATTICONF');
    	$atto->addChild('DATACONF', "$dataConf");
	 	$atto->addChild('LUOGO', "$luogoConf"); 
	 	$atto->addChild('NOMECONF', "$nomeConf");
	 	$atto->addChild('PAGFIN', "$paginaFinale");
	 	$atto->addChild('PAGIN', "$paginaIniziale");
		
	}
	else if($filtro == "rivista"){
		
	$volume = $row['volume'];  
	$numeroR = $row['numero']; 
	$inizio = $row['inizio']; 
	$fine = $row['fine'];  
		
		
		$rivista = $scheda->addChild('ARTRIV');
    	$rivista->addChild('NUMERO', "$numeroR");
	 	$rivista->addChild('VOLUME', "$volume"); 
	 	$rivista->addChild('PAGIN', "$inizio");
	 	$rivista->addChild('PAGFIN', "$fine");
	}

   
   
   
   
// ------------   VISUALIZZO XML -----------------------------------


			//se clicco scarica xml
         if( isset($_GET['xml']) ) {

         header('Content-type: text/xml');
         header('Content-Disposition: attachment; filename="PDL_scheda_'.$codScheda.'.xml"');
        
         print($scheda->asXML());
         
         die(); 
         
         }
   
// ------------  XML -----------------------------------


				
   /* free result set */
   mysqli_free_result($result);
      }
   }
      else {
     /* close connection */
		mysqli_close($link);
 		die("Errore database... oppure non sei autorizzato");
 	   }
   }	

?>

<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<!-- File principale  -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<title><?php echo $titolo; ?> - Private Digital Library</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />


<script type="text/javascript">
<!--
function loadXMLDoc (dname) {
    var xmlDoc;

    try {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open('GET', dname, false);
        xmlhttp.setRequestHeader('Content-Type', 'text/xml');
        xmlhttp.send('');
        xmlDoc = xmlhttp.responseXML;
    } catch (e) {
        try {
            xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
        } catch (e) {
            console.error(e.message);
        }
    }
    return xmlDoc;
}

function segnalazEsistente() {
//Verifica se nel file xml è già presente una segnalazione di modifica su quella scheda	

xmlDoc = loadXMLDoc("temp.xml");

x = xmlDoc.getElementsByTagName("SCHEDA");

var id_scheda= "<?php echo $codScheda ?>";

for(i=0; i<x.length; i++)
{
	var attributo= x[i].getAttribute("ID_SCHEDA");
	
	if (attributo==id_scheda) {
	
		document.getElementById("segnalazione").style.display = 'none';
		document.getElementById('attesa').innerHTML = "Scheda in attesa di revisione...";
		return 1;
	}	
}

}

var filtro= "<?php echo $filtro; ?>";
var notifica= "<?php echo $notifica; ?>";



function mostra_tab() {

if (notifica==1) { //ovvero se la scheda è Privata.

document.getElementById('notifica').style.display = "block";	
document.getElementById('visualizza_schede').style.display = "none";	
document.getElementById('link-tabella').style.display = "none";	
document.getElementById('link-download').style.display = "none";	
}

if (filtro=="libro") {

document.getElementById('print_libro').style.display = "table-row-group";	
}
else if (filtro=='capitolo') {

document.getElementById("print_capitolo").style.display='table-row-group';	
}
if (filtro=="atto") {

document.getElementById('print_atto').style.display = "table-row-group";	
}
if (filtro=="rivista") {

document.getElementById('print_rivista').style.display = "table-row-group";	
}

}
//-->
</script>

</head>

<body>
<!-- body section -->
<div id="intestazione_home">
<?php include 'common/header.php'; ?>
</div>


<div id="contenuto">

<h1><?php echo $titolo; ?></h1>
<table id="visualizza_schede" class="tab_scheda">

<div id="notifica" style="display:none;">
<p>Devi essere registrato per poter visualizzare questo documento.</p>
</div>

<tbody>
		<tr>
			<th>Descrizione</th>
			<td><?php echo $descrizione; ?></td>
		</tr>
		<tr>
			<th>Parole Chiave</th>
			<td><?php echo $keywords; ?></td>
		</tr>
		<tr>
			<th>Autore</th>
			<td><?php echo $autore; ?></td>
		</tr>
		<tr>
			<th>Anno</th>
			<td><?php echo $anno; ?></td>
		</tr>
		<tr>
			<th>Compilato da</th>
			<td><?php echo $utente; ?></td>
		</tr>

	</tbody>



	<tbody id="print_libro" style="display:none" >
		<tr>
			<th>Casa Editrice</th>
			<td><?php echo $casaEditrice; ?></td>
		</tr>
		<tr>
			<th>Edizione</th>
			<td><?php echo $edizione; ?></td>
		</tr>
		
	</tbody>

	<tbody id="print_capitolo" style="display:none;">
		<tr>
			<th>Titolo del libro</th>
			<td><?php echo $titoloLibro; ?></td>
		</tr>
		<tr>
			<th>Curatore</th>
			<td><?php echo $curatore; ?></td>
		</tr>
		<tr>
			<th>Casa editrice</th>
			<td><?php echo $casaEditrice; ?></td>
		</tr>
		<tr>
			<th>Pagina iniziale</th>
			<td><?php echo $inizio; ?></td>
		</tr>
		<tr>
			<th>Pagina finale</th>
			<td><?php echo $fine; ?></td>
		</tr>
	</tbody>
	
	<tbody id="print_atto" style="display:none">
		<tr>
			<th>Nome della conferenza</th>
			<td><?php echo $nomeConf; ?></td>
		</tr>
		<tr>
			<th>Luogo conferenza</th>
			<td><?php echo $luogoConf; ?></td>
		</tr>
		<tr>
			<th>Data conferenza</th>
			<td><?php echo $dataConf; ?></td>
		</tr>
		<tr>
			<th>Pagina iniziale</th>
			<td><?php echo $paginaIniziale; ?></td>
		</tr>
		<tr>
			<th>Pagina finale</th>
			<td><?php echo $paginaFinale; ?></td>
		</tr>
	</tbody>

	<tbody id="print_rivista" style="display:none">
		<tr>
			<th>Volume</th>
			<td><?php echo $volume; ?></td>
		</tr>
		<tr>
			<th>Numero rivista</th>
			<td><?php echo $numeroR; ?></td>
		</tr>
		<tr>
			<th>Pagina iniziale</th>
			<td><?php echo $inizio; ?></td>
		</tr>
		<tr>
			<th>Pagina finale</th>
			<td><?php echo $fine; ?></td>
		</tr>
	</tbody>
	
</table>


<p id="link-download"><a href="<?php echo $url; ?>">Scarica</a> | <?php echo '<a href="scheda-doc.php?codScheda='.$codScheda.'&filtro='.$filtro.'&xml=si">Scarica XML</a>';?></p>

<p id="link-tabella" style="text-align: right;"> <?php if(isset($emailUtente) && $utente==$emailUtente){ echo '<img src="images/edit.png" alt="Modifica" /> <a href="modifica-scheda.php?f='.$filtro.'&s='.$codScheda.'" >Modifica</a>  '; } ?></p>

<p id="segnalazione" style="text-align: right;"> <?php if( isset($emailUtente) && $utente!=$emailUtente){ echo "<img src=\"images/alert.png\" alt=\"Segnala modifica\" /> <a href=\"segnala-modifica.php?f=$filtro&u=$utente&s=$codScheda\" >Segnala una modifica</a>"; } ?></p>

<p id="attesa" style="text-align: right; color: red;"></p>

<!-- script che richiama la funzione definita sopra-->
<script type="text/javascript">
mostra_tab();
segnalazEsistente(); 
</script>


</div>

<div id="footer">
<?php include 'common/footer.html'; ?>
</div>

</body>


</html>
	
