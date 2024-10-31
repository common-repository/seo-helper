<?php

include_once 'seo_helper_functions.php';

$slug = seo_helper_get_post_slug();

$slug_paths = explode("/", $slug);
$slug_elements = array();

foreach ($slug_paths as $slug_path) {
    foreach (explode("-",$slug_path) as $slug_element) {
        $slug_elements[] = $slug_element;
    }
}

#--- Title ---------------------------------------------------------------------
$title = seo_helper_get_post_title();

$count = strlen($title);

if ($count < TITLE_COUNT_MIN || $count > TITLE_COUNT_MAX) {
    echo '<span class="seo_helper_status seo_helper_warn">&nbsp;</span>&nbsp;';
    if ($count < TITLE_COUNT_MIN) {
        echo 'The post title is very short';
    } elseif ($count > TITLE_COUNT_MAX) {
        echo 'The tile of your post is very long';
    }
    echo "<br />";
} else {
    echo '<span class="seo_helper_status seo_helper_check">&nbsp;</span>&nbsp;'."Title length is between ".TITLE_COUNT_MIN." and ".TITLE_COUNT_MAX." characters<br />";
}

$tags = seo_helper_get_tag_names();
$words = str_word_count($title, 1,SEO_HELPER_WORD_CHARS);

$tag_in_title_count = 0;
$tag_in_slug_count = 0;

foreach ($words as $word) {
    $word = strtolower($word);
    if (in_array($word,$tags)) {
        ++$tag_in_title_count;
    }
    if (in_array($word, $slug_elements)) {
        ++$tag_in_slug_count;
    }
}

if ($tag_in_title_count < KEYWORDS_IN_TITLE_MIN) {
    echo '<span class="seo_helper_status seo_helper_warn">&nbsp;</span>&nbsp;'.
         'The title contains no keyword specified';
} elseif ($tag_in_title_count > KEYWORDS_IN_TITLE_MAX) {
    echo '<span class="seo_helper_status seo_helper_warn">&nbsp;</span>&nbsp;'.
         'The title may contain to much keywords';
} else {
    $s = ($tag_in_title_count > 1)? "s":"";
    echo '<span class="seo_helper_status seo_helper_check">&nbsp;</span>&nbsp;'."$tag_in_title_count keyword$s found in title";
}
echo '<small>&nbsp;<a href="http://www.all-things-seo.com/seo/context/seo-keywords-in-headlines/" title="SEO Keywords in Headlines" target="_blank">?</a></small><br />';

if ($tag_in_slug_count == 0) {
    echo '<span class="seo_helper_status seo_helper_warn">&nbsp;</span>&nbsp;'.
         'The permalink does not reflect the post title'.
         '';
} else {
    $s = ($tag_in_slug_count > 1)? "es":"";
    echo '<span class="seo_helper_status seo_helper_check">&nbsp;</span>&nbsp;'."$tag_in_slug_count match$s found in title and permalink";
}
echo '<small>&nbsp;<a href="http://www.all-things-seo.com/seo/context/optimize-permalinks-for-search-engines/" title="Optimize Permalinks for search engines" target="_blank">?</a></small><br />';


#--- Permalink/slug ------------------------------------------------------------

$count = count($slug_elements);

if ($count < SLUG_COUNT_MIN || $count > SLUG_COUNT_MAX) {
    echo '<span class="seo_helper_status seo_helper_warn">&nbsp;</span>&nbsp;';
    if ($count <= SLUG_COUNT_MIN) {
        echo 'Your post slug/permalink is very short.';
    } elseif ($count > SLUG_COUNT_MAX && $count <= SLUG_COUNT_LIMIT) {
        echo 'Your posts permalink is a little long.';
    } elseif ($count > SLUG_COUNT_LIMIT) {
        echo 'The slug/permalink to your post is very long.';
    }
    echo '<br />';
}
