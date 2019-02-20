<?php

function counter() {
	global $counter;
	++$counter;
	return $counter;
}

/**
 * Gibt die Inhalte einer ACF Galerie zurück
 *
 * @param string $field   ACF Feld, das verwendet werden soll.
 */
function get_gallery( $field ) {

	$gallery = '';

	if ( $field ) {

		$get_tag = new HtmlMaker();
		$images  = $field;

		foreach ( $images as $image ) {

			$gallery_item = get_picture_tag( $image['ID'], array( 0 => 'gallery' ), $image['alt'], null, 'g_image' );
			$gallery     .= $get_tag->li( $gallery_item );

		}

		$gallery = $get_tag->ul( $gallery, 'gallery' );

	}

	return $gallery;

}

/**
 * Gibt das Feld Überschrift zurück
 *
 * @param string $flexible ACF Objekt des Feldes.
 */
function get_acf_headline( $flexible ) {

	$title    = '';
	$subtitle = '';

	if ( isset( $flexible['title'] ) ) {

		$title = '<h2>' . $flexible['title'] . '</h2>';

		if ( isset( $flexible['subtitle'] ) && $flexible['subtitle'] ) {

			$subtitle = '<strong class="subtitle">' . $flexible['subtitle'] . '</strong>';

		}

		return '<header>' . $title . $subtitle . '</header>';

	}

	return false;

}

	/**
	 * Gibt das Feld Editor zurück
	 *
	 * @param string $flexible ACF Objekt des Feldes.
	 */
function get_acf_editor( $flexible ) {

	if ( $flexible['editor'] ) {

		return $flexible['editor'];

	}

	return false;

}
/**
 * Gibt das Feld Intro-Text zurück
 *
 * @param string $flexible ACF Objekt des Feldes.
 */
function get_acf_intro_text( $flexible ) {

	if ( $flexible['intro_text'] ) {

		$content  = '<section id="intro-text" class="bg-white"><div class="content-inner"><h1>' . get_the_title() . '</h1>';
		$content .= '<p>' . $flexible['intro_text'] . '</p></div></section>';

		return $content;

	}

	return false;

}
/**
 * Gibt das Feld Team zurück
 *
 * @param string $flexible ACF Objekt des Feldes.
 */
function get_acf_team( $flexible ) {

	if ( $flexible['team'] ) {

		$content = '';
		$team    = $flexible['team'];

		foreach ( $team as $team_item ) {

			$content .= '<article class="team-item"><div class="item_img">' . get_picture_tag( $team_item['img'], array( 0 => 'team' ) ) . '</div><div class="item_text"><h3>' . $team_item['name'] . '</h3>' .
			( $team_item['text'] ? '<p>' . $team_item['text'] . '</p>' : null ) . '</div></article>';

		}

		return $content;

	}

	return false;

}

/**
 * Gibt das Feld News zurück
 *
 * @param string $flexible ACF Objekt des Feldes.
 */
function get_acf_news( $flexible ) {

	if ( $flexible['news'] ) {
		$content   = '';
		$news_args = array(
			'post_type'      => 'post',
			'posts_per_page' => 3,
		);
			$news  = new WP_Query( $news_args );
		if ( $news->have_posts() ) {
			$content .= '<div class="aktuelles-wrap">';
			while ( $news->have_posts() ) {
				$news->the_post();
				$media_id = get_post_thumbnail_id( $post->ID );
				$content .= '<article class="aktuelles-item"><a href="' . esc_url( get_permalink() ) . '">';
				$content .= '<h3>' . get_the_title() . '</h3>';
				$content .= '<div class="img-item"><span class="date">' . get_the_date( 'd.m.Y | H:i' ) . ' Uhr</span>';
				if ( $media_id ) {
					$content .= get_picture_tag( $media_id, array( 0 => 'news' ) );
				}
				$content .= '</div></a></article>';
			}
			$content .= '</div><a href="#" class="btn-more">mehr<svg role="img" class="symbol" aria-hidden="true" focusable="false"><use xlink:href="' . esc_url( get_template_directory_uri() ) . '/img/icons.svg#plus"></use></svg></a>';
			wp_reset_postdata();
		}

		return $content;

	}

	return false;

}

/**
 * Gibt das Feld Öffnungszeiten zurück
 *
 * @param string $flexible ACF Objekt des Feldes.
 */
function get_acf_openinghrs( $flexible ) {

	if ( $flexible['openinghrs'] ) {
		$content = $flexible['openinghrs'];
		$content = '<div class="openinghrs"><h3>Öffnungszeiten</h3>' . $content . '</div>';

		return $content;

	}

	return false;

}
/**
 * Gibt die Adresse zurück
 *
 * @param string $field   ACF Feld, das verwendet werden soll.
 */
function get_acf_location( $flexible ) {
	$get_tag        = new HtmlMaker();
		$addressdiv = '';
	if ( $flexible['name'] ) {
		$address      = '';
		$address_part = '';
		$address     .= $get_tag->tag( 'h3', $flexible['name'], array( 'itemprop' => 'name' ) );
		if ( $flexible['altname'] ) {
			$address .= $get_tag->div( $flexible['altname'], null, array( 'itemprop' => 'alternateName' ) );
		}
		$address_part  = $get_tag->div( $flexible['street'], null, array( 'itemprop' => 'streetAddress' ) );
		$address_part .= $get_tag->div( $get_tag->span( $flexible['zipcode'], null, array( 'itemprop' => 'postalCode' ) ) . ' ' . $get_tag->span( $flexible['location'], null, array( 'itemprop' => 'addressLocality' ) ) );
		$address      .= $get_tag->div(
			$address_part, 'postal', array(
				'itemprop'  => 'address',
				'itemscope' => null,
				'itemtype'  => 'http://schema.org/PostalAddress',
			)
		);
		if ( $flexible['tel'] ) {
			$address_part  = $get_tag->span( 'Telefon: ', 'lbl' );
			$address_part .= $get_tag->tag( 'span', $flexible['tel'], array( 'itemprop' => 'telephone' ) );
			$address      .= $get_tag->div( $address_part, 'phone' );
		}
		if ( $flexible['fax'] ) {
			$address_part  = $get_tag->span( 'Fax: ', 'lbl' );
			$address_part .= $get_tag->tag( 'span', $flexible['fax'], array( 'itemprop' => 'faxNumber' ) );
			$address      .= $get_tag->div( $address_part, 'fax' );
		}
		if ( $flexible['email'] ) {
			$mail          = $flexible['email'];
			$address_part  = $get_tag->span( 'E-Mail: ', 'lbl' );
			$address_part .= $get_tag->a( $get_tag->span( $mail ), 'mailto:' . $mail, null, 'E-Mail an ' . $mail . ' schreiben', null, array( 'itemprop' => 'email' ) );
			$address      .= $get_tag->div( $address_part, 'email' );
		}
		if ( $flexible['coords'] ) {
			$coords        = $flexible['coords'];
			$address_part  = $get_tag->tag(
				'meta', null, array(
					'class'    => 'lat',
					'itemprop' => 'latitude',
					'content'  => $coords['lat'],
				), true
			);
			$address_part .= $get_tag->tag(
				'meta', null, array(
					'class'    => 'lng',
					'itemprop' => 'longitude',
					'content'  => $coords['lng'],
				), true
			);
			$address      .= $get_tag->span(
				$address_part, null, array(
					'itemprop'  => 'geo',
					'itemscope' => null,
					'itemtype'  => 'http://schema.org/GeoCoordinates',
				)
			);
		}
		$addressdiv .= $get_tag->div(
			$address, 'address', array(
				'itemscope' => null,
				'itemtype'  => 'http://schema.org/LocalBusiness',
			)
		);

		$return = $get_tag->div( $get_tag->div( null, 'map' ) . $get_tag->div( $addressdiv, 'addresses' ), 'locations' );

		return $return;
	}
		return false;

}

/**
 * Google API key
 */
function ww_acf_init() {
	acf_update_setting( 'google_api_key', 'AIzaSyBQJ__YgeTKzO4wh-4-SDKqDxP9xFJl3Vk' );
}
add_action( 'acf/init', 'ww_acf_init' );

/**
 * Gibt die Inhalte einer ACF Galerie als Slider zurück
 *
 * @param string $field   ACF Feld, das verwendet werden soll.
 */
function get_acf_slider( $flexible ) {

	if ( $flexible['slider'] ) {

		$images  = $flexible['slider'];
		$get_tag = new HtmlMaker();
		$slider  = '';
		foreach ( $images as $image ) {
			$slider_item = get_picture_tag(
				$image['ID'], array(
					0    => 'slider-small',
					321  => 'slider-medium',
					641  => 'slider-large',
					769  => 'slider-xlarge',
					1025 => 'slider-xxlarge',
					1281 => 'slider-xxxlarge',
					1601 => 'slider-xxxxlarge',
				), $image['alt'], null, 'g_image'
			);
			$slider     .= $get_tag->div( $slider_item );
		}
		if ( count( $images ) > 1 ) {
				$slider_js = '$(function(){
							$(".slider").slick({
								autoplay: true,
								autoplaySpeed: 6000,
								dots: true,
								infinite: true,
								speed: 1000,
								slidesToShow: 1,
								prevArrow: "<button type=\"button\" class=\"slick-prev\">Zurück<svg role=\"img\" class=\"symbol\" aria-hidden=\"true\" focusable=\"false\"><use xlink:href=\"' . esc_url( get_template_directory_uri() ) . '/img/icons.svg#zurueck\"></use></svg></button>",
								nextArrow: "<button type=\"button\" class=\"slick-next\">Weiter<svg role=\"img\" class=\"symbol\" aria-hidden=\"true\" focusable=\"false\"><use xlink:href=\"' . esc_url( get_template_directory_uri() ) . '/img/icons.svg#weiter\"></use></svg></button>"
							});
						});';
				wp_enqueue_script( 'slider', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array( 'jquery' ), false, true );
				wp_add_inline_script( 'slider', $slider_js );
		}

		return $get_tag->div( $get_tag->div( $slider, 'slider' ), 'slideshow' );

	}

	return false;

}
	/**
	 * Gibt das Feld Akkordeon zurück
	 *
	 * @param string $flexible ACF Objekt des Feldes.
	 */
function get_acf_accordion( $flexible ) {

		$accordion       = '';
		$accordion_items = false;

	if ( isset( $flexible['items'] ) ) {

		$accordion_items = $flexible['items'];

	}

	if ( $accordion_items ) {

		foreach ( $accordion_items as $accordion_item ) {

			$accordion .= '<article class="a_item" id="ac-' . counter() . '">' .
			   '<h3 class="a_header">' . $accordion_item['headline'] . '</h3>';

			$accordion_contents = $accordion_item['content'];

			if ( $accordion_contents ) {

				$accordion .= '<div class="a_content">';

				foreach ( $accordion_contents as $accordion_content ) {

					$accordion .= '<div class="a_inner' . ( ! $accordion_content['img'] ? ' indent' : null ) . ( $accordion_content['include'] ? ' include' : null ) . '">';

					$accordion .= '<div class="a_text">' . ( $accordion_content['title'] ? '<h4>' . $accordion_content['title'] . '</h4>' : null ) . $accordion_content['text'] . '</div>';
					$accordion .= ( $accordion_content['img'] ? '<div class="a_img">' . get_picture_tag( $accordion_content['img'], array( 0 => 'ac_img' ) ) . '</div>' : null );
					$accordion .= ( $accordion_content['price'] ? '<p class="a_price">' . $accordion_content['price'] . '</p>' : null );

					$accordion .= '</div>';

				}
			}
			$accordion .= '</div></article>';

		}

		return '<div class="accordion">' . $accordion . '</div>';

	}

		return false;

}

/**
 * Gibt das Feld Erlesenes zurück
 *
 * @param string $flexible ACF Objekt des Feldes.
 */
function get_acf_selected( $flexible ) {

	if ( $flexible['text'] && $flexible['img'] ) {

			$content = '<p>' . $flexible['text'] . '</p>' .
			get_picture_tag(
				$flexible['img'], array(
					0    => 'selected-small',
					321  => 'selected-medium',
					641  => 'selected-large',
					769  => 'selected-xlarge',
					1025 => 'slider-xxlarge',
					1281 => 'slider-xxxlarge',
					1601 => 'slider-xxxxlarge',
				)
			);

		return $content;

	}

	return false;

}

	/**
	 * Gibt die Inhalte eines Abschnitts der flexiblen ACF Felds zurück
	 *
	 * @param string $flexible ACF Objekt des Abschnitts.
	 */
function get_flexible_row( $flexible ) {

	$get_tag = new HtmlMaker();
	$content = false;

	foreach ( $flexible as $row ) {

		if ( isset( $row['acf_fc_layout'] ) && function_exists( 'get_acf_' . $row['acf_fc_layout'] ) ) {

			$content .= call_user_func( 'get_acf_' . $row['acf_fc_layout'], $row );

		}
	}

	return $content;
}


	/**
	 * Gibt die Inhalte eines flexiblen ACF Felds zurück
	 *
	 * @param string $field ACF Feld, das verwendet werden soll.
	 */
function get_flexible_content( $field ) {

	$flexible = get_field_object( $field );
	$content  = '';

	if ( is_array( $flexible ) && isset( $flexible['value'] ) && is_array( $flexible['value'] ) ) {

		$content = get_flexible_row( $flexible['value'] );
		return $content;

	}

	return false;

}

	/**
	 * Gibt die Inhalte eines flexiblen ACF Felds aus
	 *
	 * @param string $field ACF Feld, das verwendet werden soll.
	 */
function the_flexible_content( $field ) {

	echo get_flexible_content( $field );

}

function hook_acf_css() {

	global $acf_css;

	echo '<style>' . $acf_css . '</style>';

	unset( $GLOBALS['acf_css'] );

}

function hook_acf_js() {

	global $acf_js;

	echo '<script>' . $acf_js . '</script>';

	unset( $GLOBALS['acf_js'] );

}
