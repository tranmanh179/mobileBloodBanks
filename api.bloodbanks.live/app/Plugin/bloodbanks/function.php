<?php 
function getGUID()
{
    return bin2hex(openssl_random_pseudo_bytes(64));
}
?>