<?php
// Includo la connessione al database
require('functions/config.php');

   //Se non è stata definita la variabile, manda l'utente alla pag di registrazione
	 if( !isset($_SESSION['login']) && !isset($_SESSION['login_ammesso']) ) {
    header('Location: registrazione.php');
    exit;
	}

	$codScheda = $_GET['s'];
	$filtro = $_GET['f'];	
	
	
	   $query= "SELECT * FROM scheda,$filtro WHERE $filtro.id_scheda=scheda.id_scheda AND scheda.id_scheda='$codScheda'";

    
	/* Select queries return a resultset */
	$result = mysqli_query($link, $query);
	
	if ($result) {
		
		//se ha trovato la riga...
		if( mysqli_num_rows($result) == 1 ){      

	/* associative array */
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

	
	//carico dati generici nelle variabili	
	$titolo = $row['titolo'];    
   $autore = $row['autore']; 
	$keywords = $row['keywords'];
	$utente = $row['email_utente'];
	$anno = $row['anno'];
	$url = $row['url'];
	$descrizione = $row['descrizione'];
	$privato = $row['privato'];


	
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
 	   
//------------------------------------------------------- INSERIMENTO -------------------------------------------------------------
	
	
	// Se il modulo viene inviato...
if(isset($_POST['Agg_libro']))
{

    // Dati Inviati dal modulo
   $titolo = (isset($_POST['Titolo_l'])) ? trim($_POST['Titolo_l']) : '';    
   $autore = (isset($_POST['Autore_l'])) ? trim($_POST['Autore_l']) : ''; 
	$keywords = (isset($_POST['Keyword_l'])) ? trim($_POST['Keyword_l']) : '';
	$anno = (isset($_POST['Anno_pub_l'])) ? trim($_POST['Anno_pub_l']) : '';
	$url = (isset($_POST['Url_l'])) ? trim($_POST['Url_l']) : '';
	$descrizione = (isset($_POST['Descrizione_l'])) ? trim($_POST['Descrizione_l']) : '';
		
	$casaEditrice = (isset($_POST['Casa'])) ? trim($_POST['Casa']) : '';  
	$edizione = (isset($_POST['Edizione'])) ? trim($_POST['Edizione']) : '';  

    
    $doc = new DOMDocument();

// Setting formatOutput to true will turn on xml formating so it looks nicely
// however if you load an already made xml you need to strip blank nodes if you want this to work
$doc->load( 'temp.xml', LIBXML_NOBLANKS);
$doc->formatOutput = true;

// Get the root element 
$root = $doc->documentElement;

// Create new  element
$scheda = $doc->createElement("SCHEDA");
$scheda->setAttribute("ID_SCHEDA","$codScheda");
$scheda->setAttribute("TIPO","$filtro");
$scheda->setAttribute("NOME_UTENTE","$utente");

// Append new link to root element
$root->appendChild($scheda);

// Create and add id to new  element

$scheda->appendChild( $doc->createElement("TITOLO_DOC","$titolo") );
$scheda->appendChild( $doc->createElement("AUTORE_DOC","$autore") );
$scheda->appendChild( $doc->createElement("ANNO","$anno") );
$scheda->appendChild( $doc->createElement("COMMENTO","$descrizione") );
$scheda->appendChild( $doc->createElement("KEYWORDS","$keywords") );
$scheda->appendChild( $doc->createElement("SECURITY","$privato") );
$scheda->appendChild( $doc->createElement("URL","$url") );

$libro=$scheda->appendChild( $doc->createElement("LIBRO") );
$libro->appendChild( $doc->createElement("EDIZIONE","$edizione") );
$libro->appendChild( $doc->createElement("CASAEDITRICE","$casaEditrice") );



print $doc->save('temp.xml');

echo "<script>alert(\"Segnalato con successo!\");
      window.location='area_riservata.php';
      </script> "; 
			           
}

else if(isset($_POST['Agg_atto']))
{


    // Dati Inviati dal modulo
   $titolo = (isset($_POST['Titolo_a'])) ? trim($_POST['Titolo_a']) : '';    
   $autore = (isset($_POST['Autore_a'])) ? trim($_POST['Autore_a']) : ''; 
	$keywords = (isset($_POST['Keyword_a'])) ? trim($_POST['Keyword_a']) : '';
	$anno = (isset($_POST['Anno_pub_a'])) ? trim($_POST['Anno_pub_a']) : '';
	$url = (isset($_POST['Url_a'])) ? trim($_POST['Url_a']) : '';
	$descrizione = (isset($_POST['Descrizione_a'])) ? trim($_POST['Descrizione_a']) : '';
		
	$nomeConf = (isset($_POST['Nome_conf'])) ? trim($_POST['Nome_conf']) : '';  
	$dataConf = (isset($_POST['Data_conf'])) ? trim($_POST['Data_conf']) : ''; 
	$luogoConf = (isset($_POST['Luogo_conf'])) ? trim($_POST['Luogo_conf']) : ''; 
	$paginaIniziale = (isset($_POST['Num_i_atto'])) ? trim($_POST['Num_i_atto']) : ''; 
	$paginaFinale = (isset($_POST['Num_f_atto'])) ? trim($_POST['Num_f_atto']) : '';   

   
	    $doc = new DOMDocument();

// Setting formatOutput to true will turn on xml formating so it looks nicely
// however if you load an already made xml you need to strip blank nodes if you want this to work
$doc->load( 'temp.xml', LIBXML_NOBLANKS);
$doc->formatOutput = true;

// Get the root element 
$root = $doc->documentElement;

// Create new  element
$scheda = $doc->createElement("SCHEDA");
$scheda->setAttribute("ID_SCHEDA","$codScheda");
$scheda->setAttribute("TIPO","$filtro");
$scheda->setAttribute("NOME_UTENTE","$utente");

// Append new link to root element
$root->appendChild($scheda);

// Create and add id to new  element

$scheda->appendChild( $doc->createElement("TITOLO_DOC","$titolo") );
$scheda->appendChild( $doc->createElement("AUTORE_DOC","$autore") );
$scheda->appendChild( $doc->createElement("ANNO","$anno") );
$scheda->appendChild( $doc->createElement("COMMENTO","$descrizione") );
$scheda->appendChild( $doc->createElement("KEYWORDS","$keywords") );
$scheda->appendChild( $doc->createElement("SECURITY","$privato") );
$scheda->appendChild( $doc->createElement("URL","$url") );

$atto=$scheda->appendChild( $doc->createElement("ATTICONF") );
$atto->appendChild( $doc->createElement("DATACONF","$dataConf") );
$atto->appendChild( $doc->createElement("LUOGO","$luogoConf") );
$atto->appendChild( $doc->createElement("NOMECONF","$nomeConf") );
$atto->appendChild( $doc->createElement("PAGFIN","$paginaFinale") );
$atto->appendChild( $doc->createElement("PAGIN","$paginaIniziale") );



print $doc->save('temp.xml');

echo "<script>alert(\"Segnalato con successo!\");
      window.location='area_riservata.php';
      </script> ";
      
  
			           
}

else if(isset($_POST['Agg_capitolo']))
{


    // Dati Inviati dal modulo
   $titolo = (isset($_POST['Titolo_c'])) ? trim($_POST['Titolo_c']) : '';    
   $autore = (isset($_POST['Autore_c'])) ? trim($_POST['Autore_c']) : ''; 
	$keywords = (isset($_POST['Keyword_c'])) ? trim($_POST['Keyword_c']) : '';
	$anno = (isset($_POST['Anno_pub_c'])) ? trim($_POST['Anno_pub_c']) : '';
	$url = (isset($_POST['Url_c'])) ? trim($_POST['Url_c']) : '';
	$descrizione = (isset($_POST['Descrizione_c'])) ? trim($_POST['Descrizione_c']) : '';
		
	$titoloCap = (isset($_POST['Titolo_cap'])) ? trim($_POST['Titolo_cap']) : '';  
	$nomeCur = (isset($_POST['Nome_cur'])) ? trim($_POST['Nome_cur']) : ''; 
	$casaEditrice = (isset($_POST['Casa2'])) ? trim($_POST['Casa2']) : ''; 
	$paginaIniziale = (isset($_POST['Num_i_cap'])) ? trim($_POST['Num_i_cap']) : ''; 
	$paginaFinale = (isset($_POST['Num_f_cap'])) ? trim($_POST['Num_f_cap']) : '';   

   
	    $doc = new DOMDocument();

// Setting formatOutput to true will turn on xml formating so it looks nicely
// however if you load an already made xml you need to strip blank nodes if you want this to work
$doc->load( 'temp.xml', LIBXML_NOBLANKS);
$doc->formatOutput = true;

// Get the root element 
$root = $doc->documentElement;

// Create new  element
$scheda = $doc->createElement("SCHEDA");
$scheda->setAttribute("ID_SCHEDA","$codScheda");
$scheda->setAttribute("TIPO","$filtro");
$scheda->setAttribute("NOME_UTENTE","$utente");

// Append new link to root element
$root->appendChild($scheda);

// Create and add id to new  element

$scheda->appendChild( $doc->createElement("TITOLO_DOC","$titolo") );
$scheda->appendChild( $doc->createElement("AUTORE_DOC","$autore") );
$scheda->appendChild( $doc->createElement("ANNO","$anno") );
$scheda->appendChild( $doc->createElement("COMMENTO","$descrizione") );
$scheda->appendChild( $doc->createElement("KEYWORDS","$keywords") );
$scheda->appendChild( $doc->createElement("SECURITY","$privato") );
$scheda->appendChild( $doc->createElement("URL","$url") );

$capitolo=$scheda->appendChild( $doc->createElement("CAPLIBRO") );
$capitolo->appendChild( $doc->createElement("CASAEDITRICE","$casaEditrice") );
$capitolo->appendChild( $doc->createElement("CURATORI","$nomeCur") );
$capitolo->appendChild( $doc->createElement("PAGFIN","$paginaFinale") );
$capitolo->appendChild( $doc->createElement("PAGIN","$paginaIniziale") );
$capitolo->appendChild( $doc->createElement("TITOLOLIB","$titoloCap") );



print $doc->save('temp.xml');

echo "<script>alert(\"Segnalato con successo!\");
      window.location='area_riservata.php';
      </script> ";
			           
}
else if(isset($_POST['Agg_articolo']))
{


    // Dati Inviati dal modulo
   $titolo = (isset($_POST['Titolo_r'])) ? trim($_POST['Titolo_r']) : '';    
   $autore = (isset($_POST['Autore_r'])) ? trim($_POST['Autore_r']) : ''; 
	$keywords = (isset($_POST['Keyword_r'])) ? trim($_POST['Keyword_r']) : '';
	$anno = (isset($_POST['Anno_pub_r'])) ? trim($_POST['Anno_pub_r']) : '';
	$url = (isset($_POST['Url_r'])) ? trim($_POST['Url_r']) : '';
	$descrizione = (isset($_POST['Descrizione_r'])) ? trim($_POST['Descrizione_r']) : '';
		
	$volume = (isset($_POST['Volume_riv'])) ? trim($_POST['Volume_riv']) : '';  
	$numeroRivista = (isset($_POST['Numero_riv'])) ? trim($_POST['Numero_riv']) : ''; 
	$paginaIniziale = (isset($_POST['Num_i_riv'])) ? trim($_POST['Num_i_riv']) : ''; 
	$paginaFinale = (isset($_POST['Num_f_riv'])) ? trim($_POST['Num_f_riv']) : '';   

   
	    $doc = new DOMDocument();

// Setting formatOutput to true will turn on xml formating so it looks nicely
// however if you load an already made xml you need to strip blank nodes if you want this to work
$doc->load( 'temp.xml', LIBXML_NOBLANKS);
$doc->formatOutput = true;

// Get the root element 
$root = $doc->documentElement;

// Create new  element
$scheda = $doc->createElement("SCHEDA");
$scheda->setAttribute("ID_SCHEDA","$codScheda");
$scheda->setAttribute("TIPO","$filtro");
$scheda->setAttribute("NOME_UTENTE","$utente");

// Append new link to root element
$root->appendChild($scheda);

// Create and add id to new  element

$scheda->appendChild( $doc->createElement("TITOLO_DOC","$titolo") );
$scheda->appendChild( $doc->createElement("AUTORE_DOC","$autore") );
$scheda->appendChild( $doc->createElement("ANNO","$anno") );
$scheda->appendChild( $doc->createElement("COMMENTO","$descrizione") );
$scheda->appendChild( $doc->createElement("KEYWORDS","$keywords") );
$scheda->appendChild( $doc->createElement("SECURITY","$privato") );
$scheda->appendChild( $doc->createElement("URL","$url") );

$rivista=$scheda->appendChild( $doc->createElement("ARTRIV") );
$rivista->appendChild( $doc->createElement("NUMERO","$numeroRivista") );
$rivista->appendChild( $doc->createElement("PAGFIN","$paginaFinale") );
$rivista->appendChild( $doc->createElement("PAGIN","$paginaIniziale") );
$rivista->appendChild( $doc->createElement("VOLUME","$volume") );



print $doc->save('temp.xml');

echo "<script>alert(\"Segnalato con successo!\");
      window.location='area_riservata.php';
      </script> ";
			           
}
else if(isset($_POST['Agg_doc']))
{


    // Dati Inviati dal modulo
   $titolo = (isset($_POST['Titolo_d'])) ? trim($_POST['Titolo_d']) : '';    
   $autore = (isset($_POST['Autore_d'])) ? trim($_POST['Autore_d']) : ''; 
	$keywords = (isset($_POST['Keyword_d'])) ? trim($_POST['Keyword_d']) : '';
	$anno = (isset($_POST['Anno_pub_d'])) ? trim($_POST['Anno_pub_d']) : '';
	$url = (isset($_POST['Url_d'])) ? trim($_POST['Url_d']) : '';
	$descrizione = (isset($_POST['Descrizione_d'])) ? trim($_POST['Descrizione_d']) : '';

   	    $doc = new DOMDocument();

// Setting formatOutput to true will turn on xml formating so it looks nicely
// however if you load an already made xml you need to strip blank nodes if you want this to work
$doc->load( 'temp.xml', LIBXML_NOBLANKS);
$doc->formatOutput = true;

// Get the root element 
$root = $doc->documentElement;

// Create new  element
$scheda = $doc->createElement("SCHEDA");
$scheda->setAttribute("ID_SCHEDA","$codScheda");
$scheda->setAttribute("TIPO","$filtro");
$scheda->setAttribute("NOME_UTENTE","$utente");

// Append new link to root element
$root->appendChild($scheda);

// Create and add id to new  element

$scheda->appendChild( $doc->createElement("TITOLO_DOC","$titolo") );
$scheda->appendChild( $doc->createElement("AUTORE_DOC","$autore") );
$scheda->appendChild( $doc->createElement("ANNO","$anno") );
$scheda->appendChild( $doc->createElement("COMMENTO","$descrizione") );
$scheda->appendChild( $doc->createElement("KEYWORDS","$keywords") );
$scheda->appendChild( $doc->createElement("SECURITY","$privato") );
$scheda->appendChild( $doc->createElement("URL","$url") );

print $doc->save('temp.xml');

echo "<script>alert(\"Segnalato con successo!\");
      window.location='area_riservata.php';
      </script> ";
			           
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


<script type="text/javascript">
<!--

//variabili di controllo
		var flag_titolo=1;
		var flag_autore=1;
		var flag_keyword=1;
		var flag_anno_pub=1;
		var flag_url=1;
		var flag_descrizione=1;
//flag per dinamici		
		var flag_casa=1;
		var flag_edizione=1;
		var flag_nome_conf=1;
		var flag_luogo_conf=1;
		var flag_data_conf=1;
		var flag_num_i_atto=1;
		var flag_num_f_atto=1;
		var flag_titolo_cap=1;
		var flag_nome_cur=1;
		var flag_casa2=1;
		var flag_num_i_cap=1;
		var flag_num_f_cap=1;
		var flag_volume_riv=1;
		var flag_numero_riv=1;
		var flag_num_i_riv=1;
		var flag_num_f_riv=1;
		
// controllo sul submit

		function controlloCondizioniLibro(agr)
{
		
		if(flag_titolo==0 || flag_autore==0 || flag_keyword==0 || flag_anno_pub==0 || flag_url==0 || flag_descrizione==0 || flag_casa==0 || flag_edizione==0)
		{
		alert("Completa tutti i campi.");
		return false;
		}
		else
		return true;
}

		function controlloCondizioniRivista(agr)
{
		
		if(flag_titolo==0 || flag_autore==0 || flag_keyword==0 || flag_anno_pub==0 || flag_url==0 || flag_descrizione==0 || flag_volume_riv==0 || flag_numero_riv==0 || flag_num_i_riv==0 || flag_num_f_riv==0)
		{
		alert("Completa tutti i campi.");
		return false;
		}
		else
		return true;
}

		function controlloCondizioniAtto(agr)
{
		
		if(flag_titolo==0 || flag_autore==0 || flag_keyword==0 || flag_anno_pub==0 || flag_url==0 || flag_descrizione==0 || flag_nome_conf==0 || flag_luogo_conf==0 || flag_data_conf==0 || flag_num_i_atto==0 || flag_num_f_atto==0)
		{
		alert("Completa tutti i campi.");
		return false;
		}
		else
		return true;
}

		function controlloCondizioniCapitolo(agr)
{
		
		if(flag_titolo==0 || flag_autore==0 || flag_keyword==0 || flag_anno_pub==0 || flag_url==0 || flag_descrizione==0 || flag_titolo_cap==0 || flag_nome_cur==0 || flag_casa2==0 || flag_num_i_cap==0 || flag_num_f_cap==0 )
		{
		alert("Completa tutti i campi.");
		return false;
		}
		else
		return true;
}

		function controlloCondizioniDocTecnico(agr)
{
		
		if(flag_titolo==0 || flag_autore==0 || flag_keyword==0 || flag_anno_pub==0 || flag_url==0 || flag_descrizione==0)
		{
		alert("Completa tutti i campi.");
		return false;
		}
		else
		return true;
}


		
		
	//elimina eventuali spazi inseriti prima e dopo il testo
		function trim(str)
		{
 		return str.replace(/^\s+|\s+$/g,"");
		}
		
		//-------------------------------------- controllo titolo
		function controlloTitolo(tipodoc)
{
		if(tipodoc==1){
    	titolo=trim(document.getElementById("Titolo_l").value);  //qui ce la soluzione
    	}
    	if(tipodoc==2){
    	titolo=trim(document.getElementById("Titolo_r").value);  //qui ce la soluzione
    	}
    	if(tipodoc==3){
    	titolo=trim(document.getElementById("Titolo_a").value);  //qui ce la soluzione
    	}
		if(tipodoc==4){
    	titolo=trim(document.getElementById("Titolo_d").value);  //qui ce la soluzione
    	}
		if(tipodoc==5){
    	titolo=trim(document.getElementById("Titolo_c").value);  //qui ce la soluzione
    	}
 
 		if (!(titolo.length<1 || titolo==""))
 		{
  		flag_titolo=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  
 		if (titolo.length<1 || titolo=="" )
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito alcun testo nel campo 'titolo'";
  		flag_titolo=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo autore
		function controlloAutore(tipodoc)
{
 		if(tipodoc==1){
    	autore=trim(document.getElementById("Autore_l").value);  //qui ce la soluzione
    	}
    	if(tipodoc==2){
    	autore=trim(document.getElementById("Autore_r").value);  //qui ce la soluzione
    	}
    	if(tipodoc==3){
    	autore=trim(document.getElementById("Autore_a").value);  //qui ce la soluzione
    	}
		if(tipodoc==4){
    	autore=trim(document.getElementById("Autore_d").value);  //qui ce la soluzione
    	}
		if(tipodoc==5){
    	autore=trim(document.getElementById("Autore_c").value);  //qui ce la soluzione
    	}
 
 		if (!(autore.length<1 || autore==""))
 		{
  		flag_autore=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  
 		if (autore.length<1 || autore=="" )
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito alcun testo nel campo 'autore'";
  		flag_autore=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo keyword
		function controlloKeyword(tipodoc)
{
 		if(tipodoc==1){
    	keyword=trim(document.getElementById("Keyword_l").value);  //qui ce la soluzione
    	}
    	if(tipodoc==2){
    	keyword=trim(document.getElementById("Keyword_r").value);  //qui ce la soluzione
    	}
    	if(tipodoc==3){
    	keyword=trim(document.getElementById("Keyword_a").value);  //qui ce la soluzione
    	}
		if(tipodoc==4){
    	keyword=trim(document.getElementById("Keyword_d").value);  //qui ce la soluzione
    	}
		if(tipodoc==5){
    	keyword=trim(document.getElementById("Keyword_c").value);  //qui ce la soluzione
    	}
 
 		if (!(keyword.length<1 || keyword==""))
 		{
  		flag_keyword=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  
 		if (keyword.length<1 || keyword=="" )
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito alcun testo nel campo 'keyword'";
  		flag_keyword=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo anno_pub
		function controlloAnno_pub(tipodoc)
{
 		if(tipodoc==1){
    	anno_pub=trim(document.getElementById("Anno_pub_l").value);  //qui ce la soluzione
    	}
    	if(tipodoc==2){
    	anno_pub=trim(document.getElementById("Anno_pub_r").value);  //qui ce la soluzione
    	}
    	if(tipodoc==3){
    	anno_pub=trim(document.getElementById("Anno_pub_a").value);  //qui ce la soluzione
    	}
		if(tipodoc==4){
    	anno_pub=trim(document.getElementById("Anno_pub_d").value);  //qui ce la soluzione
    	}
		if(tipodoc==5){
    	anno_pub=trim(document.getElementById("Anno_pub_c").value);  //qui ce la soluzione
    	}
 
 		if ((!isNaN(anno_pub)) && (parseInt(anno_pub) == anno_pub))
 		{
  		flag_anno_pub=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  		else
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito alcun testo o esso e' non valido nel campo 'anno di pubblicazione'";
  		flag_anno_pub=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo url
		function controlloUrl(tipodoc)
{
 		if(tipodoc==1){
    	url=trim(document.getElementById("Url_l").value);  //qui ce la soluzione
    	}
    	if(tipodoc==2){
    	url=trim(document.getElementById("Url_r").value);  //qui ce la soluzione
    	}
    	if(tipodoc==3){
    	url=trim(document.getElementById("Url_a").value);  //qui ce la soluzione
    	}
		if(tipodoc==4){
    	url=trim(document.getElementById("Url_d").value);  //qui ce la soluzione
    	}
		if(tipodoc==5){
    	url=trim(document.getElementById("Url_c").value);  //qui ce la soluzione
    	}
 
 		if (!(url.length<1 || url==""))
 		{
  		flag_url=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  
 		if (url.length<1 || url=="" )
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito alcun testo nel campo 'url'";
  		flag_url=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo descrizione
		function controlloDescrizione(tipodoc)
{
 		if(tipodoc==1){
    	descrizione=trim(document.getElementById("Descrizione_l").value);  //qui ce la soluzione
    	}
    	if(tipodoc==2){
    	descrizione=trim(document.getElementById("Descrizione_r").value);  //qui ce la soluzione
    	}
    	if(tipodoc==3){
    	descrizione=trim(document.getElementById("Descrizione_a").value);  //qui ce la soluzione
    	}
		if(tipodoc==4){
    	descrizione=trim(document.getElementById("Descrizione_d").value);  //qui ce la soluzione
    	}
		if(tipodoc==5){
    	descrizione=trim(document.getElementById("Descrizione_c").value);  //qui ce la soluzione
    	}
 
 		if (!(descrizione.length<1 || descrizione==""))
 		{
  		flag_descrizione=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  
 		if (descrizione.length<1 || descrizione=="" )
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito alcun testo nel campo 'descrizione'";
  		flag_descrizione=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo casa
		function controlloCasa()
{
 		casa=trim(document.getElementById("Casa").value);
 
 		if (!(casa.length<1 || casa==""))
 		{
  		flag_casa=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  
 		if (casa.length<1 || casa=="" )
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito alcun testo nel campo 'casa editrice'";
  		flag_casa=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo edizione
		function controlloEdizione()
{
 		edizione=trim(document.getElementById("Edizione").value);
 
 		if (!(edizione.length<1 || edizione==""))
 		{
  		flag_edizione=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  
 		if (edizione.length<1 || edizione=="" )
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito alcun testo nel campo 'edizione'";
  		flag_edizione=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo nome_conf
		function controlloNome_conf()
{
 		nome_conf=trim(document.getElementById("Nome_conf").value);
 
 		if (!(nome_conf.length<1 || nome_conf==""))
 		{
  		flag_nome_conf=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  
 		if (nome_conf.length<1 || nome_conf=="" )
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito alcun testo nel campo 'nome della conferenza'";
  		flag_nome_conf=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo luogo_conf
		function controlloLuogo_conf()
{
 		luogo_conf=trim(document.getElementById("Luogo_conf").value);
 
 		if (!(luogo_conf.length<1 || luogo_conf==""))
 		{
  		flag_luogo_conf=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  
 		if (luogo_conf.length<1 || luogo_conf=="" )
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito alcun testo nel campo 'luogo della conferenza'";
  		flag_luogo_conf=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo data_conf
		function controlloData_conf()
{
 		data_conf=trim(document.getElementById("Data_conf").value);
 
 		if (!(data_conf.length<1 || data_conf==""))
 		{
  		flag_data_conf=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  
 		if (data_conf.length<1 || data_conf=="" )
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito alcun testo nel campo 'data della conferenza'";
  		flag_data_conf=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo num_i_atto
		function controlloNum_i_atto()
{
 		num_i_atto=trim(document.getElementById("Num_i_atto").value);
 
 		if ( (!isNaN(num_i_atto)) && (parseInt(num_i_atto) == num_i_atto) && (num_i_atto>0))
 		{
  		flag_num_i_atto=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  		else
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito un numero corretto nel campo 'numero di pagina iniziale'";
  		flag_num_i_atto=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo num_f_atto
		function controlloNum_f_atto()
{
 		num_f_atto=trim(document.getElementById("Num_f_atto").value);
 
 		if ( (!isNaN(num_f_atto)) && (parseInt(num_f_atto) == num_f_atto) && (num_f_atto>0))
 		{
  		flag_num_f_atto=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  		else
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito un numero corretto nel campo 'numero di pagina finale'";
  		flag_num_f_atto=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo casa2
		function controlloCasa2()
{
 		casa2=trim(document.getElementById("Casa2").value);
 
 		if (!(casa2.length<1 || casa2==""))
 		{
  		flag_casa2=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  
 		if (casa2.length<1 || casa2=="" )
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito alcun testo nel campo 'casa editrice'";
  		flag_casa2=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo titolo_cap
		function controlloTitolo_cap()
{
 		titolo_cap=trim(document.getElementById("Titolo_cap").value);
 
 		if (!(titolo_cap.length<1 || titolo_cap==""))
 		{
  		flag_titolo_cap=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  
 		if (titolo_cap.length<1 || titolo_cap=="" )
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito alcun testo nel campo 'titolo del libro'";
  		flag_titolo_cap=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo nome_cur
		function controlloNome_cur()
{
 		nome_cur=trim(document.getElementById("Nome_cur").value);
 
 		if (!(nome_cur.length<1 || nome_cur==""))
 		{
  		flag_nome_cur=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  
 		if (nome_cur.length<1 || nome_cur=="" )
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito alcun testo nel campo 'nome del curatore'";
  		flag_nome_cur=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo num_i_cap
		function controlloNum_i_cap()
{
 		num_i_cap=trim(document.getElementById("Num_i_cap").value);
 
 		if ( (!isNaN(num_i_cap)) && (parseInt(num_i_cap) == num_i_cap) && (num_i_cap>0))
 		{
  		flag_num_i_cap=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  		else
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito un numero corretto nel campo 'numero di pagina iniziale'";
  		flag_num_i_cap=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo num_f_cap
		function controlloNum_f_cap()
{
 		num_f_cap=trim(document.getElementById("Num_f_cap").value);
 
 		if ( (!isNaN(num_f_cap)) && (parseInt(num_f_cap) == num_f_cap) && (num_f_cap>0))
 		{
  		flag_num_f_cap=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  		else
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito un numero corretto nel campo 'numero di pagina finale'";
  		flag_num_f_cap=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo volume_riv
		function controlloVolume_riv()
{
 		volume_riv=trim(document.getElementById("Volume_riv").value);
 
 		if (!(volume_riv.length<1 || volume_riv==""))
 		{
  		flag_volume_riv=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  
 		if (volume_riv.length<1 || volume_riv=="" )
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito alcun testo nel campo 'volume del libro'";
  		flag_volume_riv=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo numero_riv
		function controlloNumero_riv()
{
 		numero_riv=trim(document.getElementById("Numero_riv").value);
 
 		if (!(numero_riv.length<1 || numero_riv==""))
 		{
  		flag_numero_riv=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  
 		if (numero_riv.length<1 || numero_riv=="" )
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito alcun testo nel campo 'numero rivista'";
  		flag_numero_riv=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo num_i_riv
		function controlloNum_i_riv()
{
 		num_i_riv=trim(document.getElementById("Num_i_riv").value);
 
 		if ( (!isNaN(num_i_riv)) && (parseInt(num_i_riv) == num_i_riv) && (num_i_riv>0))
 		{
  		flag_num_i_riv=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  		else
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito un numero corretto nel campo 'numero di pagina iniziale'";
  		flag_num_i_riv=0;
  		return (false);
 		}
}

		//-------------------------------------- controllo num_f_riv
		function controlloNum_f_riv()
{
 		num_f_riv=trim(document.getElementById("Num_f_riv").value);
 
 		if ( (!isNaN(num_f_riv)) && (parseInt(num_f_riv) == num_f_riv) && (num_f_riv>0))
 		{
  		flag_num_f_riv=1;
  		document.getElementById('p_errore_scheda').innerHTML = "";
 		}
  		else
 		{
  		document.getElementById('p_errore_scheda').innerHTML = "Non hai inserito un numero corretto nel campo 'numero di pagina finale'";
  		flag_num_f_riv=0;
  		return (false);
 		}
}

//------------------------------------------------------Fine funzioni di controllo-----------------------------------------------

function displayInsTab()
{		
      tipodoc= "<?php echo $filtro; ?>";

		if(tipodoc=='libro'){
    		document.getElementById("libro").style.display = 'block';
    		document.getElementById("doc_tecnico").style.display = 'none';
    		document.getElementById("rivista").style.display = 'none';
    		document.getElementById("atto").style.display = 'none';
    		document.getElementById("capitolo").style.display = 'none';
    		
    		document.getElementById("Agg_scheda_libro").style.display = 'block';
    		document.getElementById("Agg_scheda_articolo").style.display = 'none';
    		document.getElementById("Agg_scheda_atto").style.display = 'none';
    		document.getElementById("Agg_scheda_documento").style.display = 'none';
    		document.getElementById("Agg_scheda_capitolo").style.display = 'none';
    		
    		
    		}
    		
      if(tipodoc=='rivista'){
      	document.getElementById("rivista").style.display = 'block';
      	document.getElementById("doc_tecnico").style.display = 'none';
      	document.getElementById("libro").style.display = 'none';
    		document.getElementById("atto").style.display = 'none';
    		document.getElementById("capitolo").style.display = 'none';
    		
    		document.getElementById("Agg_scheda_libro").style.display = 'none';
    		document.getElementById("Agg_scheda_articolo").style.display = 'block';
    		document.getElementById("Agg_scheda_atto").style.display = 'none';
    		document.getElementById("Agg_scheda_documento").style.display = 'none';
    		document.getElementById("Agg_scheda_capitolo").style.display = 'none';
      	}
      if(tipodoc=='atto'){
      	document.getElementById("atto").style.display = 'block';
      	document.getElementById("doc_tecnico").style.display = 'none';
			document.getElementById("rivista").style.display = 'none';
    		document.getElementById("libro").style.display = 'none';
    		document.getElementById("capitolo").style.display = 'none'; 
    		
    		document.getElementById("Agg_scheda_libro").style.display = 'none';
    		document.getElementById("Agg_scheda_articolo").style.display = 'none';
    		document.getElementById("Agg_scheda_atto").style.display = 'block';
    		document.getElementById("Agg_scheda_documento").style.display = 'none';
    		document.getElementById("Agg_scheda_capitolo").style.display = 'none';     	
      	}
      if(tipodoc=='doctecnico'){	
      	document.getElementById("doc_tecnico").style.display = 'block';
			document.getElementById("rivista").style.display = 'none';
    		document.getElementById("atto").style.display = 'none';
    		document.getElementById("libro").style.display = 'none';
    		document.getElementById("capitolo").style.display = 'none';
    		
    		document.getElementById("Agg_scheda_libro").style.display = 'none';
    		document.getElementById("Agg_scheda_articolo").style.display = 'none';
    		document.getElementById("Agg_scheda_atto").style.display = 'none';
    		document.getElementById("Agg_scheda_documento").style.display = 'block';
    		document.getElementById("Agg_scheda_capitolo").style.display = 'none';
			}
      if(tipodoc=='capitolo'){
      	document.getElementById("capitolo").style.display = 'block';
      	document.getElementById("doc_tecnico").style.display = 'none';
      	document.getElementById("rivista").style.display = 'none';
    		document.getElementById("atto").style.display = 'none';
    		document.getElementById("libro").style.display = 'none';
    		
    		document.getElementById("Agg_scheda_libro").style.display = 'none';
    		document.getElementById("Agg_scheda_articolo").style.display = 'none';
    		document.getElementById("Agg_scheda_atto").style.display = 'none';
    		document.getElementById("Agg_scheda_documento").style.display = 'none';
    		document.getElementById("Agg_scheda_capitolo").style.display = 'block';
      	}
      
return false;

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

		<div id="contenuto_left">

		<?php
	 if( $tipoUtente == "Responsabile" )   /* $tipoUtente è definita in /common/header.php */
		include 'common/menu_sx.php'; 
	 else if( $tipoUtente == "Ammesso" )
   	include 'common/menu_user.php'; 
		?>

		</div>
		
		<div id="contenuto_right">

		<p id="notifica"></p>		
		
		<h1>Segnala una modifica</h1>
		
		<p>Scegli il tipo di documento da segnalare: </p>
<!--
<ul class="scelta_doc">

<li><input type="radio" name="radio_doc" value="libro" onclick="displayInsTab(1);"/> Libro</li>
<li><input type="radio" name="radio_doc" value="rivista" onclick="displayInsTab(2);" /> Articolo di rivista</li>
<li><input type="radio" name="radio_doc" value="atto" onclick="displayInsTab(3);"/> Atto di conferenza</li>
<li><input type="radio" name="radio_doc" value="doctecnico" onclick="displayInsTab(4);"/> Documento tecnico</li>
<li><input type="radio" name="radio_doc" value="capitolo" onclick="displayInsTab(5);"/> Capitolo di libro</li>
</ul>
-->



<p id="p_errore_scheda"></p>

<form id="form_l" method="post" onsubmit="return controlloCondizioniLibro(this);">
		<!-- Qui campi statiche (javascript) -->

<table id="libro" style="display: none">  <!-- cancellato l'id tab_inserimento -->
		
		<tr>
			<td>Titolo *</td>
			<td><input type="text" id="Titolo_l" name="Titolo_l" value="<?php echo $titolo; ?>" onblur="return controlloTitolo(1);"/></td>
		</tr>
		<tr>
			<td>Autore *</td>
			<td><input type="text" id="Autore_l" name="Autore_l" value="<?php echo $autore; ?>" onblur="return controlloAutore(1);"/></td>
		</tr>
		<tr>
			<td>Parole chiave (separate da virgola) *</td>
			<td><input type="text" id="Keyword_l" name="Keyword_l" value="<?php echo $keywords; ?>" onblur="return controlloKeyword(1);"/></td>
		</tr>
		<tr>
			<td>Anno di pubblicazione * </td>
			<td><input type="text" id="Anno_pub_l" name="Anno_pub_l" value="<?php echo $anno; ?>" onblur="return controlloAnno_pub(1);"/></td>
		</tr>	
		<tr>
			<td>URL per il download *</td>
			<td><input type="text" id="Url_l" name="Url_l" value="<?php echo $url; ?>" onblur="return controlloUrl(1);"/></td>
		</tr>	
		<tr>
			<td>Breve descrizione sul documento *</td>
			<td><textarea id="Descrizione_l" name="Descrizione_l" onblur="return controlloDescrizione(1);"><?php echo $descrizione; ?></textarea></td>
		</tr>
	
      
      <!-- Qui campi dinamici (javascript) -->
      			
		<tr >
			<td>Casa editrice *</td>
			<td><input type="text" name="Casa" id="Casa" value="<?php echo $casaEditrice; ?>" onblur="return controlloCasa();"/></td>
		</tr>
		<tr>
			<td>Edizione *</td>
			<td><input type="text" name="Edizione" id="Edizione" value="<?php echo $edizione; ?>" onblur="return controlloEdizione();"/></td>
		</tr>
		<tr>
		<tr >
			<td colspan="2"><input name="Agg_libro" id="Agg_scheda_libro" type="submit" value="Conferma" style="display: none" /></td>
		</tr>
		<tr>
		<td colspan="2"><p> <strong> Tutti i campi contrassegnati da * sono obbligatori. </strong> </p></td>
		</tr>
</table>
	
</form>

<form id="form_a" method="post" onsubmit="return controlloCondizioniAtto();">	
<table id="atto" style="display: none">			
		
		<tr>
			<td>Titolo *</td>
			<td><input type="text" id="Titolo_a" name="Titolo_a" value="<?php echo $titolo; ?>" onblur="return controlloTitolo(3);"/></td>
		</tr>
		<tr>
			<td>Autore *</td>
			<td><input type="text" id="Autore_a" name="Autore_a" value="<?php echo $autore; ?>" onblur="return controlloAutore(3);"/></td>
		</tr>
		<tr>
			<td>Parole chiave (separate da virgola) *</td>
			<td><input type="text" id="Keyword_a" name="Keyword_a" value="<?php echo $keywords; ?>" onblur="return controlloKeyword(3);"/></td>
		</tr>
		<tr>
			<td>Anno di pubblicazione * </td>
			<td><input type="text" id="Anno_pub_a" name="Anno_pub_a" value="<?php echo $anno; ?>" onblur="return controlloAnno_pub(3);"/></td>
		</tr>	
		<tr>
			<td>URL per il download *</td>
			<td><input type="text" id="Url_a" name="Url_a" value="<?php echo $url; ?>" onblur="return controlloUrl(3);"/></td>
		</tr>	
		<tr>
			<td>Breve descrizione sul documento *</td>
			<td><textarea rows='3' id="Descrizione_a" name="Descrizione_a" onblur="return controlloDescrizione(3);"><?php echo $descrizione; ?></textarea></td>
		</tr>
		
		<tr>
			<td>Nome della conferenza *</td>
			<td><input type="text" name="Nome_conf" id="Nome_conf" value="<?php echo $nomeConf; ?>" onblur="return controlloNome_conf();"/></td>
		</tr>
		<tr>
			<td>Luogo della conferenza *</td>
			<td><input type="text" name="Luogo_conf" id="Luogo_conf" value="<?php echo $luogoConf; ?>" onblur="return controlloLuogo_conf();"/></td>
		</tr>
		<tr>
			<td>Data della conferenza *</td>
			<td><input type="text" name="Data_conf" id="Data_conf" value="<?php echo $dataConf; ?>" onblur="return controlloData_conf();"/></td>
		</tr>
		<tr>
			<td>Numero di pagine iniziale *</td>
			<td><input type="text" name="Num_i_atto" id="Num_i_atto" value="<?php echo $paginaIniziale; ?>" onblur="return controlloNum_i_atto();"/></td>
		</tr>
		<tr>
			<td>Numero di pagine finale *</td>
			<td><input type="text" name="Num_f_atto" id="Num_f_atto" value="<?php echo $paginaFinale; ?>" onblur="return controlloNum_f_atto();"/></td>
		</tr>
		<tr >
			<td colspan="2"><input name="Agg_atto" id="Agg_scheda_atto" type="submit" value="Conferma" style="display: none" /></td>
		</tr>
		<tr>
		<td colspan="2"><p> <strong> Tutti i campi contrassegnati da * sono obbligatori. </strong> </p></td>
		</tr>
		
		
</table>	
</form>		

<form id="form_c" method="post" onsubmit="return controlloCondizioniCapitolo(this);">		
<table id="capitolo" style="display: none">	
		<tr>
			<td>Titolo *</td>
			<td><input type="text" id="Titolo_c" name="Titolo_c" value="<?php echo $titolo; ?>" onblur="return controlloTitolo(5);"/></td>
		</tr>
		<tr>
			<td>Autore *</td>
			<td><input type="text" id="Autore_c" name="Autore_c" value="<?php echo $autore; ?>" onblur="return controlloAutore(5);"/></td>
		</tr>
		<tr>
			<td>Parole chiave (separate da virgola) *</td>
			<td><input type="text" id="Keyword_c" name="Keyword_c" value="<?php echo $keywords; ?>" onblur="return controlloKeyword(5);"/></td>
		</tr>
		<tr>
			<td>Anno di pubblicazione * </td>
			<td><input type="text" id="Anno_pub_c" name="Anno_pub_c" value="<?php echo $anno; ?>" onblur="return controlloAnno_pub(5);"/></td>
		</tr>	
		<tr>
			<td>URL per il download *</td>
			<td><input type="text" id="Url_c" name="Url_c" value="<?php echo $url; ?>" onblur="return controlloUrl(5);"/></td>
		</tr>	
		<tr>
			<td>Breve descrizione sul documento *</td>
			<td><textarea rows='3' id="Descrizione_c" name="Descrizione_c" onblur="return controlloDescrizione(5);"><?php echo $descrizione; ?></textarea></td>
		</tr>
		
		<tr>
			<td>Titolo del libro *</td>
			<td><input type="text" name="Titolo_cap" id="Titolo_cap" value="<?php echo $titoloLibro; ?>" onblur="return controlloTitolo_cap();"/></td>
		</tr>
		
		<tr>
			<td>Nome del curatore *</td>
			<td><input type="text" name="Nome_cur" id="Nome_cur" value="<?php echo $curatore; ?>" onblur="return controlloNome_cur();"/></td>
		</tr>
		<tr>
			<td>Casa editrice *</td>
			<td><input type="text" name="Casa2" id="Casa2" value="<?php echo $casaEditrice; ?>" onblur="return controlloCasa2();"/></td>
		</tr>
		<tr>
			<td>Numero di pagine iniziale *</td>
			<td><input type="text" name="Num_i_cap" id="Num_i_cap" value="<?php echo $inizio; ?>" onblur="return controlloNum_i_cap();"/></td>
		</tr>
		<tr>
			<td>Numero di pagine finale *</td>
			<td><input type="text" name="Num_f_cap" id="Num_f_cap" value="<?php echo $fine; ?>" onblur="return controlloNum_f_cap();"/></td>
		</tr>
		<tr >
			<td colspan="2"><input name="Agg_capitolo" id="Agg_scheda_capitolo" type="submit" value="Conferma" style="display: none" /></td>
		</tr>
		<tr>
		<td colspan="2"><p> <strong> Tutti i campi contrassegnati da * sono obbligatori. </strong> </p></td>
		</tr>
		
</table>		
</form>		

<form id="form_r" method="post" onsubmit="return controlloCondizioniRivista(this);">		
<table id="rivista" style="display: none">
		<tr>
			<td>Titolo *</td>
			<td><input type="text" id="Titolo_r" name="Titolo_r" value="<?php echo $titolo; ?>" onblur="return controlloTitolo(2);"/></td>
		</tr>
		<tr>
			<td>Autore *</td>
			<td><input type="text" id="Autore_r" name="Autore_r" value="<?php echo $autore; ?>" onblur="return controlloAutore(2);"/></td>
		</tr>
		<tr>
			<td>Parole chiave (separate da virgola) *</td>
			<td><input type="text" id="Keyword_r" name="Keyword_r" value="<?php echo $keywords; ?>" onblur="return controlloKeyword(2);"/></td>
		</tr>
		<tr>
			<td>Anno di pubblicazione * </td>
			<td><input type="text" id="Anno_pub_r" name="Anno_pub_r" value="<?php echo $anno; ?>" onblur="return controlloAnno_pub(2);"/></td>
		</tr>	
		<tr>
			<td>URL per il download *</td>
			<td><input type="text" id="Url_r" name="Url_r" value="<?php echo $url; ?>" onblur="return controlloUrl(2);"/></td>
		</tr>	
		<tr>
			<td>Breve descrizione sul documento *</td>
			<td><textarea rows='3' id="Descrizione_r" name="Descrizione_r" onblur="return controlloDescrizione(2);"><?php echo $descrizione; ?></textarea></td>
		</tr>
			
		<tr>
			<td>Volume</td>
			<td><input type="text" name="Volume_riv" id="Volume_riv" value="<?php echo $volume; ?>" onblur="return controlloVolume_riv();"/></td>
		</tr>
		<tr>
			<td>Numero rivista</td>
			<td><input type="text" name="Numero_riv" id="Numero_riv" value="<?php echo $numeroR; ?>" onblur="return controlloNumero_riv();"/></td>
		</tr>
		<tr>
			<td>Numero di pagine iniziale *</td>
			<td><input type="text" name="Num_i_riv" id="Num_i_riv" value="<?php echo $inizio; ?>" onblur="return controlloNum_i_riv();"/></td>
		</tr>
		<tr>
			<td>Numero di pagine finale *</td>
			<td><input type="text" name="Num_f_riv" id="Num_f_riv" value="<?php echo $fine; ?>" onblur="return controlloNum_f_riv();"/></td>
		</tr>
		<tr >
			<td colspan="2"><input name="Agg_articolo" id="Agg_scheda_articolo" type="submit" value="Conferma" style="display: none" /></td>
		</tr>
		<tr>
		<td colspan="2"><p> <strong> Tutti i campi contrassegnati da * sono obbligatori. </strong> </p></td>
		</tr>
</table>		
</form>		

<form id="form_d" method="post" onsubmit="return controlloCondizioniDocTecnico(this);">
		<!-- Qui campi statiche (javascript) -->

<table id="doc_tecnico" style="display: none">  <!-- cancellato l'id tab_inserimento -->
		
		<tr>
			<td>Titolo *</td>
			<td><input type="text" id="Titolo_d" name="Titolo_d" value="<?php echo $titolo; ?>" onblur="return controlloTitolo(4);"/></td>
		</tr>
		<tr>
			<td>Autore *</td>
			<td><input type="text" id="Autore_d" name="Autore_d" value="<?php echo $autore; ?>" onblur="return controlloAutore(4);"/></td>
		</tr>
		<tr>
			<td>Parole chiave (separate da virgola) *</td>
			<td><input type="text" id="Keyword_d" name="Keyword_d" value="<?php echo $keywords; ?>" onblur="return controlloKeyword(4);"/></td>
		</tr>
		<tr>
			<td>Anno di pubblicazione * </td>
			<td><input type="text" id="Anno_pub_d" name="Anno_pub_d" value="<?php echo $anno; ?>" onblur="return controlloAnno_pub(4);"/></td>
		</tr>	
		<tr>
			<td>URL per il download *</td>
			<td><input type="text" id="Url_d" name="Url_d" value="<?php echo $url; ?>" onblur="return controlloUrl(4);"/></td>
		</tr>
			<td>Breve descrizione sul documento *</td>
			<td><textarea rows='3' id="Descrizione_d" name="Descrizione_d" onblur="return controlloDescrizione(4);"><?php echo $descrizione; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="2"><input name="Agg_doc" id="Agg_scheda_documento" type="submit" value="Conferma" style="display: none" /></td>
		</tr>
		<tr>
		<td colspan="2"><p> <strong> Tutti i campi contrassegnati da * sono obbligatori. </strong> </p></td>
		</tr>
</table>
</form>

		
<script type="text/javascript">
displayInsTab();
</script>		    
      
</div>



</div>

<div id="footer">
<?php include 'common/footer.html'; ?>
</div>

</body>


</html>