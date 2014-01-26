<?php namespace Carbontwelve\ButtonBoard\Controllers;

class AdminPages extends Controller
{

    /**
     * @inherit
     */
    public function __construct( \Carbontwelve\ButtonBoard\App $app )
    {
        parent::__construct( $app );

        // Double check that we are an admin
        // @todo: figure out how to make this do a nice "wordpress" not authorised page
        if (! is_admin() ){ exit('You are not authorised to view this area.'); }

        add_action('admin_menu', array($this, 'registerAdminMenu'));
        $this->flashMessages['inputs'] = $this->sanitizeInputs();
    }

    public function registerAdminMenu()
    {
        add_menu_page(
            'Simons Button Board', // The text to be displayed in the title tags of the page when the menu is selected
            'Button Board', // The on-screen name text for the menu
            'manage_options', // The capability required for this menu to be displayed to the user.
            'button_board_index', // The slug name to refer to this menu by (should be unique for this menu).
            array($this, 'index_router'), // The function that displays the page content for the menu page.
            plugins_url('simons-button-board/public/img/icon.png'), // The icon for this menu.
            90.1 // The position in the menu order this menu should appear.
        );

        add_submenu_page(
            'button_board_index', // The slug name for the parent menu
            'Add New Button', // The text to be displayed in the title tags of the page when the menu is selected
            'Add New', // The text to be used for the menu
            'manage_options', // The capability required for this menu to be displayed to the user.
            'button_board_add', // The slug name to refer to this menu by (should be unique for this menu).
            array($this, 'add_router')
        );

        add_submenu_page(
            'button_board_index', // The slug name for the parent menu
            'Settings', // The text to be displayed in the title tags of the page when the menu is selected
            'Settings', // The text to be used for the menu
            'manage_options', // The capability required for this menu to be displayed to the user.
            'button_board_settings', // The slug name to refer to this menu by (should be unique for this menu).
            array($this, 'settings_router')
        );
    }

    public function settings_router()
    {
        echo $this->app->renderView(
            'settings',
            array(
                'flashMessages' => $this->flashMessages
            )
        );
    }

    public function add_router()
    {

        $allowedActions = array('add', 'save');
        $action         = ( isset($_GET['action']) ) ? $_GET['action'] : $allowedActions[0];
        if (!in_array($action, $allowedActions)) {
            $action = $allowedActions[0];
        }

        switch ($action) {
            case 'save':
                echo $this->save();
                break;

            case 'add':
            default:
                echo $this->add();
                break;
        }

    }

    public function index_router()
    {

        // Which "route" is this?
        $allowedActions = array('index', 'disable', 'enable', 'ban', 'archive', 'unarchive', 'trash', 'untrash');
        $action         = ( isset($_GET['action']) ) ? $_GET['action'] : $allowedActions[0];
        if (!in_array($action, $allowedActions)) {
            $action     = $allowedActions[0];
        }

        // Route to the correct method...

        switch ($action) {

            case 'disable':
                $this->disable($_GET['id']);
                break;

            case 'enable':
                $this->enable($_GET['id']);
                break;

            case 'unarchive':
                $this->unarchive($_GET['id']);
                break;

            case 'archive':
                $this->archive($_GET['id']);
                break;

            case 'untrash':
                $this->untrash($_GET['id']);
                break;

            case 'trash':
                $this->trash($_GET['id']);
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
        $type         = ( isset($_GET['type']) ) ? $_GET['type'] : $allowedTypes[0];
        if (!in_array($type, $allowedTypes)) {
            $type     = $allowedTypes[0];
        }

        /** @var \Carbontwelve\ButtonBoard\Models\Banners $model */
        $model = $this->app->getModel('banners');
        $data  = $model->getPaginated($type);

        $count = array(
            'all' => $model->count('all'),
            'archived' => $model->count('archived'),
            'trash' => $model->count('deleted')
        );

        return $this->app->renderView(
            'index',
            array(
                'pagination' => $model->getPagination(),
                'data' => $data,
                'type' => $type,
                'count' => $count,
                'flashMessages' => $this->flashMessages
            )
        );
    }

    public function add()
    {
        return $this->app->renderView(
            'add',
            array(
                'flashMessages' => $this->flashMessages
            )
        );
    }

    public function save()
    {
        // Include darth validation lib
        require __DIR__ . "/../../Vendor/darth/darth.php";

        $validator = darth(
            force(
                'required',
                'author',
                'The Banner Author field is required'
            ),
            force(
                'required|email',
                'email',
                'The Banner Author Email field is invalid'
            ),
            force(
                'required|regex',
                'button_src',
                '/^(http(?:s)?\:\/\/[a-zA-Z0-9\-]+(?:\.[a-zA-Z0-9\-]+)*\.[a-zA-Z]{2,6}(?:\/?|(?:\/[\w\-]+)*)(?:\/?|\/\w+\.[a-zA-Z]{2,4}(?:\?[\w]+\=[\w\-]+)?)?(?:\&[\w]+\=[\w\-]+)*)$/',
                'The Banner image field is invalid'
            ),
            force(
                'required|regex',
                'link_url',
                '/^(http(?:s)?\:\/\/[a-zA-Z0-9\-]+(?:\.[a-zA-Z0-9\-]+)*\.[a-zA-Z]{2,6}(?:\/?|(?:\/[\w\-]+)*)(?:\/?|\/\w+\.[a-zA-Z]{2,4}(?:\?[\w]+\=[\w\-]+)?)?(?:\&[\w]+\=[\w\-]+)*)$/',
                'The Banner link field is invalid'
            )
        );

        $this->flashMessages['errors'] = $validator($this->flashMessages['inputs']);
        if (count($this->flashMessages['errors']) > 0) {
            $this->flashMessages['error'] = "Sorry, your form could not be saved as its not valid. ";
            return $this->add();
        } else {

            /** @var \Carbontwelve\ButtonBoard\Models\Banners $model */
            $model = $this->app->getModel('banners');
            $result = $model->insert($this->flashMessages['inputs']);

            if ($result === false) {
                $this->flashMessages['error'] = "Sorry there was an error saving that form.";
                return $this->add();
            } else {
                $this->flashMessages['success'] = $result . " banner has been saved.";
                return $this->index();
            }
        }
    }

    public function unarchive($recordID = null)
    {
        /** @var \Carbontwelve\ButtonBoard\Models\Banners $model */
        $model = $this->app->getModel('banners');
        $result = $model->update($recordID, array('archived' => 0));

        if ($result === false) {
            $this->flashMessages['error'] = 'There was an error unarchiving that banner.';
        } else {
            $this->flashMessages['success'] = '1 banner unarchived. <a href="' . admin_url(
                ) . 'admin.php?page=button_board_index&amp;action=archive&amp;id=' . $recordID . '">Undo</a>';
        }

        echo $this->index();
    }

    public function archive($recordID = null)
    {
        /** @var \Carbontwelve\ButtonBoard\Models\Banners $model */
        $model = $this->app->getModel('banners');
        $result = $model->update($recordID, array('archived' => 1));

        if ($result === false) {
            $this->flashMessages['error'] = 'There was an error archiving that banner.';
        } else {
            $this->flashMessages['success'] = '1 banner archived. <a href="' . admin_url(
                ) . 'admin.php?page=button_board_index&amp;action=unarchive&amp;id=' . $recordID . '">Undo</a>';
        }

        echo $this->index();
    }

    public function trash($recordID = null)
    {
        /** @var \Carbontwelve\ButtonBoard\Models\Banners $model */
        $model = $this->app->getModel('banners');
        $result = $model->update($recordID, array('deleted_at' => date('Y-m-d H:i:s')));

        if ($result === false) {
            $this->flashMessages['error'] = 'There was an error moving that banner to the trash.';
        } else {
            $this->flashMessages['success'] = '1 banner moved to the Trash. <a href="' . admin_url(
                ) . 'admin.php?page=button_board_index&amp;action=untrash&amp;id=' . $recordID . '">Undo</a>';
        }

        echo $this->index();
    }

    public function untrash($recordID = null)
    {
        /** @var \Carbontwelve\ButtonBoard\Models\Banners $model */
        $model = $this->app->getModel('banners');
        $result = $model->update($recordID, array('deleted_at' => null));

        if ($result === false) {
            $this->flashMessages['error'] = 'There was an error moving that banner out of the trash.';
        } else {
            $this->flashMessages['success'] = '1 banner removed from the Trash. <a href="' . admin_url(
                ) . 'admin.php?page=button_board_index&amp;action=trash&amp;id=' . $recordID . '">Undo</a>';
        }

        echo $this->index();
    }

    private function disable($recordID = null)
    {
        /** @var \Carbontwelve\ButtonBoard\Models\Banners $model */
        $model = $this->app->getModel('banners');
        $result = $model->update($recordID, array('enabled' => 0));

        if ($result === false) {
            $this->flashMessages['error'] = 'There was an error disabling that banner.';
        } else {
            $this->flashMessages['success'] = '1 banner disabled. <a href="' . admin_url(
                ) . 'admin.php?page=button_board_index&amp;action=enable&amp;id=' . $recordID . '">Undo</a>';
        }

        echo $this->index();
    }

    private function enable($recordID = null)
    {
        /** @var \Carbontwelve\ButtonBoard\Models\Banners $model */
        $model = $this->app->getModel('banners');
        $result = $model->update($recordID, array('enabled' => 1));

        if ($result === false) {
            $this->flashMessages['error'] = 'There was an error enabling that banner.';
        } else {
            $this->flashMessages['success'] = '1 banner enabled. <a href="' . admin_url(
                ) . 'admin.php?page=button_board_index&amp;action=disable&amp;id=' . $recordID . '">Undo</a>';
        }
        echo $this->index();
    }

    public function update($recordID = null, $data)
    {

        if (is_null($recordID)) {
            return false;
        }

        return true;

    }

}
