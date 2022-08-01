var webpack = require('webpack'),
	webpackGulp = require('webpack-stream'),
	gulp = require('gulp'),
	browserSync = require("browser-sync"),
	rigger = require('gulp-rigger'),
	tinypng = require('gulp-tinypng-compress'),
	gulpif = require('gulp-if'),
	consolidate = require('gulp-consolidate'),
	plumber = require('gulp-plumber'),
	notifier = require('node-notifier'),
	argv = require('yargs').argv,
	sourcemaps = require('gulp-sourcemaps'),

	// Iconsfont and SVG
	iconfont = require('gulp-iconfont'),
	iconfontCss = require('gulp-iconfont-css'),
	svgmin = require('gulp-svgmin'),

	// Styles
	sass = require('gulp-sass'),
	postcss = require('gulp-postcss'),
	autoprefixer = require('autoprefixer'),
	cssnano = require('cssnano'),
	customProperties = require('postcss-custom-properties'),
	flexboxFix = require('postcss-flexbugs-fixes');

var browsersyncConfig = {
    server: {
        baseDir: './public',
        index: 'dashboard-1.html'
    },
    tunnel: true,
    host: 'localhost',
    port: 9000,
    // logLevel: 'silent'
};

/**
 * Paths to source files
 * @type {Object}
 */
var resources = {
	scss: ['src/scss/**/*.scss'],
	js: ['src/js/**/*.*'],
	fonts: ['src/fonts/**/*.*', '!src/fonts/**/*.scss'],
	images: ['src/images/**/*.*'],
	favicon: ['src/images/logo.png'],
	svg: ['src/images/svg/**/*.svg'],
	html: ['src/html/*.html'],
	htmlIncludes: ['src/html/includes/*.html']
};

/**
 * Webpack log settings
 * @type {Object}
 */
var webpackStatsConfig = {
    colors: true, hash: true, version: true, timings: true, assets: true, chunks: true,
    chunkModules: false, modules: false, children: false, cached: false, reasons: false,
    source: false, errorDetails: true, chunkOrigins: false
};

/**
 * TinyPNG API token (https://tinypng.com/)
 * @type {String}
 */
var TINYPNG_API_TOKEN = null;

/*
* Styles task
*
* Description: compile SASS and using PostCSS plugins
*/
gulp.task('build:scss', function(){
	var plugins = [
        autoprefixer({browsers: ['last 8 versions'], cascade: false}),
		customProperties({
			preserve: false
		}),
		flexboxFix()
    ];

    if (argv.prod) {
    	plugins.push(cssnano());

    	return gulp.src(resources.scss)
    		.pipe(sass().on('error', sass.logError))
    		.pipe(postcss(plugins))
    		.pipe(gulp.dest('public/assets/css'))
    		.pipe(browserSync.reload({stream: true}));
    }

	return gulp.src(resources.scss)
		.pipe(sourcemaps.init())
		.pipe(sass().on('error', sass.logError))
		.pipe(postcss(plugins))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest('public/assets/css'))
		.pipe(browserSync.reload({stream: true}));
});

/*
* JS task
*
* Description: making JS bundle
*/
gulp.task('build:js', function(done){
	return gulp.src('src/js/index.js')
		.pipe(plumber({
			errorHandler: function(error){
				notifier.notify({
					title: 'Gulp',
					message: '❌ Build failed!'
				})
			}
		}))
		.pipe(webpackGulp(require(argv.prod ? './webpack.prod.js' : './webpack.dev.js'), webpack, function(err, stats) {
			if (err) {
				notifier.notify({
					title: 'Webpack',
					message: '❌ Build failed!'
				});
				console.log(err);
			}
			console.log(stats.toString(webpackStatsConfig));
		}))
		.pipe(gulp.dest('public/assets/js'))
		.pipe(browserSync.reload({stream: true}));
});

/*
* Fonts task
*
* Description: just moving to /public folder.
*/
gulp.task('build:fonts', function(){
	return gulp.src(resources.fonts)
		.pipe(gulp.dest('public/assets/fonts'))
		.pipe(browserSync.reload({stream: true}));
});

/*
* Iconsfont task
*
* Description: making your custom iconsfont. 
* Source SVG located in /src/images/svg. 
*/
// gulp.task('build:iconsfont', function(){
// 	return gulp.src(resources.svg)
// 		.pipe(iconfont({
// 			fontName: 'Iconsfont',
// 			appendCodepoints: true,
// 			appendUnicode: false,
// 			fixedWidth: false,
// 			normalize: true,
// 			fontHeight: 1000,
// 			centerHorizontally: false,
// 			formats: ['eot', 'ttf', 'woff', 'woff2'],
// 			timestamp: Math.round(Date.now()/1000),
// 		}))
// 		.on('glyphs', function(glyphs, options) {
// 			gulp.src('src/fonts/Iconsfont/_iconsfont.scss')
// 				.pipe(consolidate('lodash', {
// 					glyphs: glyphs,
// 					fontName: options.fontName,
// 					className: 'i',
// 					timestamp: Math.round(Date.now()/1000)
// 				}))
// 			.pipe(gulp.dest('src/scss/typography'))
// 		})
// 		.pipe(gulp.dest('public/assets/fonts/Iconsfont'))
// 		.pipe(browserSync.reload({stream: true}));
// });

/*
* SVG task
*
* Making optimized SVG files for better performance
*/
gulp.task('optimize:svg', function(){
	return gulp.src(resources.svg)
		.pipe(svgmin({
			plugins: [
                // { removeDimensions: true },
                // { cleanupListOfValues: true },
                // { cleanupNumericValues: true }
            ]
		}))
		.pipe(gulp.dest('src/images/svg'));
});

/*
* Images task
*
* Description: moving to /public folder. 
* If you has TinyPNG account, you might use it API for optimize PNG and JPG.
* After optimizing, images will have a modified signature for prevent re-optimizing.
*/
gulp.task('build:images', function(){

	if (TINYPNG_API_TOKEN && argv.prod)
		return gulp.src(resources.images)
			.pipe(gulpif(/.*\.(png|jpg)$/, tinypng({
				key: TINYPNG_API_TOKEN,
				sigFile: 'images/.tinypng-sigs',
				log: true
			})))
			.pipe(gulp.dest('public/images'));

	return gulp.src(resources.images)
		.pipe(gulp.dest('public/images'))
		.pipe(browserSync.reload({stream: true}));
});

/*
* Build HTML templates 
*/
gulp.task('build:html', function(){
	return gulp.src(resources.html)
		.pipe(rigger())
		.pipe(gulp.dest('public'))
		.pipe(browserSync.reload({stream: true}));
});

/*
* Main build task
*/
gulp.task('build', [
	'build:scss',
	'build:js',
	// 'build:iconsfont',
	// 'build:html',
	'build:fonts',
	'build:images'
]);

/*
* Watch task
*/
gulp.task('watch',function(){
	gulp.watch(resources.svg, ['build:iconsfont']);
	gulp.watch(resources.fonts, ['build:fonts']);
	gulp.watch(resources.scss, ['build:scss']);
	gulp.watch(resources.js, ['build:js']);
	gulp.watch(resources.images, ['build:images']);
	// gulp.watch(resources.html, ['build:html']);
	// gulp.watch(resources.htmlIncludes, ['build:html']);
});

/*
* Browsersync server task
*/
gulp.task('webserver', function () {
    browserSync(browsersyncConfig);
});

gulp.task('default', [
	'build', 
	// 'webserver', 
	'watch'
]);
