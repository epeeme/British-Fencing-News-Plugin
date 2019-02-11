<?php

/**
 * Functions to handle the interaction with JSON data returned from the Wordpress REST API
 * call to the https://www.britishfencing.com/ web site.
 * 
 * News URL - https://www.britishfencing.com/wp-json/wp/v2/posts/?categories=33&per_page=xxx
 *
 * @author  Dan Kew <dankew@ntlworld.com>
 * @license GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 */

class HandleJSON
{

    protected $newsUrl;

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
     * Placeholder constrctor if needed for future use
     * 
     * @return void
     */
    function __construct( $plugin_name, $version ) {
        
		$this->plugin_name = $plugin_name;
        $this->version = $version;
        
        $options = get_option($this->plugin_name); 
        $number_of_news_stories = ( isset( $options['number_of_news_stories'] ) && ! empty( $options['number_of_news_stories'] ) ) ? esc_attr( $options['number_of_news_stories'] ) : '1';

        $this->newsUrl = "https://www.britishfencing.com/wp-json/wp/v2/posts/?categories=33&per_page=".$number_of_news_stories."&_embed";
    }

    /**
     * Check the URL we are requesting does exist and doesn't return a 404
     * 
     * @param string $url the location of the source JSON data
     * 
     * @return boolean
     */
    private function _URLexists()
    {
        $urlHeaders = @get_headers($this->newsUrl);
        if (!$urlHeaders || $urlHeaders[0] == 'HTTP/1.1 404 Not Found') {
            $exists = false;
        } else {
             $exists = true;
        }      
        return $exists;
    }
        
    /**
     * Request the data from the provided URL and decode the JSON
     * 
     * @param string $url source of data to extract using the Wordpress REST API v2
     * 
     * @return object
     */
    function getJSON($inUrl = '')
    {
        $json = (object)[];

        $inUrl = (!(isset($inUrl))) ? $inUrl : $this->newsUrl;

        if ($this->_URLexists($this->newsUrl)) {
            $request = wp_remote_get($this->newsUrl);
            if (!(is_wp_error($request))) {
                $body = wp_remote_retrieve_body($request);
                $json = json_decode($body);
            }  
        }
        return $json;
    } 
        
    /**
     * Extract the news post title from the JSON data. 
     * 
     * @param object $newsData JSON object containing all data
     * @param int    $position index onto the data of the news item to check
     * 
     * @return string News item title or empty string
     */
    function getTitle($newsData, $position)
    {
        return isset($newsData[$position]->title->rendered) ? $newsData[$position]->title->rendered : '';
    }
     
    /**
     * Extract the news post excerpt from the JSON data. 
     * 
     * @param object $newsData JSON object containing all data
     * @param int    $position index onto the data of the news item to check
     * 
     * @return string News item excerpt or empty string
     */
    function getExcerpt($newsData, $position)
    {
        return isset($newsData[$position]->excerpt->rendered) ? $newsData[$position]->excerpt->rendered : '';
    }

    /**
     * Extract the news post link from the JSON data. 
     * 
     * @param object $newsData JSON object containing all data
     * @param int    $position index onto the data of the news item to check
     * 
     * @return string News item link or empty string
     */
    function getLink($newsData, $position)
    {
        return isset($newsData[$position]->link) ? $newsData[$position]->link : 'https://www.britishfencing.com/news/';
    }

    /**
     * Extract the news post date published from the JSON data. 
     * 
     * @param object $newsData JSON object containing all data
     * @param int    $position index onto the data of the news item to check
     * 
     * @return string News item date published or empty string
     */
    function getDatePub($newsData, $position)
    {
        return isset($newsData[$position]->date) ? $newsData[$position]->date : '';
    }

    /**
     * Extract the news media link from published from the JSON data. 
     * 
     * @param object $newsData JSON object containing all data
     * @param int    $position index onto the data of the news item to check
     * 
     * @return string News item media link to another JSON or empty string
     */
    function getMediaLink($newsData, $position)
    {
        return isset($newsData[$position]->_embedded->{'wp:featuredmedia'}[0]->media_details->sizes->{'news-image'}->source_url) ? $newsData[$position]->_embedded->{'wp:featuredmedia'}[0]->media_details->sizes->{'news-image'}->source_url : plugins_url( '../public/images/bflogo.png', __FILE__ );
    }
}

?>