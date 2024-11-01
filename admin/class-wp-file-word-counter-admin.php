<?php

/**
 * @package    Wp_File_Word_Counter
 * @subpackage Wp_File_Word_Counter/admin
 * @author     Anurag Sharma
 */
class Wp_File_Word_Counter_Admin {

    /**
     * The ID of plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of plugin.
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
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->load_dependencies();
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        
    }

    private function load_dependencies() {
       
    }
	
	public function wp_file_word_counter_upload_dir($param) {

        $custom_dir = '/wp-file-word-counter';

        $param['path'] = $param['basedir'] . $custom_dir;

        $param['url'] = $param['basedir'] . $custom_dir;

        return $param;

    }
	
	public function wfwc_upload_file_to_media($filename, $count_word, $total_characters) {

        $parent_post_id = '';

        $filetype = wp_check_filetype(basename($filename), null);

        $wp_upload_dir = wp_upload_dir();

        $attachment = array(

            'guid' => $wp_upload_dir['url'] . '/' . basename($filename),

            'post_mime_type' => $filetype['type'],

            'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),

            'post_content' => '',

            'post_status' => 'inherit'

        );

        $attach_id = wp_insert_attachment($attachment, $filename, $parent_post_id);

        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $attach_data = wp_generate_attachment_metadata($attach_id, $filename);

        wp_update_attachment_metadata($attach_id, $attach_data);

        update_post_meta($attach_id, 'total_word', $count_word);

        update_post_meta($attach_id, 'character_count', $total_characters);

        return $attach_id;

    }
	
	public function wfwc_file_upload_action(){
		
        add_filter('upload_dir', array($this, 'wp_file_word_counter_upload_dir'), 10, 1);
		
		if ( class_exists( 'WooCommerce' ) ) {
			
			$product_id = sanitize_text_field($_POST['product_id']);
			
			$_SESSION['product_id'] = $product_id;
		}

        $return_messge = array('total_words' => '', 'character_count' => '', 'message' => 'File successfully uploaded', 'url' => '', 'message_text' => '');

        if (isset($_POST['security']) && !empty($_POST['security'])) {

            if (wp_verify_nonce($_POST['security'], 'wp_file_word_counter_params_nonce')) {

                if (!function_exists('wp_handle_upload')) {

                    require_once(ABSPATH . 'wp-admin/includes/file.php');

                }

                $uploadedfile = $_FILES['wfwcfile'];

                $upload_overrides = array('test_form' => false);

                $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

                if ($movefile && !isset($movefile['error'])) {

                    $fileArray = pathinfo($movefile['file']);

                    $file_ext = $fileArray['extension'];

                    $return_messge['url'] = $movefile['url'];

                    if ($file_ext == "doc" || $file_ext == "docx" || $file_ext == "pdf") {

                        $docObj = new Wp_File_Word_Counter_String_Reader($movefile['file']);

                        $return_string = $docObj->convertToText();

                        if ($return_string != 'File Not exists' && $return_string != 'Invalid File Type' && !empty($return_string)) {

                            $total_words = count(str_word_count($return_string, 1));

                            $total_characters = strlen(utf8_decode($return_string));

                            $attach_id = $this->wfwc_upload_file_to_media($movefile['file'], $total_words, $total_characters);

                            $attachment_page = wp_get_attachment_url($attach_id);

                            $return_messge['total_words'] = $total_words;

                            $return_messge['character_count'] = $total_characters;

                            $_SESSION['attach_id'] = $attach_id;

                            $_SESSION['total_words'] = $total_words;

                            $_SESSION['total_characters'] = $total_characters;

                            $_SESSION['file_name'] = '<a href="' . esc_url($attachment_page) . '" target="_blank">' . esc_html($fileArray['basename']) . '</a>';

                            $return_messge['message_content'] = 'File successfully uploaded';

                            echo json_encode($return_messge, true);

                        } else {

                            $return_messge = array('total_word' => '', 'message' => 'Your pdf file is secured or empty.', 'url' => '');

                            $return_messge['message_content'] = 'The file upload failed, Please choose a valid file extension and try again.';

                            echo json_encode($return_messge, true);

                        }

                    } elseif ($file_ext == 'txt') {

                        $file_content = file_get_contents($movefile['file']);

                        $total_words = count(str_word_count($file_content, 1));

                        $total_characters = strlen(utf8_decode($file_content));

                       $attach_id = $this->wfwc_upload_file_to_media($movefile['file'], $total_words, $total_characters);

                        $attachment_page = wp_get_attachment_url($attach_id);

                        $return_messge['total_words'] = $total_words;

                        $return_messge['character_count'] = $total_characters;
						
                        $_SESSION['attach_id'] = $attach_id;

                        $_SESSION['total_words'] = $total_words;

                        $_SESSION['total_characters'] = $total_characters;

                        $_SESSION['file_name'] = '<a href="' . esc_url($attachment_page) . '" target="_blank">' . esc_html($fileArray['basename']) . '</a>';

                        $return_messge['message_content'] = 'File successfully uploaded';

                        echo json_encode($return_messge, true);

                    } else {

                        $return_messge = array('total_words' => '', 'message' => 'The file upload failed, Please choose a valid file extension and try again.', 'url' => '');

                        echo json_encode($return_messge, true);

                    }

                    exit();

                } else {

                    $return_messge = array('total_words' => '', 'message' => $movefile['error'], 'url' => '');

                    echo json_encode($return_messge, true);

                    exit();

                }

            } else {

                $return_messge = array('total_words' => '', 'message' => 'security problem, wordpress nonce is not verified', 'url' => '');

                echo json_encode($return_messge, true);

                exit();

            }

        } else {

            $return_messge = array('total_words' => '', 'message' => 'security problem, wordpress nonce is not verified', 'url' => '');

            echo json_encode($return_messge, true);

            exit();

        }

    }
	

}
