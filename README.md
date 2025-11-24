# BP Elementor Widgets

A professional collection of custom Elementor widgets to enhance your website building experience.

## Description

BP Elementor Widgets is a modular plugin that provides a collection of powerful, customizable widgets for Elementor page builder. Each widget can be enabled or disabled individually to optimize your site's performance.

## Features

### Core Features
- ✅ **5 Powerful Widgets** - Countdown Timer, Gallery, Info Box, Read More, Testimonial
- ✅ **Modular Architecture** - Enable/disable widgets individually
- ✅ **Beautiful Settings Page** - Easy-to-use interface with alphabetically sorted widgets
- ✅ **Performance Optimized** - Only load what you need
- ✅ **Fully Responsive** - All widgets work perfectly on mobile, tablet, and desktop
- ✅ **Developer Friendly** - Easy to extend with new widgets
- ✅ **Clean Code** - Follows WordPress and PHP best practices
- ✅ **Well Documented** - Extensive inline documentation

### Technical Features
- ✅ **Modern Build System** - Gulp-based compilation with NPM commands
- ✅ **SCSS Styling** - Modular SCSS with variables and mixins
- ✅ **ES6 JavaScript** - Modern JavaScript with modular widget handlers
- ✅ **Font Awesome 6** - Beautiful icons for frontend widgets
- ✅ **Slick Carousel** - Smooth, responsive sliders
- ✅ **Elementor Native Integration** - Uses Elementor controls and features
- ✅ **No jQuery Conflicts** - Properly scoped and isolated code
- ✅ **Git Versioned** - Complete version control history

## Requirements

- WordPress 5.8 or higher
- Elementor 3.0.0 or higher
- PHP 7.4 or higher

## Installation

1. Upload the `bp-elementor-widgets` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to **BP Widgets** in the WordPress admin menu to enable/disable widgets
4. Start using the widgets in Elementor!

## Quick Start

1. **Enable Widgets**: Navigate to **WordPress Admin > BP Widgets**
2. **Toggle Widgets**: Click the switches to enable the widgets you want to use
3. **Edit with Elementor**: Edit any page with Elementor
4. **Find Widgets**: Search for "BP" in the widget panel or find them by name
5. **Drag & Drop**: Add widgets to your page and customize them!

### Widget Categories in Elementor

All BP widgets appear in the "BP Widgets" category in the Elementor panel for easy access.

## Available Widgets

### 1. Countdown Timer
Create urgency with a customizable countdown timer featuring recurring options.

**Features:**
- Set target date and time
- One-time or recurring countdown
- Recurring by days or hours
- Display Days, Hours, Minutes, Seconds
- Custom labels for each unit
- Two styles: Boxed and No Borders
- Auto-restart for recurring countdowns
- Shows zeros when countdown ends
- Fully responsive design
- Real-time JavaScript countdown

### 2. Gallery Carousel
Create beautiful image galleries with Slick Carousel and lightbox.

**Features:**
- Multiple images with gallery control
- Image size selection
- Aspect ratio control (1:1, 3:2, 4:3, 16:9, 21:9, custom)
- Two layouts: Default and Thumbnail Navigation
- Thumbnail navigation with overlay
- Lightbox support (Elementor native)
- Full Slick Carousel options (autoplay, speed, arrows, dots, infinite loop)
- Responsive breakpoints
- Navigation arrows with Font Awesome icons
- Customizable styling
- Smooth transitions

### 3. Info Box
Display information in a stylish box with icon, title, and description.

**Features:**
- Customizable icon (supports icon libraries)
- Flexible icon positioning (top, left, right)
- Customizable title with HTML tag selection
- Rich text description
- Optional link (whole box or button)
- Full styling controls
- Hover animations
- Responsive design

### 4. Read More
Collapsible content with a toggle button for long text.

**Features:**
- WYSIWYG content editor
- Adjustable collapsed height (50-500px)
- Optional fade effect overlay
- Customizable button text (Read More / Read Less)
- Button alignment (left/center/right)
- Auto-hide button for short content
- Smooth expand/collapse animation
- Auto-scroll to top when collapsing
- Full button styling controls
- Typography controls
- Hover and focus states
- Fully responsive

### 5. Testimonial
Display customer testimonials with ratings in slider or grid layout.

**Features:**
- Repeater field for multiple testimonials
- Optional profile image
- Customer name and subtitle/location
- Review text with quote styling
- Star rating system (0-5 stars, supports half stars)
- Two layouts: Slider and Grid
- Slider: Multiple slides per view (1-4)
- Grid: Customizable columns (1-4)
- Autoplay option for slider
- Navigation arrows and pagination dots
- Adjustable gap between cards
- Full styling controls for all elements
- Hover effects
- Equal height cards
- Fully responsive with breakpoints

## Settings Page

Access the settings page from **WordPress Admin > BP Widgets**

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
namespace BP_Elementor_Widgets\Widgets;

use BP_Elementor_Widgets\Abstracts\Base_Widget;

class Your_Widget extends Base_Widget {
    // Your widget code here
}
```

### 2. Register Widget

Add your widget to the `$available_widgets` array in `includes/class-widgets-manager.php`:

```php
'your-widget' => array(
    'title'       => esc_html__( 'Your Widget', 'bp-elementor-widgets' ),
    'description' => esc_html__( 'Description of your widget.', 'bp-elementor-widgets' ),
    'class'       => 'Your_Widget',
    'file'        => 'your-widget.php',
    'icon'        => 'eicon-info-box',
    'is_pro'      => false,
),
```

### 3. Add Widget Styles (Optional)

Create a new SCSS file in `src/scss/widgets/_your-widget.scss`:

```scss
@use '../variables' as *;
@use '../mixins' as *;

.bp-your-widget {
    // Your widget styles here
}
```

Then import it in `src/scss/frontend.scss`:

```scss
@use 'widgets/your-widget';
```

### 4. Add Widget JavaScript (Optional)

Create a new JavaScript file in `src/js/widgets/your-widget.js`:

```javascript
(function ($) {
    'use strict';

    window.BpWidgets = window.BpWidgets || {};
    
    window.BpWidgets.YourWidget = {
        init: function ($scope) {
            // Your widget JavaScript here
        }
    };

})(jQuery);
```

Then register it in `src/js/widgets.js`:

```javascript
// In registerWidgets() method:
if (window.BpWidgets.YourWidget) {
    elementorFrontend.hooks.addAction(
        'frontend/element_ready/bp-your-widget.default',
        window.BpWidgets.YourWidget.init
    );
}
```

All widget JavaScript files are automatically concatenated by the build system.

### 5. Build Assets

Run the build command to compile SCSS and JavaScript:

```bash
npm run build
```

This will compile all SCSS and JavaScript files into the `dist/` directory.

## File Structure

```
bp-elementor-widgets/
├── dist/                            # Compiled assets
│   ├── css/
│   │   ├── admin.min.css           # Compiled admin styles
│   │   └── frontend.min.css        # Compiled frontend styles
│   └── js/
│       ├── admin.min.js            # Compiled admin scripts
│       ├── editor.min.js           # Compiled editor scripts
│       ├── frontend.min.js         # Compiled frontend scripts
│       └── widgets.min.js          # Compiled widget handlers
├── src/                             # Source files (SCSS & JS)
│   ├── scss/
│   │   ├── widgets/                # Widget-specific styles
│   │   │   ├── _countdown-timer.scss
│   │   │   ├── _gallery.scss
│   │   │   ├── _info-box.scss
│   │   │   ├── _read-more.scss
│   │   │   └── _testimonial.scss
│   │   ├── _variables.scss         # SCSS variables
│   │   ├── _mixins.scss            # SCSS mixins
│   │   ├── admin.scss              # Admin styles
│   │   └── frontend.scss           # Frontend styles
│   └── js/
│       ├── widgets/                # Widget-specific JavaScript
│       │   ├── countdown-timer.js
│       │   ├── gallery.js
│       │   ├── info-box.js
│       │   ├── read-more.js
│       │   └── testimonial.js
│       ├── admin.js                # Admin scripts
│       ├── editor.js               # Editor scripts
│       ├── frontend.js             # Frontend scripts
│       └── widgets.js              # Main widget handlers
├── includes/
│   ├── abstracts/
│   │   └── class-base-widget.php   # Base widget class
│   ├── class-plugin.php            # Main plugin class
│   ├── class-settings.php          # Settings page handler
│   └── class-widgets-manager.php   # Widgets registration manager
├── widgets/
│   ├── countdown-timer.php         # Countdown Timer widget
│   ├── gallery.php                 # Gallery Carousel widget
│   ├── info-box.php                # Info Box widget
│   ├── read-more.php               # Read More widget
│   └── testimonial.php             # Testimonial widget
├── bp-elementor-widgets.php        # Main plugin file
├── gulpfile.js                     # Gulp build configuration
├── package.json                    # NPM dependencies
├── BUILD.md                        # Build system documentation
├── QUICK-START.md                  # Quick start guide
└── README.md                       # This file
```

## Hooks & Filters

### Filters

#### `bp_elementor_widgets_available`
Modify the available widgets array.

```php
add_filter( 'bp_elementor_widgets_available', function( $widgets ) {
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

## Build System

This plugin uses Gulp for asset compilation:

### Development Commands

```bash
# Install dependencies
npm install

# Build assets (compile SCSS & JS to dist/)
npm run build

# Watch for changes and auto-compile
npm run watch

# Deploy (build + create installable ZIP)
npm run deploy
```

### Technology Stack

- **SCSS** with modern `@use` syntax
- **Gulp** for task automation
- **ES6 JavaScript** with modular structure
- **Slick Carousel** for sliders
- **Font Awesome 6** for icons (frontend)
- **WordPress Dashicons** for admin icons

## Changelog

### Version 1.0.0
- Initial release
- Added 5 powerful widgets:
  - Countdown Timer (recurring & one-time)
  - Gallery Carousel (with lightbox & thumbnails)
  - Info Box (multiple layouts)
  - Read More (collapsible content)
  - Testimonial (slider & grid)
- Settings page with enable/disable functionality
- Modular architecture for easy widget additions
- Gulp-based build system with SCSS and ES6 JavaScript
- Fully responsive design
- Comprehensive styling controls
- Alphabetically sorted widget manager
- Clean, well-documented code
- WordPress Dashicons integration for admin
- Font Awesome 6 integration for frontend

## Credits

Developed by BP

## License

GPL v2 or later

