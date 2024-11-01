<?php

/**

 * @wordpress-plugin

 * Plugin Name:       WordPress File Word Counter

 * Plugin URI:        https://www.softwhiz.in/

 * Description:       Generates a shortcode to add on any place to drop file and counts words in that file.

 * Version:           1.0.2

 * Author:            Anurag Sharma

 * Author URI:        http://www.softwhiz.in/

 * License:           GPL-2.0+

 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt

 * Text Domain:       wp-file-word-counter

 * Domain Path:       /languages

 */
 
 // If this file is called directly, abort.

if (!defined('WPINC')) {

    die;

}

if (!defined('FWC_PLUGIN_URL')) {

    define('FWC_PLUGIN_URL', plugin_dir_url(__FILE__));

}

/**

 * The code that runs during plugin activation.

 * This action is documented in includes/class-wp-file-word-counter-activator.php

 */

function activate_wp_file_word_counter() {

    require_once plugin_dir_path(__FILE__) . 'includes/class-wp-file-word-counter-activator.php';

    Wp_File_Word_Counter_Activator::activate();

}

/**

 * The code that runs during plugin deactivation.

 * This action is documented in includes/class-wp-file-word-counter-deactivator.php

 */

function deactivate_wp_file_word_counter() {

    require_once plugin_dir_path(__FILE__) . 'includes/class-wp-file-word-counter-deactivator.php';

    Wp_File_Word_Counter_Deactivator::deactivate();

}



register_activation_hook(__FILE__, 'activate_wp_file_word_counter');

register_deactivation_hook(__FILE__, 'deactivate_wp_file_word_counter');


/**

 * The core plugin class that is used to define internationalization,

 * admin-specific hooks, and public-facing site hooks.

*/
 
require plugin_dir_path(__FILE__) . 'includes/class-wp-file-word-counter.php';


/**

 * Start execution of the plugin.

 *

 *

 * @since    1.0.0

 */



add_action('plugins_loaded', 'wfwc_plugins_init', 0);



function run_wp_file_word_counter() {



    $plugin = new Wp_File_Word_Counter();

    $plugin->run();

}



function wfwc_plugins_init() {

    run_wp_file_word_counter();

}
