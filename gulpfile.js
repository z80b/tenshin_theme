var gulp = require('gulp');

gulp.task('styles', function() {
    var stylus      = require('gulp-stylus');
    var autoprefixer = require('autoprefixer');
    var cleanCSS     = require('gulp-clean-css');
    var rename       = require('gulp-rename');

    return gulp.src('./src/css/index.styl')
        .pipe(stylus({
            'include css': true,
            'compress': false,
            'rawDefine': { 'inline-image': stylus.stylus.url() }
        }))
        .pipe(rename('styles.css'))
        .pipe(gulp.dest('.'));
});