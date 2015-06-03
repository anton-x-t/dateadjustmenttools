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

//Sometimes c stands for capitalized and s for space, p or par stands for parentheses.

$string['abbreviatedinstructions'] = 'This plugin has been devised to show and individually change the course start date, assignment dates and quiz dates. Another feature of this plugin has been made to change all earlier mentioned dates for a course at once. A <b>"Settings"</b> section has been coded where all the other sections <b>except</b> the "Settings" section can be shown or hidden and expanded or collapsed. However, the "Settings" section can be <b>expanded</b> or <b>collapsed</b>. Enable a section in a section by clicking that checkbox, input dates and execute your changes by clicking "Save changes". <b>WARNING: Be careful when using the "Date rollover" section.</b>';
$string['allowsubmissionsfroml'] = 'allow submissions from';
$string['allowsubmissionsfromu'] = 'Allow submissions from';
$string['applychanges'] = 'Apply changes';
$string['assignmentdateadjustmentheader'] = 'Assignment date adjustment';
$string['assignmentdateadjustmentsectiondescription'] = 'The <b>"Assignment date adjustment"</b> section shows the current assignment dates, if any. In this section it\'s <b>only</b> possible to change assignment allow submissions from dates, due dates and cut-off dates with correlating calendar events. Input dates like this: "YYYY-MM-DD HH:MM". Date example: "2018-09-10 16:52". Leave an activated field blank or incomplete for date removal.';
$string['backtocoursehome'] = 'Go Back to the first page of this course';
$string['closethequizl'] = 'close the quiz';
$string['closethequizu'] = 'Close the quiz';
$string['coursedatetableoverview'] = 'Course dates table overview';
$string['coursestart'] = 'course start';
$string['coursestartdate'] = 'Individual date adjustment';
$string['coursestartdate_help'] = 'The course start date is displayed and can be changed here. The course start date can\'t be removed.';
$string['coursestartdatec'] = 'Course start date';
$string['coursestartdateadjustmentheader'] = 'Course start date adjustment';
$string['coursestartdateadjustmentsectiondescription'] = 'The <b>"Course start date adjustment"</b> section shows the current course start date. In this section it\'s <b>only</b> possible to change the course start date. Input dates like this: "YYYY-MM-DD". Date example: "2014-11-05". Leave an activated field blank or incomplete for date removal.';
$string['cutoffdatel'] = 'cut-off date';
$string['cutoffdateu'] = 'Cut-off date';
$string['dateexample'] = 'Date example';
$string['dateindigits'] = '2014-11-05';
$string['dateindigitswithtime'] = '2018-09-10 16:52';
$string['dateoverviewheader'] = 'Date overview';
$string['dateoverviewsectiondescription'] = 'The <b>"Date overview"</b> section shows the current course start date, the current assignment dates and the current quiz dates, each in their own tables. Nothing can be changed under this section.';
$string['daterollover'] = 'Date rollover';
$string['daterollover_help'] = 'The course start date is displayed here. The course start date, assignment dates, quiz dates with calendar events can be changed here, all at once. The Date rollover tool doesn\'t take holidays and weekends into consideration. Some dates might change an hour forth or back if Daylight Saving Time is observed in the timezone of this server and if a course crosses the daylight time switching dates (a Sunday, March 25th-31st and a Sunday, October 25th-31st for Europe). Be careful!';
$string['daterolloverheader'] = 'Date rollover';
$string['daterolloversectiondescription'] = 'The <b>"Date rollover"</b> section shows the current course start date. In this section it\'s <b>only</b> possible to change the start date, the assignment dates and the quiz dates with corresponding calendar events all at once. All earlier mentioned dates will moved in relationship with the current course start date. First enable the input field, then input the new date in the form your browser is representing it, then click "Save changes" to apply changes.';
$string['daterollovertextwithvariable'] = 'The current start date for this course is {$a}. Which date would you like to change the course start date to?';
$string['daterollovertextwithvariableheader'] = 'Date rollover';
$string['daterollovertextwithvariableshort'] = 'New start date ({$a}):';
$string['daterollovertextwithoutvariableshort'] = 'New start date (YYYY-MM-DD):';
$string['daterollovertextwithoutvariableshort_help'] = 'The current start date for this course is within the parentheses. All dates belonging to this course will be adjusted backward or forward in relation with the selected date. Please select a date ranging from today until 2030-12-31.';
$string['duedatel'] = 'due date';
$string['duedateu'] = 'Due date';
$string['emptydate'] = 'Date field empty. Please try again. Thank you!';
$string['enablechangesfor'] = 'Enable changes for';
$string['enablesettingchanges'] = 'Enable setting changes';
$string['expand'] = 'Expand';
$string['headerwhenaccessingthispage'] = ' header when accessing this page';
$string['individualdateadjustment'] = 'Individual date adjustment';
$string['individualdateadjustment_help'] = 'Set a date to some time in 1970 to remove it. If a date is set in 1970, then the date doesn\'t exist and it isn\'t set.';
$string['individualdateadjustmentheader'] = 'Individual date adjustment';
$string['inputdateslikethis'] = 'Input dates like this';
$string['instructionsheader'] = 'Please read these instructions';
$string['instructionssectiondescription'] = 'The <b>"Please read these instructions"</b> section is the current section with directions on how to use the other sections.';
$string['invaliddate'] = 'Invalid date. Please try again. Thank you!';
$string['leaveanactivatedfield'] = 'Leave an activated field blank or incomplete for date removal.';
$string['name'] = 'Name';
$string['newcoursestartdate'] = 'New course start date';
$string['nopermission'] = 'You do not possess proper privileges to make these changes.<br />Contact the System Administrator for this Moodle System if think you can obtain these privileges.<br />Farewell!';
$string['nothingcanbechanged'] = 'Nothing can be changed under this section.';
$string['notaninteger'] = 'A date was not input as an integer. Please try again. Thank you!';
$string['notoolselectedp'] = '(No tool selected)';
$string['notset'] = 'Not set';
$string['openthequizl'] = 'open the quiz';
$string['openthequizu'] = 'Open the quiz';
$string['pastdate'] = 'Date in the past. Please select a date inclusively ranging from today to 2030-12-31. Thank you!';
$string['pluginname'] = 'Date adjustment tools';
$string['pleaseselectadate'] = 'Please select a date';
$string['quizclosespar'] = '(Quiz closes)';
$string['quizdateadjustmentheader'] = 'Quiz date adjustment';
$string['quizdateadjustmentsectiondescription'] = 'The <b>"Quiz date adjustment"</b> section shows the current quiz dates, if any. In this section it\'s <b>only</b> possible to change quiz open dates and quiz close dates with associated calendar events. Input dates like this: "YYYY-MM-DD HH:MM". Date example: "2020-03-01 05:10". Leave an activated field blank or incomplete for date removal.';
$string['quizopenspar'] = '(Quiz opens)';
$string['rollover'] = 'Rollover all dates in relation with the selected date';
$string['sectionshows'] = ' section shows';
$string['selecttool'] = 'Select tool';
$string['selecttoolheader'] = 'Select tool';
$string['settingsheader'] = 'Settings';
$string['settingssectiondescription'] = 'The <b>"Settings"</b> section shows and offers possibilities to change if sections should be enabled or not and expanded or not. Yet, the "Settings" section <b>can\'t</b> be disabled, though it can be collapsed. In the "Settings" section, check the "Enable setting changes" checkbox and then check another checkbox and click "Save changes" in order to change which sections that should be enabled or disabled and expanded or collapsed.';
$string['tableadjustmentheader'] = 'Course date table adjustment';
$string['thecurrentcoursestartdate'] = 'the current course start date';
$string['tldrinstructions'] = 'tldr: A plugin for changing dates for a course. Click "Save changes" to apply changes. Please use this plugin carefully.';
$string['underthissectionits'] = 'Under this section it\'s <b>only</b> possible to change';
$string['yyyymmddc'] = 'YYYY-MM-DD';
$string['yyyymmddhhmmc'] = 'YYYY-MM-DD HH:MM';