<?php
/**
 *  * @package SOPA Blackout
 *   */
/*
 * Plugin Name: SOPA Blackout JS
 * Plugin URI: https://github.com/sgerrand/sopa-blackout-for-wordpress
 * Description: SOPA Blackout JS helps you support the SOPA Blackout by inserting JavaScript into your page head on 18 January 2012.
 * Version: 1.0.2
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

define('SOPA_BLACKOUT_JS_VERSION', '1.0.2');

if ( ! class_exists('SOPA_Blackout_JS_Filter') ) {
    /**
     * Filter functions for WordPress
     */
    class SOPA_Blackout_JS_Filter {

        /**
         * SOPA Blackout date, in ISO-8601 format.
         *
         * @var string
         * @access public
         */
        const DATE_BLACKOUT     = '2012-01-18';

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
         * Minimized version of JavaScript filename.
         *
         * @var string
         * @access public
         */
        const JAVASCRIPT_FNAME_MIN = 'sopablackout.min.js';

        /**
         * Determine if the blog is in SOPA Blackout time
         *
         * Method appropriated from https://github.com/chrisguitarguy/WP-SOPA-Blackout/blob/master/wp-sopa-blackout.php
         *
         * @return bool
         * @access public
         */
        function is_sopa_blackout_time() {
            return ( ! is_admin() && date('Y-m-d', current_time('timestamp')) == self::DATE_BLACKOUT );
        }

        /**
         * Output the relevant JavaScript
         *
         * @return void
         * @access public
         */
        function enqueue_scripts() {
            $src = plugins_url(self::JAVASCRIPT_FNAME_MIN, __FILE__);

            if (self::is_sopa_blackout_time()) {
                wp_enqueue_script('sopablackout', $src);
            }
        }
    }
}

add_action('wp_enqueue_scripts', array('SOPA_Blackout_JS_Filter','enqueue_scripts'), 2);
