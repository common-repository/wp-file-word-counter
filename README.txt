=== WordPress File Word Counter ===
Contributors: anuragsharma1986.22, rajesh23sharma
Donate link: #
Tags: word count, pdf, doc, docx, txt, count words in pdf, count words in doc, count words in file,
Requires at least: 4.0
Tested up to: 4.9.2
Stable tag: 1.0.2
License: GPLv3 or later

License URI: http://www.gnu.org/licenses/gpl-3.0.html



Count number of words and characters in uploaded file.



== Description ==



= Introduction =



This plugin helps in getting number of words and characters in doc, docx, pdf and text files.



 * User can upload files on the file uploader block where plugin shortcode <strong>[file_word_count]</strong> is included.

 * The the plugin returns number of words and characters in that file and that file is also uploaded to media library.

 * You need to add an HTML element to display the value of words or characters and add following ids for total words and characters respectively : fwc-words , fwc-characters
 
 e.g. <div id="fwc-words"></div>
      <div id="fwc-characters"></div>
	  or
	  <input type="text" name="words" id="fwc-words"/>
	  <input type="text" name="characters" id="fwc-characters"/>

 * You can also call it in php file using <br/><strong> echo do_shortcode('[file_word_count]'); </strong>

= Get Involved =



= Automatic Installation =



Automatic installation is the easiest option as WordPress handles the file transfers itself and you don't need to leave your web browser. To do an automatic install of WordPress File Word Counter, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.



In the search field type WordPress File Word Counter and click Search Plugins. Once you've found our plugin you can view details about it such as the the rating and description. Most importantly, of course, you can install it by simply clicking Install Now?.



= Manual Installation =



1. Unzip the files and upload the folder into your plugins folder (/wp-content/plugins/) overwriting older versions if they exist.

2. Activate the plugin in your WordPress admin area.



== Frequently Asked Questions ==



= What document types are supported? =



 * .docx

 * .doc

 * .pdf

 * .txt



== Screenshots ==



1. Place the shortcode on page or widget and uploader will display on the frontend.



== Changelog ==

= 1.0.0 - 01.31.2018 =

* Initial stable release.