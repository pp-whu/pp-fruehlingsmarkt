<?php get_header(); ?>
  <div class="row" id="content">
    <main class="medium-8 columns">
      <section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title">Uups! Seite nicht gefunden.</h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p>Hier wurde nichts gefunden. Möchten Sie die Suche verwenden?</p>

					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
    </main>

    <aside class="medium-3 columns" data-sticky-container>
      <?php get_sidebar( 'content-aside' ); ?>
    </aside>

  </div>

<?php get_footer(); ?>
