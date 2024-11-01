<?php

/**
 * @package    Wp_File_Word_Counter
 * @subpackage Wp_File_Word_Counter/public
 * @author     Anurag Sharma
 */
class Wp_File_Word_Counter_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
		
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wfwc-uploadfile.css', array(), $this->version, 'all');
        
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
       
	   wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wfwc-uploadfile.min.js', array('jquery'), $this->version, false);
	   
		if (wp_script_is($this->plugin_name)) {

			wp_localize_script($this->plugin_name, 'wp_file_word_counter_params', apply_filters('wp_file_word_counter_params', array(

				'ajax_url' => admin_url('admin-ajax.php'),
				
				'words_id' => 'fwc-words',
				
				'characters_id' => 'fwc-characters',
				
				'max_files' => 100,

				'wp_file_word_counter_params_nonce' => wp_create_nonce("wp_file_word_counter_params_nonce"),

			)));

		}
	   wp_enqueue_script($this->plugin_name . '-public', plugin_dir_url(__FILE__) . 'js/wfwc-public.js', array('jquery'), $this->version, false);
	   
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function wfwc_shortcodes() {
       
	   add_shortcode('file_word_count', array($this, 'wp_file_word_count_shortcode_func'));
    }
	
	public function wp_file_word_count_shortcode_func(){
		echo '<div id="wfwcfileuploader">Upload</div>';
	}

    

}
