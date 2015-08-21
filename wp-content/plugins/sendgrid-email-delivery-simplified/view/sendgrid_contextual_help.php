<p>
  Email Delivery. Simplified.
</p>
<p>
  SendGrid's cloud-based email infrastructure relieves businesses of the cost and complexity
  of maintaining custom email systems. SendGrid provides reliable delivery, scalability and real-time
  analytics along with flexible APIs that make custom integration a breeze.
</p>
<p>
  Before to use this plugin, you'll need to create your very own SendGrid account.
  Go ahead and do so at <a href="http://sendgrid.com/partner/wordpress" target="_blank">http://sendgrid.com/partner/wordpress</a>
</p>
<p>
  To have the SendGrid plugin running after you activated it, please go to plugin's
  settings page and set the SendGrid credentials, and the way your email will be sent through SMTP or API.
  <br />
  You can also set default values for the 'Name', 'Sending Address' and the 'Reply Address'
  in this page, so that you don\'t need to set these headers every time you want to send an email from your
  application.
</p>
<p>
  After you have done these configurations, all your emails sent from your WordPress installation will go through SendGrid.
</p>
<p>
  Now let see how simple is to send a text email:
  <br />
  <div class="code">
    &lt;?php wp_mail('to@address.com\', 'Email Subject', 'Email Body'); ?&gt;
  </div>
  <br />
  If you want to use additional headers, here you have a more complex example:
  <br />
  <div class="code">
    $subject = 'test plugin'
    <br />
    $message = 'testing wordpress plugin'
    <br />
    $to = array('address1@sendgrid.com', 'Address2 <address2@sendgrid.com>', 'address3@sendgrid.com');
    <br />
    <br />
    $headers = array()
    <br />
    $headers[] = 'From: Me Myself <me@example.net>';
    <br />
    $headers[] = 'Cc: address4@sendgrid.com';
    <br />
    $headers[] = 'Bcc: address5@sendgrid.com';
    <br />
    <br />
    $attachments = array('/tmp/img1.jpg', '/tmp/img2.jpg');
    <br />
    <br />
    add_filter('wp_mail_content_type', 'set_html_content_type');
    <br />
    $mail = wp_mail($to, $subject, $message, $headers, $attachments);
    <br />
    remove_filter('wp_mail_content_type', 'set_html_content_type');
  </div>
  <br />
  Where:
  <br />
  <ul>
    <li>$to           -  Array or comma-separated list of email addresses to send message.</li>
    <li>$subject      -  Email subject'); ?></li>
    <li>$message      -  Message contents'); ?></li>
    <li>$headers      -  Array or "\n" separated  list of additional headers. Optional.</li>
    <li>$attachments  -  Array or "\n"/"," separated list of files to attach. Optional.</li>
  </ul>
  The wp_mail function is sending text emails as default. If you want to send an email with HTML content you have
  to set the content type to 'text/html' running
  <span class="code">
    add_filter('wp_mail_content_type', 'set_html_content_type');
  </span>
  function before to wp_mail() one.
  <br />
  <br />
  After wp_mail function you need to run the
  <span class="code">
    remove_filter('wp_mail_content_type', 'set_html_content_type');
  </span>
  to remove the 'text/html' filter to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
  <p><b>Define SendGrid settings as global variables (wp-config.php):</b></p>
  <p>
    <ol>
      <li>Set credentials (both need to be set in order to get credentials from variables and not from the database):
        <ul>
          <li>Username: <span class="code">define('SENDGRID_USERNAME', 'sendgrid_username');</span></li>
          <li>Password: <span class="code">define('SENDGRID_PASSWORD', 'sendgrid_password');</span></li>
        </ul>
      </li>
      <li>Set email related settings:
        <ul>
          <li>Send method ('api' or 'smtp'): <span class="code">define('SENDGRID_SEND_METHOD', 'api');</span></li>
          <li>From name: <span class="code">define('SENDGRID_FROM_NAME', 'Example Name');</span></li>
          <li>From email: <span class="code">define('SENDGRID_FROM_EMAIL', 'from_email@example.com');</span></li>
          <li>Reply to email: <span class="code">define('SENDGRID_REPLY_TO', 'reply_to@example.com');</span></li>
          <li>Categories: <span class="code">define('SENDGRID_CATEGORIES', 'category_1,category_2');</span></li>
        </ul>
      </li>
    </ol>
  </p>
</p>