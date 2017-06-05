// gulpfile.js 
var elixir = require('laravel-elixir');
 
require('laravel-elixir-eslint');
 
elixir(function(mix) {
  //mix.phpUnit();
  //mix.eslint([
  //'public/js/**/*.js',
  //'resources/assets/js/**/*.js'
  //]);
});

/*var gulp = require('gulp'),
    eslint = require('gulp-eslint');

function isFixed(file) {
    // Has ESLint fixed the file contents?
    return file.eslint != null && file.eslint.fixed;
}


gulp.task('lint', function () {
    // ESLint ignores files with "node_modules" paths.
    // So, it's best to have gulp ignore the directory as well.
    // Also, Be sure to return the stream from the task;
    // Otherwise, the task may end before the stream has finished.
    return gulp.src(['./src/**.js','!node_modules/**'])
        // eslint() attaches the lint output to the "eslint" property
        // of the file object so it can be used by other modules.
        .pipe(eslint({fix:true}))
        // eslint.format() outputs the lint results to the console.
        // Alternatively use eslint.formatEach() (see Docs).
        .pipe(eslint.format())
        // if fixed, write the file to dest
        .pipe(gulpIf(isFixed, gulp.dest('../test/fixtures')));
});

gulp.task('default', ['lint'], function () {
    // This will only run if the lint task is successful...
});*/