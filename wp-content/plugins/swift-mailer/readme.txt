=== Swift Mailer ===
Contributors: Turn  On Social
Tags: mail, swift mailer
Requires at least: 3.0
Tested up to: 4.1.1
Stable tag: 5.4.1
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

The Swift Mailer library and nothing more. Created for developers.

== Description ==
Loads the Swift Mailer library into WordPress and nothing more. See http://swiftmailer.org/ for more information.

This plugin was created to provide a reliable way to update the core Swift Mailer library across multiple WordPress installs. The plugin loads only the core library so any mail functions will have to be written. 

Feedback welcomed! For feature requests or questions, create a thread on the support tab (http://wordpress.org/support/plugin/swift-mailer) or email hello [at] turnonsocial [dot] com

== Installation ==
Upload and activate. You can then use the Swift Mailer library within your code - swift_required.php is automatically included.

Sample connect and send code (full documentation available at: http://swiftmailer.org/docs/sending.html )
`// Create the Transport
$transport = Swift_SmtpTransport::newInstance('smtp.example.org', 25)
  ->setUsername('your username')
  ->setPassword('your password')
  ;

// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);

// Create a message
$message = Swift_Message::newInstance('Wonderful Subject')
  ->setFrom(array('john@doe.com' => 'John Doe'))
  ->setTo(array('receiver@domain.org', 'other@domain.org' => 'A name'))
  ->setBody('Here is the message itself')
  ;

// Send the message
$result = $mailer->send($message);`

== Frequently Asked Questions ==
**How do I use this plugin?**
Upon activation, the Swift Mailer library is available to you throughout your codebase. Simply create a transport, create a message and send.

**Do you have sample code for sending email?**
See the fantastic Swift Mailer documentation http://swiftmailer.org/docs/sending.html

**I have a feature request or suggestion**
Great! Please create a message in the Support forum https://wordpress.org/support/plugin/swift-mailer

== Screenshots ==
1. Sample code for application

== Changelog ==
= 5.4.1 =
* Updated to Swift Mailer library v5.4.1

= 5.4.0 =
* Updated to PSR-1 compliant code
* Updated to Swift Mailer library v5.4.0

= 4.3.0 =
* Swift Mailer library v4.3.0

== Upgrade Notice ==
Please update to the latest version. This release upgrades the Swift Mailer library to v5.4.1 and ensure compliant PHP standards. No code changes are required!