jQuery(function ($) {

    'use strict';

    $(function () {
			
		var formData = new FormData();
		var words_id = wp_file_word_counter_params.words_id; 
		var characters_id = wp_file_word_counter_params.characters_id; 
		var max_files = wp_file_word_counter_params.max_files; 
		/* send file for upload in media library and return number of words and characters in file */
		$("#wfwcfileuploader").uploadFile({
			url: wp_file_word_counter_params.ajax_url,
			fileName:"wfwcfile",
			returnType:"json",
			maxFileCount:max_files,
			formData : {'action': "wfwc_file_upload", "security": wp_file_word_counter_params.wp_file_word_counter_params_nonce},
			onSuccess:function(files,data,xhr,pd)
			{
				/* Input numbers of words in element selected with ID */
				if($('#'+words_id).length){
					if($('#'+words_id).is('input') || $('#'+words_id).is('select')){
						$('#'+words_id).val(data.total_words);
					}else{
						$('#'+words_id).html(data.total_words);
					}
				}
				/* Input numbers of characters in element selected with ID*/
				if($('#'+characters_id).length){
					if($('#'+characters_id).is('input') || $('#'+characters_id).is('select')){
						$('#'+characters_id).val(data.character_count);
					}else{
						$('#'+characters_id).html(data.character_count);
					}
				}
				if(data.total_words == ""){
					alert(data.message);
				}else if(data.message == ""){
					alert(data.message_text);
				}
			}
		});
	});
});