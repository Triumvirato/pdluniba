<?php
// Includo la connessione al database
require('functions/config.php');

   //Se non è stata definita la variabile, manda l'utente alla pag di registrazione
	 if( !isset($_SESSION['login']) && !isset($_SESSION['login_ammesso']) ) {
    header('Location: registrazione.php');
    exit;
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
		<h1>Lista segnalazioni</h1>

<?php if( $tipoUtente == "Responsabile" ){ ?>	
		
		<script>
xmlDoc=loadXMLDoc("temp.xml");

x=xmlDoc.getElementsByTagName("SCHEDA");

if(x.length == 0)
document.write("<p>Non sono presenti schede in attesa di revisione.</p>");
else if(x.length == 1)
document.write("<p>E' presente 1 scheda in attesa di revisione:</p>");
else
document.write("<p>Ci sono "+x.length+" schede in attesa di revisione:</p>");

document.write("<ul>");
for (i=0;i<x.length;i++)
  { 
   
   var id = x[i].getAttribute("ID_SCHEDA");
   var filtro = x[i].getAttribute("TIPO");
  
  document.write("<li><a href='revisione.php?s="+id+"&f="+filtro+"'>Scheda: "+id+"  | Tipo: "+filtro+"</a></li>");

  }
document.write("</ul>");
</script>		


<?php } else if( $tipoUtente == "Ammesso" ) { ?>
		<script>
		
var emailUtente= '<?php echo $emailUtente; ?>';

xmlDoc=loadXMLDoc("temp.xml");

x=xmlDoc.getElementsByTagName("SCHEDA");

document.write("<ul>");
for (i=0;i<x.length;i++)
  { 

     if( x[i].getAttribute("NOME_UTENTE") == emailUtente )
	 {
   
   var id = x[i].getAttribute("ID_SCHEDA");
   var filtro = x[i].getAttribute("TIPO");
  
  document.write("<li><a href='revisione.php?s="+id+"&f="+filtro+"'>Scheda: "+id+"  | Tipo: "+filtro+"</a></li>");
  
      }

  }
document.write("</ul>");
</script>		


<?php } ?>
		
		</div>



</div>

<div id="footer">
<?php include 'common/footer.html'; ?>
</div>

</body>


</html>