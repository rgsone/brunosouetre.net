const gulp = require( 'gulp' );
const del = require( 'del' );
const flatten = require( 'gulp-flatten' );
const runSequence = require( 'run-sequence' );

/* #############################################
   ==== TASKS ==================================
   ############################################# */

/* #### BUILD TASKS ############################ */

// delete dist/ dir
gulp.task( 'del:dist', () => {
	return del([ 'dist/' ]);
});

// copy all files to dist/ dir
gulp.task( 'copy:toDist', () => {
	return gulp.src([
			'bootstrap/**',
			'config/**',
			'galeries/**',
			'modules/**',
			'plugins/**',
			'storage/**',
			'themes/**',
			'vendor/**',
			'.htaccess',
			'artisan',
			'index.php'
		],
		{
			base: '.',
			dot: true
		})
		.pipe( gulp.dest( 'dist/' ) );
});

// copy production .env file to dist/ dir
gulp.task( 'copy:envToDist', () => {
	return gulp.src([ 'tools/dist/.env' ], { base: '.', dot: true })
		.pipe( flatten() )
		.pipe( gulp.dest( 'dist/' ) );
});

// clean unecessaries files in dist/
gulp.task( 'clean:dist', () => {
	return del([
		'dist/**/.gitkeep',
		'dist/**/.gitignore',
		'dist/**/.git',
		'dist/config/dev/**',
		'dist/config/testing/**',
		'dist/galeries/**/*',
		'dist/themes/bsouetre/assets/src/**',
		'dist/themes/bsouetre-galeries/assets/src/**',
		'dist/themes/bsouetre-shop/assets/src/**',
		'dist/storage/app/media/**/*',
		'dist/storage/app/uploads/**/*',
		'dist/storage/framework/sessions/**/*',
		'dist/storage/logs/**/*',
		'dist/storage/temp/media/**/*',
		'dist/storage/temp/public/**/*'
	],
	{
		dot: true
	});
});

///////// prepare and build dist files for upload

gulp.task( 'build:dist', ( done ) => {
	runSequence( 'del:dist', 'copy:toDist', 'copy:envToDist', 'clean:dist', done );
});
