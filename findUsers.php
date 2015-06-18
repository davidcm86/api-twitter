<?php
class findUsers {
/**
 * find
 * buscamos los usuarios mediante un tag 
 *
 * @param mixed $tag        Description.
 * @param mixed $connection Description.
 * @param mixed $page       Description.
 *
 * @access public
 *
 * @return mixed Value.
 */
    function find($tag, $connection, $page) {
        $users = $connection->get("https://api.twitter.com/1.1/users/search.json?q=" . $tag . '&page=' . $page);
        return $users;
    }
}
?>