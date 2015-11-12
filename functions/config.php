<?php 
// avvio sessione
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

// Dati connessione al database
$db_host = '';          // Host - solitamente localhost
$db_utente = '';        // Nome utente del Database
$db_password = '';      // Password del Database
$db_nomedb = '';     	// Nome del Database



$link = mysqli_connect($db_host, $db_utente, $db_password, $db_nomedb);

if (!$link) {
    die('Connect Database Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}

//Debug
//echo 'Connesso al DB... ' . mysqli_get_host_info($link) . "\n";

//mysqli_close($link);

?>
