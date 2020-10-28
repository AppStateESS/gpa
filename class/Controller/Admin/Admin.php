<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

namespace gpa\Controller\Admin;

use gpa\Controller\SubController;
use gpa\Factory\AdminFactory;
use Canopy\Request;

class Admin extends SubController
{

    protected $view;

    public function __construct()
    {
        parent::__construct();
        $this->view = new \gpa\View\View();
    }

    public function show()
    {
        return $this->view->show();
    }

}
