<?php

function aittooja_files() {
    wp_enqueue_style('aittooja_main_styles', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'aittooja_files');