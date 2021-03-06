<?php
    require_once "connection.php";
    require_once "session.php";

    if($_SESSION['connesso']!=true){
        header('location:accessdenied.php');
        exit();
    }

    $codice = "";
    $titolo = "";
    $descrizione = "";
    $link = "";
    $altimmagine = "";
    $immagine = "";

    if($_SERVER['REQUEST_METHOD']=='POST'){
        
        if(isset($_POST['codice'])){
            $codice = $_POST['codice'];
        }

        if(isset($_POST['titolo'])){
            $titolo = $_POST['titolo'];
        }
        
        if(isset($_POST['descrizione'])){
            $descrizione = $_POST['descrizione'];
        }

        if(isset($_POST['link'])){
            $link = $_POST['link'];
        }

        if(isset($_POST['alt_immagine'])){
            $altimmagine = $_POST['alt_immagine'];
        }

        if(isset($_POST['immagine'])){
            $immagine = $_POST['immagine'];
        }

        $connessione = new connection();
        $error = '<div class="err"><ul>';
        if($connessione->isConnected()){
            
            if(isset($_POST['submitDel'])){

                $query = "DELETE FROM attivita WHERE Codice = \"$codice\"";
                $queryResult = mysqli_query($connessione->getConnection(), $query);

                if(mysqli_affected_rows($connessione->getConnection())==1){
                    $connessione->closeConnection();
                    echo "<div class='mess'>Attivita eliminata con successo, reindirizzamento in corso</div>";
					header( "refresh:5;url=gestAttivita.php" );
					exit;
                    
                }
                else{
                    echo "<div class='err'>Errore eliminazione attivita</div>";
					header( "refresh:5;url=gestAttivita.php" );
					exit;
                }

            }

            else{
				$querable=true;
				$errorino="<div class='err'><ul>";
				if($titolo==""){
					$errorino.="<li>Il campo titolo non può essere vuoto</li>";
					$querable=false;
				}
				if($descrizione==""){
					$errorino.="<li>Il campo descrizione non può essere vuoto</li>";
					$querable=false;
				}
				if($link==""){
					$errorino.="<li>Il campo link non può essere vuoto</li>";
					$querable=false;
				}
				if($altimmagine==""){
					$errorino.="<li>Il campo descrizione immagine non può essere vuoto</li>";
					$querable=false;
				}
				if($immagine==""){
					$errorino.="<li>Il campo percorso immagine non può essere vuoto</li>";
					$querable=false;
				}
				
				if ($querable){
				
					$descrizione = str_replace("'", "\'" , $descrizione);
					$descrizione = str_replace('"','\"' , $descrizione);
					$query = "UPDATE attivita SET Codice=\"$codice\", Titolo=\"$titolo\", Descrizione=\"$descrizione\",
						Link=\"$link\", AltImmagine=\"$altimmagine\", Immagine=\"$immagine\" WHERE Codice=\"$codice\"";
					$queryResult = mysqli_query($connessione->getConnection(), $query);
					if(mysqli_affected_rows($connessione->getConnection())>=1){
						$connessione->closeConnection();
						echo "<div class='mess'>Attivita aggiornata con successo, reindirizzamento in corso</div>";
						header( "refresh:5;url=gestAttivita.php" );
						exit;
					}
					else{
						 echo "<div class='err'>Errore aggiornamento attivita</div>";
						header( "refresh:5;url=gestAttivita.php" );
						exit;
					}
				} else{
					echo $errorino."</ul></div>";
					header( "refresh:5;url=gestAttivita.php" );
					exit;
					
				}

			}
        } else {
			echo "<div class='mess'> Errore nell'instaurazione della connessione</div>";
			header( "refresh:5;url=gestAttivita.php" );
			exit;
		}
    } else {
		header('location:gestAttivita.php');
		exit;
	}


?>