<?php

if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

$supportedLocales = [
    'fi',
    'en',
    'sv'
];

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

$menuListUnavailable = 'Lounalista ei ole saatavissa.';
$menuListUnavailableEn = 'Lunch menu is not available.';
$menuListUnavailableSv = 'Lunchmeny är inte tillgänglig.';

if (!defined('SUPPORTED_LOCALES')) { define('SUPPORTED_LOCALES', $supportedLocales); }
if (!defined('MENU_TITLE_OPTIONS')) { define('MENU_TITLE_OPTIONS', $menuTitleOptions); }
if (!defined('MENU_TITLE_OPTIONS_EN')) { define('MENU_TITLE_OPTIONS_EN', $menuTitleOptionsEn); }
if (!defined('MENU_TITLE_OPTIONS_SV')) { define('MENU_TITLE_OPTIONS_SV', $menuTitleOptionsSv); }
if (!defined('MENU_LIST_UNAVAILABLE')) { define('MENU_LIST_UNAVAILABLE', $menuListUnavailable); }
if (!defined('MENU_LIST_UNAVAILABLE_EN')) { define('MENU_LIST_UNAVAILABLE_EN', $menuListUnavailableEn); }
if (!defined('MENU_LIST_UNAVAILABLE_SV')) { define('MENU_LIST_UNAVAILABLE_SV', $menuListUnavailableSv); }