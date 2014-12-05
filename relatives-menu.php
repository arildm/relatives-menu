<?php
/*
Plugin Name: Relatives menu
Plugin URI: http://github.com/arildm/relatives-menu
Description: Provides a simple widget that lists child pages.
Version: 0.1
Author: Arild <arild@klavaro.se>
Author URI: http://klavaro.se
Tags: widget, pages, menu
*/

add_action( 'widgets_init', 'relatives_menu_register_widgets' );
function relatives_menu_register_widgets() {
	register_widget( 'RelativesMenuWidget' );
}

/**
 * The Relatives Menu widget.
 */
class RelativesMenuWidget extends WP_Widget {

	public function __construct( $id_base, $name, $widget_options = array(), $control_options = array() ) {
		parent::__construct(
			'relatives-menu',
			__( 'Relatives Menu' , 'relatives-menu'),
			__( "Lists child pages, and their children's children, of the ancestor of the current page." , 'relatives-menu' ),
			$control_options
		);
	}

	public function widget( $args, $instance ) {
		global $post;
		$ancestor_id = static::findAncestorId( $post );
		echo '<ul>';
		wp_list_pages( array( 'child_of' => $ancestor_id, 'title_li' => '' ) );
		echo '</ul>';
	}

	/**
	 * Find the ID of the ancestor of a post.
	 */
	protected function findAncestorId( $post ) {
		$ancestors = get_post_ancestors( $post );
		if ( count( $ancestors ) )
			return end( $ancestors );
		else
			return $post->ID;
	}

}
