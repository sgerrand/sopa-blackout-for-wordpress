<?php
/**
 *  * @package SOPA Blackout
 *   */
/*
 * Plugin Name: SOPA Blackout
 * Plugin URI: https://github.com/sgerrand/sopa-blackout-for-wordpress
 * Description: SOPA Blackout helps you support the SOPA Blackout by inserting JavaScript into your page head on 18 January 2012.
 * Version: 1.0.0
 * Author: Sasha Gerrand
 * Author URI: http://sasha.gerrand.id.au/about
 * License: GPLv2
 * */

/*
 * This program is free software; you can redistribute it and/or modify 
 * it under the terms of the GNU General Public License as published by 
 * the Free Software Foundation; version 2 of the License.
 *
 * This program is distributed in the hope that it will be useful, 
 * but WITHOUT ANY WARRANTY; without even the implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
 * GNU General Public License for more details. 
 *
 * You should have received a copy of the GNU General Public License 
 * along with this program; if not, write to the Free Software 
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 
 * */

define('SOPA_BLACKOUT_VERSION', '1.0.0');

if ( ! class_exists('SOPA_Blackout_Filter') ) {
    /**
     * Filter functions for WordPress
     */
    class SOPA_Blackout_Filter {

        /**
         * SOPA Blackout date, in ISO-8601 format.
         *
         * @var string
         * @access public
         */
        const DATE_BLACKOUT     = '2012-01-18';

        /**
         * Date format string.
         *
         * @var string
         * @access public
         */
        const DATE_FORMAT       = '%Y-%m-%d';

        /**
         * URL for source JavaScript file.
         *
         * @var string
         * @access public
         */
        const JAVASCRIPT_URL    = 'http://js.sopablackout.org/sopablackout.js';

        /**
         * JavaScript filename.
         *
         * @var string
         * @access public
         */
        const JAVASCRIPT_FNAME  = 'sopablackout.js';

        /**
         * Determine whether now is SOPA Blackout time, 
         * +/- 24 hours
         *
         * @return bool
         */
        function is_sopa_blackout_time() {
            $now        = mktime();
            $target     = strtotime(self::DATE_BLACKOUT);
            $interval   = 60 * 60 * 24;
            $start      = $target - $interval;
            $end        = $target + $interval;

            return ($now >= $start && $now <= $end);
        }

        /**
         * Output the relevant JavaScript
         *
         * @return void
         */
        function enqueue_scripts() {
            $src = plugins_url(self::JAVASCRIPT_FNAME, __FILE__);

            if (self::is_sopa_blackout_time()) {
                wp_enqueue_script('sopablackout', $src);
            }
        }
    }
}

add_action('wp_enqueue_scripts', array('SOPA_Blackout_Filter','enqueue_scripts'), 2);
