<?php
/**
 * @package All-in-One-SEO-Pack 
 */
/**
 * The File Editor class. 
 */
if ( !class_exists( 'All_in_One_SEO_Pack_File_Editor' ) ) {
	class All_in_One_SEO_Pack_File_Editor extends All_in_One_SEO_Pack_Module {

		function All_in_One_SEO_Pack_File_Editor( ) {
			$this->name = __('File Editor', 'all_in_one_seo_pack');		// Human-readable name of the plugin
			$this->prefix = 'aiosp_file_editor_';						// option prefix
			$this->file = __FILE__;										// the current file
			parent::__construct();
			if ( isset($_REQUEST['tab'] ) )
				$this->current_tab = $_REQUEST['tab'];
			else
				$this->current_tab = 'robots';

			$help_text = Array(
				'robotfile'	=> __( 'Robots.txt editor', 'all_in_one_seo_pack' ),
				'htaccfile'	=> __( '.htaccess editor', 'all_in_one_seo_pack' )
			);
			$this->default_options = array(
					'robotfile'	=> Array( 'name'	  => __( 'Edit Robots.txt',  'all_in_one_seo_pack'),
										  'save'	  => false, 'default'	  => '', 'type' => 'textarea', 'cols' => 70, 'rows' => 25, 'label' => 'top' ),
					'htaccfile'	=> Array( 'name'	  => __( 'Edit .htaccess',  'all_in_one_seo_pack'),
										  'save'	  => false, 'default'	  => '', 'type' => 'textarea', 'cols' => 70, 'rows' => 25, 'label' => 'top' )
			);

			if ( !empty( $help_text ) )
				foreach( $help_text as $k => $v )
					$this->default_options[$k]['help_text'] = $v;
			$this->tabs = Array(
					'robots' => Array( 'name' => __( 'robots.txt' ) ),
					'htaccess' => Array( 'name' => __( '.htaccess' ) )
				);
			
			$this->layout = Array(
				'robots' => Array(
						'name' => __( 'Edit robots.txt', 'all_in_one_seo_pack' ),
						'options' => Array( 'robotfile' ),
						'tab' => 'robots'
					),
				'htaccess' => Array(
					'name' => __( 'Edit .htaccess', 'all_in_one_seo_pack' ),
					'options' => Array( 'htaccfile' ),
					'tab' => 'htaccess'
					)
				);
			
			$this->update_options( ); 			// load initial options / set defaults		
		}
		
		function settings_page_init() {
			add_filter($this->prefix . 'display_options', Array( $this, 'filter_options' ), 10, 2 );
			add_filter($this->prefix . 'submit_options', Array( $this, 'filter_submit' ), 10, 2 );
		}
		
		function add_page_hooks() {
			parent::add_page_hooks();
			add_action($this->prefix . 'settings_update', Array($this, 'do_file_editor'), 10, 2 );
		}
		
		function filter_submit( $submit, $location ) {
			unset( $submit['Submit_Default'] );
			$submit['Submit']['type'] = 'hidden';
			if ( $this->current_tab == 'robots' )
				$submit['Submit_File_Editor']	= Array( 'type' => 'submit', 'class' => 'button-primary', 'value' => __('Update robots.txt', 'all_in_one_seo_pack') . ' &raquo;' );
			elseif ( $this->current_tab == 'htaccess' )
				$submit['Submit_htaccess']	= Array( 'type' => 'submit', 'class' => 'button-primary', 'value' => __('Update .htaccess', 'all_in_one_seo_pack') . ' &raquo;' );
			return $submit;
		}
		
		function filter_options( $options, $location ) {
			$prefix = $this->get_prefix( $location );
			if ( $this->current_tab == 'robots' )
				$options = $this->load_files( $options, Array( 'robotfile' => 'robots.txt' ), $prefix );			
			elseif ( $this->current_tab == 'htaccess' )
				$options = $this->load_files( $options, Array( 'htaccfile' => '.htaccess' ), $prefix );			
			return $options;
		}

		function do_file_editor( $options, $location ) {
			$prefix = $this->get_prefix( $location );
			if ( $this->current_tab == 'robots' && isset($_POST['Submit_File_Editor']) && $_POST['Submit_File_Editor'] )
				$this->save_files( Array( 'robotfile' => 'robots.txt' ), $prefix );
			elseif ( $this->current_tab == 'htaccess' && isset($_POST['Submit_htaccess']) && $_POST['Submit_htaccess'] )
				$this->save_files( Array( 'htaccfile' => '.htaccess' ), $prefix );
		}
	}
}