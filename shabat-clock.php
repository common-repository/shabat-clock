<?php
/**
 * Plugin Name: Shabat Clock
 * Plugin URI: http://wpsite.co.il
 * Description: This plugin will close down your site on shabat.
 * Version: 1.0
 * Author: Gal Hadad
 * Author URI: matilo:gal.wpsite@outlook.com
 * License: GPL2
 */

/*  Copyright 2014  Gal Hadad  (email :Gal.wpsite@outlook.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Activation hook
register_activation_hook( __FILE__, 'wdc_slider_activation' );
function wdc_slider_activation(){

}

// Deactivation hook 
register_deactivation_hook( __FILE__, 'wdc_slider_deactivation' );
function wdc_slider_deactivation(){

}

function sclock_close_down_site() {

$isSiteClose=false; //If this is set to true, site will be closed down.

$timeClose = (get_option('sclock_timeClose') != '') ? get_option('sclock_timeClose') : '18'; //get the hour of when the site should be closed on firday
$timeOpen = (get_option('sclock_timeOpen') != '') ? get_option('sclock_timeOpen') : '18';  // get the hour of when the site should be back up on saturday
$massege = (get_option('sclock_massege') != '') ? get_option('sclock_massege') : 'Shabat Shalom, this site is not working on the Shabat.'; // the massege that will be shown to the end user 

 $today=date( 'D',current_time( 'timestamp')); // get current day




if ((string)$today=='Fri' && date( 'H',current_time( 'timestamp')) >= $timeClose && !is_admin()) 
		$isSiteClose=true;

if ((string)$today=='Sat' && date( 'H',current_time( 'timestamp')) <= $timeClose && !is_admin()) 
		$isSiteClose=true;


    	if ($isSiteClose)
            wp_die($massege);
    
}

add_action ('wp_head','sclock_close_down_site');


add_action('admin_menu', 'sclock_plugin_settings');

function sclock_plugin_settings() {
    add_options_page('Shabat Clock', 'Shabat Clock', 'administrator', 'sclock_settings', 'sclock_display_settings');
}

function sclock_display_settings() {

    $massege = (get_option('sclock_massege') != '') ? get_option('sclock_massege') : 'Shabat Shalom, this site is not working on the Shabat.';

    $timeClose = (get_option('sclock_timeClose') != '') ? get_option('sclock_timeClose') : '18';
    $timeOpen = (get_option('sclock_timeOpen') != '') ? get_option('sclock_timeOpen') : '18';

   $html = '<div class="wrap">

            <form method="post" name="options" action="options.php">

            <h2>Select Your Settings</h2>' . wp_nonce_field('update-options') . '

			<p><strong>Hour to close</strong> (Enter the hour that the site will close down on friday, in one number, for example 4PM should be 16) <br>
			<input type="text" name="sclock_timeClose" value="'.$timeClose.'"/>


		<p><strong>Hour to Open</strong> (Enter the hour that the site will reopen on saturday, in one number, for example 4PM should be 16) <br>
		<input type="text" name="sclock_timeOpen" value="'.$timeOpen.'"/>

            <p><strong>Shabat Massege:</strong> (Enter the massege that will appear when the site is down on shabat) <br><textarea style="width:88%; height:300px;" name="sclock_massege">'.$massege.'</textarea> </p>
            <p class="submit">
                <input type="hidden" name="action" value="update" />  
                <input type="hidden" name="page_options" value="sclock_massege,sclock_timeOpen,sclock_timeClose" /> 
                <input type="submit" name="Submit" value="Update" />
            </p>
            </form>

        </div>';

            echo $html;


}