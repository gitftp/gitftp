<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * NOTICE:
 *
 * If you need to make modifications to the default configuration, copy
 * this file to your app/config folder, and make them in there.
 *
 * This will allow you to upgrade fuel without losing your custom config.
 */

return array(

    /**
     * link_multiple_providers
     *
     * Can multiple providers be attached to one user account
     */
    'link_multiple_providers' => TRUE,

    /**
     * auto_registration
     *
     * If true, a login via a provider will automatically create a dummy
     * local user account with a random password, if a nickname and an
     * email address is present
     */
    'auto_registration'       => FALSE,

    /**
     * default_group
     *
     * Group id to be assigned to newly created users
     */
    'default_group'           => 1,

    /**
     * debug
     *
     * Uncomment if you would like to view debug messages
     */
    'debug'                   => TRUE,

    /**
     * A random string used for signing of auth response.
     *
     * You HAVE to set this value in your application config file!
     */
    'security_salt'           => 'h247835y894dy89b7y57',

    /**
     * Higher value, better security, slower hashing;
     * Lower value, lower security, faster hashing.
     */
    'security_iteration'      => 300,

    /**
     * Time limit for valid $auth response, starting from $auth response generation to validation.
     */
    'security_timeout'        => '2 minutes',

    /**
     * Strategy
     * Refer to individual strategy's documentation on configuration requirements.
     */
    'Strategy'                => array(

        'Facebook' => array(
            'app_id'     => '1102005696495607',
            'app_secret' => 'efcfe3cd9cb538a1ae0a1b325d969638',
            'scope'      => 'email'
        ),
        'GitHub'   => array(
            'client_id'     => '7d936e80431b4d605c7f',
            'client_secret' => '8db2a8dcbeb6c72e6f0487f05f3827531d50d63e'
        )
    ),
);
