<?php namespace Carbontwelve\ButtonBoard;

/**
 * Plugin Name: Simons Button Board
 * Description: An Updated Bubs Button Board, PHP 5.3+ Only.
 * Plugin URI:
 * Version:     1.0.0
 * Author:      Simon Dann
 * Author URI:  http://photogabble.co.uk
 * License:     GPL
 * Text Domain: simons_button_board
 * Domain Path: /languages
 */

use SplClassLoader;
use Exception;

// Include the PSR-0 Classloader
require __DIR__ . '/Vendor/SplClassLoader.php';

$loader = new SplClassLoader('Carbontwelve\ButtonBoard', __DIR__);
if (!$loader->register()) {
    throw new Exception('Unable to initialize the autoloader.');
}

// Check PHP version is > 5.3 before initiating the class loader as most features
// of PHP that I use here are 5.3+ and possibly even 5.4+ (needs testing on old systems running *obsolete* versions of PHP)
// Some useful help found here:
// http://wordpress.stackexchange.com/questions/63668/autoloading-namespaces-in-wordpress-plugins-themes-can-it-work

// Start Button Board Plugin
$buttonBoard = new \Carbontwelve\ButtonBoard\App\Start;

/**
 *
 * @param int $numberOfButtons
 */
function simons_plugboard($numberOfButtons = 6)
{
    echo 'rar!';
}

// Register actions for plugin activation/deactivation
register_activation_hook( __FILE__, array($buttonBoard, 'activated') );
register_deactivation_hook( __FILE__, array($buttonBoard, 'deactivated') );
