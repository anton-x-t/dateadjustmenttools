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

require_once(__DIR__ .'/../../config.php');
require_once($CFG->libdir.'/formslib.php');

defined('MOODLE_INTERNAL') || die;

class index_form extends moodleform {
    public function definition() {
        global $DB, $USER;
        
        $mform = $this->_form;
                
        $userid = $USER->id;
        $table = $lcl_dat_str = 'local_dateadjustmenttools';
        $query_lcl = 'userid=?';
        $conditions = array ($userid);
        $recordarr = $DB->get_fieldset_select($table, 'id', $query_lcl, $conditions);
        if ( empty ($recordarr) ) {
            $settingsrecord = new stdClass();
            $settingsrecord->userid = $USER->id;
            $currenttime = time();
            $settingsrecord->timecreated = $currenttime;
            $settingsrecord->timemodified = $currenttime;
            
            $DB->insert_record ($table, $settingsrecord, $returnid = false, $bulk = false);
            
            $recordarr = $DB->get_fieldset_select($table, 'id', $query_lcl, $conditions);
        }
        
        $conditions = array ('id' => $recordarr[0]);
        $settingsrecordarr = $DB->get_records($table, $conditions);
        $settingsobject = $settingsrecordarr[$recordarr[0]];
        
        if ( $settingsobject->dateoverviewheaderexp == 1 ) {
            $dohexp = true;
        } else {
            $dohexp = false;
        }
        
        if ( $settingsobject->selecttoolheaderexp == 1 ) {
            $sthexp = true;
        } else {
            $sthexp = false;
        }
        
        $selecttool = $settingsobject->selecttool;
        
        if ( $settingsobject->daterolloverheaderexp == 1 ) {
            $drhexp = true;
        } else {
            $drhexp = false;
        }
        
        if ( $settingsobject->individualdateadjheaderexp == 1 ) {
            $idahexp = true;
        } else {
            $idahexp = false;
        }
                
        if ( $settingsobject->settingsheaderexp == 1 ) {
            $shexp = true;
        } else {
            $shexp = false;
        }    
        
        $customdataarray = $this->_customdata;
        $courseid = $customdataarray['courseid'];
		$lang = $customdataarray['lang'];
                
        if ( true ) {
            //-------------------------------------------------------------------------------------
            $dateoverviewh_str = get_string('dateoverviewheader',$lcl_dat_str);
            $mform->addElement('header','dateoverviewheader',$dateoverviewh_str);
            $mform->setExpanded('dateoverviewheader', $dohexp);
            
            $coursestartseconds = $DB->get_fieldset_select('course', 'startdate', 'id=?', array ($courseid));
            if ( $lang == 'en' ) {
				$coursestartdate = date("m/d/Y", $coursestartseconds[0]);
			} else if ( $lang == 'sv' ) {
				$coursestartdate = date("Y-m-d", $coursestartseconds[0]);
			}
            $coursestartdate_str = get_string('coursestartdatec', $lcl_dat_str);
            $mform->addElement('html', '<table border="1">');
            $mform->addElement('html', '<tr><th>'.$coursestartdate_str.'</th></tr>');
            $mform->addElement('html', '<tr><td>'.$coursestartdate.'</td></tr>');
            $mform->addElement('html', '</table><br />');
            
            $assignments=$DB->get_records('assign',array('course'=>$courseid));
            if( !empty ($assignments) ) {        
                $name = get_string('name', $lcl_dat_str);
                $allowsubmissionsfrom = get_string('allowsubmissionsfromu', $lcl_dat_str);
                $duedate = get_string('duedateu', $lcl_dat_str);
                $cutoffdate = get_string('cutoffdateu', $lcl_dat_str);
                $mform->addElement('html', '<table border="1">');
                $mform->addElement('html', '<tr><th>'.$name.'</th>');
                $mform->addElement('html', '<th>'.$allowsubmissionsfrom.'</th>');
                $mform->addElement('html', '<th>'.$duedate.'</th>');
                $mform->addElement('html', '<th>'.$cutoffdate.'</th></tr>');
                
                foreach ($assignments as $assignment) {
                    $assignmentname = $assignment->name;
					$mform->addElement('html', '<tr><td>'.$assignmentname.'</td>');
					
                    if ( !empty ($assignment->allowsubmissionsfromdate) ) {
                        if ( $lang == 'en' ) {
							$asfd = date("m/d/Y h:i a", $assignment->allowsubmissionsfromdate);
						} else if ( $lang == 'sv' ) {
							$asfd = date("Y-m-d H:i", $assignment->allowsubmissionsfromdate);
						}
                    } else {
						$asfd = get_string('notset', $lcl_dat_str);
                    }
                    $mform->addElement('html', '<td>'.$asfd.'</td>');
                    
					if ( !empty ($assignment->duedate) ) {
                        if ( $lang == 'en' ) {
							$dd = date("m/d/Y h:i a", $assignment->duedate);
						} else if ( $lang == 'sv' ) {
							$dd = date("Y-m-d H:i", $assignment->duedate);
						}
                    } else {
                        $dd = get_string('notset', $lcl_dat_str);
                    }
                    $mform->addElement('html', '<td>'.$dd.'</td>');
					
					if ( !empty ($assignment->cutoffdate) ) {
                        if ( $lang == 'en' ) {
							$cod = date("m/d/Y h:i a", $assignment->cutoffdate);
						} else if ( $lang == 'sv' ) {
							$cod = date("Y-m-d H:i", $assignment->cutoffdate);
						}
                    } else {
                        $cod = get_string('notset', $lcl_dat_str);
                    }
                    $mform->addElement('html', '<td>'.$cod.'</td></tr>');
                }
                
                $mform->addElement('html', '</table><br />');
            }    
            
            $quizzes=$DB->get_records('quiz',array('course'=>$courseid));
            if( !empty($quizzes) ) {
                $name = get_string('name', $lcl_dat_str);
                $openthequiz = get_string('openthequizu', $lcl_dat_str);
                $closethequiz = get_string('closethequizu', $lcl_dat_str);
                $mform->addElement('html', '<table border="1">');
                $mform->addElement('html', '<tr><th>'.$name.'</th>');
                $mform->addElement('html', '<th>'.$openthequiz.'</th>');
                $mform->addElement('html', '<th>'.$closethequiz.'</th></tr>');
                
                foreach($quizzes as $quiz) {
                    $quizname=$quiz->name;
					$mform->addElement('html', '<tr><td>'.$quizname.'</td>');
					
                    if ( !empty ($quiz->timeopen) ) {
                        if ( $lang == 'en' ) {
							$otq = date("m/d/Y h:i a", $quiz->timeopen);
						} else if ( $lang == 'sv' ) {
							$otq = date("Y-m-d H:i", $quiz->timeopen);
						}
                    } else {
                        $otq = get_string('notset', $lcl_dat_str);
                    }
                    $mform->addElement('html', '<td>'.$otq.'</td>');
					
                    if ( !empty ($quiz->timeclose) ) {
                        
						if ( $lang == 'en' ) {
							$ctq = date("m/d/Y h:i a", $quiz->timeclose);
						} else if ( $lang == 'sv' ) {
							$ctq = date("Y-m-d H:i", $quiz->timeclose);
						}
                    } else {
                        $ctq = get_string('notset', $lcl_dat_str);
                    }
                    $mform->addElement('html', '<td>'.$ctq.'</td><tr>');
                }
                
                $mform->addElement('html', '</table><br />');
            }
        }
        
        if ( true ) {
            //-------------------------------------------------------------------------------------
            $stheader_str = get_string('selecttoolheader', $lcl_dat_str);
            $mform->addElement('header', 'selecttoolheader', $stheader_str);
            $mform->setExpanded('selecttoolheader', $sthexp);
            
            $nts_str = get_string('notoolselectedp', $lcl_dat_str);
            $drheader_str = get_string('daterolloverheader', $lcl_dat_str);
            $idaheader_str = get_string('individualdateadjustmentheader', $lcl_dat_str);
            $tools = array (0 => $nts_str, 1 => $drheader_str, 2 => $idaheader_str);
            $mform->addElement('select', 'selecttool', get_string('selecttool', $lcl_dat_str), $tools);
            $mform->setDefault('selecttool', $selecttool);
        }
            
        if ( true ) {
            //-------------------------------------------------------------------------------------
            $drheader_str = get_string('daterolloverheader', $lcl_dat_str);
            $mform->addElement('header', 'daterolloverheader', $drheader_str);
            $mform->setExpanded('daterolloverheader', $drhexp);
			
            $timenow = time();
            $middleyear = date('Y',$timenow);
            $yearoffset = 15;
            $startyear = $middleyear-$yearoffset;
            $stopyear = $middleyear+$yearoffset;
            $coursestartseconds = $DB->get_fieldset_select('course','startdate','id=?',array($courseid));
            $allowedtimespan =
            array(
                'startyear' => $startyear,
                'stopyear'  => $stopyear,
                'timezone'  => 99,
                'optional'  => false
            );
            $csd_str = get_string('coursestartdatec', $lcl_dat_str);
            $mform->addElement('date_selector', 'rolloverdate', $csd_str, $allowedtimespan);
            $mform->setDefault('rolloverdate', $coursestartseconds[0]);
            $mform->disabledIf('rolloverdate', 'selecttool', 'neq', 1);
            $mform->addHelpButton('rolloverdate', 'daterollover', $lcl_dat_str);
        }
        
        $this->add_action_buttons();
		
        if ( true ) {
            //-------------------------------------------------------------------------------------
            $iaheader_str = get_string('individualdateadjustmentheader', $lcl_dat_str);
            $mform->addElement('header','individualdateadjustmentheader', $idaheader_str);
            $mform->setExpanded('individualdateadjustmentheader', $idahexp);
    
            $timenow = time();
            $yearnow = date('Y', $timenow);
            $yearoffset = 15;
            $startyear = $yearnow - $yearoffset;
            $stopyear = $yearnow + $yearoffset;
			$allowedtimespan = array (
						'startyear' => 1970,
						'stopyear'  => $stopyear,
						'timezone'  => 99,
						'step'      => 1,
						'optional'  => false
			);
            $csda_str = get_string('coursestartdatec', $lcl_dat_str);
            $mform->addElement('date_selector', 'coursestartdate', $csda_str, $allowedtimespan);
            $mform->disabledIf('coursestartdate', 'selecttool', 'neq', 2);
            $coursestartseconds = $DB->get_fieldset_select('course','startdate','id=?',array($courseid));
            $mform->setDefault('coursestartdate', $coursestartseconds[0]);
            $mform->addHelpButton('coursestartdate', 'coursestartdate', $lcl_dat_str);
            
            $mform->addElement('html', '<br />');
            
            $assignments=$DB->get_records('assign', array ('course'=>$courseid));
            if( !empty ($assignments) ) {
                
                $allowsubmissionsfrom = get_string('allowsubmissionsfromu', $lcl_dat_str);
                $duedate = get_string('duedateu', $lcl_dat_str);
                $cutoffdate = get_string('cutoffdateu', $lcl_dat_str);
                $i = 0;
                
                foreach ($assignments as $assignment) {            
                    $assignmentname = $assignment->name;
					$mform->addElement('html', '<b>'.$assignmentname.'</b>');
					
                    $asf_str = $allowsubmissionsfrom;
                    $mform->addElement('date_time_selector', 'assignmentasfd'.$i, $asf_str, $allowedtimespan);
                    $mform->disabledIf('assignmentasfd'.$i, 'selecttool', 'neq', 2);
                    $mform->addHelpButton('assignmentasfd'.$i, 'individualdateadjustment', $lcl_dat_str);
                    
                    //31622400 is the Unix time for 1971-01-02 00:00.
                    if ( $assignment->allowsubmissionsfromdate > 31622400 ) {
                        $asfd = $assignment->allowsubmissionsfromdate;
                    } else {
                        $asfd = 3600*24;
                    }
                    $mform->setDefault('assignmentasfd'.$i, $asfd);
                    
                    $dd_str = $duedate;
                    $mform->addElement('date_time_selector', 'assignmentdd'.$i, $dd_str, $allowedtimespan);
                    $mform->disabledIf('assignmentdd'.$i, 'selecttool', 'neq', 2);
                    $mform->addHelpButton('assignmentdd'.$i, 'individualdateadjustment', $lcl_dat_str);
                    
                    //31622400 is the Unix time for 1971-01-02 00:00.
                    if ( $assignment->duedate > 31622400 ) {
                        $dd = $assignment->duedate;
                    } else {
                        $dd = 3600*24;
                    }
                    $mform->setDefault('assignmentdd'.$i, $dd);
                    
                    $cod_str = $cutoffdate;
                    $mform->addElement('date_time_selector', 'assignmentcod'.$i, $cod_str, $allowedtimespan);
                    $mform->disabledIf('assignmentcod'.$i, 'selecttool', 'neq', 2);
                    $mform->addHelpButton('assignmentcod'.$i, 'individualdateadjustment', $lcl_dat_str);
                    
                    //31622400 is the Unix time for 1971-01-02 00:00.
                    if ( $assignment->cutoffdate > 31622400 ) {
                        $cod = $assignment->cutoffdate;
                    } else {
                        $cod = 3600*24;
                    }
                    $mform->setDefault('assignmentcod'.$i, $cod);
                    
                    $mform->addElement('hidden', 'assignmentname'.$i, $assignmentname);
                    $mform->setType('assignmentname'.$i, PARAM_RAW);
                    $assignmentid = $assignment->id;
                    $mform->addElement('hidden', 'assignmentid'.$i, $assignmentid);
                    $mform->setType('assignmentid'.$i, PARAM_INT);
                    
                    $mform->addElement('html', '<br />');
                    
                    $i++;
                }
                $mform->addElement('hidden', 'numberofassignments', $i);
                $mform->setType('numberofassignments', PARAM_INT);
            } else {
                $mform->addElement('hidden', 'numberofassignments', 0);
                $mform->setType('numberofassignments', PARAM_INT);
            }
            
            $quizzes=$DB->get_records('quiz', array ('course' => $courseid));
            if ( !empty ($quizzes) ) {
                
                $openthequiz = get_string('openthequizu', $lcl_dat_str);
                $closethequiz = get_string('closethequizu', $lcl_dat_str);
                
                $i = 0;
                foreach ($quizzes as $quiz) {
                    $quizname = $quiz->name;
					$mform->addElement('html', '<b>'.$quizname.'</b>');
					
					$otq_str = $openthequiz;
                    $mform->addElement('date_time_selector', 'quizotq'.$i, $otq_str, $allowedtimespan);
                    $mform->disabledIf('quizotq'.$i, 'selecttool', 'neq', 2);
                    $mform->addHelpButton('quizotq'.$i, 'individualdateadjustment', $lcl_dat_str);
                                        
                    //31622400 is the Unix time for 1971-01-02 00:00.
                    if ( $quiz->timeopen > 31622400 ) {
                        $otq = $quiz->timeopen;
                    } else {
                        $otq = 3600*24;
                    }
                    $mform->setDefault('quizotq'.$i, $otq);
                    
                    $ctq_str = $closethequiz;
                    $mform->addElement('date_time_selector', 'quizctq'.$i, $ctq_str, $allowedtimespan);
                    $mform->disabledIf('quizctq'.$i, 'selecttool', 'neq', 2);
                    $mform->addHelpButton('quizctq'.$i, 'individualdateadjustment', $lcl_dat_str);
                    
                    if ( $quiz->timeclose > 31622400 ) {
                        $ctq = $quiz->timeclose;
                    } else {
                        $ctq = 3600*24;
                    }
                    $mform->setDefault('quizctq'.$i, $ctq);
                    
                    $mform->addElement('hidden', 'quizname'.$i, $quizname);
                    $mform->setType('quizname'.$i, PARAM_RAW);
                    $quizid = $quiz->id;
                    $mform->addElement('hidden', 'quizid'.$i, $quizid);
                    $mform->setType('quizid'.$i, PARAM_INT);
                    
                    $mform->addElement('html', '<br />');
                    
                    $i++;
                }
                $mform->addElement('hidden', 'numberofquizzes', $i);
                $mform->setType('numberofquizzes', PARAM_INT);
            } else {
                $mform->addElement('hidden', 'numberofquizzes', 0);
                $mform->setType('numberofquizzes', PARAM_INT);
            }
        }
        
        $this->add_action_buttons();
        
        if ( true ) {
            //-----------------------------------------------------------------------------------------
            $sheader_str = get_string('settingsheader', $lcl_dat_str);
            $mform->addElement('header', 'settingsheader', $sheader_str);
            $mform->setExpanded('settingsheader', $shexp);
            
            $ext = get_string('expand', $lcl_dat_str);
            $doh = get_string('dateoverviewheader', $lcl_dat_str);
            $dateoverviewexp_str = $ext.' "'.$doh.'"';
            $mform->addElement('checkbox','dateoverviewheaderexpcheckbox', $dateoverviewexp_str);
            if ( $dohexp ) {
                $mform->setDefault('dateoverviewheaderexpcheckbox', 'checked');
            }
            
            $sth = get_string('selecttoolheader', $lcl_dat_str);
            $dateoverviewexp_str = $ext.' "'.$sth.'"';
            $mform->addElement('checkbox','selecttoolheaderexpcheckbox', $dateoverviewexp_str);
            if ( $sthexp ) {
                $mform->setDefault('selecttoolheaderexpcheckbox', 'checked');
            }
            
			$drh = get_string('daterolloverheader', $lcl_dat_str);
            $daterolloverexp_str = $ext.' "'.$drh.'"';
            $mform->addElement('checkbox','daterolloverheaderexpcheckbox', $daterolloverexp_str);
            if ( $drhexp ) {
                $mform->setDefault('daterolloverheaderexpcheckbox', 'checked');
            }
			
            $idah = get_string('individualdateadjustmentheader', $lcl_dat_str);
            $individualdateadjexp_str = $ext.' "'.$idah.'"';
            $mform->addElement('checkbox','individualdateadjheaderexpcheckbox', $individualdateadjexp_str);
            if ( $idahexp ) {
                $mform->setDefault('individualdateadjheaderexpcheckbox', 'checked');
            }
            
            $sh = get_string('settingsheader', $lcl_dat_str);
            $settingsexp_str = $ext.' "'.$sh.'"';
            $mform->addElement('checkbox','settingsheaderexpcheckbox', $settingsexp_str);
            if ( $shexp ) {
                $mform->setDefault('settingsheaderexpcheckbox', 'checked');
            }
            
            $mform->addElement('hidden', 'courseid', $courseid);
            $mform->setType('courseid', PARAM_INT);
        }
                
        $this->add_action_buttons();
    }
    
    function validation($data, $files) {
        return;
    }
}