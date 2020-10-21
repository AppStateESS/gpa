<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

namespace gpa\Resource;

class ReportData extends \phpws2\Resource
{

    protected $id;
    protected $name;
    protected $user;
    protected $created_on;
    protected $term;
    protected $table = 'report_data';

    public function __construct()
    {
        $this->id = new \phpws2\Variable\IntegerVar(0, 'id');
        $this->name = new \phpws2\Variable\StringVar(null, 'name', 100);
        $this->username = new \phpws2\Variable\StringVar(null, 'username', 50);
        $this->created_on = new \phpws2\Variable\DateTime(CURRENT_TIMESTAMP, 'created_on');
        $this->term = new \phpws2\Variable\StringVar(null, 'term', 50);
        parent::__construct();
    }

}
