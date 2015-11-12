<?php
//Se ho già effettuato l'acceso reindirizza all'area privata
if(isset($_SESSION['login']) || isset($_SESSION['login_ammesso']) ) 
    { 
		  echo '<p>Sei già autenticato</p>';	        
        header('Location: area_riservata.php');
        exit;
    }


// Se il modulo viene inviato...
if(isset($_POST['registra']))
{
    // Includo la connessione al database SOLO se il form viene inviato.
    require('functions/config.php');

    // Dati Inviati dal modulo
    $email = (isset($_POST['email'])) ? trim($_POST['email']) : '';    // Metto nella variabile 'user' il dato inviato dal modulo, se non viene inviato dò di default ''
    $pass = (isset($_POST['pass'])) ? trim($_POST['pass']) : '';   

	 $nome = (isset($_POST['nome'])) ? trim($_POST['nome']) : '';  
	 $cognome = (isset($_POST['cognome'])) ? trim($_POST['cognome']) : '';      
    
    // Filtro i dati inviati se i magic_quotes del server sono disabilitati per motivi di sicurezza
    if (!get_magic_quotes_gpc()) {
        $email = addslashes($email);
        $pass = addslashes($pass);
    }
    
    
    // Controllo l'email
    if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email))
        die('Email non valida');
    
    // Controllo il l'email  non sia già occupato
    $result = mysqli_query($link, "SELECT email FROM utenti WHERE email = '$email' LIMIT 1");
        
    if( mysqli_num_rows($result) ==1 )        
        die('Email non disponibile');
    
    // Registrazione dell'utente nel database
    else
    {
        
        // Crypt della password per garantire una miglior sicurezza
        $pass = md5($pass);
        
        // Query per l'inserimento dell'utente nel database
        $strSQL = "INSERT INTO utenti (nome,cognome,email,pass,attivato)";
        $strSQL .= "VALUES('$nome','$cognome','$email','$pass','0')";
        
	     mysqli_query($link, $strSQL) OR die("Errore, contattare l'amministratore ".mysql_error());

		  
		  echo "<script type=\"text/javascript\">alert(\"Grazie per esserti registrato. Attendi l'attivazione da parte di un responsabile\");</script> ";             
			           
		   
		   //-------- RECUPERO EMAIL DA DB E INVIO NOTIFICA ----------------
		   

		 	require('functions/config.php');
		 	
			$resultf = mysqli_query($link, "SELECT email FROM utenti where responsabile='1'");

			if ($resultf) {

			if( mysqli_num_rows($resultf) >= 1 ){

				while( $row = mysqli_fetch_array($resultf, MYSQLI_ASSOC) )
			   //Invio avviso a responsabile
				mail($row['email'], "Nuovo utente registrato", "Un utente si è registrato su PDL. Approvalo dalla tua area riservata");
			  }
			}		

			
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<!-- File principale  -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<title>Private Digital Library - Registrazione</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />


<script type="text/javascript">
<!--
//variabili di controllo
var flag_email=0;
var flag_nome=0;
var flag_cognome=0;
var flag_password=0;
var flag_pass=0;

function controlloCondizioni(agr){
	
if (document.getElementById("agree").checked == false )
{
alert("Leggi e accetta le condizioni e i termini d'uso prima di continuare");
return false;
}
if(flag_email==0 || flag_nome==0 || flag_cognome==0 || flag_password==0 || flag_pass==0)
{
alert("Completa tutti i campi.");
return false;
}
else
return true;
}

//elimina eventuali spazi inseriti prima e dopo il testo

function trim(str){
 return str.replace(/^\s+|\s+$/g,"");
}

//---------------------------------------------Controlla il campo email

function controlloEmail()
{


email=trim(document.getElementById("Email").value);
 var filtroMail=/^([a-zA-Z0-9._-])+@([a-zA-Z0-9\._\-])+\.([a-zA-Z0-9._-])([a-zA-Z0-9\._\-])+$/; //codice per far rispettare la grammatica
 
if (filtroMail.test(email)) //primo controllo per far sparire l'errore

 {
  document.getElementById('p_errore').innerHTML = "";
  flag_email=1; 
 }
 
 
 if (!filtroMail.test(email))
 {
  //alert("Controlla l'indirizzo e-mail inserito.");
  //document.getElementById("Email").focus();

  document.getElementById('p_errore').innerHTML = "Controlla l'indirizzo e-mail inserito.";
  
  return (false);
 }
}

//------------------------------------------------Controlla il campo nome
function controlloNome()
{
 nome=trim(document.getElementById("Nome").value);
 
 if (!(nome.length<1 || nome==""))
 {
  flag_nome=1;
  document.getElementById('p_errore').innerHTML = "";
 }
  
 if (nome.length<1 || nome=="" )
 {
  document.getElementById('p_errore').innerHTML = "Non hai inserito alcun testo nel campo 'Nome'";
  //document.getElementById("Nome").focus();
  return (false);
 }
}

//------------------------------------------------Controlla il campo cognome
function controlloCognome()
{
 cognome=trim(document.getElementById("Cognome").value);
  if (!(cognome.length<1 || cognome==""))
 {
  flag_cognome=1;
  document.getElementById('p_errore').innerHTML = "";
 } 
 
 if (cognome.length<1 || cognome=="" )
 {
  document.getElementById('p_errore').innerHTML = "Non hai inserito alcun testo nel campo 'Cognome'";
  //document.getElementById("Cognome").focus();
  return (false);
 }
}

//----------------------------------------------Controlla il campo password
function controlloPassword()
{
 password=trim(document.getElementById("Password").value);
 if (!(password.length<8 || password==""))
 {
  flag_password=1;
  document.getElementById('p_errore').innerHTML = "";
 } 
 
 if (password.length<8 || password=="" )
 {
  document.getElementById('p_errore').innerHTML = "Devi inserire almeno 8 caratteri nel campo 'Password'";

  //document.getElementById("Password").focus();
  return (false);
 }
}

//---------------------------------------------Controlla il campo pass
function controlloPass()
{
 pass=trim(document.getElementById("Pass").value);
 password=trim(document.getElementById("Password").value);
 if (pass==password)
 {
  flag_pass=1;
  document.getElementById('p_errore').innerHTML = "";
 } 
 
 if (pass!=password)
 {
  document.getElementById('p_errore').innerHTML = "La password non corrisponde.";

  //document.getElementById("Password").focus();
  return (false);
 }
}

//-->
</script>



</head>
<body>

<!-- Intestazione -->
<div id="intestazione_home">
	<?php include 'common/header.php'; ?>
</div>

<div id="contenitore">

<!-- Imposto il modulo di registrazione al centro -->
<div id="contenuto" style="margin: 0 auto; width: 450px">

<form id="registra" action=""  method="post"  />
<h1>Registrazione</h1>

<p id="p_errore"></p> 

<table id="tab_registra">
	<tbody>
		<tr>
			<td><input id="Nome" name="nome" placeholder="Nome" style="width: 203px;" type="text"  /></td>
			<td><input id="Cognome" name="cognome" placeholder="Cognome" style="width: 203px;" type="text"  /></td>
		</tr>
		<tr>
			<td colspan="2"><input id="email" name="email" placeholder="Email" style="width: 423px;" type="text"  /> </td>
				
		</tr>
			
		<tr>
			<td colspan="2"><input id="password" name="password" placeholder="Password" type="password" style="width: 423px;"  /></td>
		</tr>
		<tr>
			<td colspan="2"><input id="pass" name="pass" placeholder="Conferma Password" type="password"  style="width: 423px;"  /></td>
		</tr>
	</tbody>
	<tbody>
		
		<tr>
			<td colspan="2" style="padding-top:20px;"><input name="registra" type="submit" value="Registrati" /></td>
		</tr>
	</tbody>
</table>

	</form>
</div>
<div id="footer">
<?php include 'common/footer.html'; ?>
</div>
</div>

</body>
</html>