<?php
//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();

delete_option( 'sclock_timeClose');
delete_option( 'sclock_timeOpen');
delete_option( 'sclock_massege');