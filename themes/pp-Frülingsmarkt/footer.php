<div class="nachoben">
	<a href="#totop"><svg role="img" class="symbol" aria-hidden="true" focusable="false"><use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/icons.svg#arrow-totop"></use></svg></a>
</div>
<footer id="footer">
	<div class="footer">
		<nav class="footer-nav">
			<ul id="footer-menu">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-nav',
						'walker'         => new Service_Nav_Walker(),
						'container'      => '',
						'items_wrap'     => '%3$s',
						'depth'          => 1,
					)
				);
				?>
			</ul>
		</nav>
		<div id="copyright">
			<p>&copy; Stiftung Pfennigparade, Barlachstraße 26, 80804 München</p>
			<p><?php echo date( 'Y' ); ?> – Alle Rechte vorbehalten.</p>
		</div>
	</div>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
