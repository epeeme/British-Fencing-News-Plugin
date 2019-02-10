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

		$bfn = new HandleJSON();
		$theNewsData = $bfn -> getJSON();

		$non = $this -> _getNumberOfNewsItems($theNewsData);

        $plugInOutput = "<div class=\"container-fluid bfContainer\">";

		while ($this->_newsIndex < $non)
        {
			$title = $bfn -> getTitle($theNewsData, $this->_newsIndex);
			$excerpt = $bfn -> getExcerpt($theNewsData, $this->_newsIndex);
			$link = $bfn -> getLink($theNewsData, $this->_newsIndex);
			$date = $bfn -> getDatePub($theNewsData, $this->_newsIndex);

			$plugInOutput .= "<div class=\"row bfRow\">
				<div class=\"col-3 bfImage\"><img src=\"".$bfn -> getMediaLink($theNewsData, $this->_newsIndex)."\"></div>
				<div class=\"col-9 bfTextLine\">
				  <div class=\"row bfRow\">
				    <div class=\"col-12 bfTitle\"><h3>".$bfn -> getTitle($theNewsData, $this->_newsIndex)."</h3>
					  <div class=\"bfDate\">".date("F j, Y, g:i a", rest_parse_date($bfn -> getDatePub($theNewsData, $this->_newsIndex)))."</div>
					</div>
			      </div>
				  <div class=\"row bfRow\">
				    <div class=\"col-12 bfExcerpt\">".$bfn -> getExcerpt($theNewsData, $this->_newsIndex)."</div>
				  </div>
				</div>
			  </div><hr>";

			$this->_newsIndex += 1;
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
