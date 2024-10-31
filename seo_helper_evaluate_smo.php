<?php

include_once 'seo_helper_functions.php';

$a_time = false;

if ( get_post_status( get_the_ID() ) == "auto-draft" )
    $hour = date('G',  time());
else {
    $a_time = strptime(seo_helper_get_post_date(), "%Y-%m-%d %H:%M:%S");
    $hour = $a_time['tm_hour'];
}

$warn = "warn";

if ($hour < 4 || $hour > 21)
    $warn = "cross";
    
if ($hour < 6 || $hour >= 20)
    echo '<span class="seo_helper_status seo_helper_'.$warn.'">&nbsp;</span>&nbsp;Schedule post to a reading friendly time?<br />';
else
    echo '<span class="seo_helper_status seo_helper_check">&nbsp;</span>&nbsp;Post published on a reader friendly time of day<br />';

if ($a_time) {
    $post_time = mktime($a_time['tm_hour'], $a_time['tm_min'], $a_time['tm_sec'], $a_time['tm_mon']+1, $a_time['tm_mday'], $a_time['tm_year']+1900);
    $was = "was";
    if (time() < $post_time) {
        $was = "is";
    }
    $dow = date('N',$post_time);
    if ($dow > 5) {
        echo '<span class="seo_helper_status seo_helper_warn">&nbsp;</span>&nbsp;post '.$was.' published on weekend<br />';
    }
}