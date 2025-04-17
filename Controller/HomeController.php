<?php
require_once __DIR__ . '/../View/home.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
