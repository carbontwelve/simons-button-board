<?php namespace Carbontwelve\ButtonBoard;

/**
 * Class Rewrite
 *
 * @package Carbontwelve\ButtonBoard
 * @link http://ruslanbes.com/devblog/2013/04/03/wordpress-routing-explained/
 */
class Rewrite
{

    /** @var \Carbontwelve\ButtonBoard\App */
    protected $app;

    /**
     * @param $app \Carbontwelve\ButtonBoard\App
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @param $wp_rewrite
     * @return void
     */
    public function add_rewrite_rules($wp_rewrite){
        $rules = array(
            'button/out/(.+?)?$' => 'index.php?banner_id=$matches[1]',
        );
        $wp_rewrite->rules = $rules + (array)$wp_rewrite->rules;
    }

    /**
     * @param $query
     * @return void
     */
    public function pre_get_posts( $query ){
        if ( ! is_admin() && $query->is_main_query() && $query->get( 'banner_id' ) ) { // check if user asked for a non-admin page and that query contains except_category_name var

            $recordID = intval($query->get( 'banner_id' ));

            /** @var \Carbontwelve\ButtonBoard\Models\Banners $model */
            $model = $this->app->getModel('banners');
            $result = $model->get( $recordID );

            if (!is_null($result))
            {
                $model->update( $recordID, array('clicks' => ($result->clicks + 1)));
                header("Location: " . $result->link_url, true, 302);
                exit;
            }
            $query->is_404 = true;
        }
    }

    /**
     * @param $public_query_vars
     * @return mixed
     */
    public function query_vars($public_query_vars){
        array_push($public_query_vars, 'banner_id');
        return $public_query_vars;
    }
}
