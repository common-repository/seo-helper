<?php

define('SEO_HELPER_WORD_CHARS','0123456789äüöéèáàíìóòúùß');

define('SLUG_COUNT_MIN',3);
define('SLUG_COUNT_MAX',6);
define('SLUG_COUNT_LIMIT',10);

define('TITLE_COUNT_MIN',10);
define('TITLE_COUNT_MAX',70);

define('KEYWORDS_IN_TITLE_MAX',3);
define('KEYWORDS_IN_TITLE_MIN',1);

define('KEYWORDS_IN_TEXT_MIN',2);

define('WORDCOUNT_MAX',450);
define('WORDCOUNT_MIN',300);

function seo_helper_get_tag_names () {
    $keywords = array();
    $tags = get_the_tags();
    $id = get_the_ID();
    if (is_array($tags)) {
        foreach ($tags as $tag) {
            $keywords[] = strtolower(trim($tag->name));
        }
    }
    $keywords_i = stripcslashes(get_post_meta($id, "_aioseop_keywords", true));
    $keywords_i = str_replace('"', '', $keywords_i);
    if (isset($keywords_i) && !empty($keywords_i)) {
        $traverse = explode(',', $keywords_i);
        foreach ($traverse as $keyword) {
            $keywords[] = strtolower(trim($keyword));
        }
    }

    global $aioseop_options;
    if ($aioseop_options) {
        $keywords_i = stripcslashes($aioseop_options['aiosp_home_keywords']);
        $keywords_i = str_replace('"', '', $keywords_i);
        if (isset($keywords_i) && !empty($keywords_i)) {
            $traverse = explode(',', $keywords_i);
            foreach ($traverse as $keyword) {
                $keywords[] = strtolower(trim($keyword));
            }
        }
    }
  
    global $utw;
    if ($utw) {
        $post = get_post( get_the_ID() );
        $tags = $utw->GetTagsForPost($post);
        if (is_array($tags)) {
            foreach ($tags as $tag) {
                $tag = $tag->tag;
                $tag = str_replace('_',' ', $tag);
                $tag = str_replace('-',' ',$tag);
                $tag = stripcslashes($tag);
                $keywords[] = strtolower($tag);
            }
        }
    }

    $autometa = stripcslashes(get_post_meta($id, 'autometa', true));
    if (isset($autometa) && !empty($autometa)) {
        $autometa_array = explode(' ', $autometa);
        foreach ($autometa_array as $e) {
            $keywords[] = strtolower($e);
        }
    }

    return array_unique($keywords);
}

function seo_helper_get_post_slug() {
    $permalink = get_permalink( get_the_ID());
    $home_url = home_url();

    $slug = trim(preg_replace('/'.preg_quote($home_url, "/").'/', "", $permalink),"/");

    return $slug;
}

function seo_helper_get_post_title() {
    $post = get_post( get_the_ID() );
    return $post->post_title;
}

function seo_helper_get_post_body() {
    $post = get_post( get_the_ID() );
    return ($post->post_content);
}

function seo_helper_get_post_date() {
    $post = get_post( get_the_ID() );
    return ($post->post_date);
}