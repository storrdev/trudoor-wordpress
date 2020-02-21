<?php

$consumer_key       = "3abd48f9b384b739f1752b511f1fcf1d";
$consumer_secret    = "804c2d4609161739fb63966efb698738";
$token              = "afbd4eae2da0cb7baa61b4af754ed044";
$token_secret       = "eadfa0c646df41129f2d694dca0a669a";


try {

    $oauth = new OAuth($consumer_key, $consumer_secret);

} catch (OAuthException $e) {
    print_r($e->getMessage());
    echo "&lt;br/&gt;";
    print_r($e->lastResponse);
}