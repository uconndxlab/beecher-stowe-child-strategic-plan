<?php

require_once 'inc/acf.php';

function link_parent_theme_style()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'link_parent_theme_style');




/** version */
define('stowe_CHILD_STRATEGIC_PLAN_VERSION', '1.1.0');




// enqueue scripts htmx cdn
add_action('wp_enqueue_scripts', 'stowe_child_strategic_plan_enqueue_scripts');

function stowe_child_strategic_plan_enqueue_scripts()
{
    wp_enqueue_script('htmx', 'https://unpkg.com/htmx.org/dist/htmx.min.js', array(), stowe_CHILD_STRATEGIC_PLAN_VERSION, true);
}






