'use strict';

/**
 * Asset paths.
 */

var paths = {
	scripts: {
		input: 'js/**/*.js',
		polyfills: '.polyfill.js',
		output: '../js/'
	},
	styles: {
		input: 'scss/**/*.{scss,sass}',
		output: '../css/'
	},
	images: {
		input: 'images/**/*.{jpg,jpeg,png,gif}',
		output: '../images/'
	},
	svgs: {
		input: 'images/**/*.svg',
		output: '../images/'
	},
	fonts: {
		input: 'fonts/**/*',
		output: '../fonts/'
	},
	copy: {
		input: 'copy/**/*',
		output: '../'
	}
};

// General
const {gulp, src, dest, watch, series, parallel} = require('gulp');
const rename = require('gulp-rename');
const autoprefixer = require('gulp-autoprefixer');
const uglify = require('gulp-uglify');

// Scripts
const babel = require('gulp-babel');
const concat = require('gulp-concat');

// Styles
const sass = require('gulp-sass');
const scsslint = require('gulp-scss-lint');
const cleancss = require('gulp-clean-css');

// Images
var imagemin = require('gulp-imagemin');

// SVGs
var svgmin = require('gulp-svgmin');

/**
 * Task for SCSS Lint
 */
var csslint = function (done) {
	return src(paths.styles.input)
			.pipe(scsslint());
}

/**
 * Task for styles.
 */
var css = function (done) {
	return src(paths.styles.input)
			.pipe(sass().on('error', sass.logError))
			.pipe(scsslint({ 'reporterOutputFormat': 'Checkstyle' }))
			.pipe(autoprefixer({ cascade : false }))
			.pipe(cleancss())
			.pipe(rename({ suffix: '.min' }))
			.pipe( dest(paths.styles.output) );
}

/**
 * Task for scripts.
 */

var images = function (done) {
	return src( [ paths.images.input ] )
		.pipe( imagemin( { optimizationLevel: 3, progressive: true, interlaced: true } ) )
		.pipe( dest( paths.images.output ) );
}

var svg = function (done) {
    return src( [paths.svgs.input ])
        .pipe(svgmin())
        .pipe( dest(paths.svgs.output) );
}

var js = function (done) {
    return src(paths.scripts.input)
        .pipe(babel({
            presets : ['es2015']
        }))
        .pipe(rename({ suffix: '.min' }))
        .pipe(uglify())
        .pipe( dest(paths.scripts.output) );
}

/**
 * Task for fonts
 * 
 * Fonts are copied over to `assets/fonts/`
 */

var fonts = function (done) {
	return src( [ paths.fonts.input ] )
		.pipe( dest( paths.fonts.output ) );
}

/**
 * Task for includes and simple copies
 */

var copy = function (done) {
	// Copy static files
	return src(paths.copy.input)
	.pipe( dest(paths.copy.output) );
}

// Watch for changes
var watchSource = function (done) {

	watch(paths.images.input, images);
	watch(paths.svgs.input, svg);
	watch(paths.fonts.input, fonts);
	watch(paths.styles.input, css);
	watch(paths.scripts.input, js);
	watch(paths.fonts.input, fonts);
	watch(paths.copy.input, copy);
	
};


exports.default = series(
	parallel(
		images,
		svg,
		fonts,
		css,
		js,
		fonts,
		copy
	)
);


exports.watch = series(
	exports.default,
	watchSource
);