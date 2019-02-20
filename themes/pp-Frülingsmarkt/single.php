<?php

get_header();
?>
<main id="content">
	<section>
		<div class="content-inner">
		<?php
		the_title( '<h1>', '</h1>' );
		the_content();
		?>
		</div>
	</section>
</main>
<?php
get_footer();
