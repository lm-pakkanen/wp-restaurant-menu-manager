<?php

if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

$menuTitleOptions = [
    'Maanantai',
    'Tiistai',
    'Keskiviikko',
    'Torstai',
    'Perjantai',
    'Lauantai',
    'Sunnuntai',
    'Ei lounasta'
];

$menuTitleOptionsEn = [
    'Monday',
    'Tuesday',
    'Wednesday',
    'Thursday',
    'Friday',
    'Saturday',
    'Sunday',
    'No lunch'
];

$menuTitleOptionsSv = [
    'Måndag',
    'Tisdag',
    'Onsdag',
    'Torsdag',
    'Fredag',
    'Lördag',
    'Söndag',
    'Ingen lunch'
];

if (!defined('MENU_TITLE_OPTIONS')) { define('MENU_TITLE_OPTIONS', $menuTitleOptions); }
if (!defined('MENU_TITLE_OPTIONS_EN')) { define('MENU_TITLE_OPTIONS_EN', $menuTitleOptionsEn); }
if (!defined('MENU_TITLE_OPTIONS_SV')) { define('MENU_TITLE_OPTIONS_SV', $menuTitleOptionsSv); }