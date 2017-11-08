<?php
/*
Plugin Name: Add menu separators to navigation
Plugin URI: https://wordpress.org/plugins/mhm-menu-separator/
Description: Add customisation to allow separator line and text-only entries to the output of the WordPress `wp_nav_menu` function.
Text Domain: mhm-menu-separator
Author: Mark Howells-Mead
Version: 1.1.4.1
Author URI: http://permanenttourist.ch/
*/

class MHMWordPressMenuSeparator
{
    public $version = '1.1.4.1';
    public $wpversion = '4.0';

    public function __construct()
    {
        register_activation_hook(__FILE__, array($this, 'check_version'));
        add_action('admin_init', array($this, 'check_version'));

        // Don't run anything else in the plugin, if we're on an incompatible WordPress version
        if (!$this->compatible_version()) {
            return;
        }

        add_action('plugins_loaded', array($this, 'load_textdomain'));
        add_filter('walker_nav_menu_start_el', array($this, 'nav_menu_start_el'), 10, 4);
    }

    public function check_version()
    {
        // Check that this plugin is compatible with the current version of WordPress
        if (!$this->compatible_version()) {
            if (is_plugin_active(plugin_basename(__FILE__))) {
                deactivate_plugins(plugin_basename(__FILE__));
                add_action('admin_notices', array($this, 'disabled_notice'));
                if (isset($_GET['activate'])) {
                    unset($_GET['activate']);
                }
            }
        }
    }

    public function disabled_notice()
    {
        echo '<div class="notice notice-error is-dismissible">
            <p>'.sprintf(__('The plugin “%1$s” requires WordPress %2$s or higher!', 'mhm-menu-separator'),
                _x('Add menu separators to navigation', 'Plugin name', 'mhm-menu-separator'),
                $this->wpversion).'</p>
        </div>';
    }

    private function compatible_version()
    {
        if (version_compare($GLOBALS['wp_version'], $this->wpversion, '<')) {
            return false;
        }

        return true;
    }

    public function load_textdomain()
    {
        load_plugin_textdomain('mhm-menu-separator', false, plugin_basename(dirname(__FILE__)).'/languages');
    }

    public function nav_menu_start_el($item_output, $item, $depth, $args)
    {
        if ($item->post_title === '---') {
            return '<hr>'; // Horizontal line
        } elseif ($item->url === '#') {
            return $item->post_title; // Text without link
        } else {
            return $item_output; // Unmodified output for this link
        }
    }
}

new MHMWordPressMenuSeparator();
