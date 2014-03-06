<?php
/**
 * Widgetize
 *
 * This file adds the capability to fully widgetize
 * any post or page.
 *
 * @package Rampart
 * @version 1.0
 */

class THMFDN_Widgetize {

	/**
	 * Constructor function
	 *
	 * @since 1.0
	 */
	function __construct() {
		if ( is_admin() ) {
			global $pagenow;

			if ( 'widgets.php' == $pagenow ) {
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_script' ) );
				add_action( 'admin_head', array( $this, 'echo_admin_script' ) );
			}

			if ( 'post.php' ==  $pagenow || 'post-new.php' ==  $pagenow ) {
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_editor_script' ) );
				add_action( 'add_meta_boxes', array( $this, 'display_meta_box' ) );
				add_action( 'save_post', array( $this, 'meta_box_save' ) );
			}
		} else {

			add_filter( 'post_class', array( $this, 'add_post_classes' ) );

			// Filters the_content to add widget areas.
			add_filter( 'the_content', array( $this, 'display_widgetize' ) );
		}

		// Registers widget areas
		add_action( 'wp_loaded', array( $this, 'register_widget_areas' ) );

	}

	/**
	 * Enqueues widget page restructuring javascript
	 *
	 * @since 1.0
	 */
	function enqueue_admin_script() {
		wp_enqueue_script( 'widgets_admin_script', get_template_directory_uri() . '/js/widgetize-admin.js' );
	}

	/**
	 * Writes widget page restructuring javascript to the admin head.
	 *
	 * @since 1.0
	 */
	function echo_admin_script() {
		$posts = $this->get_posts_with_widgets();

		if( !empty( $posts ) ) {
			$output = '<script>';
			$output .= 'jQuery(document).ready(function($){';

			// Displays widget submenu
			$output .= '$(".wrap > h2").after("<ul class=\"subsubsub\" style=\"width:100%;\"></ul>");';
			$output .= '$(".subsubsub").append("<li><a href=\"#\" id=\"default\" class=\"current\">' . __( 'Standard Widget Areas', 'rampart' ) . '</a> </li> ");';
			$output .= 'widgetizeSetupTabs( ' . json_encode($posts)	. ' );';

			if ( !empty( $_GET['current-page'] ) ) {
				$output .= 'switchWidgetAreas("' . $_GET['current-page'] . '");';
			}

			$output .= '});';
			$output .= '</script>';

			echo $output;
		}
	}

	/**
	 * Enques required scripts/styles when needed
	 *
	 * @since 1.0
	 */
	function enqueue_editor_script() {
		wp_enqueue_script( 'widgetize_editor_script', get_template_directory_uri() . '/js/widgetize-editor.js' );
		wp_localize_script( 'widgetize_editor_script', 'objectL10n', array(
			'newWidgetAreaTitle'  => __( 'New Widget Area', 'rampart' ),
			'quickEdit'  => __( 'Quick Edit', 'rampart' ),
			'delete'  => __( 'Delete', 'rampart' ),
		) );

		wp_enqueue_style( 'widgetize_editor_style', get_template_directory_uri() . '/css/widgetize-editor.css' );
	}

	/**
	 * Gets all posts with widget areas from the database
	 *
	 * @since 1.0
	 */
	function get_posts_with_widgets() {
		// Stores an array of pages using Widgetize.
		$pages = get_posts( array(
			'meta_key' => 'widgetize_json',
			'hierarchical' => 0,
			'post_type' => 'page',
		) );

		// Stores an array of posts using Widgetize.
		$posts = get_posts( array(
			'meta_key' => 'widgetize_json',
			'hierarchical' => 0,
			'post_type' => 'post',
		) );

		// Returns combined array of $pages and $posts.
		return array_merge( $pages, $posts );
	}

	/**
	 * Registers widget areas
	 *
	 * @since			1.0
	 */
	function register_widget_areas() {
		$posts = $this->get_posts_with_widgets();

		// Loops through pages using the "Template Widgets" page template
		foreach( $posts as $post ) {
			$widget_json = get_post_meta($post->ID, 'widgetize_json', true);
			$json_array = json_decode($widget_json);

			// Checks to make sure at least one widget area is defined.
			if ( !empty( $json_array ) ) {

				// Loops through the array of widget areas.
				foreach( $json_array as $key => $value ) {

					// Sets the widget area title.
					if ( !empty( $value->title ) ) {
						$title = $value->title;
					} else {
						$title = __( 'Widget Area', 'rampart' );
					}

					// Registers an individual widget area.
					register_sidebar(
						array(
							'id' => 'page' . $post->ID . '-widgetarea' . $key,
							'name' => $title,
							'class' => $post->ID,
							'description' => __( 'Widget area for: ', 'rampart' ) . $post->post_title,
							'before_widget' => '<div id="%1$s" class="widget %2$s">',
							'after_widget' => '</div>',
							'before_title' => '<h3 class="widget-title">',
							'after_title' => '</h3>',
						)
					);
				}
			}
		}
	}

	/**
	 * Adds the widgetize meta box to the editing screen
	 *
	 * @since 1.0
	 */
	function display_meta_box() {
		// Filter allows external control of widgetize enabled post types.
		$post_type_setting = apply_filters( 'widgetize_post_types', array( 'page', 'post' ) );

		// Loops through enabled post types.
		foreach ( $post_type_setting  as $post_type ) {
			add_meta_box( 'widgetize', __( 'Widget Areas', 'rampart' ), array( $this, 'meta_box_content' ), $post_type, 'normal', 'high' );
		}
	}

	/**
	 * Outputs the meta box content
	 *
	 * @since 1.0
	 */
	function meta_box_content( $post ) {
		// Sets nonce.
		wp_nonce_field( basename( __FILE__ ), 'widgetize_nonce' );

		// Retrieves meta data.
		$meta_data = get_post_meta( $post->ID );

		if ( empty( $meta_data['widgetize_json'][0] ) ) {
			$meta_data['widgetize_json'][0] = '';
		}

		if ( empty( $meta_data['widgetize_placement'][0] ) ) {
			$meta_data['widgetize_placement'][0] = '';
		}

		?>

		<div id="widget-buttons">
			<a href="#" id="add-widget-area" class="button button-large alignleft"><?php _e( 'Add New Widget Area', 'rampart' ); ?></a>
			<label for="widgetize-placement">Placement
				<select id="widgetize-placement" name="widgetize-placement">
					<option value="widgetize-before" <?php selected( $meta_data['widgetize_placement'][0], 'widgetize-before' ); ?>><?php _e( 'Before content', 'rampart' ); ?></option>
					<option value="widgetize-replace" <?php selected( $meta_data['widgetize_placement'][0], 'widgetize-replace' ); ?>><?php _e( 'Replace content', 'rampart' ); ?></option>
					<option value="widgetize-after" <?php selected( $meta_data['widgetize_placement'][0], 'widgetize-after' ); ?>><?php _e( 'After content', 'rampart' ); ?></option>
				</select>
			</label>
			<a href="<?php echo site_url(); ?>/wp-admin/widgets.php?current-page=<?php echo $post->ID; ?>" id="manage-widgets-button" class="button button-primary button-large alignright"><?php _e( 'Manage Widgets for this Page', 'rampart' ); ?></a>
		</div>

		<?php
			$myListTable = new THMFDN_Widgetize_List_Table();
			$myListTable->prepare_items();
			$myListTable->display();
		?>

		<textarea style="width:85%; margin: 1.5em 7%; display: none;" name="widgetize-json" id="widgetize-json"><?php echo esc_attr( $meta_data['widgetize_json'][0] ); ?></textarea>

		<form method="get" action="">
			<table style="display: none;">
				<tbody id="inlineedit">
					<tr id="inline-edit" class="inline-edit-row" style="display: none;">
						<td colspan="2" class="colspanchange">

							<fieldset><div class="inline-edit-col">
								<h4><?php _e( 'Quick Edit', 'rampart' ); ?></h4>

								<label>
									<span class="title"><?php _e( 'Title', 'rampart' ); ?></span>
									<span class="input-text-wrap"><input type="text" name="title" class="ptitle edit-title" value="" /></span>
								</label>
									<label>
									<span class="title"><?php _e( 'Classes', 'rampart' ); ?></span>
									<span class="input-text-wrap"><input type="text" name="classes" class="ptitle edit-classes" value="" /></span>
								</label>
								</div>
							</fieldset>

							<p class="inline-edit-save submit">
								<a accesskey="c" href="#inline-edit" title="Cancel" class="cancel button-secondary alignleft"><?php _e( 'Cancel', 'rampart' ); ?></a>
								<a accesskey="s" href="#inline-edit" title="Update Widget Area" class="save button-primary alignright"><?php _e( 'Update Widget Area', 'rampart' ); ?></a>
								<span class="spinner"></span>
								<span class="error" style="display:none;"></span>
								<br class="clear" />
							</p>
						</td>
					</tr>
				</tbody>
			</table>
		</form>

		<?php
	}

	/**
	 * Saves the custom meta input
	 *
	 * @since 1.0
	 */
	function meta_box_save( $post_id ) {
		// Checks save status
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST[ 'widgetize_nonce' ] ) && wp_verify_nonce( $_POST[ 'widgetize_nonce' ], basename( __FILE__ ) ) ) ? true : false;

		// Exits script depending on save status
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return;
		}

		// Checks for input and sanitizes/saves if needed
		if ( !empty( $_POST[ 'widgetize-json' ] ) ) {
			update_post_meta( $post_id, 'widgetize_json', sanitize_text_field( $_POST[ 'widgetize-json' ] ) );
			update_post_meta( $post_id, 'widgetize_placement', sanitize_text_field( $_POST[ 'widgetize-placement' ] ) );
		} else {
			delete_post_meta( $post_id, 'widgetize_json' );
			delete_post_meta( $post_id, 'widgetize_placement' );
		}
	}

	/**
	 * Adds post classes
	 *
	 * @since 1.0
	 */
	function add_post_classes( $classes ) {
		global $post;

		// Retrieves meta data
		$widget_placement = get_post_meta( $post->ID, 'widgetize_placement', true );
		$widget_json = get_post_meta( $post->ID, 'widgetize_json', true );

		if ( !empty( $widget_json ) ) {
			$classes[] = 'is-widgetized';
			
			if ( 'widgetize-replace' == $widget_placement ) {
				$classes[] = 'is-fully-widgetized';
			}
		}

		// return the $classes array
		return $classes;
	}

	/**
	 * Displays widget areas on the front end
	 *
	 * @since			1.0
	 */
	function display_widgetize( $input ) {
		if( is_main_query() ) {
			global $post;

			// Prepairs output variable
			$output = '';

			// Retrieves meta data
			$widget_placement = get_post_meta( $post->ID, 'widgetize_placement', true );
			$widget_json = get_post_meta( $post->ID, 'widgetize_json', true );

			if ( !empty( $widget_json ) ) {
				// Decodes json
				$widget_areas = json_decode($widget_json);

				// Handles content/widget order
				if ( 'widgetize-after' == $widget_placement ) {
					$output .= $input;
				}

				// Loops through widget areas
				foreach( $widget_areas as $key => $settings ) {

					// Adds widget area to the output variable
					$output .= '<div id="widget-area-' . $key . '" class="widgetize widgetize-count-' . count( $this->count_widgets( 'page' . get_the_ID() . '-widgetarea' . $key ) ) . ' ' . $settings->classes . '">';
						ob_start();
						dynamic_sidebar( 'page' . get_the_ID() . '-widgetarea' . $key );
						$output .= ob_get_clean();
					$output .= '</div>';

				}

				// Handles content/widget order
				if ( 'widgetize-before' == $widget_placement ) {
					$output .= $input;
				}

			} else {
				$output = $input;
			}
		}

		return $output;
	}

	/**
	 * Counts the number of widgets in a widget area
	 *
	 * @since 1.0
	 */
	function count_widgets( $widget_area_id ) {
		global $wp_registered_sidebars;
		$widget_areas = wp_get_sidebars_widgets();

		if( empty( $widget_areas[$widget_area_id] ) ) {
			return false;
		} else {
			return $widget_areas[$widget_area_id];
		} // End if/else

	} // End function contains_widgets()

	/**
	 * Removes post title when necessary
	 *
	 * @since 1.0
	 */
	function widgetize_title( $input ) {
		global $post;

		// Retrieves meta data
		$widget_placement = get_post_meta( $post->ID, 'widgetize_placement', true );

		// Removes page title if widgets are set to replace page content
		if ( 'widgetize-replace' == $widget_placement ) {
			return false;
		} else {
			return $input;
		}
	}
}

function widgetize_init() {
	new THMFDN_Widgetize();
}
add_action( 'init', 'widgetize_init' );

// Ensures the WP_List_Table class is loaded
if ( !class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class THMFDN_Widgetize_List_Table extends WP_List_Table {

	/**
	 * Defines table columns and column titles for the widget areas meta box
	 *
	 * @since 1.0
	 */
	function get_columns() {
		$columns = array(
			'title' => __( 'Title', 'rampart' ),
			'classes' => __( 'Classes', 'rampart' ),
		);
		return $columns;
	}

	/**
	 * Prepares contents and settings of table columns for the widget areas meta box
	 *
	 * @since 1.0
	 */
	function prepare_items() {
		global $post;

		// Gets and decodes the json object that hold the widget area information
		$widget_json = get_post_meta( $post->ID, 'widgetize_json', true );
		$widget_areas = json_decode( $widget_json );

		// Adds ID to settings for access in list table
		if ( !empty( $widget_areas ) ) {
			foreach( $widget_areas as $key => $settings ) {
				$settings->id = $key;
			}
		}

		// Item settings
		$hidden = array();
		$sortable = array();
		$columns = $this->get_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->items = $widget_areas;
	}

	/**
	 * Adds edit and delete links to title column of each row
	 *
	 * @since 1.0
	 */
	function column_title( $item ) {
		$actions = array(
			'edit' => '<a href="#" id="edit-' . $item->id . '" class="widget-area-edit">' . __( 'Quick Edit', 'rampart' ) . '</a>',
			'delete' => '<a href="#" id="delete-' . $item->id . '" class="widget-area-delete">' . __( 'Delete', 'rampart' ) . '</a>',
		);

		return sprintf('%1$s %2$s', '<strong>' . $item->title . '</strong>', $this->row_actions($actions, true) );
	}

	/**
	 * Handles default column output
	 *
	 * @since 1.0
	 */
	function column_default( $item, $column_name ) {
		switch( $column_name ) {
			case 'classes':
				return $item->classes;
			default:
				return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
		}
	}

	/**
	 * Generates the table navigation above or below the table and removes the error causing duplicate nonce
	 *
	 * @since 1.0
	 */
	function display_tablenav( $which ) {
		return false;
	}
}
