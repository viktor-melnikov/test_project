/**
 * Created by viktorthegreat on 31.08.17.
 */

const gulp       = require('gulp');
const concat     = require('gulp-concat');
const less       = require('gulp-less');
const sourcemaps = require('gulp-sourcemaps');
const babel      = require('gulp-babel');
const cleanCSS   = require('gulp-clean-css');
const uglify     = require('gulp-uglify');
const rename     = require('gulp-rename');

// less to css
gulp.task('less', () => {
    gulp.src(['public/assets/less/style.less', '!public/assets/less/**/_*.less','!public/assets/less/pages/*.less'])
        .pipe(sourcemaps.init())
        .pipe(less())
        .pipe(concat('build.css'))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('public/dist/css'));
});

// Собираем JS
gulp.task('js', () => {
    gulp.src(['public/assets/js/*.js'])
        .pipe(sourcemaps.init())
        .pipe(concat('app.js'))
        .pipe(babel({
            presets: ['env']
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('public/dist/js'));
});

// copy images
gulp.task('images', () => {
    gulp.src(['public/assets/img/**/*']).pipe(gulp.dest('public/dist/img'))
});

// Fonts
gulp.task('fonts', () => {
    gulp.src(['public/assets/fonts/**/*']).pipe(gulp.dest('public/dist/fonts'));
});

gulp.task('watch', () => {
    gulp.watch('public/assets/less/**/*.less', ['less']);

    gulp.watch('public/assets/js/*.js', ['js']);

    gulp.watch('public/assets/fonts/**/*', ['fonts']);
    gulp.watch('public/assets/img/**/*', ['images']);
});

gulp.task('default', ['watch']);
gulp.task('build', ['less', 'js', 'fonts', 'images']);