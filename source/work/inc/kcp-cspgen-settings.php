<?php
/** 
 * Header Settings
 * 
 * Controls the admin settings
 * 
 * @since 7.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin's Security Header Generator
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// make sure the class doesn't already exist
if( ! class_exists( 'KCP_CSPGEN_Settings' ) ) {

    /** 
     * Class KCP_CSPGEN_Settings
     * 
     * The actual class for generating the admin settings
     * 
     * @since 7.4
     * @access public
     * @author Kevin Pirnie <me@kpirnie.com>
     * @package Kevin's Security Header Generator
     * 
    */
    class KCP_CSPGEN_Settings {

        /** 
         * kp_cspgen_settings
         * 
         * The method is responsible for implementing the admin settings
         * 
         * @since 7.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin's Security Header Generator
         * 
         * @return void This method does not return anything
         * 
        */
        public function kp_cspgen_settings( ) : void {

            // add in the menu
            $this -> kcp_cspgen_menu( );

        }

        /** 
         * kcp_cspgen_menu
         * 
         * The method is responsible for building out the admin pages
         * 
         * @since 7.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin's Security Header Generator
         * 
         * @return void This method does not return anything
         * 
        */
        private function kcp_cspgen_menu( ) : void {

            // make sure our field framework actually exists
            if( class_exists( 'KPSHG' ) ) {

                // our settings id
                $_settings_id = 'wpsh_settings';

                // create the main options page
                KPSHG::createOptions( $_settings_id, array(
                    'menu_title' => __( 'Security Headers', 'security-header-generator' ),
                    'menu_slug'  => 'wpsh_settings',
                    'menu_capability' => 'list_users',
                    'menu_icon' => 'dashicons-shield',
                    'admin_bar_menu_icon' => 'dashicons-shield',
                    'menu_position' => 2,
                    'show_in_network' => false,
                    'show_reset_all' => false,
                    'show_reset_section' => false,   
                    'sticky_header' => false,  
                    'ajax_save' => false,           
                    'footer_text' => '<a href="https://kevinpirnie.com" target="_blank"><img src="https://cdn.kevp.cc/kp/kevinpirnie-logo-color.svg" alt="Kevin Pirnie: https://kevinpirnie.com" style="width:250px !important;" /></a>',
                    'framework_title' => __( 'The Security Header Generator <small>by <a href="https://kevinpirnie.com/" target="_blank">Kevin C. Pirnie</a></small>', 'security-header-generator' ),
                    'footer_credit' => __( 'Thank you for securing your site!', 'security-header-generator' ),
                ) );

                // after the save occurs, clear WP option cache
                add_filter( 'kpshg_{$_settings_id}_saved', function( ) : void {

                    // get the current site id
                    $_site_id = get_current_blog_id( );

                    // first clear wordpress's builtin cache
                    wp_cache_flush( );

                    // now try to delete the wp object cache
                    if( function_exists( 'wp_cache_delete' ) ) {

                        // clear the plugin object cache
                        wp_cache_delete( 'uninstall_plugins', 'options' );

                        // clear the options object cache
                        wp_cache_delete( 'alloptions', 'options' );

                        // clear the rest of the object cache
                        wp_cache_delete( 'notoptions', 'options' );

                        // clear the rest of the object cache for the parent site in a multisite install
                        wp_cache_delete( $_site_id . '-notoptions', 'site-options' );

                        // clear the plugin object cache for the parent site in a multisite install
                        wp_cache_delete( $_site_id . '-active_sitewide_plugins', 'site-options' );
                    }

                    // probably overkill, but let's fire off the rest of the builtin cache flushing mechanisms
                    global $wp_object_cache;

                    // try to flush the object cache
                    $wp_object_cache -> flush( 0 );

                    // attempt to clear the opcache
                    opcache_reset( );

                } );

                // Standard Security Headers
                KPSHG::createSection( $_settings_id, 
                    array(
                        'title'  => __( 'Standard Security Headers', 'security-header-generator' ),
                        'fields' => $this -> kcp_standard_security_headers( ),
                        'description' => __( '<p><strong>NOTE</strong><br />Make sure to check your web browsers <strong>Development Tools</strong> once you are finished configuring this. You will need to make sure you are not blocking necessary items for your website.</p>', 'security-header-generator' ),
                    )
                );

                // Content Security Policy
                KPSHG::createSection( $_settings_id, 
                    array(
                        'title'  => __( 'Content Security Headers', 'security-header-generator' ),
                        'fields' => $this -> kcp_content_security_policy_headers( ),
                        'description' => __( '<p><strong>NOTE</strong><br />Make sure to check your web browsers <strong>Development Tools</strong> once you are finished configuring this. You will need to make sure you are not blocking necessary items for your website.<br /><br /><strong>Suggested:</strong><br />Add your domains to the necessary attribute prior to adding the external resource...</p>', 'security-header-generator' ),
                        'class' => 'wpsh_content_security_policy'
                    )
                );

                // Feature / Permissions Policy
                KPSHG::createSection( $_settings_id, 
                    array(
                        'title'  => __( 'Permissions Policy Headers', 'security-header-generator' ),
                        'fields' => $this -> kcp_permissions_policy_headers( ),
                        'description' => __( '<p><strong>NOTE</strong><br />Make sure to check your web browsers <strong>Development Tools</strong> once you are finished configuring this. You will need to make sure you are not blocking necessary items for your website.</p>', 'security-header-generator' ),
                    )
                );

                // the documentation "page"
                KPSHG::createSection( $_settings_id, 
                    array(
                        'title'  => __( 'Documentation', 'security-header-generator' ),
                        'fields' => array(
                            array(
                                'type' => 'content',
                                'content' => $this -> kcp_documentation( ),
                            )
                        ),
                    )
                );

                // setup and exports "page"
                KPSHG::createSection( $_settings_id, 
                    array(
                        'title'  => __( 'Export/Import Settings', 'security-header-generator' ),
                        'fields' => array(
                            array(
                                'type' => 'backup',
                            ),
                        ),
                    )
                );

            }

        }

        /** 
         * kcp_standard_security_headers
         * 
         * The method is responsible for setting up the standard security header settings
         * 
         * @since 7.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin's Security Header Generator
         * 
         * @return array Returns an array of all the settings necessary
         * 
        */
        private function kcp_standard_security_headers( ) : array {

            // return an array of the fields needed
            return array(

                // apply to admin
                array(
                    'id' => 'apply_to_admin',
                    'type' => 'switcher',
                    'title' => __( 'Apply to Admin?', 'security-header-generator' ),
                    'desc' => __( 'This will attempt to apply all headers to the admin side of your site in addition to the front-end.', 'security-header-generator' ),
                    'default' => false,
                ),

                // apply to REST
                array(
                    'id' => 'apply_to_rest',
                    'type' => 'switcher',
                    'title' => __( 'Apply to the REST API?', 'security-header-generator' ),
                    'desc' => __( 'This will attempt to apply all headers to the REST API of your site.<br /><strong>NOTE:</strong> Due to the default nature of the REST API, the headers will also be applied to the admin areas of the website. You will need to check for breakages after applying.', 'security-header-generator' ),
                    'default' => false,
                ),

                // include sts
                array(
                    'id' => 'include_sts',
                    'type' => 'switcher',
                    'title' => __( 'Include Strict Transport Security?', 'security-header-generator' ),
                    'desc' => __( 'Setting this will add another header to force Strict Transport Security. See here for more information: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security</a>', 'security-header-generator' ),
                    'default' => false,
                ),
                
                // sts cache age
                array(
                    'id' => 'include_sts_max_age',
                    'type' => 'text',
                    'title' => __( 'Cache Age', 'security-header-generator' ),
                    'desc' => __( 'The time, in seconds, that the browser should remember that a site is only to be accessed using HTTPS.', 'security-header-generator' ),
                    'default' => 31536000,
                    'attributes' => array( 'type' => 'number' ),
                    'dependency' => array( 'include_sts', '==', true ),
                ),
                
                // sts subdomains
                array(
                    'id' => 'include_sts_subdomains',
                    'type' => 'switcher',
                    'title' => __( '<strong>Include Subdomains?</strong>', 'security-header-generator' ),
                    'desc' => __( 'If this optional parameter is specified, this rule applies to all of the site\'s subdomains as well.', 'security-header-generator' ),
                    'default' => false,
                    'dependency' => array( 'include_sts', '==', true ),
                ),
                
                // sts preload
                array(
                    'id' => 'include_sts_preload',
                    'type' => 'switcher',
                    'title' => __( '<strong>Preload?</strong>', 'security-header-generator' ),
                    'desc' => __( 'If you enable preload, you should change the cache age to 2 Years. (63072000)', 'security-header-generator' ),
                    'default' => false,
                    'dependency' => array( 'include_sts', '==', true ),
                ),

                /* DEPRECATED
                // include Expect-CT header
                array(
                    'id' => 'include_expectct',
                    'type' => 'switcher',
                    'title' => __( 'Enforce Certificate Transparency?', 'security-header-generator' ),
                    'desc' => __( 'Setting this will add another header to enforce Certificate Transparency. See here for more information: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Expect-CT" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Expect-CT</a><br /><strong>NOTE: </strong>This header is likely to be deprecated in the near future.', 'security-header-generator' ),
                    'default' => false,
                ),
                */
                
                // frame sources
                array(
                    'id' => 'include_ofs',
                    'type' => 'switcher',
                    'title' => __( 'Configure Frame Sources?', 'security-header-generator' ),
                    'desc' => __( 'Setting this will add another header to configure allowed frame sources. See here for more information: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options</a>', 'security-header-generator' ),
                    'default' => false,
                ),
                
                // deny or allow sameorigin
                array(
                    'id' => 'include_ofs_type',
                    'type' => 'radio',
                    'title' => __( 'Directives', 'security-header-generator' ),
                    'desc' => __( 'Setting this will add another header to configure site framing. See here for more information: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options</a>', 'security-header-generator' ),
                    'options' => array(
                        'DENY' => __( 'deny all framing', 'security-header-generator' ),
                        'SAMEORIGIN' => __( 'deny all framing unless done from the origination domain', 'security-header-generator' ),
                    ),
                    'inline' => true,
                    'default' => 'DENY',
                    'dependency' => array( 'include_ofs', '==', true ),
                ),

                // access control allow methods
                array(
                    'id' => 'include_acam',
                    'type' => 'switcher',
                    'title' => __( 'Do you want to configure access methods?', 'security-header-generator' ),
                    'desc' => __( 'Setting this will add another header for Access-Control-Allow-Methods. See here for more information: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Methods" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Methods</a>', 'security-header-generator' ),
                    'default' => false,
                ),
                array(
                    'id' => 'include_acam_methods',
                    'type' => 'checkbox',
                    'title' => __( 'Methods', 'security-header-generator' ),
                    'desc' => __( 'Select the methods you wish to allow.<br /><strong>NOTE:</strong> Most public websites require at least GET to be viewable online.<br /><strong>NOTE 2:</strong> This will block unselected methods.', 'security-header-generator' ),
                    'options' => array(
                        'GET' => __( 'GET', 'security-header-generator' ),
                        'HEAD' => __( 'HEAD', 'security-header-generator' ),
                        'POST' => __( 'POST', 'security-header-generator' ),
                        'PUT' => __( 'PUT', 'security-header-generator' ),
                        'DELETE' => __( 'DELETE', 'security-header-generator' ),
                        'CONNECT' => __( 'CONNECT', 'security-header-generator' ),
                        'OPTIONS' => __( 'OPTIONS', 'security-header-generator' ),
                        'TRACE' => __( 'TRACE', 'security-header-generator' ),
                        'PATCH' => __( 'PATCH', 'security-header-generator' ),
                        '*' => __( 'Allow All', 'security-header-generator' ),
                    ),
                    'inline' => true,
                    'default' => array( 'GET', 'POST', 'HEAD' ),
                    'dependency' => array( 'include_acam', '==', true ),
                ),

                // access control allow credentials
                array(
                    'id' => 'include_acac',
                    'type' => 'switcher',
                    'title' => __( 'Do you want to allow access control credentials?', 'security-header-generator' ),
                    'desc' => __( 'Setting this will add another header for Access-Control-Allow-Credentials. See here for more information: <a href=https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Credentials" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Credentials</a>', 'security-header-generator' ),
                    'default' => true,
                ),
                
                // access control allow origin
                array(
                    'id' => 'include_acao',
                    'type' => 'switcher',
                    'title' => __( 'Do you want to allow an access control origin?', 'security-header-generator' ),
                    'desc' => __( 'Setting this will add another header for Access-Control-Allow-Origin. See here for more information: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin</a>', 'security-header-generator' ),
                    'default' => false,
                ),

                // origin
                array(
                    'id' => 'include_acao_origin',
                    'type' => 'text',
                    'title' => __( 'Origin', 'security-header-generator' ),
                    'desc' => __( 'Set the allowed access origin here.  Can either be an asterisk: <code>*</code>, or a FQDN URL: <code>https://example.com</code><br /><strong>NOTE: </strong>If nothing is put in here, we will default to <code>*</code>', 'security-header-generator' ),
                    'dependency' => array( 'include_acao', '==', true ),
                ),
                
                // mimetype sniffing
                array(
                    'id' => 'include_mimesniffing',
                    'type' => 'switcher',
                    'title' => __( 'Do you want to prevent mime-type sniffing?', 'security-header-generator' ),
                    'desc' => __( 'Setting this will add another header to force proper mime-types. See here for more information: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Content-Type-Options" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Content-Type-Options</a>', 'security-header-generator' ),
                    'default' => false,
                ),
                
                // referrer policy
                array(
                    'id' => 'include_referrer_policy',
                    'type' => 'switcher',
                    'title' => __( 'Do you want to configure origin referrers?', 'security-header-generator' ),
                    'desc' => __( 'Setting this will add another header to configure allowed origin referrers. See here for more information: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referrer-Policy" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referrer-Policy</a>', 'security-header-generator' ),
                    'default' => false,
                ),
                
                // configure the referrer policy
                array(
                    'id' => 'include_referrer_policy_setting',
                    'type' => 'radio',
                    'title' => __( 'Directives', 'security-header-generator' ),
                    'options' => array(
                        'no-referrer' => __( 'no referrer', 'security-header-generator' ),
                        'no-referrer-when-downgrade' => __( 'no referrer on protocol downgrade', 'security-header-generator' ),
                        'origin' => __( 'origin only', 'security-header-generator' ),
                        'origin-when-cross-origin' => __( 'origin on cross-domain', 'security-header-generator' ),
                        'same-origin' => __( 'same origin', 'security-header-generator' ),
                        'strict-origin' => __( 'strict origin', 'security-header-generator' ),
                        'strict-origin-when-cross-origin' => __( 'strict origin on cross domain', 'security-header-generator' ),
                        'unsafe-url' => __( 'full referrer path', 'security-header-generator' )
                    ),
                    'inline' => true,
                    'default' => 'strict-origin',
                    'dependency' => array( 'include_referrer_policy', '==', true ),
                ),
                
                // force downloads
                array(
                    'id' => 'include_download_options',
                    'type' => 'switcher',
                    'title' => __( 'Do you want to force downloads?', 'security-header-generator' ),
                    'desc' => __( 'Setting this will add another header to downloading resources instead of directly openning them in the browser. See here for more information: <a href="https://www.nwebsec.com/HttpHeaders/SecurityHeaders/XDownloadOptions" target="_blank">https://www.nwebsec.com/HttpHeaders/SecurityHeaders/XDownloadOptions</a>', 'security-header-generator' ),
                    'default' => false,
                ),
                
                // block cross-domain requests from pdf's and flash
                array(
                    'id' => 'include_crossdomain',
                    'type' => 'switcher',
                    'title' => __( 'Do you want to block cross domain origins?', 'security-header-generator' ),
                    'desc' => __( 'Setting this will add another header to block cross domain origins. See here for more information: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Headers/X-Permitted-Cross-Domain-Policies" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Headers/X-Permitted-Cross-Domain-Policies</a>', 'security-header-generator' ),
                    'default' => false,
                ),
                
                // upgrade insecure requests
                array(
                    'id' => 'include_upgrade_insecure',
                    'type' => 'switcher',
                    'title' => __( 'Do you want to upgrade insecure requests?', 'security-header-generator' ),
                    'desc' => __( 'Setting this will add another header to upgrade insecure requests. See here for more information: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Upgrade-Insecure-Requests" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Upgrade-Insecure-Requests</a>', 'security-header-generator' ),
                    'default' => false,
                ),

                // Cross-Origin-Embedder-Policy
                array(
                    'id' => 'coep',
                    'type' => 'switcher',
                    'title' => __( 'Do you want to configure a Cross-Origin-Embedder-Policy?', 'security-header-generator' ),
                    'desc' => __( 'Setting this will add another header to set a Cross-Origin-Embedder-Policy. See here for more information: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cross-Origin-Embedder-Policy" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cross-Origin-Embedder-Policy</a>', 'security-header-generator' ),
                    'default' => false,
                ),

                // configure the resource policy
                array(
                    'id' => 'coep_setting',
                    'type' => 'radio',
                    'title' => __( 'Directives', 'security-header-generator' ),
                    'options' => array(
                        'unsafe-none' => __( 'unsafe-none', 'security-header-generator' ),
                        'require-corp' => __( 'require-corp', 'security-header-generator' ),
                    ),
                    'inline' => true,
                    'default' => 'unsafe-none',
                    'dependency' => array( 'coep', '==', true ),
                ),

                // Cross-Origin-Resource-Policy
                array(
                    'id' => 'corp',
                    'type' => 'switcher',
                    'title' => __( 'Do you want to configure a Cross-Origin-Resource-Policy?', 'security-header-generator' ),
                    'desc' => __( 'Setting this will add another header to set a Cross-Origin-Resource-Policy. See here for more information: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Cross-Origin_Resource_Policy" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/Cross-Origin_Resource_Policy</a>', 'security-header-generator' ),
                    'default' => false,
                ),

                // configure the resource policy
                array(
                    'id' => 'corp_setting',
                    'type' => 'radio',
                    'title' => __( 'Directives', 'security-header-generator' ),
                    'options' => array(
                        'same-site' => __( 'same-site', 'security-header-generator' ),
                        'same-origin' => __( 'same-origin', 'security-header-generator' ),
                        'cross-origin' => __( 'cross-origin', 'security-header-generator' ),
                    ),
                    'inline' => true,
                    'default' => 'same-origin',
                    'dependency' => array( 'corp', '==', true ),
                ),

                // Cross-Origin-Opener-Policy
                array(
                    'id' => 'coop',
                    'type' => 'switcher',
                    'title' => __( 'Do you want to configure a Cross-Origin-Opener-Policy?', 'security-header-generator' ),
                    'desc' => __( 'Setting this will add another header to set a Cross-Origin-Opener-Policy. See here for more information: <a href="https://owasp.org/www-project-secure-headers/#cross-origin-opener-policy" target="_blank">https://owasp.org/www-project-secure-headers/#cross-origin-opener-policy</a>', 'security-header-generator' ),
                    'default' => false,
                ),

                // configure the opener policy
                array(
                    'id' => 'coop_setting',
                    'type' => 'radio',
                    'title' => __( 'Directives', 'security-header-generator' ),
                    'options' => array(
                        'unsafe-none' => __( 'unsafe-none', 'security-header-generator' ),
                        'same-origin-allow-popups' => __( 'same-origin-allow-popups', 'security-header-generator' ),
                        'same-origin' => __( 'same-origin', 'security-header-generator' ),
                    ),
                    'inline' => true,
                    'default' => 'unsafe-none',
                    'dependency' => array( 'coop', '==', true ),
                ),

            );

        }

        /** 
         * kcp_content_security_policy_headers
         * 
         * The method is responsible for setting up the content security policy header settings
         * 
         * @since 7.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin's Security Header Generator
         * 
         * @return array Returns an array of all the settings necessary
         * 
        */
        private function kcp_content_security_policy_headers( ) : array {

            // hold the return array and directives array
            $_ret = array( ); $_ret_dir = array( );

            // hold an array of directives
            $_dir = KCP_CSPGEN_Common::get_csp_directives( );

            // build out our first set of fields
            $_ret[] = array(

                // generate content security policy
                array(
                    'id' => 'generate_csp',
                    'type' => 'switcher',
                    'title' => __( 'Generate CSP?', 'security-header-generator' ),
                    'desc' => __( 'Setting this will set the flag for generating a Content Security Policy.  See here for more information: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP</a>', 'security-header-generator' ),
                    'default' => false,
                ),

                // apply to admin
                array(
                    'id' => 'apply_csp_to_admin',
                    'type' => 'switcher',
                    'title' => __( 'Apply to Admin?', 'security-header-generator' ),
                    'desc' => __( 'This will attempt to apply the Content Security Policy Headers to the admin side of your site in addition to the front-end.', 'security-header-generator' ),
                    'default' => false,
                    'dependency' => array( 'generate_csp', '==', true ),
                ),
                
                // include wordpress defaults
                array(
                    'id' => 'include_wordpress_defaults',
                    'type' => 'switcher',
                    'title' => __( 'Include Wordpress Defaults?', 'security-header-generator' ),
                    'desc' => __( 'This will include resources for the following: <br />google.com, gstatic.com, google-analytics.com, googletagmanager.com, yoast.com, w.org, gravatar.com, doubleclick.net, bootstrapcdn.com, and wpengine.com', 'security-header-generator' ),
                    'default' => false,
                    'dependency' => array( 'generate_csp', '==', true ),
                ),
                
                // basic auth username
                array(
                    'id' => 'auth_un',
                    'type' => 'text',
                    'title' => __( '<strong>Basic Auth Username</strong>', 'security-header-generator' ),
                    'desc' => __( 'Enter your Basic Auth Username, if your site has this protection. (aka: htaccess protection, or htpasswd', 'security-header-generator' ),
                    'dependency' => array( 'generate_csp', '==', true ),
                    'class' => 'kpsh-half-field',
                    'attributes' => array( 'autocomplete' => 'off', ),
                ),
                
                // basic auth password
                array(
                    'id' => 'auth_pw',
                    'type' => 'text',
                    'attributes' => array( 'type' => 'password', 'autocomplete' => 'new-password' ),
                    'title' => __( '<strong>Basic Auth Password</strong>', 'security-header-generator' ),
                    'desc' => __( 'Enter your Basic Auth Password, if your site has this protection. (aka: htaccess protection, or htpasswd', 'security-header-generator' ),
                    'dependency' => array( 'generate_csp', '==', true ),
                    'class' => 'kpsh-half-field',

                ),

            );

            // loop over the directives array
            foreach( $_dir as $_key => $_val ) {

                // we want some other fields for the sandbox directive
                if( $_val['id'] == 'generate_csp_custom_sandbox' ) {

                    // add the field to the array
                    $_ret_dir[] = array(

                        // csp directive
                        array(
                            'id' => $_val['id'],
                            'title' => $_val['title'],
                            'desc' => $_val['desc'],
                            'type' => 'checkbox',
                            'options' => array(
                                'allow-downloads' => __( 'allow-downloads', 'security-header-generator' ),
                                'allow-downloads-without-user-activation' => __( 'allow-downloads-without-user-activation', 'security-header-generator' ),
                                'allow-forms' => __( 'allow-forms', 'security-header-generator' ),
                                'allow-modals' => __( 'allow-modals', 'security-header-generator' ),
                                'allow-orientation-lock' => __( 'allow-orientation-lock', 'security-header-generator' ),
                                'allow-pointer-lock' => __( 'allow-pointer-lock', 'security-header-generator' ),
                                'allow-popups' => __( 'allow-popups', 'security-header-generator' ),
                                'allow-popups-to-escape-sandbox' => __( 'allow-popups-to-escape-sandbox', 'security-header-generator' ),
                                'allow-presentation' => __( 'allow-presentation', 'security-header-generator' ),
                                'allow-same-origin' => __( 'allow-same-origin', 'security-header-generator' ),
                                'allow-scripts' => __( 'allow-scripts', 'security-header-generator' ),
                                'allow-storage-access-by-user-activation' => __( 'allow-storage-access-by-user-activation', 'security-header-generator' ),
                                'allow-top-navigation' => __( 'allow-top-navigation', 'security-header-generator' ),
                                'allow-top-navigation-by-user-activation' => __( 'allow-top-navigation-by-user-activation', 'security-header-generator' ),
                                'allow-top-navigation-to-custom-protocols' => __( 'allow-top-navigation-to-custom-protocols', 'security-header-generator' ),
                            ),
                            'inline' => true,
                            'class' => 'kpsh-full-field',
                            'dependency' => array( 'generate_csp', '==', true ),
                        ),

                    );

                // we don't want the full fields set for the report-to directive
                } elseif( $_val['id'] == 'generate_csp_report_to' ) {

                    // add the field to the array
                    $_ret_dir[] = array(

                        // csp directive
                        array(
                            'id' => $_val['id'],
                            'title' => $_val['title'],
                            'desc' => $_val['desc'],
                            'type' => 'text',
                            'dependency' => array( 'generate_csp', '==', true ),
                            'class' => 'kpsh-half-field',
                        ),
                        array(
                            'id' => $_val['id'] . '_hidden',
                            'type' => 'text',
                            'default' => '0',
                            'dependency' => array( 'generate_csp', '==', true ),
                            'class' => 'kpsh-half-field kpsh-half-field-hidden',
                        )

                    );

                // it's not, we can move on
                } else {

                    // add the field to the array
                    $_ret_dir[] = array(

                        // csp directive
                        array(
                            'id' => $_val['id'],
                            'title' => $_val['title'],
                            'desc' => $_val['desc'],
                            'type' => 'text',
                            'dependency' => array( 'generate_csp', '==', true ),
                            'class' => 'kpsh-half-field',
                        ),

                        // extra fields
                        array(
                            'id' => $_val['id'] . '_allow_unsafe',
                            'title' => __( 'Extra Settings?', 'security-header-generator' ),
                            'desc' => __( 'Injects the proper attribute when selected', 'security-header-generator' ),
                            'type' => 'checkbox',
                            'options' => $this -> manage_extras( $_val['id'] ),
                            'inline' => true,
                            'dependency' => array( 'generate_csp', '==', true ),
                            'class' => 'kpsh-half-field',
                        )

                    );
                }

            }

            // inject the flattenned directive field array
            $_ret[] = array_merge( ...$_ret_dir );

            // return the unpacked array
            return array_merge( ...$_ret );

        }

        /** 
         * kcp_permissions_policy_headers
         * 
         * The method is responsible for setting up the permissions/feature policy header settings
         * 
         * @since 7.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin's Security Header Generator
         * 
         * @return array Returns an array of all the settings necessary
         * 
        */
        private function kcp_permissions_policy_headers( ) : array {

            // return the array of fields
            return array(

                // Feature Policy: aka Permissions-Policy
                array(
                    'id' => 'feature_policy',
                    'type' => 'switcher',
                    'title' => __( 'Do you want to configure a Feature Policy (aka Permissions-Policy)?', 'security-header-generator' ),
                    'desc' => __( 'Setting this will add another header to configure browser and frame permissions. See here for more information: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Feature-Policy" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Feature-Policy</a><br /><br /><strong>NOTE: </strong> Some of these features are not implemented for all browsers, and/or could be experimental.  Please read through that information and decide what features you need, and what audiences you need to apply to.', 'security-header-generator' ),
                    'default' => false,
                ),

                // apply to admin
                array(
                    'id' => 'apply_fp_to_admin',
                    'type' => 'switcher',
                    'title' => __( 'Apply to Admin?', 'security-header-generator' ),
                    'desc' => __( 'This will attempt to apply the Feature Policy Headers to the admin side of your site in addition to the front-end.', 'security-header-generator' ),
                    'default' => false,
                    'dependency' => array( 'feature_policy', '==', true ),
                ),

                // Feature Policies Fieldset
                array(
                    'id' => 'feature_policies',
                    'type' => 'fieldset',
                    'title' => __( 'Allowed Policy Directives', 'security-header-generator' ),
                    'desc' => __( 'Select the policy directives you would like to allow, along with its origins. See here for more information: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Feature-Policy#directives" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Feature-Policy#directives</a>', 'security-header-generator' ),
                    'dependency' => array( 'feature_policy', '==', true ),
                    'fields' => $this -> kcp_feature_policy_fields( ),
                ),

            );

        }

        /** 
         * kcp_feature_policy_fields
         * 
         * The method is responsible for generating an array of feature policies available to configure
         * 
         * @since 7.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin's Security Header Generator
         * 
         * @return array Returns an array of the feature policies fields
         * 
        */
        private function kcp_feature_policy_fields( ) : array {

            // get the array of policies
            $_policies = KCP_CSPGEN_Common::get_permissions_directives( );

            // setup the returnable array
            $_ret = array( );

            // loop over the policies array and add the approriate field
            foreach( $_policies as $_key => $_val ) {

                $_ret[] = array( 

                    // policy directive
                    array(
                        'id' => $_val['id'],
                        'title' => $_val['title'],
                        'desc' => $_val['desc'],
                        'type' => 'button_set',
                        'options' => array(
                            0 => __( 'None', 'security-header-generator' ),
                            1 => __( 'Any', 'security-header-generator' ),
                            2 => __( 'Self', 'security-header-generator' ),
                            3 => __( 'Source', 'security-header-generator' ),
                        ),
                        'default' => 1,
                        'inline' => true,
                    ),

                    // source domains if needed
                    array(
                        'id' => 'fp_' . $_key . '_src_domain',
                        'type' => 'text',
                        'title' => __( 'Source Domains', 'security-header-generator' ),
                        'desc' => __( 'Space-delimited list of allowed source URIs. Please make sure they include the http(s):// and each is enclosed in quotes.', 'security-header-generator' ),
                        'dependency' => array( 'fp_' . $_key, '==', 3 ),
                    ),

                );

            }

            // return the fields
            return array_merge( ...$_ret );

        }

        /** 
         * kcp_documentation
         * 
         * The method is responsible for pulling in and rendering the "documentation" page in admin
         * 
         * @since 7.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin's Security Header Generator
         * 
         * @return string Returns string of the page
         * 
        */
        private function kcp_documentation( ) : string {

            // include our implementation... because there is PHP processing, we need to utilize output bufferring
            ob_start( );

            // include the file
            include_once( WPSH_PATH . '/work/doc.php' );

            // throw the contents of the buffer into the out variable
            $_out = ob_get_contents( );

            // clean the output bufferring and end it
            ob_end_clean( );

            // return the rendered content
            return $_out;

        }

        /** 
         * manage_extras
         * 
         * The method is responsible for properly setting up the "extras" options
         * 
         * @since 7.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin's Security Header Generator
         * 
         * @param array $_extras The extras array
         * 
         * @return array Returns array of options
         * 
        */
        protected function manage_extras( string $_item ) : array {

            // setup a returnable array
            $_ret = array( );

            // if the item does not need inline or eval
            if( $_item != 'generate_csp_custom_baseuri' ) {
                $_ret[1] = __( 'Inline', 'security-header-generator' );
                $_ret[2] = __( 'Eval', 'security-header-generator' );
            }

            // by default all items need these
            $_ret[0] = __( 'Self', 'security-header-generator' );
            $_ret[3] = __( 'None', 'security-header-generator' );

            // return the array
            return $_ret;

        }
    
    }

}
