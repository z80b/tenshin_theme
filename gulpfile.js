var gulp = require('gulp');

gulp.task('styles', function() {
    var stylus       = require('gulp-stylus'),
        autoprefixer = require('gulp-autoprefixer'),
        cleanCSS     = require('gulp-clean-css'),
        rename       = require('gulp-rename'),
        axis         = require('axis');

    return gulp.src('./src/css/index.styl')
        .pipe(stylus({
            'include css': true,
            'compress': false,
            'use': axis(),
            'rawDefine': { 'inline-image': stylus.stylus.url({
                paths: ['./src/css/imgs']
            }) }
        }))
        .pipe(autoprefixer(['> 0%']))
        .pipe(rename('styles.css'))
        .pipe(gulp.dest('./'));
});

gulp.task('scripts', function() {
    var browserify = require('browserify'),
        babelify   = require('babelify'),
        source     = require('vinyl-source-stream');

    return browserify({ entries: 'src/js/index.js'})
        .transform(babelify, {
            presets: ['es2015', 'stage-0']
        })
        .bundle()
        .on('error', function(err){
            console.log('[browserify error]');
            console.log(err.message);
        })
        .pipe(source('scripts.js'))
        .pipe(gulp.dest('.'));
});

gulp.task('default', ['styles'], function() {
    gulp.watch('./**/*.styl', ['styles']);
});