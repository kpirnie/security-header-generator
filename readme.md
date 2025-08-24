# Security Header Generator

A comprehensive WordPress plugin that generates proper security HTTP response headers, creates Content Security Policy configurations, and sets browser permissions to help protect your website against various security threats.

## Description

The Security Header Generator plugin provides a simplified way to implement security headers for your WordPress website, helping to mitigate attacks such as Cross-Site Scripting (XSS), data injection, and other common web vulnerabilities. The plugin generates appropriate security HTTP response headers and attempts to create a valid Content Security Policy based on your site's configuration.

## Features

### Security Headers
- **Content Security Policy (CSP)** - Comprehensive CSP configuration with WordPress defaults
- **Cross-Origin Resource Policy (CORP)** - Control how resources are shared across origins
- **Permissions Policy** - Configure browser feature permissions
- **Access Control Headers** - CORS configuration support
- **Expect-CT Header** - Certificate Transparency enforcement
- **Upgrade Insecure Requests** - Force HTTPS connections

### Content Security Policy Directives
- Complete support for all modern CSP directives including:
  - `script-src`, `style-src`, `img-src`, `font-src`, `connect-src`
  - `child-src`, `manifest-src`, `object-src`, `worker-src`
  - `script-src-elem`, `script-src-attr`, `style-src-elem`, `style-src-attr`
  - `base-uri`, `sandbox`, and more
- Unsafe inline and unsafe eval settings for each directive
- WordPress defaults included for popular themes and plugins

### Browser Permissions
- Configure permissions for modern browser APIs:
  - Camera, microphone, geolocation
  - Accelerometer, gyroscope, magnetometer  
  - USB, serial, HID device access
  - Screen wake lock, idle detection
  - Web share, publickey credentials
  - And many more

### Additional Features
- **Export/Import Settings** - Backup and restore your configurations
- **Documentation** - Built-in help and guidance
- **REST API Support** - Apply CSP headers to WordPress REST API
- **Admin Separation** - Different header configurations for admin vs frontend
- **Server Identity Removal** - Remove server advertising headers

## Installation

### Method 1: WordPress Admin Dashboard
1. Navigate to **Plugins** > **Add New** in your WordPress dashboard
2. Search for "Security Header Generator"
3. Click **Install Now** and then **Activate**

### Method 2: Manual Installation
1. Download the plugin zip file
2. Upload and extract to `/wp-content/plugins/security-header-generator/`
3. Activate the plugin through the **Plugins** menu in WordPress

### Method 3: Upload via Admin
1. Download the plugin zip file
2. Go to **Plugins** > **Add New** > **Upload Plugin**
3. Choose the zip file and click **Install Now**
4. Activate the plugin

## Configuration

### Getting Started
1. After activation, navigate to the plugin settings in your WordPress dashboard
2. Start with the **Standard Security Header** tab to configure basic headers
3. Use the **Content Security Policy** tab to configure CSP directives
4. Check the **Documentation** tab for detailed guidance

### Content Security Policy Setup
Setting up CSP can be complex and requires careful attention:

1. **Initial Configuration**: Browse your website thoroughly and track all external resources
2. **Add Sources**: Include all legitimate sources in the plugin's CSP settings
3. **Test Thoroughly**: Save settings and test your site functionality
4. **Iterate**: Repeat the process multiple times to catch all resources
5. **Monitor**: Some external resources load their own dependencies that won't appear until parent resources are allowed

**Important**: CSP configuration may require multiple iterations. External resources like iframes, scripts, and stylesheets can pull in their own external dependencies that won't be visible until the parent items are properly configured.

### WordPress Defaults
The plugin includes optimized WordPress defaults compatible with:
- **Core WordPress** (versions 5.6.10+)
- **Popular Themes**: Twenty Twenty series
- **Popular Plugins**: Gravity Forms

## Requirements

- **WordPress**: 5.6.10 or higher
- **PHP**: 8.1 or higher (PHP 8.4 compatible)
- **WordPress Version Tested**: Up to 6.9

## Frequently Asked Questions

### Why do I need this plugin?
This plugin provides a simplified way to set security headers for your website, helping to mitigate various types of attacks and improve your site's security posture.

### What is a Content Security Policy?
A Content Security Policy is an added layer of security that helps detect and mitigate certain types of attacks, including Cross-Site Scripting (XSS) and data injection attacks.

### How can I ensure all requests are sent via HTTPS?
In the **Standard Security Header** tab, enable "upgrade insecure requests" and save your settings.

### Can I backup my settings?
Yes! Use the **Export/Import Settings** tab to backup and restore your configurations.

### Where can I find documentation?
Built-in documentation is available in the plugin settings under the **Documentation** tab.

## Support

### Community Support
For general support questions, please visit the [WordPress.org plugin support forum](https://wordpress.org/support/plugin/security-header-generator/).

### Professional Support
For complex CSP configurations or professional assistance, contact the developer at: https://kevp.us/contact

**Note**: Due to the complexity and time required for proper CSP configuration, individual CSP setup assistance cannot be provided through the WordPress.org support forums.

## Changelog Highlights

### Version 5.3.01 (Latest)
- ✅ WordPress Core 6.9 compatibility verified
- ⬆️ PHP 8.1 minimum requirement
- 🔄 Updated WordPress defaults
- 🐛 Fixed 'None' CSP setting functionality

### Version 5.2.99
- ➕ Added 'base-uri' directive
- ➖ Removed multisite functionality (was causing header application issues)
- 🔄 Renamed 'Allow Unsafe' to 'Extras'
- ➖ Removed 'report-to' directive (pending full browser support)

### Version 5.0.11
- ➕ Added 'sandbox' directive for CSP
- 🐛 Fixed CSP header application when no value is set
- ✅ PHP 8.3 compatibility verified

For complete changelog, see the plugin's WordPress.org page.

## Contributing

The Security Header Generator is open source software. Contributions are welcome!

- **Browse the code**: [Plugin Trac](https://plugins.trac.wordpress.org/browser/security-header-generator/)
- **SVN Repository**: [Security Header Generator SVN](https://plugins.svn.wordpress.org/security-header-generator/)
- **Development Log**: [RSS Feed](https://plugins.trac.wordpress.org/log/security-header-generator/?limit=100&mode=stop_on_copy&format=rss)

### Translation
Help translate the plugin into your language at [WordPress Translate](https://translate.wordpress.org/projects/wp-plugins/security-header-generator).

## Security

This plugin implements security best practices and is regularly updated to maintain compatibility with the latest WordPress versions and security standards. All headers and policies are implemented following current web security guidelines and MDN documentation.

## License

This plugin is licensed under the GPL v2 or later.

---

**Disclaimer**: Proper security header configuration requires careful planning and testing. Always test thoroughly in a staging environment before applying to production sites. The complexity of Content Security Policy means multiple iterations may be required to achieve full compatibility with your site's resources.