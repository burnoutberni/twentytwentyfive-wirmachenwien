<?php
/**
 * Twenty Twenty-Five functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

// Adds theme support for post formats.
if ( ! function_exists( 'twentytwentyfive_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'twentytwentyfive_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_editor_style() {
		add_editor_style( 'assets/css/editor-style.css' );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_editor_style' );

// Enqueues style.css on the front.
if ( ! function_exists( 'twentytwentyfive_enqueue_styles' ) ) :
	/**
	 * Enqueues style.css on the front.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_enqueue_styles() {
		wp_enqueue_style(
			'twentytwentyfive-style',
			get_parent_theme_file_uri( 'style.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'twentytwentyfive_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'twentytwentyfive_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfive' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'twentytwentyfive_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfive_page',
			array(
				'label'       => __( 'Pages', 'twentytwentyfive' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfive' ),
			)
		);

		register_block_pattern_category(
			'twentytwentyfive_post-format',
			array(
				'label'       => __( 'Post formats', 'twentytwentyfive' ),
				'description' => __( 'A collection of post format patterns.', 'twentytwentyfive' ),
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'twentytwentyfive_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_register_block_bindings() {
		register_block_bindings_source(
			'twentytwentyfive/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'twentytwentyfive' ),
				'get_value_callback' => 'twentytwentyfive_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'twentytwentyfive_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function twentytwentyfive_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;

function twentytwentyfive_group_block_as_link( $block_content, $block ) {
    // Only affect front-end (not editor preview)
    if ( is_admin() ) {
        return $block_content;
    }

    // Only for core/group blocks
    if ( $block['blockName'] !== 'core/group' ) {
        return $block_content;
    }

    // Check for the isLink attribute
    if ( empty( $block['attrs']['isLink'] ) || $block['attrs']['isLink'] !== true ) {
        return $block_content;
    }

    // Make sure we're in the loop and have a global $post
    global $post;
    if ( ! $post ) {
        return $block_content;
    }

    // Wrap block in a link
    $permalink = get_permalink( $post );
    $linked = sprintf(
        '<a href="%s" class="group-link-wrapper" style="display:block; text-decoration:none; color:inherit;">%s</a>',
        esc_url( $permalink ),
        $block_content
    );

    return $linked;
}
add_filter( 'render_block', 'twentytwentyfive_group_block_as_link', 10, 2 );

// Add `isLink` attribute to core/group
function twentytwentyfive_add_group_block_islink_attr( $metadata ) {
    if ( $metadata['name'] !== 'core/group' ) {
        return $metadata;
    }

    // Add the isLink attribute definition
    $metadata['attributes']['isLink'] = array(
        'type'    => 'boolean',
        'default' => false,
    );

    return $metadata;
}
add_filter( 'block_type_metadata', 'twentytwentyfive_add_group_block_islink_attr' );

function twentytwentyfive_enqueue_group_islink_editor_assets() {
    wp_enqueue_script(
        'twentytwentyfive-group-islink-control',
        get_template_directory_uri() . '/assets/js/group-islink-control.js',
        array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post', 'wp-components', 'wp-element', 'wp-hooks', 'wp-compose' ),
        filemtime( get_template_directory() . '/assets/js/group-islink-control.js' )
    );
}
add_action( 'enqueue_block_editor_assets', 'twentytwentyfive_enqueue_group_islink_editor_assets' );

function twentytwentyfive_register_group_islink_attribute() {
    register_block_type(
        'core/group',
        array(
            'attributes' => array(
                'isLink' => array(
                    'type'    => 'boolean',
                    'default' => false,
                ),
            ),
        )
    );
}
add_action( 'init', 'twentytwentyfive_register_group_islink_attribute' );