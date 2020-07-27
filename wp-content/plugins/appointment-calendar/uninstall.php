<?php 
require_once("appointment-calendar.php");

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

// Delete all plugin data 
appointzilla_delete_data();

deactivate_plugins( plugin_basename( __FILE__ ) );