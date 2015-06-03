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

/*
Versions are written like this in Moodle: 
YYYYMMDDVV=2014050300, the year 2014 AD, May, the third, version 00.
YYYY=years after Christ, MM=months, DD=days, VV=version.
*/

//The version of Moodle that this plugin is tested and written for.
//Upgrade to the current version of Moodle and maybe test the latest version and rewrite this date
//before sending in.
//                 YYYYMMDDVV
$plugin->version = 2014111000;

//The version of Moodle that this plugin demands at minimum.
//                  YYYYMMDDVV
$plugin->requires = 2014111001;

//This plugin component, the name of it.
$plugin->component = 'local_dateadjustmenttools';
