'use strict';

/**
 * Asset paths.
 */
var paths = {
	jade: {
		input: 'jade/**/*.jade',
		ignore: '!./jade/**/_*.jade',
		output: '../../'
	},
	scripts: {
		input: 'js/**/*.js',
		ignore: '!./js/**/_*.js',
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
const { gulp, src, dest, watch, series, parallel } = require('gulp');
const plumber		= require('gulp-plumber');
const rename 		= require('gulp-rename');
const autoprefixer 	= require('gulp-autoprefixer');
const uglify 		= require('gulp-uglify');
const args			= require('yargs').argv;
const isRelease 	= args.release || false;

// Pug
const jade = require('gulp-jade-php');

// Scripts
const babel = require('gulp-babel');
const include = require('gulp-include')

// Styles
const sass = require('gulp-sass');
//const scsslint = require('gulp-scss-lint');
const cleancss = require('gulp-clean-css');

// Images
const imagemin = require('gulp-imagemin');

// SVGs
const svgmin = require('gulp-svgmin');

/**
 * Task for building the HTML/PHPs
 */
const buildTemplates = function (done) {
	return src([paths.jade.input, paths.jade.ignore])
			.pipe(plumber())
			.pipe( jade({
				'pretty': (!isRelease) ? true : false,
				'locals': {
					'echo': function(str) {
						return "<?php echo " + str + " ?>"
					},
					'image': function(src) {
						return ("<?php echo get_template_directory_uri() ?>/assets/images/" + src);
					},
					'background': function(src, fromWP) {
						var url = "/assets/images/";
						url += src;
						if (fromWP) {
							return ("background-image: url('<?php echo " + src + "?>')");
						} else {
							return ("background-image: url('<?php echo get_template_directory_uri() . \"" + url + "\" ?>')");
						}
					},
					'css': function(value) {
						return ("<?php echo get_template_directory_uri() ?>/assets/css/" + value);
					},
					'js': function(value) {
						return ("<?php echo get_template_directory_uri() ?>/assets/js/" + value);
					},
					'assets': function(src) {
						return ("<?php echo get_template_directory_uri() ?>/assets/" + src);
					}
				}
			}) )
			//.pipe(rename({ extname: '.php' }))
			.pipe(dest(paths.jade.output))
}

/**
 * Task for styles.
 */
const css = function (done) {
	return src(paths.styles.input)
    		.pipe(plumber())
			//.pipe(scsslint({ 'reporterOutputFormat': 'Checkstyle' }))
			.pipe(sass().on('error', sass.logError))
			.pipe(autoprefixer({ cascade : false }))
			.pipe(cleancss())
			.pipe(rename({ suffix: '.min' }))
			.pipe( dest(paths.styles.output) );
}

/**
 * Task for scripts.
 */
const images = function (done) {
	return src( [ paths.images.input ] )
    	.pipe(plumber())
		.pipe( imagemin( { optimizationLevel: 3, progressive: true, interlaced: true } ) )
		.pipe( dest( paths.images.output ) );
}

/**
 * Task for SVGs.
 */
const svg = function (done) {
	return src( [ paths.svgs.input ])
		.pipe(plumber())
        .pipe(svgmin())
        .pipe( dest(paths.svgs.output) );
}

/**
 * Task for JS and libs.
 */
const js = function (done) {
    return src( [ paths.scripts.input, paths.scripts.ignore ] )
		.pipe(plumber())
		.pipe(include())
		  .on('error', console.log)
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
const fonts = function (done) {
	return src( [ paths.fonts.input ] )
		.pipe(plumber())
		.pipe( dest( paths.fonts.output ) );
}

/**
 * Task for includes and simple copies
 */
const copy = function (done) {
	// Copy static files
	return src(paths.copy.input)
		.pipe(plumber())
		.pipe( dest(paths.copy.output) );
}

// Watch for changes
const watchSource = function (done) {

	watch(paths.jade.input, buildTemplates);
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
		buildTemplates,
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