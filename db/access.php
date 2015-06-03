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

//If MOODLE_INTERNAL is not defined, then die(), which means terminating the plug-in.
//This line is common in Moodle code.
defined('MOODLE_INTERNAL') || die;

$capabilities = array(
    'local/dateadjustmenttools:writepermission' => array(
        'captype'      =>    'write',
        'contextlevel' =>    CONTEXT_COURSE,
        'archetypes'   =>    array(
            'coursecreator'  => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
			'manager'        => CAP_ALLOW,
            'teacher'        => CAP_ALLOW        
        )
    ),    
);
