<?php
require('functions/config.php');

if ($_REQUEST['titolo'])
{
echo "Segnalazione avvenuta<br />";

					if( isset($_SESSION['login']) ) {
						$emailUtente = $_SESSION['login']; 
						$tipoUtente = "Responsabile";
						}
	 				else if( isset($_SESSION['login_ammesso']) ){
   					$emailUtente = $_SESSION['login_ammesso'];
   					$tipoUtente = "Ammesso";
   					}


$xml = simplexml_load_file('temp.xml');

$codScheda = $_REQUEST['codScheda'];    

foreach($xml->SCHEDA as $scheda)
{

   if($scheda['ID_SCHEDA']==$codScheda){
   
   $filtro= $scheda->attributes()->TIPO;
   $emailPropietario= $scheda->attributes()->NOME_UTENTE;

   	if($tipoUtente=="Responsabile")
   	$scheda->addAttribute('RESPONSABILE', '1');

			if($emailUtente == $emailPropietario)	{
			$scheda->addAttribute('PROPRIETARIO', '1');
			}

	if( $scheda->attributes()->PROPRIETARIO && $scheda->attributes()->RESPONSABILE )
	{

	//Effettua le query
	
	$titolo = $_REQUEST['titolo'];    
    $autore = $_REQUEST['autore']; 
	$keywords = $_REQUEST['keywords'];
	$privato = $_REQUEST['privato'];
	$anno = $_REQUEST['anno'];
	$url = $_REQUEST['url'];
	$descrizione = $_REQUEST['descrizione'];

	if($filtro=="libro")
	{

	$casaEditrice = $_REQUEST['casaEditrice'];  
	$edizione = $_REQUEST['edizione'];


        $strSQL = "UPDATE scheda SET titolo='$titolo', autore='$autore', keywords='$keywords', descrizione='$descrizione', privato='$privato', anno='$anno', url='$url' WHERE id_scheda='$codScheda';";
        
		  $strSQL .= "UPDATE libro SET casa_editrice='$casaEditrice', edizione='$edizione' WHERE id_scheda='$codScheda'";
		        
        
	     mysqli_multi_query($link, $strSQL) OR die("Errore, contattare l'amministratore ".mysql_error());

		 echo "Libro caricato sul server";
	}	
	
	if($filtro=="atto")
	{
	$nomeConf = $_REQUEST['nomeConf'];  
	$dataConf = $_REQUEST['dataConf']; 
	$luogoConf = $_REQUEST['luogoConf']; 
	$paginaIniziale = $_REQUEST['paginaIniziale']; 
	$paginaFinale = $_REQUEST['paginaFinale'];   

      $strSQL = "UPDATE scheda SET titolo='$titolo', autore='$autore', keywords='$keywords', descrizione='$descrizione', privato='$privato', anno='$anno', url='$url' WHERE id_scheda='$codScheda';";
        
 		$strSQL .= "UPDATE atto SET nome='$nomeConf', data='$dataConf',luogo='$luogoConf', inizio='$paginaIniziale', fine='$paginaFinale' WHERE id_scheda='$codScheda'";        
        	
	
	mysqli_multi_query($link, $strSQL) OR die("Errore, contattare l'amministratore ".mysql_error());

	echo "Atto di conferenza caricato sul server";
	}
	
	if($filtro=="capitolo")
	{
	$titoloCap = $_REQUEST['titoloLibro'];  
	$nomeCur = $_REQUEST['curatore']; 
	$casaEditrice = $_REQUEST['casaEditriceC']; 
	$paginaIniziale = $_REQUEST['inizio']; 
	$paginaFinale = $_REQUEST['fine']; 

   
	
   $strSQL = "UPDATE scheda SET titolo='$titolo', autore='$autore', keywords='$keywords', descrizione='$descrizione', privato='$privato', anno='$anno', url='$url' WHERE id_scheda='$codScheda';";

	$strSQL .= "UPDATE capitolo SET titolo_libro='$titoloCap', curatore='$nomeCur', casa_editrice='$casaEditrice', inizio='$paginaIniziale', fine='$paginaFinale' WHERE id_scheda='$codScheda'";        
        
	mysqli_multi_query($link, $strSQL) OR die("Errore, contattare l'amministratore ".mysql_error());
   
   echo "Capitolo di libro caricato sul server";
	}
	
	if($filtro=="rivista")
	{
	
	$volume = $_REQUEST['volumeR'];   
	$numeroRivista = $_REQUEST['numeroR'];  
	$paginaIniziale = $_REQUEST['inizioR'];  
	$paginaFinale = $_REQUEST['fineR'];  


   $strSQL = "UPDATE scheda SET titolo='$titolo', autore='$autore', keywords='$keywords', descrizione='$descrizione', privato='$privato', anno='$anno', url='$url' WHERE id_scheda='$codScheda';";
        
	$strSQL .= "UPDATE rivista SET volume='$volume', numero='$numeroRivista', inizio='$paginaIniziale', fine='$paginaFinale' WHERE id_scheda='$codScheda'";        

	
	mysqli_multi_query($link, $strSQL) OR die("Errore, contattare l'amministratore ".mysql_error());
	
	   echo "Articolo di rivista caricato sul server";

	
	}
	
	if($filtro=="doctecnico")
	{
	
	$strSQL = "UPDATE scheda SET titolo='$titolo', autore='$autore', keywords='$keywords', descrizione='$descrizione', privato='$privato', anno='$anno', url='$url' WHERE id_scheda='$codScheda'"; 
        
	mysqli_query($link, $strSQL) OR die("Errore, contattare l'amministratore ".mysql_error());
	
	   echo "Rapporto tecnico caricato sul server";

	
	}
	
		//Rimuovi la scheda!
		$dom=dom_import_simplexml($scheda);
        $dom->parentNode->removeChild($dom);
		
	} 	
   	
   	
   }
}
 
 $xml->asXML('temp.xml');


}

?>