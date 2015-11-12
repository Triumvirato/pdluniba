<?php

	if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
	
	if( !isset($_SESSION['login']) && !isset($_SESSION['login_ammesso']) ){ 
	
	
?>	
	
	<div id="autentica">
	
	<!-- Tabella senza bordi contenente il form di login  -->
	<form action="functions/login.php" method="post" >	
	<table id="tab_autentica">
	<tbody>
		<tr>
			<td>Email</td>
			<td>Password</td>
		</tr>
		<tr>
			<td><input name="email" type="text" /></td>
			<td><input name="pass" type="password" /></td>
		</tr>
		<tr>
			<td colspan="2"><input name="login" type="submit"  class="login" value="Accedi"/> <input name="registrati" type="button" onclick="location.href='registrazione.php';" class="login" value="Registrati"/></td>
		</tr>
	</tbody>
</table>
 </form>
 
 </div>
 
 <?php } else{
 	
					if( isset($_SESSION['login']) ) {
						$emailUtente = $_SESSION['login']; 
						$tipoUtente = "Responsabile";
						}
	 				else if( isset($_SESSION['login_ammesso']) ){
   					$emailUtente = $_SESSION['login_ammesso'];
   					$tipoUtente = "Ammesso";
   					}
   					 	
 	
 					echo '<div id="autentica"><p>Benvenuto '.$emailUtente." (".$tipoUtente.")</p>";
 					echo '<p><a href="area_riservata.php">Gestione account</a> | <a href="./functions/logout.php">Disconnettiti</a></p></div>';
  } ?>
 

 	<!-- Menu superiore destro  -->
	<div id="menu_sup">	
		<a href="./index.php">Home</a> <span>|</span> <a href="./cose-pdl.php">Cos'è PDL</a> <span>|</span> <a href="mailto:info@pdluniba.netsons.org">Contatti</a>
	</div>
