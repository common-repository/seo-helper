<?php

include_once 'seo_helper_functions.php';

$rawbody = seo_helper_get_post_body();
$body = strip_tags($rawbody);

$words = str_word_count($body, 1,SEO_HELPER_WORD_CHARS);

$keywords_in_text = 0;

foreach ($tags as $keyword) {
    if (in_array($keyword, $words)) {
        ++$keywords_in_text;
    }
}

if ($keywords_in_text < KEYWORDS_IN_TEXT_MIN) {
    if ($keywords_in_text == 0)
        echo '<span class="seo_helper_status seo_helper_warn">&nbsp;</span>&nbsp;'."The text contains no keywords<br />";
    elseif ($keywords_in_text < KEYWORDS_IN_TEXT_MIN)
        echo '<span class="seo_helper_status seo_helper_warn">&nbsp;</span>&nbsp;'."The text should contain at least ".KEYWORDS_IN_TEXT_MIN." keywords<br />";
} else {
    echo '<span class="seo_helper_status seo_helper_check">&nbsp;</span>&nbsp;'."The text contains ".$keywords_in_text." keywords or tags<br />";
}

$n_h1 = substr_count($rawbody, "<h1");

if ($n_h1 > 0) {
    echo '<span class="seo_helper_status seo_helper_cross">&nbsp;</span>&nbsp;post should never contain <em>&lt;h1&gt;</em>-tags<small>&nbsp;<a href="http://www.all-things-seo.com/seo/contextual-seo/search-engine-optimized-html-structure/" title="Search engine optimized HTML structure" target="_blank">?</a></small><br />';
}

$wordcount = str_word_count($body, 0,SEO_HELPER_WORD_CHARS);
$words_in_title =  str_word_count($title, 0,SEO_HELPER_WORD_CHARS);
$totalwords = $words_in_title + $wordcount;

if (($totalwords) < WORDCOUNT_MIN) {
    $cross = "cross";
    if ($totalwords > WORDCOUNT_MIN/2 + 20)
        $cross = "warn";
    echo '<span class="seo_helper_status seo_helper_'.$cross.'">&nbsp;</span>&nbsp;Your word count is below reccomendation';
} elseif ($wordcount > WORDCOUNT_MAX) {
    echo '<span class="seo_helper_status seo_helper_warn">&nbsp;</span>&nbsp;Word count higher than reccomended';
} elseif ($wordcount >= (2*WORDCOUNT_MIN)) {
    echo '<span class="seo_helper_status seo_helper_warn">&nbsp;</span>&nbsp;Enough content to split it to a series of posts?';
} else {
    echo '<span class="seo_helper_status seo_helper_check">&nbsp;</span>&nbsp;Your estimated word count is '.$wordcount;
}
echo "<small>&nbsp;<a href=\"http://www.all-things-seo.com/seo/context/word-count-relevance-for-seo/\" title=\"Word Count Relevance for SEO\" target=\"_blank\">?</a></small><br />";

# --- link structure -----------------------------------------------------------

$n_href = substr_count($rawbody, " href=\""); # number of all links
$n_href_internal = substr_count($rawbody, " href=\"".site_url())
                 + substr_count($rawbody, " href=\"/")
                 - substr_count($rawbody, " href=\"//");

if ($n_href_internal > 0) {
    echo '<span class="seo_helper_status seo_helper_check">&nbsp;</span>&nbsp;Post has '.$n_href_internal. ' internal links<br />';
}

if (($n_href - $n_href_internal) > $n_href_internal) {
    echo '<span class="seo_helper_status seo_helper_warn">&nbsp;</span>&nbsp;More external links than internal links found<br />';
}