<?php
class createFollowers {
/**
 * createFollowerTwitter
 * cogemos el id y creamos la relación 
 *
 * @param mixed $myConnectionTwitter Description.
 * @param mixed $fileName            Description.
 *
 * @access public
 *
 * @return mixed Value.
 */
    function createFollowerTwitter($myConnectionTwitter, $fileName) {
        $file = fopen('tags-sin-borrar/' . $fileName, "r");
            $cont = 0;
            while(!feof($file)) {
                $cont++;
                $idFile = fgets($file);
                $idFileExplode = explode(' ', $idFile);
                // creamos el follower
                $resul = $myConnectionTwitter->post("https://api.twitter.com/1.1/friendships/create.json?user_id=" . $idFileExplode[0] . "&follow=true");
                var_dump($resul);
                // si es igual a cero dormimos 2 segundos para evitar posibles banneos
                if ($cont%10 == 0) {
                    sleep(2);
                }
            }
            // meter el tag en el archivo tags
            insertarTag();
            fclose($file);
    }

/**
 * insertarTag
 * metemos el tag en el archivo tags para saber cuales hemos buscado 
 *
 * @access public
 *
 * @return mixed Value.
 */
    function insertarTag($fileName) {
        $tag = explode('-', $fileName);
        echo "El tag en insertarTag es: " . $tag;
        $file = fopen('tags.txt', "a");
        if ($file) {
            if (fwrite($file, $tag . PHP_EOL)) {
                echo "Se han creado los followers";
            } else {
                echo "Ha habido un problema al crear los followers";
            }
        }
        exit();
    }
}
?>