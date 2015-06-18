<?php
require_once('/var/www/api-twitter/connection.php');
$connection = new connection();
$myConnectionTwitter = $connection->connectionTwitter();
if (empty($argv[1])) {
    echo "Introduce el fichero a borrar sus ids";
    exit();
}
//el nombre del fichero es:
$fileName = $argv[1];
// recorrer leyendo el fichero
if (!file_exists('tags-sin-borrar/' . $fileName)) {
    echo "No existe el fichero indicado";
    exit();
}
$file = fopen('tags-sin-borrar/' . $fileName, "r");
$cont = 0;
// leemos el archivo y destruimos las relaciones con la que no nos sigue
while(!feof($file)) {
    $cont++;
    $idFile = fgets($file);
    $idFileExplode = explode(' ', $idFile);
    $res = $myConnectionTwitter->post("https://api.twitter.com/1.1/friendships/destroy.json?user_id=" . $idFileExplode[0]);
    var_dump($res);
    // si es igual a cero dormimos 2 segundos para evitar posibles banneos
    if ($cont%10 == 0) {
        sleep(2);
    }
}
moverRenombrarFichero($fileName);
fclose($file);

/**
 * moverRenombrarFichero
 * vamos a mover el fichero a la carpeta de tag ya borrados y a renombrarlo 
 *
 * @param mixed $fileName Description.
 *
 * @access public
 *
 * @return mixed Value.
 */
function moverRenombrarFichero($fileName) {
    //renombrar y mover
    rename('tags-sin-borrar/' . $fileName, 'tags-borrados/1-' . $fileName);
    return true;
}
?>
