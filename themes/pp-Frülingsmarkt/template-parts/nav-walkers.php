<?php
/**
 * Navigations-Funktionen
 **/

class Simple_Nav_Walker extends Walker_Nav_Menu {

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$output .= sprintf(
			'<li><a href="' . ( ! is_front_page() ? get_home_url() : null ) . '#%s">%s</a>',
			ww_get_slug_from_url( $item->url ),
			$item->title
		);
	}
}

class Social_Nav_Walker extends Walker_Nav_Menu {

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$output .= sprintf(
			'<li class="%s"><a href="%s" target="_blank">%s</a>',
			( 'Facebook' === $item->title ? 'fb-logo' : null ),
			$item->url,
			( 'Facebook' === $item->title ? '<svg role="img" class="symbol" aria-hidden="true" focusable="false"><use xlink:href="' . get_template_directory_uri() . '/img/icons.svg#facebook"></use></svg><span class="show-for-sr">Facebook</span>' : $item->title )
		);
	}
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}

class Service_Nav_Walker extends Walker {

	public function walk( $elements, $max_depth ) {

		$list = array();

		foreach ( $elements as $item ) {

				$list[] = '<li><a href="' . $item->url . '"' . ( $item->target ? ' target="_blank"' : '' ) . '>' . $item->title . '</a></li>';

		}

		return join( $list );
	}
}
