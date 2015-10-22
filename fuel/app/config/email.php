<?php

return array(

    /**
     * Default settings
     */
    'defaults'      => array(

        /**
         * Mail useragent string
         */
        'useragent'      => 'Gitftp - the deployment tool',
        /**
         * Mail driver (mail, smtp, sendmail, noop)
         */
        'driver'         => 'smtp',

        /**
         * Whether to send as html, set to null for autodetection.
         */
        'is_html'        => TRUE,

        /**
         * Email charset
         */
        'charset'        => 'utf-8',

        /**
         * Wether to encode subject and recipient names.
         * Requires the mbstring extension: http://www.php.net/manual/en/ref.mbstring.php
         */
        'encode_headers' => TRUE,

        /**
         * Ecoding (8bit, base64 or quoted-printable)
         */
        'encoding'       => '8bit',

        /**
         * Email priority
         */
        'priority'       => \Email::P_NORMAL,

        /**
         * Default sender details
         */
        'from'           => array(
            'email' => 'no-reply@gitftp.com',
            'name'  => 'Gitftp - You push we deploy',
        ),

        /**
         * Default return path
         */
        'return_path'    => FALSE,

        /**
         * Whether to validate email addresses
         */
        'validate'       => TRUE,

        /**
         * Auto attach inline files
         */
        'auto_attach'    => TRUE,

        /**
         * Auto generate alt body from html body
         */
        'generate_alt'   => TRUE,

        /**
         * Forces content type multipart/related to be set as multipart/mixed.
         */
        'force_mixed'    => FALSE,

        /**
         * Wordwrap size, set to null, 0 or false to disable wordwrapping
         */
        'wordwrap'       => 76,

        /**
         * Path to sendmail
         */
        'sendmail_path'  => '/usr/sbin/sendmail',

        /**
         * SMTP settings
         */
        'smtp'           => array(
            'host'     => 'mail.gitftp.com',
            'port'     => 587,
            'username' => 'no-reply@gitftp.com',
            'password' => '-SVr*KLhT$b&',
            'timeout'  => 5,
        ),

        /**
         * Newline
         */
        'newline'        => "\n",

        /**
         * Attachment paths
         */
        'attach_paths'   => array(
            // absolute path
            '',
            // relative to docroot.
            DOCROOT,
        ),
    ),

    /**
     * Default setup group
     */
    'default_setup' => 'default',

    /**
     * Setup groups
     */
    'setups'        => array(
        'default' => array(),
    ),

);
