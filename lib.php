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

defined('MOODLE_INTERNAL') || die;

global $CFG;

require_once($CFG->dirroot.'/lib/navigationlib.php');
require_once($CFG->dirroot.'/local/dateadjustmenttools/db/access.php');

//Function for getting the link "Date adjustment tools" under "Course administration" to show.
function local_dateadjustmenttools_extends_settings_navigation ($settingsnav, $context) {
    
    global $CFG, $PAGE;
        
    //If the node 'courseadmin' does not exist, then exit this function via return.
    if (null == ($courseadmin_node = $settingsnav->get('courseadmin'))) {
        return;
    }    
    
    $context_temp = $context;
    
    $context = $PAGE->context;
        
    $coursecontext = $context->get_course_context();
        
    if (!has_capability('local/dateadjustmenttools:writepermission', $coursecontext)) {
        return;
    }
    
    $context = $context_temp;
    
    //If not in a course context, then leave (return), does not work for the login screen?
    if ($context == null || $context->contextlevel != CONTEXT_COURSE) {
        return;
    }
    
    //Make a new node called '$branch' out of the node called 'courseadmin'.
    $branch = $settingsnav -> get('courseadmin');
    
    //Extract the plugin name to the variable '$pn'.
    $pn = get_string('pluginname', 'local_dateadjustmenttools');
    
    //Make an url to 'dateadjustmenttools.php' with the course id appended.
    $url = new moodle_url('/local/dateadjustmenttools/index.php', array('courseid' => $context->instanceid));
    
    //Add a node under '$branch' called '$extrabranch' with the name '$pn' and the url '$url'.
    $extrabranch = $branch->add($pn,$url);/**/
}

//Function for Date rollover.
function local_dateadjustmenttools_rollover_dates ($data, $courseid) {
    global $DB;
	
    $temp=$DB->get_fieldset_select('course', 'startdate', 'id=?', array ($courseid));
    
	$offset = 0;
	
    if ( !empty ($temp) ) {
        $newcoursestartdate = $data->rolloverdate;
        $oldcoursestartdate = $temp[0];
		$offset = $newcoursestartdate - $oldcoursestartdate;
		
		local_dateadjustmenttools_int_validation ($newcoursestartdate);
    }	
    
    $assignments = $DB->get_records('assign', array ('course' => $courseid));
    if ( !empty ($assignments) ) {
        foreach ($assignments as $assignment) {            
            $assignmentrecord = new stdClass();
            
            $assignmentrecord->id=$assignment->id;
            if ( $assignment->allowsubmissionsfromdate != 0 ) {
                $assignmentrecord->allowsubmissionsfromdate = ( ($assignment->allowsubmissionsfromdate) + ($offset) );
            }
            if ( $assignment->duedate != 0 ) {
                $assignmentrecord->duedate = ( ($assignment->duedate) + ($offset) );
            }
            if ( $assignment->cutoffdate != 0 ) {
                $assignmentrecord->cutoffdate = ( ($assignment->cutoffdate) + ($offset) );
            }
            
			$currenttime = time();
            $assignmentrecord->timemodified=$currenttime;
            
            $DB->update_record('assign',$assignmentrecord);
        }
    }
        
    $quizzes = $DB->get_records('quiz', array ('course' => $courseid));
    if ( !empty ($quizzes) ) {
        foreach ($quizzes as $quiz) {
            $quizrecord = new stdClass();
            
            $quizrecord->id=$quiz->id;
            if ( $quiz->timeopen != 0 ) {
                $quizrecord->timeopen = ( ($quiz->timeopen) + ($offset) );
            }
            if ( $quiz->timeclose != 0 ) {
                $quizrecord->timeclose = ( ($quiz->timeclose) + ($offset) );
            }
            
            $quizrecord->timemodified = $currenttime;
            
            $DB->update_record('quiz', $quizrecord);
        }
    }
    
    $coursedates=$DB->get_records('course', array('id' => $courseid));
    if ( !empty ($coursedates) ) {
        foreach ($coursedates as $coursedate) {
            $courserecord = new stdClass();
            
            $courserecord->id = $coursedate->id;
            $courserecord->startdate = $newcoursestartdate;
            $courserecord->timemodified = $currenttime;
            
            $DB->update_record('course', $courserecord);
        }
    }
    
    $calendarevents=$DB->get_records('event',array ('courseid' => $courseid));
    if ( !empty ($calendarevents) ) {
        foreach ($calendarevents as $calendarevent) {
            $eventrecord = new stdClass();
            
            $eventrecord->id = $calendarevent->id;
            $eventrecord->timestart = ( ($calendarevent->timestart) + ($offset) );
            $eventrecord->timemodified = $currenttime;
            
            $DB->update_record('event', $eventrecord);
        }
    }
}

//Function for changing the course start date.
function local_dateadjustmenttools_change_course_start_date($data, $courseid) {
    global $DB;
    
    $newcoursestartdate = $data->coursestartdate;
    
	local_dateadjustmenttools_int_validation ($newcoursestartdate);
	
    $courserecord = new stdClass();
    $courserecord->id = $courseid;
    $courserecord->startdate = $newcoursestartdate;
    $currenttime = time();
    $courserecord->timemodified = $currenttime;
    
    $DB->update_record('course', $courserecord);
}

//Function for changing the assignment dates with relating calendar events.
function local_dateadjustmenttools_change_assignment_dates($data, $courseid, $localindex) {
    global $DB, $USER;
    
    $assignmentnamestr = 'assignmentname'.$localindex;
    $assignmentname = $data->$assignmentnamestr;
    $assignmentidstr = 'assignmentid'.$localindex;
    $assignmentid = $data->$assignmentidstr;
    $asfdstr = 'assignmentasfd'.$localindex;
    $asfd = $data->$asfdstr;
    $ddstr = 'assignmentdd'.$localindex;
    $dd = $data->$ddstr;
    $codstr = 'assignmentcod'.$localindex;
    $cod = $data->$codstr;
	
	local_dateadjustmenttools_int_validation ($asfd);
	local_dateadjustmenttools_int_validation ($dd);
	local_dateadjustmenttools_int_validation ($cod);
    
    $assignmentrecord = new stdClass();
    $assignmentrecord->id = $assignmentid;
    
    //31622400 is the Unix time for 1971-01-02 00:00.
    if ( $asfd > 31622400 ) {
        $assignmentrecord->allowsubmissionsfromdate = $asfd;
    } else {
        $assignmentrecord->allowsubmissionsfromdate = 0;
    }
    
    //31622400 is the Unix time for 1971-01-02 00:00.
    if ( $dd > 31622400 ) {
        $assignmentrecord->duedate = $dd;
        
        //Calendar event query.
        $query_ass = 'courseid=? AND instance=? AND modulename=? AND eventtype=?';
        $conditions = array($courseid, $assignmentid, 'assign', 'due');
        $get_fieldset_eve = $DB->get_fieldset_select('event', 'id', $query_ass, $conditions);
        
        //Update calendar.
        if ( !empty ($get_fieldset_eve) ) { //If an event exists, update the event.
            $eventrecord = new stdClass();
            
            $eventrecord->id = $get_fieldset_eve[0];
            $eventrecord->timestart = $dd;
            $currenttime = time();
            $eventrecord->timemodified = $currenttime;
            
            $DB->update_record('event',$eventrecord);
        } else { //If an event doesn't exist, create a new calendar event.
            $query_ass = 'course=? AND id=?';
            $conditions = array($courseid, $assignmentid);
            $get_record_ass = $DB->get_fieldset_select('assign', 'intro', $query_ass, $conditions);
            $assignmentdescription = $get_record_ass[0];
            
            $event = new stdClass;
            $event->name         = $assignmentname;
            $event->description  = $assignmentdescription;
            $event->courseid     = $courseid;
            $event->groupid      = 0;
            $event->userid       = $USER->id;
            $event->modulename   = 'assign';
            $event->instance     = $assignmentid;
            $event->eventtype    = 'due';
            $event->timestart    = $dd;
            $event->visible      = 1;
            $event->timeduration = 0;
            $currenttime = time();
            $event->timemodified = $currenttime;
            calendar_event::create($event);
        }
    } else { 
        //If a date in 1970 is selected then change the duedate to 0.
        $assignmentrecord->duedate = 0;
        
        //Calendar event query.
        $query_ass = 'courseid=? AND instance=? AND modulename=? AND eventtype=?';
        $conditions = array($courseid, $assignmentid, 'assign', 'due');
        $get_fieldset_eve = $DB->get_fieldset_select('event', 'id', $query_ass, $conditions);
        
        //Update calendar.
        if( !empty ($get_fieldset_eve) ) { //If there is an event, load it and delete it.
            $calendarevent = calendar_event::load($get_fieldset_eve[0]);
            $calendarevent->delete();
        } //Else do nothing.
    }
    
    //31622400 is the Unix time for 1971-01-02 00:00.
    if ( $cod > 31622400 ) {
        $assignmentrecord->cutoffdate = $cod;
    } else {
        $assignmentrecord->cutoffdate = 0;
    }
    $currenttime = time();
    $assignmentrecord->timemodified = $currenttime;
    
    $DB->update_record('assign', $assignmentrecord);
}

//Function for changing the quiz dates with relating calendar events.
function local_dateadjustmenttools_change_quiz_dates($data, $courseid, $localindex) {
    global $DB,$USER;
    
    $quiznamestr = 'quizname'.$localindex;
    $quizname = $data->$quiznamestr;
    $quizidstr = 'quizid'.$localindex;
    $quizid = $data->$quizidstr;
    $otqstr = 'quizotq'.$localindex;
    $otq = $data->$otqstr;
    $ctqstr = 'quizctq'.$localindex;
    $ctq = $data->$ctqstr;
	
	local_dateadjustmenttools_int_validation ($otq);
	local_dateadjustmenttools_int_validation ($ctq);
    
    $quizrecord = new stdClass();
    $quizrecord->id = $quizid;
    
    //31622400 is the Unix time for 1971-01-02 00:00.
    if ( $otq > 31622400 ) {
        $quizrecord->timeopen = $otq;
        
        //Calendar event query.
        $query_qui = 'courseid=? AND instance=? AND modulename=? AND eventtype=?';
        $conditions = array($courseid, $quizid, 'quiz', 'open');
        $get_fieldset_eve = $DB->get_fieldset_select('event', 'id', $query_qui, $conditions);
        
        //Update calendar.
        if ( !empty ($get_fieldset_eve) ) { //If an event exists, update the event.
            $eventrecord = new stdClass();
            
            $eventrecord->id = $get_fieldset_eve[0];
            $eventrecord->timestart = $otq;
            $currenttime = time();
            $eventrecord->timemodified = $currenttime;
            
            $DB->update_record('event',$eventrecord);
        } else { //If an event doesn't exist, create a new calendar event.
            $query_qui = 'course=? AND id=?';
            $conditions = array($courseid, $quizid);
            $get_record_qui = $DB->get_fieldset_select('quiz', 'intro', $query_qui, $conditions);
            $quizdescription = $get_record_qui[0];
            
            $event = new stdClass;
            $quizopens_str = get_string('quizopenspar' ,'local_dateadjustmenttools');
            $event->name         = $quizname.' '.$quizopens_str;
            $event->description  = $quizdescription;
            $event->courseid     = $courseid;
            $event->groupid      = 0;
            $event->userid       = $USER->id;
            $event->modulename   = 'quiz';
            $event->instance     = $quizid;
            $event->eventtype    = 'open';
            $event->timestart    = $otq;
            $event->visible      = 1;
            $event->timeduration = 0;
            $currenttime = time();
            $event->timemodified = $currenttime;
            
            calendar_event::create($event);
        }
    } else {
        $quizrecord->timeopen = 0;
        
        //Calendar event query.
        $query_eve = 'courseid=? AND instance=? AND modulename=? AND eventtype=?';
        $conditions = array($courseid, $quizid, 'quiz', 'open');
        $get_fieldset_eve = $DB->get_fieldset_select('event', 'id', $query_eve, $conditions);
                
        //Update calendar.
        if( !empty ($get_fieldset_eve) ) { //If there is an event, load it and delete it.
            $calendarevent = calendar_event::load($get_fieldset_eve[0]);
            $calendarevent->delete();
        } //Else do nothing.
    }
    //31622400 is the Unix time for 1971-01-02 00:00.
    if ( $ctq > 31622400 ) {
        $quizrecord->timeclose = $ctq;
        
        //Calendar event query.
        $query_qui = 'courseid=? AND instance=? AND modulename=? AND eventtype=?';
        $conditions = array($courseid, $quizid, 'quiz', 'close');
        $get_fieldset_eve = $DB->get_fieldset_select('event', 'id', $query_qui, $conditions);
        
        //Update calendar.
        if ( !empty ($get_fieldset_eve) ) { //If an event exists, update the event.
            $eventrecord = new stdClass();
            
            $eventrecord->id = $get_fieldset_eve[0];
            $eventrecord->timestart = $ctq;
            $currenttime = time();
            $eventrecord->timemodified = $currenttime;
            
            $DB->update_record('event',$eventrecord);
        } else { //If an event doesn't exist, create a new calendar event.
            $query_qui = 'course=? AND id=?';
            $conditions = array($courseid, $quizid);
            $get_record_qui = $DB->get_fieldset_select('quiz', 'intro', $query_qui, $conditions);
            $quizdescription = $get_record_qui[0];
            
            $event = new stdClass;
            $quizcloses_str = get_string('quizclosespar', 'local_dateadjustmenttools');
            $event->name         = $quizname.' '.$quizcloses_str;
            $event->description  = $quizdescription;
            $event->courseid     = $courseid;
            $event->groupid      = 0;
            $event->userid       = $USER->id;
            $event->modulename   = 'quiz';
            $event->instance     = $quizid;
            $event->eventtype    = 'close';
            $event->timestart    = $ctq;
            $event->visible      = 1;
            $event->timeduration = 0;
            $currenttime = time();
            $event->timemodified = $currenttime;
            
            calendar_event::create($event);
        }
    } else {
        $quizrecord->timeclose = 0;
        
        //Calendar event query.
        $query_eve = 'courseid=? AND instance=? AND modulename=? AND eventtype=?';
        $conditions = array ($courseid, $quizid, 'quiz', 'close');
        $get_fieldset_eve = $DB->get_fieldset_select('event', 'id', $query_eve, $conditions);
                
        //Update calendar.
        if( !empty ($get_fieldset_eve) ) { //If there is an event, load it and delete it.
            $calendarevent = calendar_event::load($get_fieldset_eve[0]);
            $calendarevent->delete();
        } //Else do nothing.
    }
    $currenttime = time();
    $quizrecord->timemodified = $currenttime;
    
    $DB->update_record('quiz', $quizrecord);
}

//Function for changing the plugin expand/collapse settings.
function local_dateadjustmenttools_change_settings ($data) {
    global $DB, $USER;
    
    $userid = $USER->id;
    $table = 'local_dateadjustmenttools';
    $query_lcl = 'userid=?';
    $conditions = array ($userid);
    $recordarr = $DB->get_fieldset_select($table, 'id', $query_lcl, $conditions);
    
    $settingsrecord = new stdClass();
    $settingsrecord->id = $recordarr[0];
    
    if ( !empty ( $data->dateoverviewheaderexpcheckbox ) ) {
        $settingsrecord->dateoverviewheaderexp = 1;
    } else {
        $settingsrecord->dateoverviewheaderexp = 0;
    }
    
    if ( !empty ( $data->selecttoolheaderexpcheckbox ) ) {
        $settingsrecord->selecttoolheaderexp = 1;
    } else {
        $settingsrecord->selecttoolheaderexp = 0;
    }
    
    $settingsrecord->selecttool = $data->selecttool;
    
    if ( !empty ( $data->daterolloverheaderexpcheckbox ) ) {
        $settingsrecord->daterolloverheaderexp = 1;
    } else {
        $settingsrecord->daterolloverheaderexp = 0;
    }
    
    if ( !empty ( $data->individualdateadjheaderexpcheckbox ) ) {
        $settingsrecord->individualdateadjheaderexp = 1;
    } else {
        $settingsrecord->individualdateadjheaderexp = 0;
    }
    
    if ( !empty ( $data->settingsheaderexpcheckbox ) ) {
        $settingsrecord->settingsheaderexp = 1;
    } else {
        $settingsrecord->settingsheaderexp = 0;
    }
    
    $currenttime = time();
    $settingsrecord->timemodified = $currenttime;
    
    $DB->update_record ($table, $settingsrecord);
}



//Function for custom integer validation.
function local_dateadjustmenttools_int_validation ($var) {
    if ( empty ($var) ) { //Checks if $var is empty.
        $error = get_string('emptydate','local_dateadjustmenttools');
    } else if ( $var < 0 ) { //Checks if $var is below zero.
		$error = get_string('invaliddate','local_dateadjustmenttools');
	} else if ( !is_int ($var) ) { //Checks if $var isn't an integer.
        $error = get_string('notaninteger','local_dateadjustmenttools');
    }
    if ( !empty ($error) ) { //If any earlier checks prompt true, show the error and exit.
        echo $error;
        echo '<br /><a href="" onclick="history.go(-1)"><button>Go Back</button></a>';
        die;
    }
}