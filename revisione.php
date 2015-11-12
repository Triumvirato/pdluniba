<?php
// Includo la connessione al database
require('functions/config.php');


	$codScheda = $_GET['s'];
	$filtro = $_GET['f'];

	
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
	
	if($filtro == "libro"){
		$casaEditrice = $row['casa_editrice'];  
		$edizione = $row['edizione'];
		
				
		
	}
	else if($filtro == "capitolo"){
		$titoloLibro = $row['titolo_libro']; 
		$curatore = $row['curatore']; 
		$casaEditrice = $row['casa_editrice']; 
		$inizio = $row['inizio']; 
		$fine = $row['fine']; 
		
			
		
	}
	else if($filtro == "atto"){
	$nomeConf = $row['nome'];  
	$dataConf = $row['data']; 
	$luogoConf = $row['luogo']; 
	$paginaIniziale = $row['inizio']; 
	$paginaFinale = $row['fine']; 
	
		
	}
	else if($filtro == "rivista"){
		
	$volume = $row['volume'];  
	$numeroR = $row['numero']; 
	$inizio = $row['inizio']; 
	$fine = $row['fine'];  
		
	
	}


				
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

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript">
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

xmlDoc = loadXMLDoc("temp.xml");
x = xmlDoc.getElementsByTagName("SCHEDA");

var id_scheda= "<?php echo $codScheda ?>";
var i=0;



while( x[i].getAttribute("ID_SCHEDA")!=id_scheda ){

i++;

}

var tipo=x[i].getAttribute("TIPO");

var titolo = x[i].childNodes[1].textContent;   
var descrizione= x[i].childNodes[7].textContent;;
var keywords= x[i].childNodes[9].textContent;
var autore= x[i].childNodes[3].textContent;
var anno= x[i].childNodes[5].textContent;
var url= x[i].childNodes[13].textContent;
var utente= x[i].getAttribute("NOME_UTENTE");


if (tipo=="libro") {
var casaEditrice= x[i].childNodes[15].childNodes[1].textContent;
var edizione= x[i].childNodes[15].childNodes[3].textContent;

$(document).ready(function() {
      $("#driver").click(function(event){
          $.post( 
             "approvazione.php",
             { 	codScheda: id_scheda,
			    titolo: titolo,
				descrizione: descrizione,	
				keywords: keywords,
				autore: autore,
				anno: anno,
				url: url,
				utente: utente,
				
				casaEditrice: casaEditrice,
				edizione: edizione,
				
			   },
             function(data) {
                $('#stage').html(data);
             }

          );
      });
   });

}
else if (tipo=="capitolo") {
var titoloLibro= x[i].childNodes[15].childNodes[9].textContent;
var curatore= x[i].childNodes[15].childNodes[3].textContent;
var casaEditriceC= x[i].childNodes[15].childNodes[1].textContent;
var inizio= x[i].childNodes[15].childNodes[5].textContent;
var fine= x[i].childNodes[15].childNodes[7].textContent;

$(document).ready(function() {
      $("#driver").click(function(event){
          $.post( 
             "approvazione.php",
             { 	codScheda: id_scheda,
				titolo: titolo,
				descrizione: descrizione,	
				keywords: keywords,
				autore: autore,
				anno: anno,
				url: url,
				utente: utente,
				
				titoloLibro: titoloLibro,
				curatore: curatore,
				casaEditriceC: casaEditriceC,
				inizio: inizio,
				fine: fine
				
			   },
             function(data) {
                $('#stage').html(data);
             }

          );
      });
   });

}
else if (tipo=="atto") {

var nomeConf= x[i].childNodes[15].childNodes[5].textContent;
var dataConf= x[i].childNodes[15].childNodes[1].textContent;
var luogoConf= x[i].childNodes[15].childNodes[3].textContent;
var paginaIniziale= x[i].childNodes[15].childNodes[9].textContent;
var paginaFinale= x[i].childNodes[15].childNodes[7].textContent;

$(document).ready(function() {
      $("#driver").click(function(event){
          $.post( 
             "approvazione.php",
             { 	codScheda: id_scheda,
			    titolo: titolo,
				descrizione: descrizione,	
				keywords: keywords,
				autore: autore,
				anno: anno,
				url: url,
				utente: utente,
				
				nomeConf: nomeConf,
				dataConf: dataConf,
				luogoConf: luogoConf,
				paginaIniziale: paginaIniziale,
				paginaFinale: paginaFinale
				
			   },
             function(data) {
                $('#stage').html(data);
             }

          );
      });
   });

}

else if (tipo=="rivista") {
var volumeR= x[i].childNodes[15].childNodes[7].textContent;
var numeroR= x[i].childNodes[15].childNodes[1].textContent;
var inizioR= x[i].childNodes[15].childNodes[5].textContent;
var fineR= x[i].childNodes[15].childNodes[3].textContent;

$(document).ready(function() {
      $("#driver").click(function(event){
          $.post( 
             "approvazione.php",
             { 	codScheda: id_scheda,
			    titolo: titolo,
				descrizione: descrizione,	
				keywords: keywords,
				autore: autore,
				anno: anno,
				url: url,
				utente: utente,
				volumeR: volumeR,
				numeroR: numeroR,
				inizioR: inizioR,
				fineR: fineR
				
			   },
             function(data) {
                $('#stage').html(data);
             }

          );
      });
   });
}


//------ Ajax e jQuery -------
/*
$(document).ready(function() {
      $("#driver").click(function(event){
          $.post( 
             "approvazione.php",
             { 	titolo: titolo,
				descrizione: descrizione,	
				keywords: keywords,
				autore: autore,
				anno: anno,
				url: url,
				utente: utente,
				
			   },
             function(data) {
                $('#stage').html(data);
             }

          );
      });
   });
   */
//----------------------------
   

var filtro= "<?php echo $filtro; ?>";
var notifica= "<?php echo $notifica; ?>";


function mostra_tab() {

if (filtro=="libro") {

document.getElementById('print_libro').style.display = "table-row-group";	
document.getElementById('print_libro2').style.display = "table-row-group";	
}
else if (filtro=="capitolo") {

document.getElementById("print_capitolo").style.display='table-row-group';
document.getElementById("print_capitolo2").style.display='table-row-group';	
}
if (filtro=="atto") {

document.getElementById('print_atto').style.display = "table-row-group";	
document.getElementById('print_atto2').style.display = "table-row-group";
}
if (filtro=="rivista") {

document.getElementById('print_rivista').style.display = "table-row-group";
document.getElementById('print_rivista2').style.display = "table-row-group";	
}

}


</script>



</head>

<body>
<!-- body section -->
<div id="intestazione_home">
<?php include 'common/header.php'; ?>
</div>


<div id="contenuto">

<h1>Segnalazioni</h1>

<h4>Scheda originale</h4>

<table id="visualizza_schede" class="tab_scheda">
<tbody>
		<tr>
			<th>Titolo</th>
			<td><?php echo $titolo; ?></td>
		</tr>
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
			<th>URL</th>
			<td><?php echo $url; ?></td>
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


<!-- Tabella segnalazioni -->


<h4>Scheda segnalata</h4>

<table id="visualizza_schede2" class="tab_scheda">
<tbody>
		<tr>
			<th>Titolo</th>
			<td><script>document.write(titolo);</script></td>
		</tr>
		<tr>
			<th>Descrizione</th>
			<td><script>document.write(descrizione);</script></td>
		</tr>
		<tr>
			<th>Parole Chiave</th>
			<td><script>document.write(keywords);</script></td>
		</tr>
		<tr>
			<th>Autore</th>
			<td><script>document.write(autore);</script></td>
		</tr>
		<tr>
			<th>Anno</th>
			<td><script>document.write(anno);</script></td>
		</tr>
		<tr>
			<th>Compilato da</th>
			<td><script>document.write(utente);</script></td>
		</tr>
		<tr>
			<th>URL</th>
			<td><script>document.write(url);</script></td>
		</tr>

	</tbody>



	<tbody id="print_libro2" style="display:none" >
		<tr>
			<th>Casa Editrice</th>
			<td><script>document.write(casaEditrice);</script></td>
		</tr>
		<tr>
			<th>Edizione</th>
			<td><script>document.write(edizione);</script></td>
		</tr>
		
	</tbody>

	<tbody id="print_capitolo2" style="display:none;">
		<tr>
			<th>Titolo del libro</th>
			<td><script>document.write(titoloLibro);</script></td>
		</tr>
		<tr>
			<th>Curatore</th>
			<td><script>document.write(curatore);</script></td>
		</tr>
		<tr>
			<th>Casa editrice</th>
			<td><script>document.write(casaEditriceC);</script></td>
		</tr>
		<tr>
			<th>Pagina iniziale</th>
			<td><script>document.write(inizio);</script></td>
		</tr>
		<tr>
			<th>Pagina finale</th>
			<td><script>document.write(fine);</script></td>
		</tr>
	</tbody>
	
	<tbody id="print_atto2" style="display:none">
		<tr>
			<th>Nome della conferenza</th>
			<td><script>document.write(nomeConf);</script></td>
		</tr>
		<tr>
			<th>Luogo conferenza</th>
			<td><script>document.write(luogoConf);</script></td>
		</tr>
		<tr>
			<th>Data conferenza</th>
			<td><script>document.write(dataConf);</script></td>
		</tr>
		<tr>
			<th>Pagina iniziale</th>
			<td><script>document.write(paginaIniziale);</script></td>
		</tr>
		<tr>
			<th>Pagina finale</th>
			<td><script>document.write(paginaFinale);</script></td>
		</tr>
	</tbody>

	<tbody id="print_rivista2" style="display:none">
		<tr>
			<th>Volume</th>
			<td><script>document.write(volumeR);</script></td>
		</tr>
		<tr>
			<th>Numero rivista</th>
			<td><script>document.write(numeroR);</script></td>
		</tr>
		<tr>
			<th>Pagina iniziale</th>
			<td><script>document.write(inizioR);</script></td>
		</tr>
		<tr>
			<th>Pagina finale</th>
			<td><script>document.write(fineR);</script></td>
		</tr>
	</tbody>
	
</table>


<!-- script che richiama la funzione definita sopra-->
<script type="text/javascript">
mostra_tab();
</script>


   <div id="stage">
    
   </div>
   <br/>
   <input type="button" id="driver" value="APPROVA SCHEDA" />


</div>

<div id="footer">
<?php include 'common/footer.html'; ?>
</div>

</body>


</html>
	
