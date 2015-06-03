<?php

/*
    This file is part of Moodle - http://moodle.org/
    
    Released under GNU General Public License version three (3), for further details,
    review the web page "https://www.gnu.org/licenses/gpl.html" or "license.txt".
	
	A tool for Date rollover and a tool for Individual date adjustment. Jesus lives!
	
	@package    local
	@subpackage dateadjustmenttools
	@copyright  2014 Tsedey Terefe   <snort.test123@gmail.com>
	@copyright  2015 Anton Thelander <anton.thelander@outlook.com>
	@license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

global $CFG, $DB, $OUTPUT, $PAGE;

require_once(__DIR__ .'/../../config.php');
require_once($CFG->libdir.'/moodlelib.php');
require_once($CFG->dirroot.'/local/dateadjustmenttools/index_form.php');
require_once($CFG->dirroot.'/local/dateadjustmenttools/lib.php');

defined('MOODLE_INTERNAL') || die;

$courseid = required_param('courseid', PARAM_INT);

//Check if the course id is valid.
if ( !($course = $DB->get_record('course', array('id'=>$courseid))) ) {
    print_error('invalidcourseid', 'error');
    return;
}

//Check if the course has a context.
if ( !$context = context_course::instance($course->id) ) {
    print_error('nocontext');
    return;
}

//The $course login variable enables the navigation bar, navbar. This is also for security.
require_login ($course);
//Require capability is here for security.
require_capability ('local/dateadjustmenttools:writepermission', $context);

//These two rows are a must so Moodle won't complain.
$url = new moodle_url('/local/dateadjustmenttools/index.php', array('courseid' => $courseid));
$PAGE->set_url($url); //An example for use of this row is changing language.

//Setting the title of the page and the heading, coming just above the navbar.
$pluginname = get_string('pluginname', 'local_dateadjustmenttools');
$PAGE->set_title($course->fullname.': '.$pluginname);
$PAGE->set_heading($course->fullname.': '.$pluginname);

//Determining what language that's used for the session.
$lang = 'nolang';
if ($pluginname == 'Date adjustment tools') {
    $lang = 'en';
} else if ($pluginname == 'Datumjusteringsverktyg') {
    $lang = 'sv';
}

//Adding some data that will be useful in the form.
$customdata = array ('courseid' => $courseid, 'lang' => $lang);
$mform = new index_form ($url->out(), $customdata);
 
//Form processing and displaying is done here.
if ( $mform->is_cancelled() ) { //Cancellation, going back to the course home page.
    $url = new moodle_url('/course/view.php', array ('id' => $courseid));
    redirect($url);
} else if ( $data = $mform->get_data() ) {
    if ( ($data->selecttool) == 1 ) { //Date rollover.
        local_dateadjustmenttools_rollover_dates ($data, $courseid);
    } else if ( ($data->selecttool) == 2 ) { //Individual date adjustment.
        local_dateadjustmenttools_change_course_start_date ($data, $courseid); //Course start date adjustment.
        
		for ($i = 0; $i < $data->numberofassignments; $i++) { //Assignment date adjustment.
            local_dateadjustmenttools_change_assignment_dates ($data, $courseid, $i);
        }
        
		for ($i = 0; $i < $data->numberofquizzes; $i++) { //Quiz date adjustment.
            local_dateadjustmenttools_change_quiz_dates ($data, $courseid, $i);
        }
    }
    
    local_dateadjustmenttools_change_settings ($data); //Settings adjustment.
    
    $url = new moodle_url('/local/dateadjustmenttools/index.php', array ('courseid' => $courseid));
    redirect($url);
} else {
    echo $OUTPUT->header(); //Display the Moodle header.
    
    $mform->display(); //Display the form.
    
    echo $OUTPUT->footer(); //Display the Moodle footer.
}
