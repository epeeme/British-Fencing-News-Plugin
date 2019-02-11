<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://dankew.me
 * @since      1.0.0
 *
 * @package    Britishfencing_News
 * @subpackage Britishfencing_News/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Britishfencing_News
 * @subpackage Britishfencing_News/public
 * @author     Dan Kew <dankew@ntlworld.com>
 */
class Britishfencing_News_Public {

	private $_newsIndex = 0; 

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/britishfencing-news-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/britishfencing-news-public.js', array( 'jquery' ), $this->version, false );

	}

	public function britishfencing_news_output( $atts ) {
		// $args = shortcode_atts(
		// 	array(
		// 		'arg1'   => 'arg1',
		// 		'arg2'   => 'arg2',
		// 	),
		// 	$atts
		// );
		// code...
		// $var = ( strtolower( $args['arg1']) != "" ) ? strtolower( $args['arg1'] ) : 'default';
		// code...
		// return $var;

		$bfn = new HandleJSON( $this->plugin_name, $this->version );
		$theNewsData = $bfn -> getJSON();

		$non = $this -> _getNumberOfNewsItems($theNewsData);

    $plugInOutput = "<div class=\"container-fluid bfContainer\">";

		$options = get_option($this->plugin_name); 
		$show_excerpt = ( isset( $options['show_excerpt'] ) && ! empty( $options['show_excerpt'] ) ) ? esc_attr( $options['show_excerpt'] ) : 'Yes';
		$display_type = ( isset( $options['display_type'] ) && ! empty( $options['display_type'] ) ) ? esc_attr( $options['display_type'] ) : 'List';

     switch ($display_type) {
			 case 'List' : {
				 $plugInOutput .= "<ul>";
				 while ($this->_newsIndex < $non) {
					 
				 	 $plugInOutput .= "<li><a href=\"".$bfn -> getLink($theNewsData, $this->_newsIndex)."\">".$bfn -> getTitle($theNewsData, $this->_newsIndex)."</a> (".date("F j, Y, g:i a", rest_parse_date($bfn -> getDatePub($theNewsData, $this->_newsIndex))).")";
					 if ($show_excerpt === 'Yes') {
						 $plugInOutput .= "<br>".$bfn -> getExcerpt($theNewsData, $this->_newsIndex)."<hr>";
					 }		
					 $plugInOutput .= "</li>";
					 $this->_newsIndex += 1;
				 }
				 $plugInOutput .= "</ul>";
         break;
			 }
			 case 'Agenda' : {
				 while ($this->_newsIndex < $non) {
					 $plugInOutput .= "<div class=\"row bfRow\">
						<div class=\"col-3 bfImage\"><img src=\"".$bfn -> getMediaLink($theNewsData, $this->_newsIndex)."\"></div>
						<div class=\"col-9 bfTextLine\">
							<div class=\"row bfRow\">
								<div class=\"col-12 bfTitle\"><h3>".$bfn -> getTitle($theNewsData, $this->_newsIndex)."</h3>
								<div class=\"bfDate\">".date("F j, Y, g:i a", rest_parse_date($bfn -> getDatePub($theNewsData, $this->_newsIndex)))."</div>
							</div>
								</div>";
					  if ($show_excerpt === 'Yes') {
							$plugInOutput .= "<div class=\"row bfRow\">
								<div class=\"col-12 bfExcerpt\">".$bfn -> getExcerpt($theNewsData, $this->_newsIndex)."</div>
							</div>";
					  }		
					  $plugInOutput .= "</div></div><hr>";
				    $this->_newsIndex += 1;
			   }
         break;
		 	 }
		 	 case 'Panels' : {
				$plugInOutput .= "<div id=\"bfPanelContainer\">";
				$pc = 1;
				while ($this->_newsIndex < $non) {
					$plugInOutput .= "<div class=\"bfPanel cl".$pc." cl".($pc+2)."\">
					 <div class=\"bfImagePanel\"><img src=\"".$bfn -> getMediaLink($theNewsData, $this->_newsIndex)."\"></div>
					 <div class=\"bfTextPanel\">
					     <h3>".$bfn -> getTitle($theNewsData, $this->_newsIndex)."</h3>
							 <br>".date("F j, Y, g:i a", rest_parse_date($bfn -> getDatePub($theNewsData, $this->_newsIndex)));
					 if ($show_excerpt === 'Yes') {
						 $plugInOutput .= "<p>".$bfn -> getExcerpt($theNewsData, $this->_newsIndex)."</p>";
					 }		
					 $plugInOutput .= "</div></div>";
					 $this->_newsIndex += 1;
					 $pc++;
					 if ($pc == 3) { $pc = 1; }
				}
				$plugInOutput .= "</div>";
				break;
			 }
		 }
			

		$plugInOutput .= "</div>";

		echo $plugInOutput;

	}

    /**
     * Return the number of news items found in the JSON data
     * 
     * @param object $allnews JSON decoded dataset
     * 
     * @return int
     */
    private function _getNumberOfNewsItems($allnews)
    {
         return count($allnews); 
    }

}
