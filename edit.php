<?php

/*
    This file is part of Moodle - http://moodle.org/
    
    Released under GNU General Public License version three (3), for further details,
    review the web page "https://www.gnu.org/licenses/gpl.html".
*/

defined('MOODLE_INTERNAL') || die;

global $CFG,$DB,$USER;

require_once('../../config.php');
require_once($CFG->dirroot.'/course/lib.php');
require_once($CFG->libdir.'/filelib.php');
require_once($CFG->dirroot.'/local/datfc/datfc_form.php');

$courseid=required_param('courseid',PARAM_INT);

//Check if the course id is valid.
if (!($course = $DB->get_record('course', array('id'=>$courseid)))) {
    print_error('invalidcourseid', 'error');
    return;
}

//Check if the course has a context.
if (!$context = context_course::instance($course->id)) {
    print_error('nocontext');
    return;
}

//The $course login variable enables the navigation bar, navbar.
require_login($course);

$customdata=array('courseid'=>$courseid,'usertimezone'=>$usertimezone);
$form=new datfc_form(null,$customdata);

if(!($data=$form->get_data())){
    echo 'No data.';
}

if(($data->toolselect)=='1'){
    
    $sql3=$DB->get_fieldset_select('assign','course','course=?',array($courseid));

    //If there is at least one assignment for the course, enter this if-statement (if $sql3 is not empty).
    if (!empty($sql3))
    {    
                
        if (!(has_capability('local/datfc:writepermission', $context))) {
            $nopermission=get_string('nopermission','local_datfc');
            echo $nopermission.'<br /><br />';
            return;
        }
                
        if ($data=$form->get_data())
        {
            $sql2=$DB->get_fieldset_select
            (
                'course',
                'startdate',
                'id=?',
                array($courseid)
            );
            
            $assignments=$DB->get_records
            (
                'assign',
                array('course'=>$courseid)
            );
            
            foreach($assignments as $assignment)
            {            
                $record=new stdClass();
                
                $record->id=$assignment->id;
                
                $currentime=time();
                
                $tiral3=(($data->rolloverdate)-($sql2[0]));
                
                $record->duedate=
                (
                    ($assignment->duedate)+
                    ($data->rolloverdate)-
                    ($sql2[0])
                );
                
                $record->allowsubmissionsfromdate=
                (
                    ($assignment->allowsubmissionsfromdate)+
                    ($data->rolloverdate)-
                    ($sql2[0])
                );
                
                $record->cutoffdate=
                (
                    ($assignment->cutoffdate)+
                    ($data->rolloverdate)-
                    ($sql2[0])
                );
                
                $record->timemodified=$currentime;
                
                $DB->update_record
                (
                    'assign',
                    $record
                );
            }            
            
            $upcomingevents=$DB->get_records
            (
                'event',
                array('courseid'=>$courseid)
            );
               
            foreach($upcomingevents as $upcomingevent)
            {
                $eventrecord=new stdClass();
                
                $eventrecord->id=$upcomingevent->id;
                
                $currentime=time();
                
                $eventrecord->timestart=
                (
                    ($upcomingevent->timestart)+
                    ($data->rolloverdate)-($sql2[0])
                );
                
                $eventrecord->timemodified=$currentime ;
                $DB->update_record
                (
                    'event',
                    $eventrecord
                );
            }
            
            $as=$DB->get_records
            (
                'course',
                array('id'=>$courseid)
            );
            
            foreach ($as as  $a )
            {
                $courserecord=new stdClass();
                $courserecord->id=$a->id;
                $courserecord->startdate=$data->rolloverdate;
                $DB->update_record
                (
                    'course',
                    $courserecord
                );
            }
        }
        else{
            echo '<br />No data.';
        }
    }
}
//Redirect to "index.php".
$url=new moodle_url('/local/datfc/index.php',array('courseid'=>$courseid),array('exitid'=>4));
redirect($url, '', 0);
