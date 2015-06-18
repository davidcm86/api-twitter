<?php
require_once('/var/www/api-twitter/connection.php');
require_once('/var/www/api-twitter/findUsers.php');
require_once('/var/www/api-twitter/saveIdUsers.php');
require_once('/var/www/api-twitter/createFollowers.php');
// comprobamos si ya hemos buscado el tag o no
$tag = existeTag($argv);
// vamos a realizar la conexión
$connection = new connection();
$myConnectionTwitter = $connection->connectionTwitter();
$page = '1'; // la paginación empieza en ....tendré que ir aumentando de 1 a 10, 20, 30....
$pageLimit = '100'; // paginamos 5,10,15, veces...lo que pongamos
$date = date('dmY');
$nombreFichero = $tag . '-' . $date . '.txt';
echo "El nombre del fichero es: " . $nombreFichero;

do {
	// buscamos usuarios de twitter por un tag determinado
	$findUsers = new findUsers();
	$usersTwitterTag = $findUsers->find($tag, $myConnectionTwitter, $page);
	// salvamos los usuarios en un fichero
	$saveIdUsers = new saveIdUsers();
	$fileName = $saveIdUsers->saveIdUsersTwitter($usersTwitterTag, $tag, $date);
	$page++;
	sleep(2); // para no saturar la api, nos echamos 2 segundos
} while ($page <= $pageLimit && $usersTwitterTag);

// creamos los followers del fichero
$createFollower = new createFollowers();
$usersTwitterTag = $createFollower->createFollowerTwitter($myConnectionTwitter, $nombreFichero);
exit();

/**
 * buscarTag
 * pasamos un tag para ver si existe o no en nuestro archivo de tags  
 *
 * @param mixed $tag Description.
 *
 * @access public
 *
 * @return mixed Value.
 */
	function existeTag($tag) {
		if (empty($tag[1])) {
			echo "Debe especificar un tag";
			exit();
		} else {
			// miramos si existe el fichero y buscamos el tag en el archivo de tags
			$fileName = 'tags.txt';
			if (!file_exists($fileName)) {
				$fileName = fopen($fileName, 'w') or die("No se puede crear el fichero");
			}
			$file = fopen($fileName, "r");
			while(!feof($file)) {
		    	$tagsFile = fgets($file);
		    	$tagsFile = trim($tagsFile); // quitamos espacios en blanco
		    	if ($tagsFile == $tag[1]) {
		    		echo "Ya existe el tag: " .  $tag[1];
		    		exit();
		    	}
		    }
		}
		// si no hemos roto el ciclo del método con el exit, significa que no existe el tag por lo que si se puede crear
		return $tag[1];
		exit();
	}
?>
