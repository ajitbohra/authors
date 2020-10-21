<?php
/**
 * View for authors archive.
 *
 * @author  Ajit Bohra <ajit@lubus.in>
 * @license MIT
 *
 * @see   https://www.lubus.in/
 *
 * @copyright 2019 LUBUS
 * @package   aba
 */

get_header();
?>

<main id="site-content" role="main">
	<header class="archive-header has-text-align-center header-footer-group">
		<div class="archive-header-inner section-inner medium">
			<h1 class="archive-title">Authors</h1>
		</div>
	</header>

	<div class="post-inner">

		<div class="entry-content">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					?>

					<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
						<?php
						the_title( '<h2 class="entry-title heading-size-1"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
						?>
					</article>
					<?php
				endwhile;
			endif;
			?>
		</div>
	</div>

</main>

<?php require_once 'pagination.php'; ?>

<?php get_footer(); ?>
