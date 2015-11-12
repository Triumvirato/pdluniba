<?php 
// avvio sessione
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

// Dati connessione al database
$db_host = 'mysql.netsons.com';       // Host - solitamente localhost
$db_utente = 'qdytaqlz_admin';        	// Nome utente del Database
$db_password = 'pdluniba$14B';        		// Password del Database
$db_nomedb = 'qdytaqlz_pdl';     		// Nome del Database


// Procedural style PHP.net


$link = mysqli_connect($db_host, $db_utente, $db_password, $db_nomedb);

if (!$link) {
    die('Connect Database Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}

//Debug
//echo 'Connesso al DB... ' . mysqli_get_host_info($link) . "\n";

//mysqli_close($link);

?>
