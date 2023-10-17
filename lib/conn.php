<?php
$db = newAdoConnection('mysqli');
$db->setConnectionParameter(MYSQLI_SET_CHARSET_NAME, 'utf8');
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;




switch ($_SERVER['HTTP_HOST']) {
    case "localhost":
    	$db->connect("localhost", "root", "", "identita");
		define("DATABASENAME","identita");
		error_reporting(E_ALL);
        break;
    default:
       die("DB ErrorConnect");
}


function gendata($etaMinima=1,$etaMassima=100){
 
// Calcola le date di nascita corrispondenti all'età minima e massima
$dataMinima = strtotime("-{$etaMassima} years");
$dataMassima = strtotime("-{$etaMinima} years");

// Genera una data casuale di nascita all'interno del range
$dataCasuale = mt_rand($dataMinima, $dataMassima);

// Formatta la data casuale nel formato desiderato
$dataFormattata = date('Y-m-d', $dataCasuale);

// Stampa la data casuale
return $dataFormattata;
	
}

function GenereCasuale($n=10){


$array = [];

for ($i = 0; $i < $n; $i++) {
    $randomValue = rand(0, 1); // Genera un numero casuale tra 0 e 1
    
    if ($randomValue === 0) {
        $array[] = "M"; // Aggiunge "M" all'array se il valore casuale è 0
    } else {
        $array[] = "F"; // Aggiunge "F" all'array se il valore casuale è 1
    }
}

// Stampa l'array generato
return $array;

}

?>