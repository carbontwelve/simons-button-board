<?php namespace Carbontwelve\ButtonBoard\App\Models;

class Banners implements BaseModelInterface
{

    protected $app;

    /** @var wpdb */
    protected $wpdb;
    /** @var string $table Table name */
    protected $table = 'buttons';
    /** @var string $tableVersion Version of this table */
    protected $tableVersion = "1.0.0";

    public function __construct($wpdb, $app)
    {
        $this->wpdb = $wpdb;
        $this->app = $app;
    }

    public function install()
    {
        $tableName = $this->wpdb->prefix . $this->table;
        $installedVersion = get_option("carbontwelve_buttonboard_banners_db_version");

        if ($installedVersion === false) {

            // Install our table
            $sql = "" .
                "CREATE TABLE `$tableName`
			(
	  			id mediumint(9) NOT NULL AUTO_INCREMENT,
	  			created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	  			updated_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	  			deleted_at datetime DEFAULT NULL NULL,
	  			created_by mediumint(9) NOT NULL,
	  			updated_by mediumint(9) NOT NULL,
	  			deleted_by mediumint(9) NOT NULL,
	  			author VARCHAR(100) NOT NULL,
	  			email VARCHAR(250) NOT NULL,
	  			link_url VARCHAR(250) NOT NULL,
	  			button_src VARCHAR(250) DEFAULT '' NOT NULL,
	  			views mediumint(9) NOT NULL,
	  			clicks mediumint(9) NOT NULL,
	  			archived tinyint(1) DEFAULT FALSE NOT NULL,
	  			UNIQUE KEY id (id)
	    	);";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);

            add_option("carbontwelve_buttonboard_banners_db_version", $this->tableVersion);

            // Insert default first banner :)
            $sql = "INSERT INTO `$tableName`
				(
					`created_at`,
					`author`,
					`email`,
					`button_src`,
					`link_url`
				)
				VALUES(
					'" . date('Y-m-d H:i:s') . "',
					'Simon Dann',
					'simon.dann@gmail.com',
					'" . $this->app->getPluginUrl() . "public/img/default.gif',
					'http://www.photogabble.co.uk'
				)";
            $this->wpdb->query($sql);

        } elseif ($installedVersion != $this->version) {
            // Upgrade our table

            // Upgrade sql will be here
            // update_option( "carbontwelve_buttonboard_banners_db_version", $this->version );
        }
    }

    protected function getQueryEnd($type = 'all')
    {
        switch ($type) {
            case 'deleted':
                $query = "`" . $this->wpdb->prefix . $this->table . "` WHERE `deleted_at` IS NOT NULL";
                break;

            case 'archived':
                $query = "`" . $this->wpdb->prefix . $this->table . "` WHERE `archived` = TRUE AND `deleted_at` IS NULL";
                break;

            default:
            case 'all':
                $query = "`" . $this->wpdb->prefix . $this->table . "` WHERE `deleted_at` IS NULL";
                break;
        }

        return $query;
    }

    public function getAll($type = 'all')
    {
        $query = 'SELECT * FROM ' . $this->getQueryEnd($type);
        return $this->wpdb->get_results($query);
    }

    public function count($type = 'all')
    {
        $query = 'SELECT COUNT(`id`) as `c` FROM ' . $this->getQueryEnd($type);
        return $this->wpdb->get_var($query);
    }

    public function update($id = null, Array $data)
    {
        if (!isset($data['updated_at'])) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        $sqlParts = array();
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $format = '%s';
            } else {
                $format = '%d';
            }
            if (is_null($value)) {
                $format = 'NULL';
            }

            $sqlParts[] = '`' . $key . '` = ' . $format;

            if ($format == 'NULL') {
                unset($data[$key]);
            }
        }

        $sqlParts = implode(',', $sqlParts);
        $sqlValues = array_values($data);

        var_dump($sqlValues);

        $sql = $this->wpdb->prepare(
            "UPDATE `" . $this->wpdb->prefix . $this->table . "` SET " . $sqlParts . " WHERE `id` = " . intval($id),
            $sqlValues
        );

        var_dump($sql);

        return $this->wpdb->query($sql);
    }

    public function insert(Array $data)
    {

        if (!isset($data['created_at'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        $sqlParts = array();
        foreach ($data as $value) {
            if (is_string($value)) {
                $format = '%s';
            } else {
                $format = '%d';
            }
            if (is_null($value)) {
                $format = 'NULL';
            }

            $sqlParts[] = $format;
        }

        $sqlKeys = array_keys($data);
        foreach ($sqlKeys as &$value) {
            $value = '`' . $value . '`';
        }
        unset($value);

        $sqlKeys = implode(',', $sqlKeys);
        $sqlParts = implode(',', $sqlParts);
        $sqlValues = array_values($data);

        $sql = $this->wpdb->prepare(
            "INSERT INTO `" . $this->wpdb->prefix . $this->table . "` (" . $sqlKeys . ") VALUES (" . $sqlParts . ")",
            $sqlValues
        );

        return $this->wpdb->query($sql);
    }
}
