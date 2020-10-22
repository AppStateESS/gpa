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
    protected $table = 'gpa_data';

    public function __construct()
    {
        $this->id = new \phpws2\Variable\IntegerVar(0, 'id');
        $this->name = new \phpws2\Variable\StringVar(null, 'name', 100);
        $this->username = new \phpws2\Variable\StringVar(null, 'username', 50);
        $this->created_on = new \phpws2\Variable\DateTime(0, 'created_on');
        $this->term = new \phpws2\Variable\StringVar(null, 'term', 50);
        parent::__construct();
        $this->created_on->stamp();
    }
/*
    public function getTimeStamp()
    {
        $date = new DateTime();
        $date = $date->getTimestamp();
        return $date->format('Y-m-d H:i:s');
    }
*/
}
