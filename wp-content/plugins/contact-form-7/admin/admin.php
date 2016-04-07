<?php

require_once WPCF7_PLUGIN_DIR . '/admin/includes/admin-functions.php';
require_once WPCF7_PLUGIN_DIR . '/admin/includes/help-tabs.php';
require_once WPCF7_PLUGIN_DIR . '/admin/includes/tag-generator.php';

add_action( 'admin_init', 'wpcf7_admin_init' );

function wpcf7_admin_init() {
	do_action( 'wpcf7_admin_init' );
}

add_action( 'admin_menu', 'wpcf7_admin_menu', 9 );

function wpcf7_admin_menu() {
	global $_wp_last_object_menu;

	$_wp_last_object_menu++;

	add_menu_page( __( 'Contact Form 7', 'contact-form-7' ),
		__( 'Contact', 'contact-form-7' ),
		'wpcf7_read_contact_forms', 'wpcf7',
		'wpcf7_admin_management_page', 'dashicons-email',
		$_wp_last_object_menu );

	$edit = add_submenu_page( 'wpcf7',
		__( 'Edit Contact Form', 'contact-form-7' ),
		__( 'Contact Forms', 'contact-form-7' ),
		'wpcf7_read_contact_forms', 'wpcf7',
		'wpcf7_admin_management_page' );

	add_action( 'load-' . $edit, 'wpcf7_load_contact_form_admin' );

	$addnew = add_submenu_page( 'wpcf7',
		__( 'Add New Contact Form', 'contact-form-7' ),
		__( 'Add New', 'contact-form-7' ),
		'wpcf7_edit_contact_forms', 'wpcf7-new',
		'wpcf7_admin_add_new_page' );

	add_action( 'load-' . $addnew, 'wpcf7_load_contact_form_admin' );

	$integration = WPCF7_Integration::get_instance();

	if ( $integration->service_exists() ) {
		$integration = add_submenu_page( 'wpcf7',
			__( 'Integration with Other Services', 'contact-form-7' ),
			__( 'Integration', 'contact-form-7' ),
			'wpcf7_manage_integration', 'wpcf7-integration',
			'wpcf7_admin_integration_page' );

		add_action( 'load-' . $integration, 'wpcf7_load_integration_page' );
	}
}

add_filter( 'set-screen-option', 'wpcf7_set_screen_options', 10, 3 );

function wpcf7_set_screen_options( $result, $option, $value ) {
	$wpcf7_screens = array(
		'cfseven_contact_forms_per_page' );

	if ( in_array( $option, $wpcf7_screens ) )
		$result = $value;

	return $result;
}

function wpcf7_load_contact_form_admin() {
	global $plugin_page;

	$action = wpcf7_current_action();

	if ( 'save' == $action ) {
		$id = $_POST['post_ID'];
		check_admin_referer( 'wpcf7-save-contact-form_' . $id );

		if ( ! current_user_can( 'wpcf7_edit_contact_form', $id ) )
			wp_die( __( 'You are not allowed to edit this item.', 'contact-form-7' ) );

		$id = wpcf7_save_contact_form( $id );

		$query = array(
			'message' => ( -1 == $_POST['post_ID'] ) ? 'created' : 'saved',
			'post' => $id,
			'active-tab' => isset( $_POST['active-tab'] ) ? (int) $_POST['active-tab'] : 0 );

		$redirect_to = add_query_arg( $query, menu_page_url( 'wpcf7', false ) );
		wp_safe_redirect( $redirect_to );
		exit();
	}

	if ( 'copy' == $action ) {
		$id = empty( $_POST['post_ID'] )
			? absint( $_REQUEST['post'] )
			: absint( $_POST['post_ID'] );

		check_admin_referer( 'wpcf7-copy-contact-form_' . $id );

		if ( ! current_user_can( 'wpcf7_edit_contact_form', $id ) )
			wp_die( __( 'You are not allowed to edit this item.', 'contact-form-7' ) );

		$query = array();

		if ( $contact_form = wpcf7_contact_form( $id ) ) {
			$new_contact_form = $contact_form->copy();
			$new_contact_form->save();

			$query['post'] = $new_contact_form->id();
			$query['message'] = 'created';
		}

		$redirect_to = add_query_arg( $query, menu_page_url( 'wpcf7', false ) );

		wp_safe_redirect( $redirect_to );
		exit();
	}

	if ( 'delete' == $action ) {
		if ( ! empty( $_POST['post_ID'] ) )
			check_admin_referer( 'wpcf7-delete-contact-form_' . $_POST['post_ID'] );
		elseif ( ! is_array( $_REQUEST['post'] ) )
			check_admin_referer( 'wpcf7-delete-contact-form_' . $_REQUEST['post'] );
		else
			check_admin_referer( 'bulk-posts' );

		$posts = empty( $_POST['post_ID'] )
			? (array) $_REQUEST['post']
			: (array) $_POST['post_ID'];

		$deleted = 0;

		foreach ( $posts as $post ) {
			$post = WPCF7_ContactForm::get_instance( $post );

			if ( empty( $post ) )
				continue;

			if ( ! current_user_can( 'wpcf7_delete_contact_form', $post->id() ) )
				wp_die( __( 'You are not allowed to delete this item.', 'contact-form-7' ) );

			if ( ! $post->delete() )
				wp_die( __( 'Error in deleting.', 'contact-form-7' ) );

			$deleted += 1;
		}

		$query = array();

		if ( ! empty( $deleted ) )
			$query['message'] = 'deleted';

		$redirect_to = add_query_arg( $query, menu_page_url( 'wpcf7', false ) );

		wp_safe_redirect( $redirect_to );
		exit();
	}

	if ( 'validate' == $action && wpcf7_validate_configuration() ) {
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
			check_admin_referer( 'wpcf7-bulk-validate' );

			if ( ! current_user_can( 'wpcf7_edit_contact_forms' ) ) {
				wp_die( __( "You are not allowed to validate configuration.", 'contact-form-7' ) );
			}

			$contact_forms = WPCF7_ContactForm::find();
			$result = array(
				'timestamp' => current_time( 'timestamp' ),
				'version' => WPCF7_VERSION,
				'count_valid' => 0,
				'count_invalid' => 0 );

			foreach ( $contact_forms as $contact_form ) {
				$contact_form->validate_configuration();

				if ( $contact_form->get_config_errors() ) {
					$result['count_invalid'] += 1;
				} else {
					$result['count_valid'] += 1;
				}
			}

			WPCF7::update_option( 'bulk_validate', $result );

			$query = array(
				'message' => 'validated' );

			$redirect_to = add_query_arg( $query, menu_page_url( 'wpcf7', false ) );
			wp_safe_redirect( $redirect_to );
			exit();
		}
	}

	$_GET['post'] = isset( $_GET['post'] ) ? $_GET['post'] : '';

	$post = null;

	if ( 'wpcf7-new' == $plugin_page ) {
		$post = WPCF7_ContactForm::get_template( array(
			'locale' => isset( $_GET['locale'] ) ? $_GET['locale'] : null ) );
	} elseif ( ! empty( $_GET['post'] ) ) {
		$post = WPCF7_ContactForm::get_instance( $_GET['post'] );
	}

	$current_screen = get_current_screen();

	$help_tabs = new WPCF7_Help_Tabs( $current_screen );

	if ( $post && current_user_can( 'wpcf7_edit_contact_form', $post->id() ) ) {
		$help_tabs->set_help_tabs( 'edit' );
	} else {
		$help_tabs->set_help_tabs( 'list' );

		if ( ! class_exists( 'WPCF7_Contact_Form_List_Table' ) ) {
			require_once WPCF7_PLUGIN_DIR . '/admin/includes/class-contact-forms-list-table.php';
		}

		add_filter( 'manage_' . $current_screen->id . '_columns',
			array( 'WPCF7_Contact_Form_List_Table', 'define_columns' ) );

		add_screen_option( 'per_page', array(
			'default' => 20,
			'option' => 'cfseven_contact_forms_per_page' ) );
	}
}

add_action( 'admin_enqueue_scripts', 'wpcf7_admin_enqueue_scripts' );

function wpcf7_admin_enqueue_scripts( $hook_suffix ) {
	if ( false === strpos( $hook_suffix, 'wpcf7' ) ) {
		return;
	}

	wp_enqueue_style( 'contact-form-7-admin',
		wpcf7_plugin_url( 'admin/css/styles.css' ),
		array(), WPCF7_VERSION, 'all' );

	if ( wpcf7_is_rtl() ) {
		wp_enqueue_style( 'contact-form-7-admin-rtl',
			wpcf7_plugin_url( 'admin/css/styles-rtl.css' ),
			array(), WPCF7_VERSION, 'all' );
	}

	wp_enqueue_script( 'wpcf7-admin',
		wpcf7_plugin_url( 'admin/js/scripts.js' ),
		array( 'jquery', 'jquery-ui-tabs' ),
		WPCF7_VERSION, true );

	wp_localize_script( 'wpcf7-admin', '_wpcf7', array(
		'pluginUrl' => wpcf7_plugin_url(),
		'saveAlert' => __( "The changes you made will be lost if you navigate away from this page.", 'contact-form-7' ),
		'activeTab' => isset( $_GET['active-tab'] ) ? (int) $_GET['active-tab'] : 0 ) );

	add_thickbox();

	wp_enqueue_script( 'wpcf7-admin-taggenerator',
		wpcf7_plugin_url( 'admin/js/tag-generator.js' ),
		array( 'jquery', 'thickbox', 'wpcf7-admin' ), WPCF7_VERSION, true );
}

function wpcf7_admin_management_page() {
	if ( $post = wpcf7_get_current_contact_form() ) {
		$post_id = $post->initial() ? -1 : $post->id();

		require_once WPCF7_PLUGIN_DIR . '/admin/includes/editor.php';
		require_once WPCF7_PLUGIN_DIR . '/admin/edit-contact-form.php';
		return;
	}

	if ( 'validate' == wpcf7_current_action()
	&& wpcf7_validate_configuration()
	&& current_user_can( 'wpcf7_edit_contact_forms' ) ) {
		wpcf7_admin_bulk_validate_page();
		return;
	}

	$list_table = new WPCF7_Contact_Form_List_Table();
	$list_table->prepare_items();

?>
<div class="wrap">

<h1><?php
	echo esc_html( __( 'Contact Forms', 'contact-form-7' ) );

	if ( current_user_can( 'wpcf7_edit_contact_forms' ) ) {
		echo ' <a href="' . esc_url( menu_page_url( 'wpcf7-new', false ) ) . '" class="add-new-h2">' . esc_html( __( 'Add New', 'contact-form-7' ) ) . '</a>';
	}

	if ( ! empty( $_REQUEST['s'] ) ) {
		echo sprintf( '<span class="subtitle">'
			. __( 'Search results for &#8220;%s&#8221;', 'contact-form-7' )
			. '</span>', esc_html( $_REQUEST['s'] ) );
	}
?></h1>

<?php do_action( 'wpcf7_admin_notices' ); ?>

<form method="get" action="">
	<input type="hidden" name="page" value="<?php echo esc_attr( $_REQUEST['page'] ); ?>" />
	<?php $list_table->search_box( __( 'Search Contact Forms', 'contact-form-7' ), 'wpcf7-contact' ); ?>
	<?php $list_table->display(); ?>
</form>

</div>
<?php
}

function wpcf7_admin_bulk_validate_page() {
	$contact_forms = WPCF7_ContactForm::find();
	$count = WPCF7_ContactForm::count();

	$submit_text = sprintf(
		_n(
			"Validate %s Contact Form Now",
			"Validate %s Contact Forms Now",
			$count, 'contact-form-7' ),
		number_format_i18n( $count ) );

?>
<div class="wrap">

<h1><?php echo esc_html( __( 'Validate Configuration', 'contact-form-7' ) ); ?></h1>

<form method="post" action="">
	<input type="hidden" name="action" value="validate" />
	<?php wp_nonce_field( 'wpcf7-bulk-validate' ); ?>
	<p><input type="submit" class="button" value="<?php echo esc_attr( $submit_text ); ?>" /></p>
</form>

<?php echo wpcf7_link( __( 'http://contactform7.com/configuration-validator-faq/', 'contact-form-7' ), __( 'FAQ about Configuration Validator', 'contact-form-7' ) ); ?>

</div>
<?php
}

function wpcf7_admin_add_new_page() {
	$post = wpcf7_get_current_contact_form();

	if ( ! $post ) {
		$post = WPCF7_ContactForm::get_template();
	}

	$post_id = -1;

	require_once WPCF7_PLUGIN_DIR . '/admin/includes/editor.php';
	require_once WPCF7_PLUGIN_DIR . '/admin/edit-contact-form.php';
}

function wpcf7_load_integration_page() {
	$integration = WPCF7_Integration::get_instance();

	if ( isset( $_REQUEST['service'] )
	&& $integration->service_exists( $_REQUEST['service'] ) ) {
		$service = $integration->get_service( $_REQUEST['service'] );
		$service->load( wpcf7_current_action() );
	}

	$help_tabs = new WPCF7_Help_Tabs( get_current_screen() );
	$help_tabs->set_help_tabs( 'integration' );
}

function wpcf7_admin_integration_page() {
	$integration = WPCF7_Integration::get_instance();

?>
<div class="wrap">

<h1><?php echo esc_html( __( 'Integration with Other Services', 'contact-form-7' ) ); ?></h1>

<?php do_action( 'wpcf7_admin_notices' ); ?>

<?php
	if ( isset( $_REQUEST['service'] )
	&& $service = $integration->get_service( $_REQUEST['service'] ) ) {
		$message = isset( $_REQUEST['message'] ) ? $_REQUEST['message'] : '';
		$service->admin_notice( $message );
		$integration->list_services( array( 'include' => $_REQUEST['service'] ) );
	} else {
		$integration->list_services();
	}
?>

</div>
<?php
}

/* Misc */

add_action( 'wpcf7_admin_notices', 'wpcf7_admin_updated_message' );

function wpcf7_admin_updated_message() {
	if ( empty( $_REQUEST['message'] ) ) {
		return;
	}

	if ( 'created' == $_REQUEST['message'] ) {
		$updated_message = __( "Contact form created.", 'contact-form-7' );
	} elseif ( 'saved' == $_REQUEST['message'] ) {
		$updated_message = __( "Contact form saved.", 'contact-form-7' );
	} elseif ( 'deleted' == $_REQUEST['message'] ) {
		$updated_message = __( "Contact form deleted.", 'contact-form-7' );
	}

	if ( ! empty( $updated_message ) ) {
		echo sprintf( '<div id="message" class="updated notice notice-success is-dismissible"><p>%s</p></div>', esc_html( $updated_message ) );
		return;
	}

	if ( 'validated' == $_REQUEST['message'] ) {
		$bulk_validate = WPCF7::get_option( 'bulk_validate', array() );
		$count_invalid = isset( $bulk_validate['count_invalid'] )
			? absint( $bulk_validate['count_invalid'] ) : 0;

		if ( $count_invalid ) {
			$updated_message = sprintf(
				_n(
					"Configuration validation completed. An invalid contact form was found.",
					"Configuration validation completed. %s invalid contact forms were found.",
					$count_invalid, 'contact-form-7' ),
				number_format_i18n( $count_invalid ) );

			echo sprintf( '<div id="message" class="notice notice-warning is-dismissible"><p>%s</p></div>', esc_html( $updated_message ) );
		} else {
			$updated_message = __( "Configuration validation completed. No invalid contact form was found.", 'contact-form-7' );

			echo sprintf( '<div id="message" class="notice notice-success is-dismissible"><p>%s</p></div>', esc_html( $updated_message ) );
		}

		return;
	}
}

add_filter( 'plugin_action_links', 'wpcf7_plugin_action_links', 10, 2 );

function wpcf7_plugin_action_links( $links, $file ) {
	if ( $file != WPCF7_PLUGIN_BASENAME )
		return $links;

	$settings_link = '<a href="' . menu_page_url( 'wpcf7', false ) . '">'
		. esc_html( __( 'Settings', 'contact-form-7' ) ) . '</a>';

	array_unshift( $links, $settings_link );

	return $links;
}

add_action( 'wpcf7_admin_notices', 'wpcf7_old_wp_version_error', 2 );

function wpcf7_old_wp_version_error() {
	$wp_version = get_bloginfo( 'version' );

	if ( ! version_compare( $wp_version, WPCF7_REQUIRED_WP_VERSION, '<' ) ) {
		return;
	}

?>
<div class="notice notice-error is-dismissible">
<p><?php echo sprintf( __( '<strong>Contact Form 7 %1$s requires WordPress %2$s or higher.</strong> Please <a href="%3$s">update WordPress</a> first.', 'contact-form-7' ), WPCF7_VERSION, WPCF7_REQUIRED_WP_VERSION, admin_url( 'update-core.php' ) ); ?></p>
</div>
<?php
}

add_action( 'wpcf7_admin_notices', 'wpcf7_welcome_panel', 4 );

function wpcf7_welcome_panel() {
	global $plugin_page;

	if ( 'wpcf7' != $plugin_page || ! empty( $_GET['post'] ) ) {
		return;
	}

	$classes = 'welcome-panel';

	$vers = (array) get_user_meta( get_current_user_id(),
		'wpcf7_hide_welcome_panel_on', true );

	if ( wpcf7_version_grep( wpcf7_version( 'only_major=1' ), $vers ) ) {
		$classes .= ' hidden';
	}

?>
<div id="welcome-panel" class="<?php echo esc_attr( $classes ); ?>">
	<?php wp_nonce_field( 'wpcf7-welcome-panel-nonce', 'welcomepanelnonce', false ); ?>
	<a class="welcome-panel-close" href="<?php echo esc_url( menu_page_url( 'wpcf7', false ) ); ?>"><?php echo esc_html( __( 'Dismiss', 'contact-form-7' ) ); ?></a>

	<div class="welcome-panel-content">
		<div class="welcome-panel-column-container">
			<div class="welcome-panel-column">
				<h3><?php echo esc_html( __( 'Contact Form 7 Needs Your Support', 'contact-form-7' ) ); ?></h3>
				<p class="message"><?php echo esc_html( __( "It is hard to continue development and support for this plugin without contributions from users like you. If you enjoy using Contact Form 7 and find it useful, please consider making a donation.", 'contact-form-7' ) ); ?></p>
				<p><?php echo wpcf7_link( __( 'http://contactform7.com/donate/', 'contact-form-7' ), __( 'Donate', 'contact-form-7' ), array( 'class' => 'button button-primary' ) ); ?></p>
			</div>

			<div class="welcome-panel-column">
				<h3><?php echo esc_html( __( 'Get Started', 'contact-form-7' ) ); ?></h3>
				<ul>
					<li><?php echo wpcf7_link( __( 'http://contactform7.com/getting-started-with-contact-form-7/', 'contact-form-7' ), __( 'Getting Started with Contact Form 7', 'contact-form-7' ) ); ?></li>
					<li><?php echo wpcf7_link( __( 'http://contactform7.com/admin-screen/', 'contact-form-7' ), __( 'Admin Screen', 'contact-form-7' ) ); ?></li>
					<li><?php echo wpcf7_link( __( 'http://contactform7.com/tag-syntax/', 'contact-form-7' ), __( 'How Tags Work', 'contact-form-7' ) ); ?></li>
					<li><?php echo wpcf7_link( __( 'http://contactform7.com/setting-up-mail/', 'contact-form-7' ), __( 'Setting Up Mail', 'contact-form-7' ) ); ?></li>
				</ul>
			</div>

			<div class="welcome-panel-column">
				<h3><?php echo esc_html( __( 'Did You Know?', 'contact-form-7' ) ); ?></h3>
				<ul>
					<li><?php echo wpcf7_link( __( 'http://contactform7.com/spam-filtering-with-akismet/', 'contact-form-7' ), __( 'Spam Filtering with Akismet', 'contact-form-7' ) ); ?></li>
					<li><?php echo wpcf7_link( __( 'http://contactform7.com/save-submitted-messages-with-flamingo/', 'contact-form-7' ), __( 'Save Messages with Flamingo', 'contact-form-7' ) ); ?></li>
					<li><?php echo wpcf7_link( __( 'http://contactform7.com/selectable-recipient-with-pipes/', 'contact-form-7' ), __( 'Selectable Recipient with Pipes', 'contact-form-7' ) ); ?></li>
					<li><?php echo wpcf7_link( __( 'http://contactform7.com/tracking-form-submissions-with-google-analytics/', 'contact-form-7' ), __( 'Tracking with Google Analytics', 'contact-form-7' ) ); ?></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php
}

add_action( 'wp_ajax_wpcf7-update-welcome-panel', 'wpcf7_admin_ajax_welcome_panel' );

function wpcf7_admin_ajax_welcome_panel() {
	check_ajax_referer( 'wpcf7-welcome-panel-nonce', 'welcomepanelnonce' );

	$vers = get_user_meta( get_current_user_id(),
		'wpcf7_hide_welcome_panel_on', true );

	if ( empty( $vers ) || ! is_array( $vers ) ) {
		$vers = array();
	}

	if ( empty( $_POST['visible'] ) ) {
		$vers[] = WPCF7_VERSION;
	}

	$vers = array_unique( $vers );

	update_user_meta( get_current_user_id(), 'wpcf7_hide_welcome_panel_on', $vers );

	wp_die( 1 );
}

add_action( 'wpcf7_admin_notices', 'wpcf7_not_allowed_to_edit' );

function wpcf7_not_allowed_to_edit() {
	if ( ! $contact_form = wpcf7_get_current_contact_form() ) {
		return;
	}

	$post_id = $contact_form->id();

	if ( current_user_can( 'wpcf7_edit_contact_form', $post_id ) ) {
		return;
	}

	$message = __( "You are not allowed to edit this contact form.",
		'contact-form-7' );

	echo sprintf(
		'<div class="notice notice-warning is-dismissible"><p>%s</p></div>',
		esc_html( $message ) );
}

add_action( 'wpcf7_admin_notices', 'wpcf7_notice_config_errors' );

function wpcf7_notice_config_errors() {
	if ( ! $contact_form = wpcf7_get_current_contact_form() ) {
		return;
	}

	if ( ! wpcf7_validate_configuration()
	|| ! current_user_can( 'wpcf7_edit_contact_form', $contact_form->id() ) ) {
		return;
	}

	if ( $config_errors = $contact_form->get_config_errors() ) {
		$message = sprintf(
			_n(
				"This contact form has a configuration error.",
				"This contact form has %s configuration errors.",
				count( $config_errors ), 'contact-form-7' ),
			number_format_i18n( count( $config_errors ) ) );

		$link = wpcf7_link(
			__( 'http://contactform7.com/configuration-errors/', 'contact-form-7' ),
			__( 'How to Resolve Configuration Errors', 'contact-form-7' ) );

		echo sprintf( '<div class="notice notice-warning is-dismissible"><p>%s &raquo; %s</p></div>', esc_html( $message ), $link );
	}
}

add_action( 'admin_notices', 'wpcf7_notice_bulk_validate_config' );

function wpcf7_notice_bulk_validate_config() {
	if ( ! wpcf7_validate_configuration()
	|| ! current_user_can( 'wpcf7_edit_contact_forms' ) ) {
		return;
	}

	if ( isset( $_GET['page'] ) && 'wpcf7' == $_GET['page']
	&& isset( $_GET['action'] ) && 'validate' == $_GET['action'] ) {
		return;
	}

	if ( WPCF7::get_option( 'bulk_validate' ) ) { // already done.
		return;
	}

	$link = add_query_arg(
		array( 'action' => 'validate' ),
		menu_page_url( 'wpcf7', false ) );

	$link = sprintf( '<a href="%s">%s</a>', $link, esc_html( __( 'Validate Contact Form 7 Configuration', 'contact-form-7' ) ) );

	$message = __( "Misconfiguration leads to mail delivery failure or other troubles. Validate your contact forms now.", 'contact-form-7' );

	echo sprintf( '<div class="notice notice-warning is-dismissible"><p>%s &raquo; %s</p></div>', esc_html( $message ), $link );
}
