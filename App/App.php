<?php namespace Carbontwelve\ButtonBoard\App;

/**
 * Class App
 * @package Carbontwelve\ButtonBoard\App
 */
Class App
{

    /** @var null|string Absolute path to App directory */
    protected $path;
    /** @var null|string URL To plugin root */
    protected $pluginUrl;
    /** @var \Carbontwelve\ButtonBoard\App\View */
    protected $view;
    /** @var array Loaded Models */
    protected $models = array();
    /** @var \wpdb Wordpress database class */
    protected $wpdb;
    /** @var \Carbontwelve\ButtonBoard\App\Rewrite  */
    protected $rewriter;

    /**
     * Setup our plugin environment
     * @param string|null $path
     * @param string|null $pluginUrl
     */
    public function __construct($path = null, $pluginUrl = null)
    {
        /** @var \wpdb $wpdb */
        global $wpdb;
        $this->wpdb      = $wpdb;
        $this->path      = $path;
        $this->pluginUrl = $pluginUrl;
        $this->view      = new View($this->path . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR);
        $this->rewriter  = new Rewrite($this);
    }

    /**
     * Factory method for initiating our models
     *
     * @param $className
     * @param $class
     */
    public function registerModel($className, $class)
    {
        $this->models[$className] = new $class($this->wpdb, $this);
    }

    public function getRewriter()
    {
        return $this->rewriter;
    }

    /**
     * Method for returning a model
     *
     * @param $className
     * @return mixed
     */
    public function getModel($className)
    {
        return $this->models[$className];
    }

    /**
     * Returns Plugins Absolute Path
     * @return null|string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Returns Plugins URL
     * @return null|string
     */
    public function getPluginUrl()
    {
        return $this->pluginUrl;
    }

    /**
     * Method run when plugin is installed/upgraded
     *
     * @param string $version
     */
    public function install($version = "1.0.0")
    {
        if (count($this->models) > 0) {
            foreach ($this->models as $model) {
                $model->install();
            }
        }

        if ($version === false) {
            add_option("carbontwelve_buttonboard_version", $version);
        } else {
            update_option("carbontwelve_buttonboard_version", $version);
        }
    }

    /**
     * Render a given view file and return the result
     * @param  string $template
     * @param  array $data
     * @return string
     */
    public function renderView($template = '', $data = array())
    {
        return $this->view->render($template, $data);
    }

}
