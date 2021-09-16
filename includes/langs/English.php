<?php
function  lang($phrase){
    static $langs=array(
        //the navbar
        "Home"          =>" الصفحة الرئسية",
        "catagorise"    =>"فئات",
        "settings"      =>"اعدادات",
        "log out"       =>"خروج",
        "my profile"    =>"ملفك الشخصي"
        // //////////////////////////////////
    );
    return $langs[$phrase];
}