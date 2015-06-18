<?php
class connection {

    function connectionTwitter() {
        session_start();
        require_once("twitteroauth-master/twitteroauth/twitteroauth.php"); //Path to twitteroauth library
         
        $twitteruser = "";
        $consumerkey = "";
        $consumersecret = "";
        $accesstoken = "";
        $accesstokensecret = "";
         
        return $this->getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);

    }

    function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
        $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
        return $connection;
    }
}

?>