<!DOCTYPE html>
<html lang="it">
<?php 
include("lib/CodiceFiscale.class.php");
include("lib/adodb5/adodb.inc.php");
include("lib/conn.php");

if(isset($_POST['invio'])){
//print_r($_POST);
$opz=$_POST;
$opz['gruppo_eta']=explode("-",$opz['gruppo_eta']);
if($opz['genere']=="M"){$w=" WHERE genere = 'M' ";}
if($opz['genere']=="F"){$w=" WHERE genere = 'F' ";}
if($opz['genere']=="I"){$w="";}

//$db->debug=true;
$sesso=array("M"=>"Maschio","F"=>"Femmina");

$cognomi = $db->getAll("SELECT cognome FROM cognomi ORDER BY RAND() LIMIT {$opz['numero']}");
$cognomi=array_column($cognomi,"cognome");

$nomis = $db->getAll("SELECT nome,genere FROM nomi {$w} ORDER BY RAND() LIMIT {$opz['numero']}");

$nomi=array_column($nomis,"nome");
$generi=array_column($nomis,"genere");
$lnascita = $db->getAll("SELECT codice,CONCAT(descrizione,' (',provincia,')') as descr FROM lut_comuni_province_statiesteri ORDER BY RAND() LIMIT {$opz['numero']}");
$codice = array_column($lnascita,"codice");
$descr = array_column($lnascita,"descr");
//$generi = GenereCasuale($opz['numero']);

for($i=0;$i<$opz['numero'];$i++){
	$dnascita[] = gendata($opz['gruppo_eta']['0'],$opz['gruppo_eta']['1']);
}

}

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generatore di identità false</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
		<h1>Generatore di identità false</h1>
        <form action="index.php" method="POST">
            <div class="mb-3">
                <label for="numero" class="form-label">Numero (1-1000)</label>
                <input type="number" class="form-control" id="numero" name="numero" min="1" max="1000" value="<?php echo (isset($opz['numero']) ? "{$opz['numero']}" : "1")?>" required>
            </div>
            <div class="mb-3">
                <label for="genere" class="form-label">Genere</label>
                <select class="form-select" id="genere" name="genere" required>
                    <option value="I">Entrambi i generi</option>
                    <option value="M">Maschio</option>
                    <option value="F">Femmina</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="gruppo_eta" class="form-label">Gruppo età</label>
                <select class="form-select" id="gruppo_eta" name="gruppo_eta" required>
                    <option value="1-100">Qualsiasi</option>
                    <option value="1-20">1-20</option>
                    <option value="21-40">21-40</option>
                    <option value="41-65">41-65</option>
                    <option value="66-100">66-100</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="invio">Invia</button>
        </form>
    </div>



<?php if(isset($opz['numero'])){?>
    <div class="container mt-5">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Progressivo</th>
                    <th scope="col">Codice Fiscale</th>
                    <th scope="col">Cognome</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Data di nascita</th>
                    <th scope="col">Luogo di nascita</th>
                    <th scope="col">Genere</th>
                </tr>
            </thead>
            <tbody>
                <!-- Esempio di riga della tabella -->
				
				<?php for($i=0;$i<$opz['numero'];$i++){
				
				$CF = new CodiceFiscale();
				$cfcalcolato[$i] = $CF->Calcola($cognomi[$i], $nomi[$i], $dnascita[$i], $generi[$i],null,$codice[$i]);
				unset($CF)	;
				?>
                <tr>
                    <th scope="row"><?php echo ($i+1)?></th>
                    <td><?php echo $cfcalcolato[$i]?></td>
                    <td><?php echo $cognomi[$i]?></td>
                    <td><?php echo $nomi[$i]?></td>
                    <td><?php echo $dnascita[$i]?></td>
                    <td><?php echo $descr[$i]?></td>
                    <td><?php echo $sesso[$generi[$i]]?></td>
                </tr>
				<?php }
				}?>
                <!-- Aggiungi altre righe della tabella qui -->
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>