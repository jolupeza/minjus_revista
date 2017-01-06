<?php
/**
 * The file responsible for starting the Revista Manager plugin.
 *
 * The Revista Manager is a plugin it allows you to manage other types of content and functionality of the web.
 *
 *
 * @wordpress-plugin
 * Plugin Name:       Revista Manager
 * Plugin URI:        https://github.com/jolupeza/minjus_revista
 * Description:       Manage personalized web content.
 * Version:           1.0.0
 * Author:            José Pérez
 * Author URI:        http://
 * Text Domain:       cepuch-manager-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, then abort execution.
if (!defined('WPINC')) {
    die;
}

/**
 * Include the core class responsible for loading all necessary components of the plugin.
 */
require_once plugin_dir_path(__FILE__).'includes/class-revista-manager.php';

/**
 * Instantiates the Revista Manager class and then
 * calls its run method officially starting up the plugin.
 */
function run_revista_manager()
{
    $spmm = new Revista_Manager();
    $spmm->run();
}

// Call the above function to begin execution of the plugin.
run_revista_manager();
