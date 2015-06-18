<?php
class saveIdUsers {
/**
 * saveIdUsersTwitter
 * escribimos los id obetenido en el fichero
 * 
 * @param mixed $usersTwitterTag Description.
 * @param mixed $tag             Description.
 * @param mixed $date            Description.
 *
 * @access public
 *
 * @return mixed Value.
 */
    function saveIdUsersTwitter($usersTwitterTag, $tag, $date) {
        $fileName = $tag . '-' . $date . '.txt';
        foreach ($usersTwitterTag as $t) {
            $file = fopen('tags-sin-borrar/' . $fileName, "a");
            if (!empty($t->id_str)) {
                fwrite($file, $t->id_str . ' ' . $t->screen_name .  ' ' . $date . PHP_EOL);
            } else {
                fclose($file);
                return $fileName;
            }
        }
        fclose($file);
        return $fileName;
    }
}
?>