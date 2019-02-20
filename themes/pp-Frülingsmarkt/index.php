<?php

get_header();
the_post();
?>
<main id="content">
	<section id="single-page">
		<div class="content-inner">
		<?php
		the_title( '<h1>', '</h1>' );
		the_flexible_content( 'flexible' );
		?>
	</div>
	</section>
</main>
<?php
get_footer();
