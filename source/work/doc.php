<?php

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// check user capabilities
if( ! current_user_can( 'manage_options' ) ) {
    return;
}
?>

<style type="text/css">
    .the_list {
        margin-left: 25px;
    }
</style>
    <p><?php _e( 'This plugin generates the proper security HTTP response headers and generates a Content Security Policy if configured to do so', 'security-header-generator' ); ?>.</p>
    <h3 id="install"><?php _e( 'Install', 'security-header-generator' ); ?></h3>
    <ul class="the_list">
        <li><?php _e( 'Download the plugin, unzip it, and upload to your sites', 'security-header-generator' ); ?> `/wp-content/plugins/` <?php _e( 'directory', 'security-header-generator' ); ?>
            <ul class="the_list">
                <li><?php _e( 'You can also upload it directly to your Plugins admin', 'security-header-generator' ); ?></li>
            </ul>
        </li>
        <li><?php _e( 'Activate the plugin through the \'Plugins\' menu in WordPress', 'security-header-generator' ); ?></li>
    </ul>
    <h3 id="usage"><?php _e( 'Usage', 'security-header-generator' ); ?></h3>
    <p><?php _e( 'Head over to the admin section of your site and click &quot;Security Headers&quot;, configure how you need it to be configured.  The configured headers will automatically be implemented.', 'security-header-generator' ); ?></p>
    <h3 id="settings"><?php _e( 'GOTCHA', 'security-header-generator' ); ?></h3>
    <p><?php _e( 'If your hosting environment is already setting these headers, most likely your settings in this plugin will <strong>NOT</strong> get overwritten with the values you specify', 'security-header-generator' ); ?>.</p>
    <p><?php _e( 'If this is indeed the case, please check with your hosting company if they are, or check your server configuration for the headers getting set.  The plugin will do it\'s best to override them, but in some environments this is just not possible', 'security-header-generator' ); ?>.</p>
    <h3 id="settings"><?php _e( 'Settings', 'security-header-generator' ); ?></h3>
    <ul class="the_list">
        <li><h3><?php _e( 'Standard Security Tab', 'security-header-generator' ); ?></h3>
            <ul class="the_list">
            <li>
                    <strong><?php _e( 'Apply to Admin', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li><?php _e( 'Select yes or no to apply these same headers to the admin side of your site', 'security-header-generator' ); ?>.</li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Apply to the REST API', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li><?php _e( 'Select yes or no to apply these same headers to the REST API of your site. <strong>NOTE:</strong> Due to the default nature of the REST API, the headers will also be applied to the admin areas of the website. You will need to check for breakages after applying.', 'security-header-generator' ); ?>.</li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Strict Transport Security', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Select Yes or No to have the plugin include the Strict Transport Security header to your site', 'security-header-generator' ); ?>.
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'See here for more information', 'security-header-generator' ); ?>:
                                    <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'Configure the directives accordingly', 'security-header-generator' ); ?>.
                            <ul class="the_list">
                                <li><?php _e( 'Cache Age: How long should browsers force HTTPS access for, in seconds', 'security-header-generator' ); ?>.</li>
                                <li><?php _e( 'Include Subdomains: Include all subdomains in this rule', 'security-header-generator' ); ?>?</li>
                                <li><?php _e( 'Preload: This is a Google specification. See here for more information:', 'security-header-generator' ); ?> <a href="https://hstspreload.org/" target="_blank">https://hstspreload.org/</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Frame Sources', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Select Yes or No to have the plugin add a header to configure frame sources', 'security-header-generator' ); ?>.
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'See here for more information', 'security-header-generator' ); ?>: <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'Configure the directive to either decline all framing, or only allow SAMEORIGIN framing', 'security-header-generator' ); ?>.
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Access Control Methods', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Select Yes or No to have the plugin add a header to allow an access control method list.', 'security-header-generator' ); ?>.
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'See here for more information', 'security-header-generator' ); ?>: <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Methods">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Methods</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'Select the appropriate HTTP methods to allow to access the site. Selecting "Allow All" will check or uncheck all methods. Default: GET, POST, HEAD', 'security-header-generator' ); ?>.
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Access Control Credentials', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Select Yes or No to have the plugin add a header to allow access control credentials.', 'security-header-generator' ); ?>.
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'See here for more information', 'security-header-generator' ); ?>: <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Credentials">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Credentials</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'Selecting Yes will allow the browser to allow credentials to be set with Javascript, useful for JS driven API calls. Default: Yes', 'security-header-generator' ); ?>.
                        </li>
                    </ul>
                </li>


                <li>
                    <strong><?php _e( 'Access Control Origin', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Select Yes or No to have the plugin add a header to allow an access control origin.', 'security-header-generator' ); ?>.
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'See here for more information', 'security-header-generator' ); ?>: <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'Configure the directive to either add an origin FQDN URL to allow, or use an <code>*</code> to allow all', 'security-header-generator' ); ?>.
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Prevent MimeType Sniffing', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Select Yes or No to have the plugin add a header to prevent mime-type sniffing', 'security-header-generator' ); ?>.
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'See here for more information', 'security-header-generator' ); ?>:
                                    <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Content-Type-Options">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Content-Type-Options</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Origin Referrers', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Select Yes or No to have the plugin add a header to allow only origin referrers', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'See here for more information', 'security-header-generator' ); ?>: <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referrer-Policy">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referrer-Policy</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'Select Referrer Policy to send', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li><?php _e( 'No Referrer: The Referer header will be omitted entirely. No referrer information is sent along with requests', 'security-header-generator' ); ?>.</li>
                                <li><?php _e( 'Origin Only: Only send the origin of the document as the referrer', 'security-header-generator' ); ?>.</li>
                                <li><?php _e( 'Same Origin: A referrer will be sent for same-site origins, but cross-origin requests will send no referrer information', 'security-header-generator' ); ?>.</li>
                                <li><?php _e( 'Strict Origin on Cross Domain: Send the origin, path, and querystring when performing a same-origin request, only send the origin when the protocol security level stays the same while performing a cross-origin request', 'security-header-generator' ); ?></li>
                                <li><?php _e( 'No Referrer on Downgrade: The origin, path, and querystring of the URL are sent as a referrer when the protocol security level stays the same', 'security-header-generator' ); ?></li>
                                <li><?php _e( 'Origin on Cross Domain: Send the origin, path, and query string when performing a same-origin request, but only send the origin of the document for other cases', 'security-header-generator' ); ?>.</li>
                                <li><?php _e( 'Strict Origin: Only send the origin of the document as the referrer when the protocol security level stays the same', 'security-header-generator' ); ?></li>
                                <li><?php _e( 'Full Referrer: Send the origin, path, and query string when performing any request, regardless of security', 'security-header-generator' ); ?>.</li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Force Downloads', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Select Yes or No to have the plugin add a header to attempt to force downloading resources instead of directly openning them in the browser', 'security-header-generator' ); ?>.
                            <ul class="the_list">
                                <li><?php _e( 'See here for more information', 'security-header-generator' ); ?>: <a target="_blank" href="https://www.nwebsec.com/HttpHeaders/SecurityHeaders/XDownloadOptions">https://www.nwebsec.com/HttpHeaders/SecurityHeaders/XDownloadOptions</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Cross Domain Origins', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Select Yes or No to have the plugin add a header to block cross domain origins. This generally is only', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'See here for more information', 'security-header-generator' ); ?>: <a target="_blank" href="https://webtechsurvey.com/response-header/x-permitted-cross-domain-policies">https://webtechsurvey.com/response-header/x-permitted-cross-domain-policies</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Upgrade Insecure Requests', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Select Yes or No to have the plugin add a header to upgrade insecure requests', 'security-header-generator' ); ?>.
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'See here for more information', 'security-header-generator' ); ?>:
                                    <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Upgrade-Insecure-Requests">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Upgrade-Insecure-Requests</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Cross Origin Embedder Policy', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Select Yes or No to have the plugin include the Cross-Origin-Embedder-Policy header to your site', 'security-header-generator' ); ?>.
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'See here for more information', 'security-header-generator' ); ?>:
                                    <a target="_blank" href="https://owasp.org/www-project-secure-headers/#cross-origin-embedder-policy">https://owasp.org/www-project-secure-headers/#cross-origin-embedder-policy</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'Configure the directives accordingly', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li>unsafe-none: <?php _e( 'Allows the document to fetch cross-origin resources without giving explicit permission through the CORS protocol or the Cross-Origin-Resource-Policy header', 'security-header-generator' ); ?>.</li>
                                <li>require-corp: <?php _e( 'Forces the document to only load resources from the same origin, or resources explicitly marked as loadable from another origin.', 'security-header-generator' ); ?>.</li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Cross Origin Resource Policy', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Select Yes or No to have the plugin include the Cross-Origin-Resource-Policy header to your site', 'security-header-generator' ); ?>.
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'See here for more information', 'security-header-generator' ); ?>:
                                    <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Cross-Origin_Resource_Policy">https://developer.mozilla.org/en-US/docs/Web/HTTP/Cross-Origin_Resource_Policy</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'Configure the directives accordingly', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li>same-site: <?php _e( 'Only requests from the same Site can read the resource.', 'security-header-generator' ); ?>.</li>
                                <li>same-origin: <?php _e( 'Only requests from the same origin (i.e. scheme + host + port) can read the resource.', 'security-header-generator' ); ?>.</li>
                                <li>cross-origin: <?php _e( 'Requests from any origin (both same-site and cross-site) can read the resource. This is useful when COEP is used.', 'security-header-generator' ); ?>.</li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Cross Origin Opener Policy', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Select Yes or No to have the plugin include the Cross-Origin-Opener-Policy header to your site', 'security-header-generator' ); ?>.
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'See here for more information', 'security-header-generator' ); ?>:
                                    <a target="_blank" href="https://owasp.org/www-project-secure-headers/#cross-origin-opener-policy">https://owasp.org/www-project-secure-headers/#cross-origin-opener-policy</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'Configure the directives accordingly', 'security-header-generator' ); ?>.
                            <ul class="the_list">
                                <li>unsafe-none: <?php _e( 'Allows the document to be added to its opener’s browsing context group unless the opener itself has a COOP of same-origin or same-origin-allow-popups', 'security-header-generator' ); ?>.</li>
                                <li>same-origin-allow-popups: <?php _e( 'Retains references to newly opened windows or tabs which either don’t set COOP or which opt out of isolation by setting a COOP of unsafe-none', 'security-header-generator' ); ?>.</li>
                                <li>same-origin: <?php _e( 'Isolates the browsing context exclusively to same-origin documents. Cross-origin documents are not loaded in the same browsing context', 'security-header-generator' ); ?>.</li>
                            </ul>
                        </li>
                    </ul>
                </li>

            </ul>
        </li>
        <li><h3><?php _e( 'Content Security Policy Tab', 'security-header-generator' ); ?></h3>
            <ul class="the_list">
                <li>
                    <strong><?php _e( 'Content Security Policy', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Select Yes or No to have the plugin attempt to automatically generate a Content Security Policy. Selecting Yes, will open up a handful of text fields that you can add additional domains to. Please only include the FQDN, and please organize them accordingly', 'security-header-generator' ); ?>.
                            <ul class="the_list">
                                <li><?php _e( 'Use a space-delimited list if you need add more than one additional domain', 'security-header-generator' ); ?>.</li>
                            </ul>
                        </li>
                        <li><p><?php _e( 'This will attempt to parse the enqueued styles and scripts for the front-end of your site automatically, provided your theme has properly done this', 'security-header-generator' ); ?>.</p></li>
                        <li>
                            <p><?php _e( 'This will add 2 additional headers to your site', 'security-header-generator' ); ?>. Content-Security-Policy <?php _e( 'and', 'security-header-generator' ); ?> X-Content-Security-Policy, <?php _e( 'configured with the detected and custom added domains to their respective content types', 'security-header-generator' ); ?>.</p>
                        </li>
                        <li><?php _e( 'See here for more information', 'security-header-generator' ); ?>: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP</a></li>
                    </ul>
                    <li>
                    <strong><?php _e( 'Wordpress Defaults', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Select Yes or No to have the plugin automatically include Wordpress specific external resources in the Content Security Policy', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li><?php _e( 'I have left this as an unconditional field. There may be a point in we browsers futures where it may have a use other than just the CSP', 'security-header-generator' ); ?></li>
                                <li>
                                    <ul class="the_list">
                                        <li>img-src: *.googletagmanager.com *.w.org *.gravatar.com *.google.com *.google-analytics.com *.gstatic.com</li>
                                        <li>script-src: *.g.doubleclick.net *.google-analytics.com *.google.com *.googletagmanager.com *.gstatic.com</li>
                                        <li>style-src: *.googleapis.com *.gstatic.com</li>
                                        <li>font-src: *.gstatic.com *.bootstrapcdn.com</li>
                                        <li>frame-src: *.g.doubleclick.net *.google.com *.fls.doubleclick.net</li>
                                        <li>connect-src: *.google-analytics.com *.wpengine.com yoast.com *.google.com *.g.doubleclick.net</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <strong><?php _e( 'Apply to Admin', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li><?php _e( 'Select yes or no to apply these same headers to the admin side of your site', 'security-header-generator' ); ?>.</li>
                    </ul>

                    <strong><?php _e( 'CSP Header Directives', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                    <?php

                        // the directives
                        $_directives = KCP_CSPGEN_Common::get_csp_directives( );
                        
                        // loop them
                        foreach( $_directives as $_k => $_v ) {

                            ?>
                            <li>
                                <strong><?php _e( 'Name', 'security-header-generator' ); ?>:</strong> <?php _e( $_k ); ?><br />
                                <?php _e( $_v['desc'] ); ?>
                            </li>
                            <?php

                        }

                    ?>
                    </ul>
                </li>
            </ul>
        </li>
        <li><h3><?php _e( 'Permissions Policy Tab', 'security-header-generator' ); ?></h3>
            <ul class="the_list">
                <li>
                    <?php _e( 'Select Yes or No to have the plugin attempt to automatically generate a Permissions Policy. Selecting Yes, will open up a handful of directives and the sources for them.  If you select "Source" for any of them you will be allowed to enter a space-delimited list of URL\'s to be allowed as sources', 'security-header-generator' ); ?>.
                    <ul class="the_list">
                        <li><?php _e( 'Please make sure to use full URL\'s for the sources including the protocol used. (example', 'security-header-generator' ); ?>: https://kevinpirnie.com)</li>
                    </ul>
                </li>
                <li><?php _e( 'See here for more information', 'security-header-generator' ); ?>: <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Feature-Policy" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Feature-Policy</a></li>
            </ul>
            <strong><?php _e( 'Apply to Admin', 'security-header-generator' ); ?></strong>
            <ul class="the_list">
                <li><?php _e( 'Select yes or no to apply these same headers to the admin side of your site', 'security-header-generator' ); ?>.</li>
            </ul>
            <strong><?php _e( 'Permission/Feature Policy Directives', 'security-header-generator' ); ?></strong>
            <ul class="the_list">
            <?php

                // the directives
                $_directives = KCP_CSPGEN_Common::get_permissions_directives( );
                
                // loop them
                foreach( $_directives as $_k => $_v ) {

                    ?>
                    <li>
                        <strong><?php _e( 'Name', 'security-header-generator' ); ?>:</strong> <?php _e( $_k ); ?><br />
                        <?php _e( $_v['desc'] ); ?>
                    </li>
                    <?php

                }

            ?>
            </ul>
        </li>
    </ul>
