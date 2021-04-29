<?php
/*
  Plugin Name: Stilts Custom Add-ons
  Description: Re-usable functions that we can keep out of the functions.php file
  Author: Stilts Media Co.
  Version: 0.1
*/

  if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


  // Plugin-critical includes
  include('rest-api-endpoints.php');
  include('shortcodes.php');

?>