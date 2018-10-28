/**
 * This example:
 *  Uses the built-in BrowserSync server for HTML files
 *  Watches & compiles SASS files
 *  Watches & injects CSS files
 * 
 * More details: http://www.browsersync.io/docs/gulp/
 * 
 * Install:
 * npm install browser-sync gulp gulp-sass --save-dev
 * 
 * Then run it with:
 * gulp
 */
var browserSync = require('browser-sync');
var reload = browserSync.reload;
var gulp = require('gulp');
var sass = require('gulp-sass');

// Browser-sync task, only cares about compiled CSS
gulp.task('browser-sync', function () {
	browserSync.init({
		proxy: "http://labo.msk"
	});
});


// Sass task, will run when any SCSS files change & BrowserSync
// will auto-update browsers
gulp.task('sass', function () {
	return gulp.src('css/**/*.scss')
		.pipe(sass())
		.on('error', function (err) {
			console.log(err.toString());

			this.emit('end');
		})
		.pipe(gulp.dest('css'))
		.pipe(reload({ stream: true }));
});

// Reload all Browsers
gulp.task('bs-reload', function () {
	browserSync.reload();
});

// Default task to be run with `gulp`
// This default task will run BrowserSync & then use Gulp to watch files.
// When a file is changed, an event is emitted to BrowserSync with the filepath.
gulp.task('default', ['browser-sync'], function () {
	gulp.watch(['css/*.css', 'js/*.js'], function (file) {
		if (file.type === "changed") {
			reload(file.path);
		}
	});

	gulp.watch("css/**/*.scss", ['sass']);

	gulp.watch("*.php", ['bs-reload']);
});