<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package thebox
 * @since thebox 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header clearfix headerstyle" role="banner">
		<div class="site-brand clearfix wrapper">
			<hgroup>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				
			</hgroup>
			<p class="explanation">آزمایشگاه تخصصی ابزار های هوشمند</p>
			
			<?php $options = get_option( 'thebox_theme_options' ); ?>
			
			<div class="social-links">
				<?php if ( $options['github'] != '' ) : ?>
					<a href="<?php echo $options['githuburl']; ?>" class="github" alt="github"><span class="icon-github"></span></a>
				<?php endif; ?>
			
				<?php if ( $options['facebookurl'] != '' ) : ?>
					<a href="<?php echo $options['facebookurl']; ?>" class="facebook" alt="facebook"><span class="icon-facebook"></span></a>
				<?php endif; ?>
				
				<?php if ( $options['twitterurl'] != '' ) : ?>
					<a href="<?php echo $options['twitterurl']; ?>" class="twitter" alt="twitter"><span class="icon-twitter"></span></a>
				<?php endif; ?>

				<?php if ( $options['googleplusurl'] != '' ) : ?>
					<a href="<?php echo $options['googleplusurl']; ?>" class="googleplus" alt="google plus"><span class="icon-google-plus"></span></a>
				<?php endif; ?>
				
				<?php if ( $options['instagramurl'] != '' ) : ?>
					<a href="<?php echo $options['instagramurl']; ?>" class="instagram" alt="instagram"><span class="icon-instagram"></span></a>
				<?php endif; ?>

				
				<?php if ( ! $options['hiderss'] ) : ?>
					<a href="<?php bloginfo( 'rss2_url' ); ?>" class="rss"><span class="icon-rss" alt="rss"></span></a>
				<?php endif; ?>
				
			</div><!-- .social-links-->
			
		</div>	
		<nav role="navigation" class="site-navigation main-navigation clearfix">
			<h1 class="assistive-text"><?php // _e( 'Menu', 'thebox' ); ?></h1>
			<div class="assistive-text skip-link">
				<a href="#content" title="<?php esc_attr_e( 'Skip to content', 'thebox' ); ?>">
					<?php _e( 'Skip to content', 'thebox' ); ?>
				</a>
			</div>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- .site-navigation .main-navigation -->
	</header><!-- #masthead .site-header -->

<div id="page" class="two-col">
<div id="main" class="site-main clearfix">
		
		<?php $header_image = get_header_image();
			if ( ! empty( $header_image ) ) { ?>
				<a class="header-image" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
				</a>
		<?php } // if ( ! empty( $header_image ) ) ?>
		