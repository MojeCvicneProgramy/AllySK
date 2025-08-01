<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php
	elegant_description();
	elegant_keywords();
	elegant_canonical();

	/**
	 * Fires in the head, before {@see wp_head()} is called. This action can be used to
	 * insert elements into the beginning of the head before any styles or scripts.
	 *
	 * @since 1.0
	 */
	do_action( 'et_head_meta' );

	$template_directory_uri = get_template_directory_uri();
?>

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<script type="text/javascript">
		document.documentElement.className = 'js';
	</script>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
	wp_body_open();

	$product_tour_enabled = et_builder_is_product_tour_enabled();
	$page_container_style = $product_tour_enabled ? ' style="padding-top: 0px;"' : ''; ?>
	<div id="page-container"<?php echo et_core_intentionally_unescaped( $page_container_style, 'fixed_string' ); ?>>
<?php
	if ( $product_tour_enabled || is_page_template( 'page-template-blank.php' ) ) {
		return;
	}

	$et_secondary_nav_items = et_divi_get_top_nav_items();

	$et_phone_number = $et_secondary_nav_items->phone_number;

	$et_email = $et_secondary_nav_items->email;

	$et_contact_info_defined = $et_secondary_nav_items->contact_info_defined;

	$show_header_social_icons = $et_secondary_nav_items->show_header_social_icons;

	$et_secondary_nav = $et_secondary_nav_items->secondary_nav;

	$et_top_info_defined = $et_secondary_nav_items->top_info_defined;

	$et_slide_header = 'slide' === et_get_option( 'header_style', 'left' ) || 'fullscreen' === et_get_option( 'header_style', 'left' ) ? true : false;

	$show_search_icon = ( false !== et_get_option( 'show_search_icon', true ) && ! $et_slide_header ) || is_customize_preview();
?>

	<?php if ( $et_top_info_defined && ! $et_slide_header || is_customize_preview() ) : ?>
		<?php ob_start(); ?>
		<div id="top-header"<?php echo $et_top_info_defined ? '' : 'style="display: none;"'; ?>>
			<div class="container clearfix">

			<?php if ( $et_contact_info_defined ) : ?>

				<div id="et-info">
				<?php if ( ! empty( $et_phone_number = et_get_option( 'phone_number' ) ) ) : ?>
					<span id="et-info-phone"><?php echo et_core_esc_previously( et_sanitize_html_input_text( strval( $et_phone_number ) ) ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $et_email = et_get_option( 'header_email' ) ) ) : ?>
					<a href="<?php echo esc_attr( 'mailto:' . $et_email ); ?>"><span id="et-info-email"><?php echo esc_html( $et_email ); ?></span></a>
				<?php endif; ?>

				<?php
				if ( true === $show_header_social_icons ) {
					get_template_part( 'includes/social_icons', 'header' );
				} ?>
				</div>

			<?php endif; // true === $et_contact_info_defined ?>

				<div id="et-secondary-menu">
				<?php
					if ( ! $et_contact_info_defined && true === $show_header_social_icons ) {
						get_template_part( 'includes/social_icons', 'header' );
					} else if ( $et_contact_info_defined && true === $show_header_social_icons ) {
						ob_start();

						get_template_part( 'includes/social_icons', 'header' );

						$duplicate_social_icons = ob_get_contents();

						ob_end_clean();

						printf(
							'<div class="et_duplicate_social_icons">
								%1$s
							</div>',
							et_core_esc_previously( $duplicate_social_icons )
						);
					}

					if ( '' !== $et_secondary_nav ) {
						echo et_core_esc_wp( $et_secondary_nav );
					}

					et_show_cart_total();
				?>
				</div>

			</div>
		</div>
	<?php
		$top_header = ob_get_clean();

		/**
		 * Filters the HTML output for the top header.
		 *
		 * @since 3.10
		 *
		 * @param string $top_header
		 */
		echo et_core_intentionally_unescaped( apply_filters( 'et_html_top_header', $top_header ), 'html' );
	?>
	<?php endif; // true ==== $et_top_info_defined ?>

	<?php if ( $et_slide_header || is_customize_preview() ) : ?>
		<?php ob_start(); ?>
		<div class="et_slide_in_menu_container">
			<div class="a11y-close-button-wrap a11y-close-top"><button id="a11y-close-menu-top" class="a11y-close-menu" tabindex="0"><?php esc_html_e('Close Menu', 'Divi'); ?>/button></div>
			<?php if ( 'fullscreen' === et_get_option( 'header_style', 'left' ) || is_customize_preview() ) { ?>
				<span class="mobile_menu_bar et_toggle_fullscreen_menu"></span>
			<?php } ?>

			<?php
				if ( $et_contact_info_defined || true === $show_header_social_icons || false !== et_get_option( 'show_search_icon', true ) || class_exists( 'woocommerce' ) || is_customize_preview() ) { ?>
					<div class="et_slide_menu_top">

					<?php if ( 'fullscreen' === et_get_option( 'header_style', 'left' ) ) { ?>
						<div class="et_pb_top_menu_inner">
					<?php } ?>
			<?php }

				if ( true === $show_header_social_icons ) {
					get_template_part( 'includes/social_icons', 'header' );
				}

				et_show_cart_total();
			?>
			<?php if ( false !== et_get_option( 'show_search_icon', true ) || is_customize_preview() ) : ?>
				<?php if ( 'fullscreen' !== et_get_option( 'header_style', 'left' ) ) { ?>
					<div class="clear"></div>
				<?php } ?>
				<form role="search" method="get" class="et-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php
						echo sprintf('<label><span class="screen-reader-text">%1$s</span><input type="search" class="et-search-field" placeholder="%2$s" value="%3$s" name="s" title="%4$s" /></label>',
   					 		esc_html__('Search for:', 'Divi'),
							esc_attr__('Search …', 'Divi'),
    						get_search_query(),
   					 		esc_attr__('Search for:', 'Divi')
						);

						/**
						 * Fires inside the search form element, just before its closing tag.
						 *
						 * @since ??
						 */
						do_action( 'et_search_form_fields' );
					?>
					<button type="submit" id="searchsubmit_header" aria-label="<?php echo esc_attr__( 'Submit Search', 'Divi' ); ?>"></button>
				</form>
			<?php endif; // true === et_get_option( 'show_search_icon', false ) ?>

			<?php if ( $et_contact_info_defined ) : ?>

				<div id="et-info">
				<?php if ( ! empty( $et_phone_number = et_get_option( 'phone_number' ) ) ) : ?>
					<span id="et-info-phone"><?php echo et_core_esc_previously( et_sanitize_html_input_text( strval( $et_phone_number ) ) ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $et_email = et_get_option( 'header_email' ) ) ) : ?>
					<a href="<?php echo esc_attr( 'mailto:' . $et_email ); ?>"><span id="et-info-email"><?php echo esc_html( $et_email ); ?></span></a>
				<?php endif; ?>
				</div>

			<?php endif; // true === $et_contact_info_defined ?>
			<?php if ( $et_contact_info_defined || true === $show_header_social_icons || false !== et_get_option( 'show_search_icon', true ) || class_exists( 'woocommerce' ) || is_customize_preview() ) { ?>
				<?php if ( 'fullscreen' === et_get_option( 'header_style', 'left' ) ) { ?>
					</div>
				<?php } ?>

				</div>
			<?php } ?>

			<div class="et_pb_fullscreen_nav_container">
				<?php
					$slide_nav = '';
					$slide_menu_class = 'et_mobile_menu';

					$slide_nav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'echo' => false, 'items_wrap' => '%3$s' ) );
					$slide_nav .= wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'echo' => false, 'items_wrap' => '%3$s' ) );
				?>
				<nav id="mobile-menu-slide-nav" aria-label="Primary Menu">
				<ul id="mobile_menu_slide" class="<?php echo esc_attr( $slide_menu_class ); ?>">

				<?php
					if ( '' === $slide_nav ) :
				?>
						<?php if ( 'on' === et_get_option( 'divi_home_link' ) ) { ?>
							<li <?php if ( is_home() ) echo( 'class="current_page_item"' ); ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'Divi' ); ?></a></li>
						<?php }; ?>

						<?php show_page_menu( $slide_menu_class, false, false ); ?>
						<?php show_categories_menu( $slide_menu_class, false ); ?>
				<?php
					else :
						echo et_core_esc_wp( $slide_nav ) ;
					endif;
				?>

				</ul>
				</nav>
			</div>
		</div>
	<?php
		$slide_header = ob_get_clean();

		/**
		 * Filters the HTML output for the slide header.
		 *
		 * @since 3.10
		 *
		 * @param string $top_header
		 */
		echo et_core_intentionally_unescaped( apply_filters( 'et_html_slide_header', $slide_header ), 'html' );
	?>
	<?php endif; // true ==== $et_slide_header ?>

	<?php ob_start(); ?>
		<header id="main-header" data-height-onload="<?php echo esc_attr( et_get_option( 'menu_height', '66' ) ); ?>">
			<div class="container clearfix et_menu_container">
			<?php
				$logo = ( $user_logo = et_get_option( 'divi_logo' ) ) && ! empty( $user_logo )
					? $user_logo
					: $template_directory_uri . '/images/logo.png';

				// Get logo image size based on attachment URL.
				$logo_size   = et_get_attachment_size_by_url( $logo );
				$logo_width  = ( ! empty( $logo_size ) && is_numeric( $logo_size[0] ) )
						? $logo_size[0]
						: '93'; // 93 is the width of the default logo.
				$logo_height = ( ! empty( $logo_size ) && is_numeric( $logo_size[1] ) )
						? $logo_size[1]
						: '43'; // 43 is the height of the default logo.

				ob_start();
			?>
				<div class="logo_container">
					<span class="logo_helper"></span>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<img src="<?php echo esc_attr( $logo ); ?>" width="<?php echo esc_attr( $logo_width ); ?>" height="<?php echo esc_attr( $logo_height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="logo" data-height-percentage="<?php echo esc_attr( et_get_option( 'logo_height', '54' ) ); ?>" />
					</a>
				</div>
			<?php
				$logo_container = ob_get_clean();

				/**
				 * Filters the HTML output for the logo container.
				 *
				 * @since 3.10
				 *
				 * @param string $logo_container
				 */
				echo et_core_intentionally_unescaped( apply_filters( 'et_html_logo_container', $logo_container ), 'html' );
			?>
				<div id="et-top-navigation" data-height="<?php echo esc_attr( et_get_option( 'menu_height', '66' ) ); ?>" data-fixed-height="<?php echo esc_attr( et_get_option( 'minimized_menu_height', '40' ) ); ?>">
					<?php if ( ! $et_slide_header || is_customize_preview() ) : ?>
						<nav id="top-menu-nav" aria-label="Primary Menu">
						<?php
							$menuClass = 'nav';
							if ( 'on' === et_get_option( 'divi_disable_toptier' ) ) $menuClass .= ' et_disable_top_tier';
							$primaryNav = '';

							$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => 'top-menu', 'echo' => false ) );
							if ( empty( $primaryNav ) ) :
						?>
							<ul id="top-menu" class="<?php echo esc_attr( $menuClass ); ?>">
								<?php if ( 'on' === et_get_option( 'divi_home_link' ) ) { ?>
									<li <?php if ( is_home() ) echo( 'class="current_page_item"' ); ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'Divi' ); ?></a></li>
								<?php }; ?>

								<?php show_page_menu( $menuClass, false, false ); ?>
								<?php show_categories_menu( $menuClass, false ); ?>
							</ul>
						<?php
							else :
								echo et_core_esc_wp( $primaryNav );
							endif;
						?>
						</nav>
					<?php endif; ?>

					<?php
					if ( ! $et_top_info_defined && ( ! $et_slide_header || is_customize_preview() ) ) {
						et_show_cart_total( array(
							'no_text' => true,
						) );
					}
					?>

					<?php if ( $et_slide_header || is_customize_preview() ) : ?>
						<span class="mobile_menu_bar et_pb_header_toggle et_toggle_<?php echo esc_attr( et_get_option( 'header_style', 'left' ) ); ?>_menu"></span>
					<?php endif; ?>

					<?php if ( $show_search_icon ) : ?>
						<div id="et_top_search">
							<!--<span id="et_search_icon"></span>-->
							<button class="fd-access-search"><span class="screen-reader-text"><?php esc_html_e('Access Search Form', 'Divi'); ?>/span><i class="fd-search" aria-hidden="true"></i></button>
						</div>
					<?php endif; ?>

					<?php

					/**
					 * Fires at the end of the 'et-top-navigation' element, just before its closing tag.
					 *
					 * @since 1.0
					 */
					do_action( 'et_header_top' );

					?>
				</div> <!-- #et-top-navigation -->
			</div> <!-- .container -->
			<?php if ( $show_search_icon ) : ?>
			<div class="et_search_outer">
				<div class="container et_search_form_container">
					<form role="search" method="get" class="et-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php
						echo sprintf('<label><span class="screen-reader-text">%1$s</span><input type="search" 
						class="et-search-field" placeholder="%2$s" value="%3$s" name="s" title="%4$s" /></label>
						<input type="submit" value="%5$s" class="fd-search" aria-label="%6$s">',
    						esc_html__('Search for:', 'Divi'),
    						esc_attr__('Search …', 'Divi'),
    						get_search_query(),
    						esc_attr__('Search for:', 'Divi'),
    						esc_attr__('Submit', 'Divi'),
   							 esc_attr__('Submit Search', 'Divi')
						);


						/**
						 * Fires inside the search form element, just before its closing tag.
						 *
						 * @since ??
						 */
						do_action( 'et_search_form_fields' );
					?>
					</form>
					<button class="fd-close-search"><span class="screen-reader-text"><?php esc_html_e('Close Search Form', 'Divi'); ?>/span><span class="et_close_search_field" aria-hidden="true"></span></button>
				</div>
			</div>
			<?php endif; ?>
		</header> <!-- #main-header -->
	<?php
		$main_header = ob_get_clean();

		/**
		 * Filters the HTML output for the main header.
		 *
		 * @since 3.10
		 *
		 * @param string $main_header
		 */
		echo et_core_intentionally_unescaped( apply_filters( 'et_html_main_header', $main_header ), 'html' );
	?>
		<div id="et-main-area">
	<?php
		/**
		 * Fires after the header, before the main content is output.
		 *
		 * @since 3.10
		 */
		do_action( 'et_before_main_content' );
