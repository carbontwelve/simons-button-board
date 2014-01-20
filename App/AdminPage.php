<?php namespace Carbontwelve\ButtonBoard\App;

class AdminPage
{

	protected $app;

	protected $flashMessages = array(
		'success' => false,
		'error'   => false
		);

	public function __construct($app)
	{
		$this->app = $app;
		add_action( 'admin_menu', array( $this, 'registerAdminMenu' ) );
	}

	public function registerAdminMenu()
	{
		add_menu_page( 
			'Simons Button Board', 										// The text to be displayed in the title tags of the page when the menu is selected
			'Button Board', 											// The on-screen name text for the menu
			'manage_options', 											// The capability required for this menu to be displayed to the user.
			'button_board_index', 										// The slug name to refer to this menu by (should be unique for this menu).
			array($this, 'index_router'),     							// The function that displays the page content for the menu page.
			plugins_url( 'simons-button-board/public/img/icon.png' ),	// The icon for this menu.
			90.1 										    			// The position in the menu order this menu should appear.
		);

		add_submenu_page(
			'button_board_index',										// The slug name for the parent menu
			'Add New Button',											// The text to be displayed in the title tags of the page when the menu is selected
			'Add New',													// The text to be used for the menu
			'manage_options', 											// The capability required for this menu to be displayed to the user.
			'button_board_add', 										// The slug name to refer to this menu by (should be unique for this menu).
			array($this, 'add_router')
		);
	}

	public function add_router()
	{

		$allowedActions = array('add');
		$action  = $_GET['action'];
		if ( ! in_array($action, $allowedActions)){ $action = $allowedActions[0]; }

		switch ($action)
		{
			case 'add':
			default:
				echo $this->add();
				break;
		}

	}

	public function index_router()
	{

		// Which "route" is this?
		$allowedActions = array('index', 'disable', 'ban', 'archive', 'unarchive', 'trash', 'untrash');
		$action  = $_GET['action'];
		if ( ! in_array($action, $allowedActions)){ $action = $allowedActions[0]; }

		// Route to the correct method...

		switch ($action)
		{

			case 'unarchive':
				$this->unarchive( $_GET['id'] );
				break;

			case 'archive':
				$this->archive( $_GET['id'] );
				break;
		
			case 'untrash':
				$this->untrash( $_GET['id'] );
				break;

			case 'trash':
				$this->trash( $_GET['id'] );
				break;

			case 'index':
			default:
				echo $this->index();
				break;
		}
	}

	public function index()
	{

		// Which record types are we after?
		$allowedTypes = array('all', 'archived', 'deleted');
		$type  = $_GET['type'];
		if ( ! in_array($type, $allowedTypes)){ $type = $allowedTypes[0]; }

		$model = $this->app->getModel('banners');
		$data  = $model->getAll($type);

		$count = array(
			'all'      => $model->count('all'),
			'archived' => $model->count('archived'),
			'trash'    => $model->count('deleted')
		);

		return $this->app->renderView('index', array(
			'data'  => $data, 
			'type'  => $type,
			'count' => $count,
			'flashMessages' => $this->flashMessages
			));
	}

	public function add()
	{
		return $this->app->renderView('add', array(
			'flashMessages' => $this->flashMessages
			));
	}

	public function unarchive ( $recordID = null )
	{
		$model  = $this->app->getModel('banners');
		$result = $model->update($recordID, array( 'archived' => 0 ));

		if ($result === false)
		{
			$this->flashMessages['error']   = 'There was an error unarchiving that banner.';
		}else{
			$this->flashMessages['success'] = '1 banner unarchived. <a href="'.admin_url().'admin.php?page=button_board_index&amp;action=archive&amp;id='.$recordID.'">Undo</a>'; 
		}

		echo $this->index();
	}

	public function archive ( $recordID = null )
	{
		$model  = $this->app->getModel('banners');
		$result = $model->update($recordID, array( 'archived' => 1 ));

		if ($result === false)
		{
			$this->flashMessages['error']   = 'There was an error archiving that banner.';
		}else{
			$this->flashMessages['success'] = '1 banner archived. <a href="'.admin_url().'admin.php?page=button_board_index&amp;action=unarchive&amp;id='.$recordID.'">Undo</a>'; 
		}

		echo $this->index();
	}

	public function trash ( $recordID = null )
	{
		$model  = $this->app->getModel('banners');
		$result = $model->update($recordID, array( 'deleted_at' => date('Y-m-d H:i:s') ));
		
		if ($result === false)
		{
			$this->flashMessages['error']   = 'There was an error moving that banner to the trash.';
		}else{
			$this->flashMessages['success'] = '1 banner moved to the Trash. <a href="'.admin_url().'admin.php?page=button_board_index&amp;action=untrash&amp;id='.$recordID.'">Undo</a>'; 
		}

		echo $this->index();
	}

	public function untrash ( $recordID = null )
	{
		$model  = $this->app->getModel('banners');
		$result = $model->update($recordID, array( 'deleted_at' => NULL ));
		
		if ($result === false)
		{
			$this->flashMessages['error']   = 'There was an error moving that banner out of the trash.';
		}else{
			$this->flashMessages['success'] = '1 banner removed from the Trash. <a href="'.admin_url().'admin.php?page=button_board_index&amp;action=trash&amp;id='.$recordID.'">Undo</a>'; 
		}

		echo $this->index();
	}

	public function update( $recordID = null, $data )
	{

		if (is_null($recordID)){ return false; }



	}
}