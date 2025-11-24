/**
 * Gulpfile for BP Elementor Widgets
 *
 * Build system for compiling SCSS, minifying JS, and creating deployable plugin.
 *
 * @package BP_Elementor_Widgets
 */

const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const cleanCSS = require('gulp-clean-css');
const rename = require('gulp-rename');
const sourcemaps = require('gulp-sourcemaps');
const zip = require('gulp-zip');
const autoprefixer = require('gulp-autoprefixer');
const del = require('del');
const merge = require('merge-stream');

/**
 * File Paths
 */
const paths = {
	scss: {
		src: 'src/scss/**/*.scss',
		dest: 'dist/css/'
	},
	js: {
		src: 'src/js/**/*.js',
		dest: 'dist/js/'
	},
	php: [
		'**/*.php',
		'!node_modules/**',
		'!build/**',
		'!dist/**'
	],
	deploy: [
		'**/*',
		'!node_modules/**',
		'!src/**',
		'!build/**',
		'!.git/**',
		'!.gitignore',
		'!gulpfile.js',
		'!package.json',
		'!package-lock.json',
		'!**/.DS_Store'
	]
};

/**
 * Clean Task
 * Removes dist and build directories
 */
function clean() {
	return del(['dist', 'build']);
}

/**
 * Compile SCSS Task
 * Compiles SCSS to CSS with sourcemaps, autoprefixer, and minification
 */
function compileSCSS() {
	return gulp.src(paths.scss.src)
		.pipe(sourcemaps.init())
		.pipe(sass({
			outputStyle: 'expanded',
			precision: 10,
			silenceDeprecations: ['legacy-js-api']
		}).on('error', sass.logError))
		.pipe(autoprefixer({
			cascade: false
		}))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(paths.scss.dest))
		.pipe(rename({ suffix: '.min' }))
		.pipe(cleanCSS({ compatibility: 'ie10' }))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(paths.scss.dest));
}

/**
 * Compile JavaScript Task
 * Minifies JS files with sourcemaps
 */
function compileJS() {
	return gulp.src(paths.js.src)
		.pipe(sourcemaps.init())
		.pipe(gulp.dest(paths.js.dest))
		.pipe(rename({ suffix: '.min' }))
		.pipe(uglify())
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(paths.js.dest));
}

/**
 * Watch Task
 * Watches for changes in SCSS and JS files
 */
function watch() {
	gulp.watch(paths.scss.src, compileSCSS);
	gulp.watch(paths.js.src, compileJS);
}

/**
 * Build Task
 * Compiles SCSS and JS
 */
const build = gulp.series(clean, gulp.parallel(compileSCSS, compileJS));

/**
 * Deploy Task
 * Creates a deployable ZIP file of the plugin
 */
function createZip() {
	return gulp.src(paths.deploy, { base: '..' })
		.pipe(rename(function(path) {
			path.dirname = 'bp-elementor-widgets/' + path.dirname;
		}))
		.pipe(zip('bp-elementor-widgets.zip'))
		.pipe(gulp.dest('build'));
}

const deploy = gulp.series(build, createZip);

/**
 * Export Tasks
 */
exports.clean = clean;
exports.scss = compileSCSS;
exports.js = compileJS;
exports.watch = watch;
exports.build = build;
exports.deploy = deploy;
exports.default = build;

