<?php
/**
 * CONSTANTS
 */
define('CORE_PATH', __DIR__ . DIRECTORY_SEPARATOR);
define('CONFIG', CORE_PATH . 'env.php');
define('AUTOLOAD', CORE_PATH . 'autoload.php');

/**
 * Requires of the application
 */
require_once(AUTOLOAD);
require_once(CORE_PATH . 'vendor/simple_html_dom.php');


// Main controller: for now just get daily free book
$packtpub = new \PacktpubDaily\libraries\Packtpub();

$freeBook = $packtpub->getDailyFreeBook();
if ($freeBook !== null) {
    $packtpub->claim($freeBook);
}