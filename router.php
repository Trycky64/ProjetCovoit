<?php
// router.php

// Si le fichier demandé est un fichier statique, PHP doit le servir tel quel
if (preg_match('/\.(?:css|js|png|jpg|jpeg|gif|ico|svg|woff2?|ttf|eot)$/', $_SERVER["REQUEST_URI"]) && file_exists(__DIR__ . $_SERVER["REQUEST_URI"])) {
    return false;
}

// Sinon on renvoie vers l'index
require __DIR__ . '/index.php';
