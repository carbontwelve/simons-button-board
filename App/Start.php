<?php namespace Carbontwelve\ButtonBoard\App;

// Define our APP_PATH as used by the very simple view engine
define(__NAMESPACE__ . '\APP_PATH', __DIR__);
define(__NAMESPACE__ . '\PLUGIN_URL', plugins_url('simons-button-board/'));

class Start
{

    /** Instance of Class App **/
    protected $app;

    /** @var Plugin Version * */
    protected $version = "1.0.0";

    /**
     * Check to see if plugin is loaded, and if so fire $this->loaded
     */
    function __construct()
    {
        // If our plugin is loaded and activated then we need to start it up
        add_action('plugins_loaded', array($this, 'loaded'));
    }

    /**
     * Load plugin classes and initiate everything
     */
    function loaded()
    {
        // "Load" plugin
        $this->app = new App(
            __DIR__,
            plugins_url('simons-button-board/')
        );

        $this->app->registerModel('banners', '\\Carbontwelve\\ButtonBoard\\App\\Models\\Banners');

        // Run install/upgrade if not already installed/upgraded
        // This has to be loaded after the models have been registered...
        if (get_site_option('carbontwelve_buttonboard_version') != $this->version) {
            $this->app->install($this->version);
        }

        // Add Pages to administration
        new AdminPage($this->app);

        // Register short codes
        new ShortCode($this->app);

        // Make plugin available to themes
    }
}
