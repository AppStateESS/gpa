<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

namespace gpa\Resource;

class ReportResults extends \phpws2\Resource
{

    protected $id;
    protected $first_name;
    protected $last_name;
    protected $banner;
    protected $transfer;
    protected $credits;
    protected $year;
    protected $gpa;
    protected $hs_gpa;
    protected $term;
    protected $term_gpa;
    protected $report_id;
    protected $table = 'report_results';

    public function __construct()
    {
        $this->id = new \phpws2\Variable\IntegerVar(0, 'id');
        $this->first_name = new \phpws2\Variable\StringVar(null, 'first_name', 50);
        $this->last_name = new \phpws2\Variable\StringVar(null, 'last_name', 50);
        $this->banner = new \phpws2\Variable\IntegerVar(0, 'banner');
        $this->transfer = new \phpws2\Variable\BooleanVar(false, 'transfer');
        $this->credits = new \phpws2\Variable\IntegerVar(0, 'credits');
        $this->year = new \phpws2\Variable\StringVar(0, 'year', 50);
        $this->gpa = new \phpws2\Variable\DoubleVar(0, 'gpa');
        $this->hs_gpa = new \phpws2\Variable\DoubleVar(0, 'hs_gpa');
        $this->term = new \phpws2\Variable\StringVar(null, 'term', 50);
        $this->term_gpa = new \phpws2\Variable\DoubleVar(0, 'term_gpa');
        $this->term_gpa = new \phpws2\Variable\IntegerVar(0, 'report_id');
        parent::__construct();
    }

}
