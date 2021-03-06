<?php
    require_once "connection.php";
	require_once "session.php";
	
	 if($_SESSION['connesso']!=true){
        header('location:accessdenied.php');
        exit();
    }
	
	
    $connessione = new connection();
    $paginaHTML = file_get_contents("..". DIRECTORY_SEPARATOR . "html". DIRECTORY_SEPARATOR ."gestPrenotazioni.html");

    if($connessione->isConnected()){
        
        $listaPrenotazioni = $connessione->getListPrenotazioni();
        if($listaPrenotazioni != null){
			
            $ulPrenotazione = '<ul class="admin" id="prenotazione">';

            foreach($listaPrenotazioni as $prenotazione){
				$ulPrenotazione.='<li><form class="book" action="../php/modificaPrenotazione.php" method="post" title="Form per gestione prenotazioni" aria-label="Form per gestire le prenotazioni"> <fieldset class="display_admin" > 
					<label for="nomecognome"> Cliente: '.$prenotazione['Nome']." ".$prenotazione['Cognome'].'</label>
					<input type="text" name="codice"  aria-hidden="true" class="codicihidden" id="codice"  value="'.$prenotazione['Codice'].'"/>
					<div class="campo_prenotazione" id="chkin-chkout"><div id="campo_chkin" class="campo_chk">
					<label for="checkin">Data di check-in:</label>
					<input type="text" name="checkin" id="checkin" aria-required="true" value="'.$prenotazione['DataCheckIn'].'"aria-label="Inserisci la data del checkin nel formato AAAA-MM-GG" title="Inserisci la data del checkin nel formato AAAA-MM-GG"/></div>
					<div id="campo_chkout" class="campo_chk">
					<label for="checkout">Data di check-out:</label>
					<input type="text" name="checkout" id="checkout" aria-required="true" value="'.$prenotazione['DataCheckOut'].'"aria-label="Inserisci la data del checkout nel formato AAAA-MM-GG" title="Inserisci la data del checkout nel formato AAAA-MM-GG"/></div></div>
					<textarea id="richieste" name="richieste" title="Scrivi qui per richieste particolari" aria-label="Scrivi qui per richieste particolari">'.$prenotazione['Richieste'].'</textarea>
					<div class="campo_prenotazione campo_attivita bottoni">
					<button type="submit" id="submitMod" name="submitMod" title="Pulsante per modificare la prenotazione" aria-label="Pulsante per modificare la prenotazione">Modifica</button>
					<button type="submit" id="submitDel" name="submitDel" title="Pulsante per cancellare la prenotazione" aria-label="Pulsante per cancellare la prenotazione">Rimuovi</button></div>	
					</fieldset></form></li>';
            }

            $ulPrenotazione.='</ul>';
            echo str_replace("<listaprenotazione />", $ulPrenotazione, $paginaHTML);
        }
        else{
            echo str_replace("<listaprenotazione />", "Nessuna prenotazione presente", $paginaHTML);
        }
    }
    else{
        die("Connessione non riuscita");
    }

    $connessione->closeConnection();

?>
