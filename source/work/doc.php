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
    .technical-section {
        margin-top: 40px;
        padding-top: 30px;
        border-top: 3px solid #2271b1;
    }
    .technical-section h3 {
        color: #2271b1;
    }
</style>
    <p><?php _e( 'This plugin generates the proper security HTTP response headers and generates a Content Security Policy if configured to do so', 'security-header-generator' ); ?>.</p>
    
    <h3 id="install"><?php _e( 'Install', 'security-header-generator' ); ?></h3>
    <ul class="the_list">
        <li><?php _e( 'Download the plugin, unzip it, and upload to your sites', 'security-header-generator' ); ?> <code>/wp-content/plugins/</code> <?php _e( 'directory', 'security-header-generator' ); ?>
            <ul class="the_list">
                <li><?php _e( 'You can also upload it directly to your Plugins admin', 'security-header-generator' ); ?></li>
            </ul>
        </li>
        <li><?php _e( 'Activate the plugin through the "Plugins" menu in WordPress', 'security-header-generator' ); ?></li>
    </ul>
    
    <h3 id="usage"><?php _e( 'Usage', 'security-header-generator' ); ?></h3>
    <p><?php _e( 'Head over to the admin section of your site and click "Security Headers", configure how you need it to be configured. The configured headers will automatically be implemented.', 'security-header-generator' ); ?></p>
    
    <h3 id="gotcha"><?php _e( 'IMPORTANT: Hosting Environment Considerations', 'security-header-generator' ); ?></h3>
    <p><?php _e( 'If your hosting environment is already setting these headers, most likely your settings in this plugin will <strong>NOT</strong> override the values you specify', 'security-header-generator' ); ?>.</p>
    <p><?php _e( 'If this is the case, please check with your hosting company or review your server configuration for headers being set. The plugin will do its best to override them, but in some environments this is just not possible', 'security-header-generator' ); ?>.</p>
    
    <h3 id="settings"><?php _e( 'Settings Overview', 'security-header-generator' ); ?></h3>
    
    <ul class="the_list">
        <li><h3><?php _e( 'Standard Security Headers Tab', 'security-header-generator' ); ?></h3>
            <p><?php _e( 'This tab controls the basic security headers that protect your website from common attacks and vulnerabilities.', 'security-header-generator' ); ?></p>
            <ul class="the_list">
                <li>
                    <strong><?php _e( 'Apply to Admin', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li><?php _e( 'Choose whether to apply these security headers to the WordPress admin area in addition to your public-facing website. Enabling this provides protection for your admin panel as well.', 'security-header-generator' ); ?></li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Apply to the REST API', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li><?php _e( 'Choose whether to apply these headers to your WordPress REST API. <strong>NOTE:</strong> Because of how WordPress works, enabling this will also apply headers to the admin areas. Test thoroughly after enabling to ensure nothing breaks.', 'security-header-generator' ); ?></li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Strict Transport Security', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'This forces browsers to only access your site over HTTPS (secure connections), preventing downgrade attacks where someone might try to force an insecure HTTP connection.', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'Learn more:', 'security-header-generator' ); ?>
                                    <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'Configuration options:', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li><strong><?php _e( 'Cache Age:', 'security-header-generator' ); ?></strong> <?php _e( 'How long (in seconds) browsers should remember to only use HTTPS. Default is 31536000 (1 year).', 'security-header-generator' ); ?></li>
                                <li><strong><?php _e( 'Include Subdomains:', 'security-header-generator' ); ?></strong> <?php _e( 'Apply this rule to all subdomains (like blog.yoursite.com, shop.yoursite.com). Only enable if ALL your subdomains use HTTPS.', 'security-header-generator' ); ?></li>
                                <li><strong><?php _e( 'Preload:', 'security-header-generator' ); ?></strong> <?php _e( 'Submit your site to browsers\' preload lists for maximum security. If enabled, change Cache Age to 63072000 (2 years). Learn more:', 'security-header-generator' ); ?> <a href="https://hstspreload.org/" target="_blank">https://hstspreload.org/</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Frame Sources', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Controls whether other websites can display your site in an iframe or frame. This prevents "clickjacking" attacks where attackers trick users by embedding your site invisibly.', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'Learn more:', 'security-header-generator' ); ?>
                                    <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'Options:', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li><strong>DENY:</strong> <?php _e( 'Block all websites from framing your site (most secure)', 'security-header-generator' ); ?></li>
                                <li><strong>SAMEORIGIN:</strong> <?php _e( 'Only allow your own domain to frame your site (useful if you need iframes on your own site)', 'security-header-generator' ); ?></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Access Control Methods', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Controls which HTTP request methods (like GET, POST, etc.) external websites can use when accessing your site. This is useful for API security.', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'Learn more:', 'security-header-generator' ); ?>
                                    <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Methods">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Methods</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'Select which methods to allow. Most public websites need at least GET (for viewing pages). Clicking "Allow All" will check or uncheck all options. <strong>Note:</strong> Unselected methods will be blocked.', 'security-header-generator' ); ?>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Access Control Credentials', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Allows browsers to send cookies and authentication information when JavaScript makes requests to your site. Useful for AJAX-based features and API calls that require user authentication.', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'Learn more:', 'security-header-generator' ); ?>
                                    <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Credentials">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Credentials</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'Default is Yes. Most modern websites need this enabled for JavaScript-driven features to work properly.', 'security-header-generator' ); ?>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Access Control Origin', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Specifies which external websites can access your site\'s resources. This helps prevent unauthorized cross-site requests.', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'Learn more:', 'security-header-generator' ); ?>
                                    <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'Enter a specific domain (like <code>https://example.com</code>) or use <code>*</code> to allow all domains. If left empty, defaults to <code>*</code>.', 'security-header-generator' ); ?>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Prevent MimeType Sniffing', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Stops browsers from trying to "guess" the type of files you serve. This prevents attackers from disguising malicious files as safe ones.', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'Learn more:', 'security-header-generator' ); ?>
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
                            <?php _e( 'Controls how much information about your site is shared when users click links to external websites. This protects user privacy.', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'Learn more:', 'security-header-generator' ); ?>
                                    <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referrer-Policy">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referrer-Policy</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'Policy options (from most private to least private):', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li><strong>no-referrer:</strong> <?php _e( 'Share no information at all', 'security-header-generator' ); ?></li>
                                <li><strong>strict-origin:</strong> <?php _e( 'Only share your domain name, only on secure (HTTPS) connections (recommended)', 'security-header-generator' ); ?></li>
                                <li><strong>origin:</strong> <?php _e( 'Only share your domain name', 'security-header-generator' ); ?></li>
                                <li><strong>same-origin:</strong> <?php _e( 'Share full URL within your own site, but only domain for external sites', 'security-header-generator' ); ?></li>
                                <li><strong>strict-origin-when-cross-origin:</strong> <?php _e( 'Share full URL on your site, domain only for external sites (on secure connections)', 'security-header-generator' ); ?></li>
                                <li><strong>origin-when-cross-origin:</strong> <?php _e( 'Share full URL on your site, domain only for external sites', 'security-header-generator' ); ?></li>
                                <li><strong>no-referrer-when-downgrade:</strong> <?php _e( 'Share full URL except when moving from HTTPS to HTTP', 'security-header-generator' ); ?></li>
                                <li><strong>unsafe-url:</strong> <?php _e( 'Always share full URL (least private)', 'security-header-generator' ); ?></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Force Downloads', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Forces certain files to be downloaded rather than opened directly in the browser. This adds an extra layer of security for file handling.', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li><?php _e( 'Learn more:', 'security-header-generator' ); ?> <a target="_blank" href="https://www.nwebsec.com/HttpHeaders/SecurityHeaders/XDownloadOptions">https://www.nwebsec.com/HttpHeaders/SecurityHeaders/XDownloadOptions</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Cross Domain Origins', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Blocks cross-domain access for PDFs and Flash content embedded on your site. This prevents certain types of attacks using these file types.', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'Learn more:', 'security-header-generator' ); ?>
                                    <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Permitted-Cross-Domain-Policies">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Permitted-Cross-Domain-Policies</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Upgrade Insecure Requests', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Automatically upgrades all insecure (HTTP) requests to secure (HTTPS) requests. This ensures all resources load securely even if old links reference HTTP.', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'Learn more:', 'security-header-generator' ); ?>
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
                            <?php _e( 'Controls how your site can embed resources from other domains. This prevents certain types of attacks involving embedded content.', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'Learn more:', 'security-header-generator' ); ?>
                                    <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cross-Origin-Embedder-Policy">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cross-Origin-Embedder-Policy</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'Options:', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li><strong>unsafe-none:</strong> <?php _e( 'Allow embedding external resources without explicit permission (default, less secure)', 'security-header-generator' ); ?></li>
                                <li><strong>require-corp:</strong> <?php _e( 'Only allow resources explicitly marked as embeddable (more secure, may require configuration)', 'security-header-generator' ); ?></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Cross Origin Resource Policy', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Controls which websites can load resources (images, scripts, etc.) from your site. This prevents unauthorized use of your content.', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'Learn more:', 'security-header-generator' ); ?>
                                    <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Cross-Origin_Resource_Policy">https://developer.mozilla.org/en-US/docs/Web/HTTP/Cross-Origin_Resource_Policy</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'Options:', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li><strong>same-origin:</strong> <?php _e( 'Only your exact domain can use your resources (most secure)', 'security-header-generator' ); ?></li>
                                <li><strong>same-site:</strong> <?php _e( 'Your domain and subdomains can use your resources', 'security-header-generator' ); ?></li>
                                <li><strong>cross-origin:</strong> <?php _e( 'Any website can use your resources (least secure)', 'security-header-generator' ); ?></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Cross Origin Opener Policy', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Controls whether other websites can access your site when opened in popups or new tabs. This prevents certain cross-site attacks.', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li>
                                    <?php _e( 'Learn more:', 'security-header-generator' ); ?>
                                    <a target="_blank" href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cross-Origin-Opener-Policy">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cross-Origin-Opener-Policy</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'Options:', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li><strong>unsafe-none:</strong> <?php _e( 'Allow normal popup/tab behavior (default)', 'security-header-generator' ); ?></li>
                                <li><strong>same-origin-allow-popups:</strong> <?php _e( 'Allow popups but isolate from other origins', 'security-header-generator' ); ?></li>
                                <li><strong>same-origin:</strong> <?php _e( 'Complete isolation from other origins (most secure)', 'security-header-generator' ); ?></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        
        <li><h3><?php _e( 'Content Security Policy Tab', 'security-header-generator' ); ?></h3>
            <p><?php _e( 'Content Security Policy (CSP) is an advanced security feature that controls which external resources your website can load. This prevents many types of attacks including Cross-Site Scripting (XSS).', 'security-header-generator' ); ?></p>
            <ul class="the_list">
                <li>
                    <strong><?php _e( 'Generate CSP', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Enable this to create a Content Security Policy for your site. This will show many additional fields where you can specify which external resources (scripts, styles, images, etc.) are allowed to load.', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li><?php _e( 'Enter external domains in the Source fields using a space-separated list (example: <code>cdn.example.com fonts.google.com</code>)', 'security-header-generator' ); ?></li>
                                <li><?php _e( 'Learn more:', 'security-header-generator' ); ?> <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Apply to Admin', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li><?php _e( 'Choose whether to apply the Content Security Policy to your WordPress admin area as well as the public site. <strong>Warning:</strong> This may break admin features if not configured correctly. Test thoroughly.', 'security-header-generator' ); ?></li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Include WordPress Defaults', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'This toggle controls whether WordPress default domains are <strong>added to</strong> your custom values. It does NOT replace your custom settings.', 'security-header-generator' ); ?>
                        </li>
                        <li>
                            <?php _e( 'How it works:', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li><strong><?php _e( 'When ON:', 'security-header-generator' ); ?></strong> <?php _e( 'Your custom domains PLUS WordPress default domains are included in the CSP', 'security-header-generator' ); ?></li>
                                <li><strong><?php _e( 'When OFF:', 'security-header-generator' ); ?></strong> <?php _e( 'Only your custom domains are included in the CSP', 'security-header-generator' ); ?></li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'WordPress default domains that will be added when enabled:', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li><strong>style-src:</strong> <code>https: *.googleapis.com</code></li>
                                <li><strong>script-src:</strong> <code>https: *.googleapis.com *.gstatic.com</code></li>
                                <li><strong>font-src:</strong> <code>data: https: *.gstatic.com</code></li>
                                <li><strong>img-src:</strong> <code>data: https: *.gravatar.com *.wordpress.org s.w.org</code></li>
                                <li><strong>connect-src:</strong> <code>https:</code></li>
                                <li><strong>frame-src:</strong> <code>https: *.youtube.com *.vimeo.com</code></li>
                                <li><strong>media-src:</strong> <code>https: s.w.org</code></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Understanding CSP Directive Configuration', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li><?php _e( 'Each CSP directive (like script-src, style-src, etc.) has two configuration sections:', 'security-header-generator' ); ?></li>
                        <li>
                            <strong>1. <?php _e( 'Source Field (Left Side):', 'security-header-generator' ); ?></strong>
                            <ul class="the_list">
                                <li><?php _e( 'Enter external domains that should be allowed for this type of resource', 'security-header-generator' ); ?></li>
                                <li><?php _e( 'Example for scripts: <code>cdn.jsdelivr.net ajax.googleapis.com</code>', 'security-header-generator' ); ?></li>
                                <li><?php _e( 'Separate multiple domains with spaces', 'security-header-generator' ); ?></li>
                            </ul>
                        </li>
                        <li>
                            <strong>2. <?php _e( 'Extra Settings Checkboxes (Right Side):', 'security-header-generator' ); ?></strong>
                            <ul class="the_list">
                                <li><strong>Self:</strong> <?php _e( 'Allow resources from your own domain (recommended for most directives)', 'security-header-generator' ); ?></li>
                                <li><strong>Inline:</strong> <?php _e( 'Allow inline styles/scripts embedded in your HTML. <strong>Warning:</strong> This reduces security and should only be used if necessary.', 'security-header-generator' ); ?></li>
                                <li><strong>Eval:</strong> <?php _e( 'Allow JavaScript eval() function. <strong>Warning:</strong> This reduces security and should only be used if necessary.', 'security-header-generator' ); ?></li>
                                <li><strong>None:</strong> <?php _e( 'Block ALL sources for this directive (overrides everything else). Use this to completely disable a resource type.', 'security-header-generator' ); ?></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'How WordPress Defaults Toggle Affects Settings', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li><?php _e( 'When you turn WordPress Defaults ON:', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li><?php _e( 'WordPress default domains are ADDED to your Source field values', 'security-header-generator' ); ?></li>
                                <li><?php _e( 'Extra Settings checkboxes are temporarily set (usually "Self" is checked)', 'security-header-generator' ); ?></li>
                                <li><?php _e( 'Your original checkbox selections are saved in the background', 'security-header-generator' ); ?></li>
                            </ul>
                        </li>
                        <li><?php _e( 'When you turn WordPress Defaults OFF:', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li><?php _e( 'WordPress default domains are removed', 'security-header-generator' ); ?></li>
                                <li><?php _e( 'Your original Extra Settings checkbox selections are restored', 'security-header-generator' ); ?></li>
                            </ul>
                        </li>
                        <li>
                            <strong><?php _e( 'Important:', 'security-header-generator' ); ?></strong> <?php _e( 'Changes only take effect when you click "Save Settings". Toggling WordPress Defaults on/off without saving will not permanently change your configuration.', 'security-header-generator' ); ?>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        
        <li><h3><?php _e( 'Permissions Policy Tab', 'security-header-generator' ); ?></h3>
            <p><?php _e( 'Permissions Policy (formerly Feature Policy) controls which browser features and APIs your website and embedded content can use. This prevents malicious scripts from accessing sensitive features like camera, microphone, or geolocation.', 'security-header-generator' ); ?></p>
            <ul class="the_list">
                <li>
                    <strong><?php _e( 'Configure Permissions Policy', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li>
                            <?php _e( 'Enable this to control browser feature permissions. For each feature, you can choose:', 'security-header-generator' ); ?>
                            <ul class="the_list">
                                <li><strong>None:</strong> <?php _e( 'Block this feature completely', 'security-header-generator' ); ?></li>
                                <li><strong>Any:</strong> <?php _e( 'Allow from any domain (least secure)', 'security-header-generator' ); ?></li>
                                <li><strong>Self:</strong> <?php _e( 'Only allow from your own domain (recommended)', 'security-header-generator' ); ?></li>
                                <li><strong>Source:</strong> <?php _e( 'Allow from specific domains you list', 'security-header-generator' ); ?></li>
                            </ul>
                        </li>
                        <li>
                            <?php _e( 'If you select "Source", enter full URLs with protocol: <code>https://example.com https://trusted-site.com</code>', 'security-header-generator' ); ?>
                        </li>
                        <li><?php _e( 'Learn more:', 'security-header-generator' ); ?> <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Permissions-Policy" target="_blank">https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Permissions-Policy</a></li>
                    </ul>
                </li>
                <li>
                    <strong><?php _e( 'Apply to Admin', 'security-header-generator' ); ?></strong>
                    <ul class="the_list">
                        <li><?php _e( 'Choose whether to apply Permissions Policy to your WordPress admin area as well as the public site.', 'security-header-generator' ); ?></li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
    
    <div class="technical-section">
        <h3><?php _e( 'Technical Reference: CSP Directives', 'security-header-generator' ); ?></h3>
        <p><em><?php _e( 'This section provides technical details about each Content Security Policy directive. These are automatically generated based on the plugin configuration.', 'security-header-generator' ); ?></em></p>
        <ul class="the_list">
        <?php
            // the directives
            $_directives = KCP_CSPGEN_Common::get_csp_directives( );
            
            // loop them
            foreach( $_directives as $_k => $_v ) {
                ?>
                <li>
                    <strong><?php echo esc_html( $_k ); ?></strong><br />
                    <?php echo wp_kses_post( $_v['desc'] ); ?>
                </li>
                <?php
            }
        ?>
        </ul>
        
        <h3><?php _e( 'Technical Reference: Permissions Policy Directives', 'security-header-generator' ); ?></h3>
        <p><em><?php _e( 'This section provides technical details about each Permissions Policy directive. Note that browser support varies by directive.', 'security-header-generator' ); ?></em></p>
        <ul class="the_list">
        <?php
            // the directives
            $_directives = KCP_CSPGEN_Common::get_permissions_directives( );
            
            // loop them
            foreach( $_directives as $_k => $_v ) {
                ?>
                <li>
                    <strong><?php echo esc_html( $_k ); ?></strong><br />
                    <?php echo wp_kses_post( $_v['desc'] ); ?>
                </li>
                <?php
            }
        ?>
        </ul>
    </div>