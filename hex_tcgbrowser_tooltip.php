<?php
/*
Plugin Name: Hex TCGBrowser Card Tooltips
Plugin URI: http://hex.tcgbrowser.com/tools/api
Description: Transform Hex TCG card names into links that show the card image when hovering over them.
Author: bogycoins
Version: 1.0
*/


function hex_tcgbrowser_register_button($buttons)
{
    array_push($buttons, "separator", "hex_tcgbrowser");
    return $buttons;
}

function hex_tcgbrowser_add_tinymce_plugin($plugin_array)
{
    $plugin_array['hex_tcgbrowser'] = get_bloginfo('wpurl') .
        '/wp-content/plugins/hex_tcgbrowser_tooltip/resources/tinymce3/editor_plugin.js';
    return $plugin_array;
}

function hex_tcgbrowser_add_buttons()
{
    wp_enqueue_script('hex_tcgbrowser', 'http://hex.tcgbrowser.com/tools/api/tooltip.js', array('jquery'));

    if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
        return;

    if (get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "hex_tcgbrowser_add_tinymce_plugin");
        add_filter('mce_buttons', 'hex_tcgbrowser_register_button');
    }
}

add_action('init', 'hex_tcgbrowser_add_buttons');
