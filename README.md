# BUB Elementor Widgets

A professional collection of custom Elementor widgets to enhance your website building experience.

## Description

BUB Elementor Widgets is a modular plugin that provides a collection of powerful, customizable widgets for Elementor page builder. Each widget can be enabled or disabled individually to optimize your site's performance.

## Features

- ✅ **Modular Architecture** - Enable/disable widgets individually
- ✅ **Beautiful Settings Page** - Easy-to-use interface for managing widgets
- ✅ **Performance Optimized** - Only load what you need
- ✅ **Developer Friendly** - Easy to extend with new widgets
- ✅ **Clean Code** - Follows WordPress and PHP best practices
- ✅ **Well Documented** - Extensive inline documentation

## Requirements

- WordPress 5.8 or higher
- Elementor 3.0.0 or higher
- PHP 7.4 or higher

## Installation

1. Upload the `bub-elementor-widgets` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to **BUB Widgets** in the WordPress admin menu to enable/disable widgets
4. Start using the widgets in Elementor!

## Available Widgets

### Info Box
Display information in a stylish box with icon, title, and description.

**Features:**
- Customizable icon (supports icon libraries)
- Flexible icon positioning (top, left, right)
- Customizable title with HTML tag selection
- Rich text description
- Optional link (whole box or button)
- Full styling controls
- Responsive design

## Settings Page

Access the settings page from **WordPress Admin > BUB Widgets**

The settings page allows you to:
- Enable or disable individual widgets
- Enable/disable all widgets at once
- View widget descriptions and features
- Access demo links (when available)

## Adding New Widgets

This plugin is designed to make adding new widgets easy. Follow these steps:

### 1. Create Widget File

Create a new widget file in the `widgets/` directory:

```php
<?php
namespace BUB_Elementor_Widgets\Widgets;

use BUB_Elementor_Widgets\Abstracts\Base_Widget;

class Your_Widget extends Base_Widget {
    // Your widget code here
}
```

### 2. Register Widget

Add your widget to the `$available_widgets` array in `includes/class-widgets-manager.php`:

```php
'your-widget' => array(
    'title'       => esc_html__( 'Your Widget', 'bub-elementor-widgets' ),
    'description' => esc_html__( 'Description of your widget.', 'bub-elementor-widgets' ),
    'class'       => 'Your_Widget',
    'file'        => 'your-widget.php',
    'icon'        => 'eicon-info-box',
    'is_pro'      => false,
),
```

### 3. Add Widget Styles (Optional)

Add your custom styles to `assets/css/frontend.css`

### 4. Add Widget JavaScript (Optional)

Add your custom JavaScript to `assets/js/frontend.js` and register the handler:

```javascript
elementorFrontend.hooks.addAction(
    'frontend/element_ready/bub-your-widget.default',
    YourWidgetHandler
);
```

## File Structure

```
bub-elementor-widgets/
├── assets/
│   ├── css/
│   │   ├── admin.css        # Admin settings page styles
│   │   └── frontend.css     # Frontend widget styles
│   └── js/
│       ├── admin.js         # Admin settings page scripts
│       ├── editor.js        # Elementor editor scripts
│       └── frontend.js      # Frontend widget scripts
├── includes/
│   ├── abstracts/
│   │   └── class-base-widget.php    # Base widget class
│   ├── class-plugin.php             # Main plugin class
│   ├── class-settings.php           # Settings page handler
│   └── class-widgets-manager.php    # Widgets registration manager
├── widgets/
│   └── info-box.php                 # Info Box widget
├── bub-elementor-widgets.php        # Main plugin file
└── README.md                        # This file
```

## Hooks & Filters

### Filters

#### `bub_elementor_widgets_available`
Modify the available widgets array.

```php
add_filter( 'bub_elementor_widgets_available', function( $widgets ) {
    // Add or modify widgets
    return $widgets;
});
```

### Actions

All standard WordPress and Elementor actions are available.

## Coding Standards

This plugin follows:
- WordPress Coding Standards
- PHP best practices
- ES6 JavaScript standards
- BEM methodology for CSS

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## Support & Documentation

For support, please visit:
- Plugin Documentation: [Your documentation URL]
- Support Forum: [Your support URL]

## Changelog

### Version 1.0.0
- Initial release
- Added Info Box widget
- Settings page with enable/disable functionality
- Modular architecture for easy widget additions

## Credits

Developed by BUB

## License

GPL v2 or later

