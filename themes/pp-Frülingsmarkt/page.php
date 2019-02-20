<?php


get_header();
the_post();
$this_page_id = $post->ID;
?>
<main id="content">
	<?php
	the_flexible_content( 'flexible' );

	$query_page = new WP_Query(
		array(
			'showposts'   => 20,
			'post_parent' => $this_page_id,
			'post_type'   => 'page',
			'orderby'     => 'menu_order',
			'order'       => 'ASC',
		)
	);
	if ( $query_page->have_posts() ) {
		while ( $query_page->have_posts() ) {
			$query_page->the_post();
			?>
			<section id="<?php echo esc_attr( ww_get_slug_from_url( get_the_permalink() ) ); ?>"<?php echo ( 'none' === get_field( 'background' ) ? null : ' class="bg-' . get_field( 'background' ) . '"' ); ?>>
				<div class="content-inner">
				<?php
				the_title( '<h2>', '</h2>' );
				the_flexible_content( 'flexible' );
				?>
			</div>
			</section>
	<?php
		}
	}
	?>
	</main>
<?php
get_footer();
