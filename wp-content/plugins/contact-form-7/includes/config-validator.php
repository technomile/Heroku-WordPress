<?php

class WPCF7_ConfigValidator {

	const error_maybe_empty = 101;
	const error_invalid_syntax = 102;
	const error_email_not_in_site_domain = 103;
	const error_html_in_message = 104;

	private $contact_form;
	private $errors = array();

	public function __construct( WPCF7_ContactForm $contact_form ) {
		$this->contact_form = $contact_form;
		$this->errors = (array) get_post_meta(
			$this->contact_form->id(), '_config_errors', true );
		$this->errors = array_filter( $this->errors );
	}

	public function is_valid() {
		return ! $this->errors;
	}

	public function get_errors() {
		return $this->errors;
	}

	public function get_error( $section ) {
		if ( isset( $this->errors[$section] ) ) {
			return $this->errors[$section];
		}

		return null;
	}

	public function get_error_message( $section ) {
		$code = $this->get_error( $section );

		switch ( $code ) {
			case self::error_maybe_empty:
				return __( "This field can be empty depending on user input.", 'contact-form-7' );
			case self::error_invalid_syntax:
				return __( "This field has syntax errors.", 'contact-form-7' );
			case self::error_email_not_in_site_domain:
				return __( "This email address does not belong to the same domain as the site.", 'contact-form-7' );
			case self::error_html_in_message:
				return __( "HTML tags are not allowed in a message.", 'contact-form-7' );
			default:
				return '';
		}
	}

	private function add_error( $section, $error ) {
		$this->errors[$section] = $error;
	}

	public function validate() {
		$this->errors = array();

		$this->validate_mail( 'mail' );
		$this->validate_mail( 'mail_2' );
		$this->validate_messages();

		delete_post_meta( $this->contact_form->id(), '_config_errors' );

		if ( $this->errors ) {
			update_post_meta( $this->contact_form->id(), '_config_errors',
				$this->errors );
			return false;
		}

		return true;
	}

	public function validate_mail( $template = 'mail' ) {
		$components = (array) $this->contact_form->prop( $template );

		if ( ! $components ) {
			return;
		}

		if ( 'mail' != $template && empty( $components['active'] ) ) {
			return;
		}

		$components = wp_parse_args( $components, array(
			'subject' => '',
			'sender' => '',
			'recipient' => '',
			'additional_headers' => '',
			'body' => '' ) );

		$callback = array( $this, 'replace_mail_tags_with_minimum_input' );

		$subject = $components['subject'];
		$subject = new WPCF7_MailTaggedText( $subject,
			array( 'callback' => $callback ) );
		$subject = $subject->replace_tags();
		$subject = wpcf7_strip_newline( $subject );

		if ( '' === $subject ) {
			$this->add_error( sprintf( '%s.subject', $template ),
				self::error_maybe_empty );
		}

		$sender = $components['sender'];
		$sender = new WPCF7_MailTaggedText( $sender,
			array( 'callback' => $callback ) );
		$sender = $sender->replace_tags();
		$sender = wpcf7_strip_newline( $sender );

		if ( ! wpcf7_is_mailbox_list( $sender ) ) {
			$this->add_error( sprintf( '%s.sender', $template ),
				self::error_invalid_syntax );
		} elseif ( ! wpcf7_is_email_in_site_domain( $sender ) ) {
			$this->add_error( sprintf( '%s.sender', $template ),
				self::error_email_not_in_site_domain );
		}

		$recipient = $components['recipient'];
		$recipient = new WPCF7_MailTaggedText( $recipient,
			array( 'callback' => $callback ) );
		$recipient = $recipient->replace_tags();
		$recipient = wpcf7_strip_newline( $recipient );

		if ( ! wpcf7_is_mailbox_list( $recipient ) ) {
			$this->add_error( sprintf( '%s.recipient', $template ),
				self::error_invalid_syntax );
		}

		$additional_headers = $components['additional_headers'];
		$additional_headers = new WPCF7_MailTaggedText( $additional_headers,
			array( 'callback' => $callback ) );
		$additional_headers = $additional_headers->replace_tags();

		if ( ! $this->test_additional_headers_syntax( $additional_headers ) ) {
			$this->add_error( sprintf( '%s.additional_headers', $template ),
				self::error_invalid_syntax );
		}

		$body = $components['body'];
		$body = new WPCF7_MailTaggedText( $body,
			array( 'callback' => $callback ) );
		$body = $body->replace_tags();

		if ( '' === $body ) {
			$this->add_error( sprintf( '%s.body', $template ),
				self::error_maybe_empty );
		}
	}

	public function test_additional_headers_syntax( $content ) {
		$headers = explode( "\n", $content );

		foreach ( $headers as $header ) {
			$header = trim( $header );

			if ( '' === $header ) {
				continue;
			}

			if ( ! preg_match( '/^([0-9A-Za-z-]+):(.+)$/', $header, $matches ) ) {
				return false;
			}

			$is_mailbox_list_field = in_array( strtolower( $matches[1] ),
				array( 'reply-to', 'cc', 'bcc' ) );

			if ( $is_mailbox_list_field
			&& ! wpcf7_is_mailbox_list( $matches[2] ) ) {
				return false;
			}
		}

		return true;
	}

	public function validate_messages() {
		$messages = (array) $this->contact_form->prop( 'messages' );

		if ( ! $messages ) {
			return;
		}

		if ( isset( $messages['captcha_not_match'] )
		&& ! wpcf7_use_really_simple_captcha() ) {
			unset( $messages['captcha_not_match'] );
		}

		foreach ( $messages as $key => $message ) {
			$stripped = wp_strip_all_tags( $message );

			if ( $stripped != $message ) {
				$this->add_error( sprintf( 'messages.%s', $key ),
					self::error_html_in_message );
			}
		}
	}

	public function replace_mail_tags_with_minimum_input( $matches ) {
		// allow [[foo]] syntax for escaping a tag
		if ( $matches[1] == '[' && $matches[4] == ']' ) {
			return substr( $matches[0], 1, -1 );
		}

		$tag = $matches[0];
		$tagname = $matches[2];
		$values = $matches[3];

		if ( ! empty( $values ) ) {
			preg_match_all( '/"[^"]*"|\'[^\']*\'/', $values, $matches );
			$values = wpcf7_strip_quote_deep( $matches[0] );
		}

		$do_not_heat = false;

		if ( preg_match( '/^_raw_(.+)$/', $tagname, $matches ) ) {
			$tagname = trim( $matches[1] );
			$do_not_heat = true;
		}

		$format = '';

		if ( preg_match( '/^_format_(.+)$/', $tagname, $matches ) ) {
			$tagname = trim( $matches[1] );
			$format = $values[0];
		}

		$example_email = 'example@example.com';
		$example_text = 'example';
		$example_blank = '';

		$form_tags = $this->contact_form->form_scan_shortcode(
			array( 'name' => $tagname ) );

		if ( $form_tags ) {
			$form_tag = new WPCF7_Shortcode( $form_tags[0] );

			$is_required = ( $form_tag->is_required() || 'radio' == $form_tag->type );

			if ( ! $is_required ) {
				return $example_blank;
			}

			$is_selectable = in_array( $form_tag->basetype,
				array( 'radio', 'checkbox', 'select' ) );

			if ( $is_selectable ) {
				if ( $form_tag->pipes instanceof WPCF7_Pipes ) {
					if ( $do_not_heat ) {
						$before_pipes = $form_tag->pipes->collect_befores();
						$last_item = array_pop( $before_pipes );
					} else {
						$after_pipes = $form_tag->pipes->collect_afters();
						$last_item = array_pop( $after_pipes );
					}
				} else {
					$last_item = array_pop( $form_tag->values );
				}

				if ( $last_item && wpcf7_is_mailbox_list( $last_item ) ) {
					return $example_email;
				} else {
					return $example_text;
				}
			}

			if ( 'email' == $form_tag->basetype ) {
				return $example_email;
			} else {
				return $example_text;
			}

		} else {
			$tagname = preg_replace( '/^wpcf7\./', '_', $tagname ); // for back-compat

			if ( '_post_author_email' == $tagname ) {
				return $example_email;
			} elseif ( '_' == substr( $tagname, 0, 1 ) ) { // maybe special mail tag
				return $example_text;
			}
		}

		return $tag;
	}
}
