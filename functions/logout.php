<?php
// Includo la connessione al database
require('config.php');

// Esegue il logout cancellando la sessione
session_destroy();

// reindirizzamento nell'area privata
header('Location: ../index.php');
exit;

?>