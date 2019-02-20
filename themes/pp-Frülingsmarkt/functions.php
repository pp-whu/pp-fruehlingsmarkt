<?php
/**
 * Allgemeine Theme Funktionen
 *
 * @package WeClimb
 **/

// ACF.
require_once 'template-parts/acf-definitions.php';
require_once 'template-parts/acf-functions.php';
// HTML Maker laden.
require_once 'template-parts/html-maker.php';
// Navigations-Funktionen bereitstellen.
require_once 'template-parts/nav-walkers.php';
// Funktionen für responsive Bilder.
require_once 'template-parts/picture-functions.php';
// Funktionen für Hero-Image.
require_once 'template-parts/hero-image.php';
// Title Tag aktiveren.
add_theme_support( 'title-tag' );
// Beitragsbild aktiveren.
add_theme_support( 'post-thumbnails' );
// Bildgrößen registrieren.
add_image_size( 'ac_img', 116, 116, true );
add_image_size( 'team', 539, 583, true );
add_image_size( 'news', 316, 316, true );
add_image_size( 'slider-small', 320, 180, true );
add_image_size( 'slider-medium', 640, 360, true );
add_image_size( 'slider-large', 768, 432, true );
add_image_size( 'slider-xlarge', 1024, 576, true );
add_image_size( 'slider-xxlarge', 1280, 720, true );
add_image_size( 'slider-xxxlarge', 1600, 900, true );
add_image_size( 'slider-xxxxlarge', 1920, 1080, true );
add_image_size( 'selected-small', 320, 240, true );
add_image_size( 'selected-medium', 640, 480, true );
add_image_size( 'selected-large', 768, 576, true );
add_image_size( 'selected-xlarge', 1024, 768, true );
/**
 * Entfernt die WP Versionsangaben
 *
 * @param str $src Pfad zur Datei.
 * @param str $handle Handle der Datei.
 */
function ww_remove_ver_css_js( $src, $handle ) {
	$handles_with_version = [ 'ww-script', 'ww-style' ];

	if ( strpos( $src, 'ver=' ) && ! in_array( $handle, $handles_with_version, true ) ) {
		$src = remove_query_arg( 'ver', $src );
	}

	return $src;
}
add_filter( 'style_loader_src', 'ww_remove_ver_css_js', 9999, 2 );
add_filter( 'script_loader_src', 'ww_remove_ver_css_js', 9999, 2 );

// XML-RPC API für Fernzugriff deaktivieren.
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Emoji aus dem header entfernen
 **/
function ww_disable_emoji_dequeue_script() {
	wp_dequeue_script( 'emoji' );
}
add_action( 'wp_print_scripts', 'ww_disable_emoji_dequeue_script', 100 );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
/**
 * Head Links entfernen
 **/
function ww_remove_headlinks() {
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
	remove_action( 'wp_head', 'wp_shortlink_header', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
}
add_action( 'init', 'ww_remove_headlinks' );
/**
 * Registriert die Menüs
 **/
function ww_register_menus() {
	register_nav_menu( 'social-nav', 'Socialnavigation' );
	register_nav_menu( 'main-nav', 'Hauptnavigation' );
	register_nav_menu( 'footer-nav', 'Footernavigation' );
}
add_action( 'init', 'ww_register_menus' );

/**
 * Liefert Array mit Datei inklusive Template Pfad und Änderungsdatum.
 *
 * @param array $src Pfad zur Datei innerhalb des WordPress Verzeichnisses.
 */
function get_src_path_uri_version( $src ) {
	$src      = '/' . rtrim( $src, '/' );
	$src_path = get_template_directory() . $src;
	$src_uri  = get_template_directory_uri() . $src;

	if ( file_exists( $src_path ) ) {
		return array(
			'uri'     => $src_uri,
			'version' => filemtime( $src_path ),
		);
	}

	return false;
}

/**
 * Ruft wp_enqueue_script setzt das Änderungsdatum der Datei als Version.
 *
 * @param array $handle    Name des Scripts.
 * @param array $src       Pfad zum Script innerhalb des aktuellen Template Verzeichnisses.
 * @param array $deps      Abhängigkeiten zu anderen Scripts.
 * @param array $in_footer True wenn Script vor /body statt vor /head ausgegeben werden soll, default false.
 */
function enqueue_script_with_timestamp( $handle, $src, $deps = array(), $in_footer = false ) {
	$src = get_src_path_uri_version( $src );

	if ( $src ) {
		wp_enqueue_script( $handle, $src['uri'], $deps, $src['version'], $in_footer );
	}
}

/**
 * Ruft wp_enqueue_style setzt das Änderungsdatum der Datei als Version.
 *
 * @param array $handle Name des Styles.
 * @param array $src    Pfad zum Style innerhalb des aktuellen Template Verzeichnisses.
 * @param array $deps   Abhängigkeiten zu anderen Styles.
 * @param array $media  Medien, für die das Style gedacht ist, default all.
 */
function enqueue_style_with_timestamp( $handle, $src, $deps = array(), $media = 'all' ) {
	$src = get_src_path_uri_version( $src );

	if ( $src ) {
		wp_enqueue_style( $handle, $src['uri'], $deps, $src['version'], $media );
	}
}

/**
 * Lädt Skripte und Styles.
 */
function enqueue_styles_scripts() {

	// WordPress jQuery entfernen.
	wp_deregister_script( 'jquery' );

	// Aktuelles jQuery registrieren.
	wp_register_script( 'jquery', 'https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js', array(), false, true );

	// Aktuelles jQuery laden.
	wp_enqueue_script( 'jquery' );

	// Haupt-Skript laden.
	enqueue_script_with_timestamp( 'ww-script', 'js/app.min.js', array( 'jquery', 'svg4everybody' ), true );

	// Haupt-Style laden.
	enqueue_style_with_timestamp( 'ww-style', 'css/template.min.css' );

	// SVG-Unterstützung für IE laden.
	wp_enqueue_script( 'svg4everybody', get_template_directory_uri() . '/js/svg4everybody.min.js', array( 'jquery' ), false, true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_styles_scripts' );

/**
 * Setzt die WP SEO Metabox nach unten.
 */
function filter_yoast_seo_metabox() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'filter_yoast_seo_metabox' );

/**
 * Converts permalink into slug.
 *
 * @param string $url Insert permalink.
 */
function ww_get_slug_from_url( $url ) {
	return end( explode( '/', $url, -1 ) );
}

if ( ! function_exists( 'write_log' ) ) {
	/**
	 * Schreibt individuellen Inhalt nach wp-content/debug.log
	 *
	 * @param misc $log Inhalt zur Ausgabe.
	 **/
	function write_log( $log ) {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}
