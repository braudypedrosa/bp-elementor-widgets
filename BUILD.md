# Build System Documentation

This document explains how to use the build system for BP Elementor Widgets.

## Overview

The plugin uses **Gulp** to compile SCSS to CSS, minify JavaScript, and create deployable plugin packages.

## Prerequisites

- **Node.js** (v14 or higher)
- **npm** (comes with Node.js)

## Installation

1. Navigate to the plugin directory:
```bash
cd /path/to/wp-content/plugins/bp-elementor-widgets
```

2. Install dependencies:
```bash
npm install
```

## File Structure

```
bp-elementor-widgets/
├── src/                    # Source files (you edit these)
│   ├── scss/              # SCSS source files
│   │   ├── _variables.scss
│   │   ├── _mixins.scss
│   │   ├── frontend.scss
│   │   ├── admin.scss
│   │   └── widgets/
│   │       ├── _info-box.scss
│   │       └── _countdown-timer.scss
│   └── js/                # JavaScript source files
│       ├── frontend.js
│       ├── admin.js
│       ├── editor.js
│       └── widgets.js     # All widget-specific code
├── dist/                   # Compiled files (auto-generated)
│   ├── css/
│   │   ├── frontend.css
│   │   ├── frontend.min.css
│   │   ├── admin.css
│   │   └── admin.min.css
│   └── js/
│       ├── frontend.js
│       ├── frontend.min.js
│       └── ...
└── build/                  # Deployable plugin (auto-generated)
    └── bp-elementor-widgets.zip
```

## NPM Scripts

### `npm run build`

Compiles SCSS and minifies JavaScript.

```bash
npm run build
```

**What it does:**
1. Cleans `dist/` directory
2. Compiles SCSS to CSS
3. Adds vendor prefixes
4. Creates minified versions (.min.css)
5. Minifies JavaScript files
6. Generates sourcemaps

**Output:**
- `dist/css/frontend.css` + `frontend.min.css`
- `dist/css/admin.css` + `admin.min.css`
- `dist/js/*.js` + `*.min.js`

### `npm run deploy`

Builds everything and creates a deployable ZIP file.

```bash
npm run deploy
```

**What it does:**
1. Runs `npm run build`
2. Creates `build/bp-elementor-widgets.zip`

**The ZIP includes:**
- All PHP files
- Compiled assets (`dist/` folder)
- README.md
- LICENSE file

**The ZIP excludes:**
- `node_modules/`
- `src/` folder
- `.git/`
- Build configuration files
- Old `assets/` folder

### `npm run watch`

Watches for changes and auto-compiles.

```bash
npm run watch
```

**What it does:**
- Monitors `src/scss/**/*.scss` for changes
- Monitors `src/js/**/*.js` for changes
- Automatically runs compilation when files change

**Use this during development!**

### `npm run clean`

Removes compiled files.

```bash
npm run clean
```

**What it does:**
- Deletes `dist/` directory
- Deletes `build/` directory

## Development Workflow

### For Active Development:

1. Start the watch task:
```bash
npm run watch
```

2. Edit files in `src/` directory
3. Changes compile automatically
4. Refresh browser to see changes

### For Production Build:

1. Make your changes in `src/`
2. Test thoroughly
3. Run the deploy command:
```bash
npm run deploy
```

4. Find the ZIP file in `build/bp-elementor-widgets.zip`
5. Upload to WordPress or distribute

## Working with SCSS

All styles use modern SCSS syntax with `@use` modules (Sass 3.0 compatible).

### Adding a New Widget Style:

1. Create `src/scss/widgets/_your-widget.scss`
2. Load variables and mixins at the top:

```scss
@use '../variables' as *;
@use '../mixins' as *;
```

3. Add your styles using variables and mixins
4. Load in `src/scss/frontend.scss`:

```scss
@use 'widgets/your-widget';
```

5. Run `npm run build`

### Using Variables:

```scss
// At the top of your widget SCSS file
@use '../variables' as *;
@use '../mixins' as *;

.my-widget {
    color: $color-primary;
    padding: $spacing-lg;
    border-radius: $border-radius-md;
    @include transition(all);
}
```

### Using Mixins:

```scss
.my-widget {
    @include flex-center;
    @include box-shadow(2);
    
    @include tablet {
        padding: $spacing-sm;
    }
}
```

## Working with JavaScript

JavaScript files are minified but not compiled (no Babel/Webpack).

### File Structure:
- `src/js/frontend.js` - General frontend utilities
- `src/js/widgets.js` - **All widget-specific code** (consolidated)
- `src/js/admin.js` - Admin settings page
- `src/js/editor.js` - Elementor editor enhancements

### Adding Widget JavaScript:

Add your widget handler to `src/js/widgets.js`:

```javascript
// 1. Register in registerWidgets()
elementorFrontend.hooks.addAction(
    'frontend/element_ready/bp-your-widget.default',
    BpWidgets.YourWidget.init
);

// 2. Add handler object
BpWidgets.YourWidget = {
    init: function($scope) {
        const $widget = $scope.find('.bp-your-widget');
        // Your widget code here
    }
};
```

**Best practices:**
- Write ES5-compatible code
- OR use ES6 features supported by target browsers
- Keep all widget code in `widgets.js` (don't create separate files)
- Test in multiple browsers

## Troubleshooting

### "Module not found" errors:

```bash
rm -rf node_modules
npm install
```

### Build fails:

1. Check for SCSS syntax errors
2. Check for JavaScript syntax errors
3. Run `npm run clean` then `npm run build`

### Sourcemaps not working:

Sourcemaps are generated automatically. Make sure:
- Dev tools are open
- Sourcemaps are enabled in browser
- You're loading the .min files

## Gulp Tasks Reference

| Task | Command | Description |
|------|---------|-------------|
| `clean` | `gulp clean` | Remove dist and build |
| `scss` | `gulp scss` | Compile SCSS only |
| `js` | `gulp js` | Minify JS only |
| `watch` | `gulp watch` | Watch and auto-compile |
| `build` | `gulp build` | Full build |
| `deploy` | `gulp deploy` | Build + create ZIP |
| default | `gulp` | Runs `build` |

## Customizing the Build

Edit `gulpfile.js` to customize:
- File paths
- Compilation options
- Build output
- ZIP file contents

## Best Practices

1. **Never edit** files in `dist/` directly
2. **Always edit** files in `src/`
3. **Run build** before committing
4. **Test** the deployment ZIP before distributing
5. **Use watch** during active development
6. **Keep** `node_modules/` in `.gitignore`
7. **Commit** compiled files in `dist/` (or don't, your choice)

## Git Workflow

The `.gitignore` is configured to:
- Ignore `node_modules/`
- Ignore `build/`
- Keep `dist/` (optional, you can change this)
- Ignore the old `assets/` folder

If you want to ignore `dist/` (team compiles locally):
```bash
echo "/dist/" >> .gitignore
```

## Questions?

- Check `gulpfile.js` for task definitions
- Check `package.json` for dependencies
- Check `src/scss/_variables.scss` for available variables
- Check `src/scss/_mixins.scss` for available mixins

