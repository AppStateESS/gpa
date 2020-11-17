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
    protected $resultsView;

    public function __construct()
    {
        parent::__construct();
        $this->view = new \gpa\View\View();
        $this->resultsView = new \gpa\View\ResultsView();
    }

    public function show()
    {
        return $this->view->show();
    }

    public function showResults()
    {
        return $this->resultsView->show();
    }

}
