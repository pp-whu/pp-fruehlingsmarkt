<?php


/**
 * Gibt ein Responsives Hero-Image mittels HTML5 Picture Tag aus zurück.
 *
 * @param array $sizes    Breakpoints und Größen zur Anzeige des Bildes;
 *                        Format 'breakpoint' => 'size'.
 */
function get_hero_image( $sizes = array( 0 => 'full' ) ) {

	if ( is_search() ) {
		$thumb_id = get_post_thumbnail_id( get_option( 'page_on_front' ) );
	} elseif ( has_post_thumbnail() ) {
		$thumb_id = get_post_thumbnail_id();
	} else {
		while ( $post ) {
			$post_parent_id = $post->post_parent;
			if ( $post_parent_id ) {
				$thumb_id = get_post_thumbnail_id( $post_parent_id );
			} else {
				$thumb_id = get_post_thumbnail_id( get_option( 'page_on_front' ) );
			}
			if ( $thumb_id ) {
				break;
			}
			$post = get_post( $post->post_parent );
		}
		wp_reset_postdata();
	}

	if ( $thumb_id ) {

		$content = get_picture_tag( $thumb_id, $sizes, '', '', true );

		return $content;

	} else {

		return false;

	}
}

/**
 * Gibt ein Responsives Hero-Image mittels HTML5 Picture Tag aus.
 *
 * @param array $sizes    Breakpoints und Größen zur Anzeige des Bildes;
 *                        Format 'breakpoint' => 'size'.
 */
function the_hero_image( $sizes = array( 0 => 'full' ) ) {

	echo get_hero_image( $sizes );

}
