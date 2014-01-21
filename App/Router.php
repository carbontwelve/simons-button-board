<?php namespace Carbontwelve\ButtonBoard\App;

class Router
{
    protected $app;

    // Note: For this to work the user has to rerun their rewrite rules from config. Need to automate that on plugin install!

    public function __construct( $app )
    {
        $this->app = $app;
        add_action( 'init', array($this, 'go') );
    }

    public function go()
    {
        if ( ! is_admin() )
        {
            //echo 'hello world';
        }

    }
}
