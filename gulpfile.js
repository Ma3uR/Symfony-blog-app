let gulp = require('gulp');
let sass = require('gulp-sass');
let sourcemaps = require('gulp-sourcemaps');

gulp.task('default', async function() {
    gulp.src('assets/sass/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('public/css'));
});

gulp.task('watch', function() {
    gulp.watch('public/sass/**/*.scss', gulp.series('default'));
});
