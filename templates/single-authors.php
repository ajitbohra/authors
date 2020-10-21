<?php
/**
 * View for authors single.
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

$image = wp_get_attachment_image_src( $post->image_id, 'medium' );

// Gallery images.
if ( $post->gallery_image_ids ) {
	$gallery_image_ids = explode( ',', $post->gallery_image_ids );
	$gallery_args      = array(
		'post_type'      => 'attachment',
		'orderby'        => 'post__in',
		'order'          => 'ASC',
		'post__in'       => $gallery_image_ids,
		'numberposts'    => -1,
		'post_mime_type' => 'image',
	);
	$images            = get_posts( $gallery_args );
} else {
	$images = false;
}

// Author posts.
if ( $post->user_id ) {
	$post_args    = array(
		'author'      => $post->user_id,
		'numberposts' => -1,
	);
	$author_posts = get_posts( $post_args );
} else {
	$author_posts = false;
}
?>
<main id="site-content" role="main">
	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

		<header class="entry-header has-text-align-center">
			<div class="entry-header-inner section-inner medium">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</div>
		</header>

		<div class="post-inner">

			<div class="entry-content">
				<ul class="author-meta-info">
					<?php if ( $post->first_name ) : ?>
						<li>
							<span>First Name: </span> <?php echo wp_kses_post( $post->first_name ); ?>
						</li>
					<?php endif; ?>


					<?php if ( $post->last_name ) : ?>
						<li>
							<span>Last Name: </span> <?php echo wp_kses_post( $post->last_name ); ?>
						</li>
					<?php endif; ?>


					<?php if ( $post->biography ) : ?>
						<li>
							<span>Biography: </span>
							<p><?php echo wp_kses_post( $post->biography ); ?></p>
						</li>
					<?php endif; ?>

					<?php if ( $post->facebook_url ) : ?>
						<li>
							<span>Facebook Url: </span>
							<a href="<?php echo esc_url( $post->facebook_url ); ?>" target="_new"><?php echo wp_kses_post( $post->facebook_url ); ?></a>

						</li>
					<?php endif; ?>

					<?php if ( $post->linkedin_url ) : ?>
						<li>
							<span>Linkedin Url: </span>
							<a href="<?php echo esc_url( $post->linkedin_url ); ?>" target="_new"><?php echo wp_kses_post( $post->linkedin_url ); ?></a>
						</li>
					<?php endif; ?>

					<?php if ( $image ) : ?>
						<li id="author-image">
							<span>Image:</span><br />
							<a href="<?php echo esc_url( wp_get_attachment_url( $post->image_id ) ); ?>">
								<img src="<?php echo esc_url( $image[0] ); ?>" />
							</a>
						</li>
					<?php endif; ?>

					<?php if ( $images ) : ?>
						<li id="author-gallery">
							<span>Gallery</span>
							<ul class="author-gallery">
								<?php
								foreach ( $images as $image ) :
									$image_src = wp_get_attachment_image_src( $image->ID, 'thumbnail' );
									?>

									<li>
										<a href="<?php echo esc_url( wp_get_attachment_url( $image->ID ) ); ?>">
											<img src="<?php echo esc_url( $image_src[0] ); ?>" />
										</a>
									</li>

									<?php
								endforeach;
								?>
							</ul>
						</li>
					<?php endif; ?>

					<?php if ( $author_posts ) : ?>
						<li id="author-posts">
							<span>Posts:</span>
							<ul>
								<?php foreach ( $author_posts as $author_post ) : ?>
									<li>
										<a href="<?php the_permalink( $author_post->ID ); ?>">
											<?php echo wp_kses_post( $author_post->post_title ); ?></a>
									</li>
								<?php endforeach; ?>
							</ul>
						</li>
					<?php endif; ?>
				</ul>
			</div>

			<div class="section-inner">
				<?php require_once 'navigation.php'; ?>
			</div>

		</div>

	</article>
</main>
<?php get_footer(); ?>
