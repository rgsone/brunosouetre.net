const gulp = require( 'gulp' );
const del = require( 'del' );
const flatten = require( 'gulp-flatten' );
const runSequence = require( 'run-sequence' );
const realFavicon = require ( 'gulp-real-favicon' );
const fs = require( 'fs' );

/* #############################################
   ==== TASKS ==================================
   ############################################# */

/* #### FAVICON TASKS ########################## */

const FAVICON_DATA_FILE = 'faviconData.json';

gulp.task( 'favicon:gen', ( done ) => {
	realFavicon.generateFavicon({
		masterPicture: 'favicon-base.png',
		dest: './',
		iconsPath: '/',
		design: {
			ios: {
				pictureAspect: 'backgroundAndMargin',
				backgroundColor: '#ffffff',
				margin: '28%',
				assets: {
					ios6AndPriorIcons: false,
					ios7AndLaterIcons: true,
					precomposedIcons: false,
					declareOnlyDefaultIcon: true
				},
				appName: 'bsouetre.net'
			},
			desktopBrowser: {},
			windows: {
				pictureAspect: 'noChange',
				backgroundColor: '#ffffff',
				onConflict: 'override',
				assets: {
					windows80Ie10Tile: false,
					windows10Ie11EdgeTiles: {
						small: false,
						medium: true,
						big: false,
						rectangle: false
					}
				},
				appName: 'bsouetre.net'
			},
			androidChrome: {
				pictureAspect: 'backgroundAndMargin',
				margin: '17%',
				backgroundColor: '#ffffff',
				themeColor: '#eb4545',
				manifest: {
					name: 'bsouetre.net',
					display: 'browser',
					orientation: 'notSet',
					onConflict: 'override',
					declared: true
				},
				assets: {
					legacyIcon: false,
					lowResolutionIcons: false
				}
			},
			safariPinnedTab: {
				pictureAspect: 'blackAndWhite',
				threshold: 40,
				themeColor: '#5bbad5'
			}
		},
		settings: {
			compression: 2,
			scalingAlgorithm: 'Mitchell',
			errorOnImageTooSmall: false
		},
		markupFile: FAVICON_DATA_FILE
	}, () => {
		done();
	});
});

gulp.task( 'favicon:inject-markups', () => {
	return gulp.src([ 'themes/bsouetre/partials/favicon.htm' ])
		.pipe( realFavicon.injectFaviconMarkups( JSON.parse( fs.readFileSync( FAVICON_DATA_FILE ) ).favicon.html_code ) )
		.pipe( gulp.dest( 'themes/bsouetre/partials' ) )
		.pipe( gulp.dest( 'themes/bsouetre-galeries/partials' ) )
		.pipe( gulp.dest( 'themes/bsouetre-shop/partials' ) );
});

gulp.task( 'favicon:check-for-update', ( done ) => {
	const currentVersion = JSON.parse( fs.readFileSync( FAVICON_DATA_FILE ) ).version;
	realFavicon.checkForUpdates( currentVersion, ( err ) => {
		if ( err ) throw err;
	});
});

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
