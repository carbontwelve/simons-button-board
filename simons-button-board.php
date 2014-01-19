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
    if ( ! $loader->register()) {
        throw new Exception('Unable to initialize the autoloader.');
    }
    
    // Start Button Board Plugin
    $buttonBoard = new \Carbontwelve\ButtonBoard\App\Start;
