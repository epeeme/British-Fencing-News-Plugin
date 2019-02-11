<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://dankew.me
 * @since      1.0.0
 *
 * @package    Britishfencing_News
 * @subpackage Britishfencing_News/admin/partials
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h2>British Fencing News <?php _e('Options', $this->plugin_name); ?></h2>
    <p>Simple plugin to import the latest published news from the British Fencing web site - <a href="https://www.britishfencing.com/news/">https://www.britishfencing.com/news/</a>.</p>
    <h4>Useage</h4>
    <p>shortcode - <code>[britishfencing-news]</code></p>
    <hr>
    <form method="post" name="cleanup_options" action="options.php">
    <?php
        //Grab all options
        $options = get_option($this->plugin_name); 

        $number_of_news_stories = ( isset( $options['number_of_news_stories'] ) && ! empty( $options['number_of_news_stories'] ) ) ? esc_attr( $options['number_of_news_stories'] ) : '1';
        $show_excerpt = ( isset( $options['show_excerpt'] ) && ! empty( $options['show_excerpt'] ) ) ? esc_attr( $options['show_excerpt'] ) : '1';
        $display_type = ( isset( $options['display_type'] ) && ! empty( $options['display_type'] ) ) ? esc_attr( $options['display_type'] ) : 'List';
        
        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
    ?>

    <fieldset>
        <p><?php _e( 'Display Format', $this->plugin_name ); ?></p>
        <legend class="screen-reader-text">
            <span><?php _e( 'Display Format', $this->plugin_name ); ?></span>
        </legend>
        <label for="display_type">
            <select name="<?php echo $this->plugin_name; ?>[display_type]" id="<?php echo $this->plugin_name; ?>-display_type">
                <option <?php if ( $display_type == 'List' ) echo 'selected="selected"'; ?> value="List">List</option>
                <option <?php if ( $display_type == 'Agenda' ) echo 'selected="selected"'; ?> value="Agenda">Agenda</option>
                <option <?php if ( $display_type == 'Panels' ) echo 'selected="selected"'; ?> value="Panels">Panels</option>
            </select>
        </label>
    </fieldset>

    <hr>

    <fieldset>
        <p><?php _e( 'Number Of News Stories.', $this->plugin_name ); ?></p>
        <legend class="screen-reader-text">
            <span><?php _e( 'Number Of News Stories', $this->plugin_name ); ?></span>
        </legend>
        <label for="number_of_news_stories">
            <select name="<?php echo $this->plugin_name; ?>[number_of_news_stories]" id="<?php echo $this->plugin_name; ?>-number_of_news_stories">
                <option <?php if ( $number_of_news_stories == '1' ) echo 'selected="selected"'; ?> value="1">1</option>
                <option <?php if ( $number_of_news_stories == '3' ) echo 'selected="selected"'; ?> value="3">3</option>
                <option <?php if ( $number_of_news_stories == '5' ) echo 'selected="selected"'; ?> value="5">5</option>
                <option <?php if ( $number_of_news_stories == '10' ) echo 'selected="selected"'; ?> value="10">10</option>
                <option <?php if ( $number_of_news_stories == '25' ) echo 'selected="selected"'; ?> value="25">25</option>
                <option <?php if ( $number_of_news_stories == '50' ) echo 'selected="selected"'; ?> value="50">50</option>
            </select>
        </label>
    </fieldset>

    <fieldset>
        <p><?php _e( 'Show Excerpt.', $this->plugin_name ); ?></p>
        <legend class="screen-reader-text">
            <span><?php _e( 'Show Excerpt', $this->plugin_name ); ?></span>
        </legend>
        <label for="<?php echo $this->plugin_name; ?>-show_excerpt">
            <input type="radio" name="<?php echo $this->plugin_name; ?>[show_excerpt]" value="Yes" <?php checked( 'Yes', $show_excerpt); ?> />
            <span><?php esc_attr_e('Yes', $this->plugin_name); ?></span>
            <input type="radio" name="<?php echo $this->plugin_name; ?>[show_excerpt]" value="No" <?php checked( 'No', $show_excerpt); ?> />
            <span><?php esc_attr_e('No', $this->plugin_name); ?></span>
        </label>
    </fieldset>


    <?php submit_button( __( 'Save all changes', $this->plugin_name ), 'primary','submit', TRUE ); ?>
    </form>
</div>
