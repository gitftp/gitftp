<?php

return [

    /**
     * Default settings
     */
    'defaults'      => [

        /**
         * Mail useragent string
         */
        'useragent'      => 'Gitftp, the deployment tool ' . GF_VERSION,

        /**
         * Mail driver (mail, smtp, sendmail, noop)
         */
        'driver'         => 'mail',

        /**
         * Whether to send as html, set to null for autodetection.
         */
        'is_html'        => true,

        /**
         * Email charset
         */
        'charset'        => 'utf-8',

        /**
         * Wether to encode subject and recipient names.
         * Requires the mbstring extension: http://www.php.net/manual/en/ref.mbstring.php
         */
        'encode_headers' => true,

        /**
         * Ecoding (8bit, base64 or quoted-printable)
         */
        'encoding'       => '8bit',

        /**
         * Email priority
         */
        'priority'       => \Email\Email::P_NORMAL,

        /**
         * Default sender details
         */
        'from'           => [
            'email' => 'no-reply@gitftp.com',
            'name'  => 'Gitftp, deployments',
        ],

        /**
         * Default return path
         */
        'return_path'    => false,

        /**
         * Whether to validate email addresses
         */
        'validate'       => true,

        /**
         * Auto attach inline files
         */
        'auto_attach'    => true,

        /**
         * Auto generate alt body from html body
         */
        'generate_alt'   => true,

        /**
         * Forces content type multipart/related to be set as multipart/mixed.
         */
        'force_mixed'    => false,

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
        'smtp'           => [
            'host'     => 'mail.gitftp.com',
            'port'     => 587,
            'username' => 'no-reply@gitftp.com',
            'password' => '-SVr*KLhT$b&',
            'timeout'  => 5,
        ],

        /**
         * Newline
         */
        'newline'        => "\n",

        /**
         * Attachment paths
         */
        'attach_paths'   => [
            // absolute path
            '',
            // relative to docroot.
            DOCROOT,
        ],
    ],

    /**
     * Default setup group
     */
    'default_setup' => 'default',

    /**
     * Setup groups
     */
    'setups'        => [
        'default' => [],
    ],

];
