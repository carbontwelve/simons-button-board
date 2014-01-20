<?php namespace Carbontwelve\ButtonBoard\App;

Class App
{

	protected $path;
	protected $pluginUrl;

	/** @var \Carbontwelve\ButtonBoard\App\View */
	protected $view;

	protected $models = array();

	protected $wpdb;

	/**
	 * Setup our plugin environment
	 * @param string|null $path
	 * @param string|null $pluginUrl
	 */
	public function __construct($path = null, $pluginUrl = null)
    {
    	global $wpdb;
    	$this->wpdb      = $wpdb;
    	$this->path      = $path;
    	$this->pluginUrl = $pluginUrl;
    	$this->view      = new View($this->path . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR);
    }

    public function registerModel( $className, $class )
    {
		$this->models[$className] = new $class( $this->wpdb, $this );
    }

    public function getModel( $className )
    {
    	return $this->models[$className];
    }

    public function getPluginUrl()
    {
    	return $this->pluginUrl;
    }

    public function install($version = "1.0.0")
    {
    	if (count($this->models) > 0)
    	{
    		foreach( $this->models as $model )
    		{
    			$model->install();
    		}
    	}

    	if ($version === false)
    	{
    		add_option( "carbontwelve_buttonboard_version", $version );
    	}else{
    		update_option( "carbontwelve_buttonboard_version", $version );
    	}
    }

    /**
     * Render a given view file and return the result
     * @param  string $template
     * @param  array  $data
     * @return string
     */
    public function renderView( $template = '', $data = array() ) 
    {
    	return $this->view->render($template, $data);
    }

}