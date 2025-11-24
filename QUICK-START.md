# Quick Start Guide

## 🚀 Getting Started

### First Time Setup

```bash
cd /Users/braudy/Local\ Sites/plugin-making-site/app/public/wp-content/plugins/bp-elementor-widgets
npm install
npm run build
```

## 📝 Common Commands

### During Development

```bash
npm run watch
```
Automatically compiles when you save files. **Use this while developing!**

### Build for Testing

```bash
npm run build
```
Compiles all SCSS and JS. Run this before testing changes.

### Create Deployable Plugin

```bash
npm run deploy
```
Builds everything and creates `build/bp-elementor-widgets.zip` ready for upload.

## 📁 Where to Edit Files

### ✅ Edit These:
- `src/scss/` - All SCSS files
- `src/js/` - All JavaScript files
- `widgets/` - Widget PHP files
- `includes/` - Plugin PHP classes

### ❌ Don't Edit These:
- `dist/` - Auto-generated compiled files
- `build/` - Auto-generated ZIP file
- `node_modules/` - npm packages

## 🎨 Adding a New Widget

### 1. Create Widget PHP File
`widgets/your-widget.php`

### 2. Create Widget SCSS
`src/scss/widgets/_your-widget.scss`

### 3. Import SCSS
In `src/scss/frontend.scss`:
```scss
@import 'widgets/your-widget';
```

### 4. Register Widget
In `includes/class-widgets-manager.php`:
```php
'your-widget' => array(
    'title'       => 'Your Widget',
    'description' => 'Description here',
    'class'       => 'Your_Widget',
    'file'        => 'your-widget.php',
    'icon'        => 'eicon-icon-name',
    'is_pro'      => false,
),
```

### 5. Add Widget JavaScript (if needed)
In `src/js/widgets.js`, add your widget handler:
```javascript
// Register in registerWidgets()
elementorFrontend.hooks.addAction(
    'frontend/element_ready/bp-your-widget.default',
    BpWidgets.YourWidget.init
);

// Add handler
BpWidgets.YourWidget = {
    init: function($scope) {
        // Your widget JS here
    }
};
```

### 6. Build
```bash
npm run build
```

### 7. Test in Elementor
The widget will appear in the "BP Widgets" category.

## 🎨 Using SCSS Variables

### Colors
```scss
$color-primary          // #6EC1E4
$color-secondary        // #667eea  
$color-text-dark        // #333333
$color-text-medium      // #666666
```

### Spacing
```scss
$spacing-xs    // 5px
$spacing-sm    // 10px
$spacing-md    // 15px
$spacing-lg    // 20px
$spacing-xl    // 30px
```

### Example Widget SCSS
```scss
.bp-your-widget {
    padding: $spacing-lg;
    background: $color-primary;
    border-radius: $border-radius-md;
    @include transition(all);
    
    &:hover {
        @include box-shadow(3);
    }
    
    @include tablet {
        padding: $spacing-md;
    }
}
```

## 🐛 Troubleshooting

### Build Errors
```bash
npm run clean
npm install
npm run build
```

### Watch Not Working
Stop with `Ctrl+C` and restart:
```bash
npm run watch
```

### Plugin Not Loading Styles
1. Check `dist/` folder has compiled files
2. Run `npm run build`
3. Clear browser cache
4. Hard refresh (Cmd+Shift+R)

## 📦 Deploying Plugin

### Test Build
```bash
npm run deploy
```
Check `build/bp-elementor-widgets.zip`

### Upload to WordPress
1. Go to WordPress Admin → Plugins → Add New → Upload
2. Choose `build/bp-elementor-widgets.zip`
3. Install and activate

### Or Use on Another Site
Just copy the whole `bp-elementor-widgets` folder to another WordPress installation's plugins directory.

## 🎯 Current Widgets

1. **Info Box** - Display information with icon, title, and description
2. **Countdown Timer** - Create urgency with countdown (one-time or recurring)

## 📚 Documentation

- **BUILD.md** - Complete build system documentation
- **README.md** - Plugin documentation
- **Code comments** - Detailed inline documentation

## 💡 Tips

1. **Always run** `npm run watch` during development
2. **Test changes** in Elementor after building
3. **Use SCSS variables** for consistency
4. **Follow naming** convention: `.bp-widget-name`
5. **Commit regularly** with descriptive messages
6. **Run build** before committing to ensure no errors

## ⚡ Quick Tips

- Use `@include tablet { }` for responsive styles
- Use `@include flex-center` for centering
- Use `@include box-shadow(1-4)` for shadows
- Use `@include transition(all)` for animations
- Check `_mixins.scss` for all available mixins

## 🎨 Style Guide

- Class names: `.bp-widget-element`
- Variables: `$name-type`
- Mixins: `@include mixin-name`
- Always use variables for colors/spacing
- Mobile-first responsive design

## 📝 Git Workflow

```bash
# Make changes
npm run build

# Check what changed
git status

# Stage changes
git add -A

# Commit
git commit -m "Description of changes"

# View history
git log --oneline
```

## 🚀 Next Steps

1. Activate plugin in WordPress
2. Go to **BP Widgets** settings
3. Enable widgets you want to use
4. Start building pages with Elementor!

Happy coding! 🎉

