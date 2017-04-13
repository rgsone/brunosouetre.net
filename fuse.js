const { FuseBox, SassPlugin, CSSResourcePlugin, CSSPlugin, BabelPlugin, PostCSS, UglifyJSPlugin } = require( 'fuse-box' );
const autoprefixer = require( 'autoprefixer' );
const postcssDiscardComments = require( 'postcss-discard-comments' );
const Program = require( 'commander' );


////////////////////////

const themePath = 'themes';
const srcPath = '/assets/src';
const outputFilePath = '/assets/js/app.js';
const themesPathname = {
	site: '/bsouetre',
	shop: '/bsouetre-shop',
	galleries: '/bsouetre-galeries'
};

function launch( cmd )
{
	if ( cmd._name != 'dev' && cmd._name != 'build' ) return;

	let currentThemePathname;

	switch ( cmd.theme )
	{
		case 'shop':
			currentThemePathname = themesPathname.shop;
			break;
		case 'galeries':
			currentThemePathname = themesPathname.galleries;
			break;
		default:
			currentThemePathname = themesPathname.site;
			break;
	}

	const homeDir = `./${themePath}${currentThemePathname}${srcPath}`;
	const outFile = `./${themePath}${currentThemePathname}${outputFilePath}`;

	// Fusebox config

	const fuse = FuseBox.init({
		homeDir: homeDir,
		outFile: outFile,
		log: true,
		debug: false,
		cache: true,
		plugins: getPluginsFortheme( cmd._name, currentThemePathname )
	});

	if ( cmd._name == 'dev' ) {
		fuse.devServer("> index.js", {port: 1337});
		return;
	}

	fuse.bundle( "> index.js" );
}

function getPluginsFortheme( cmdName, themePathname )
{
	if ( cmdName == 'dev' ) {
		return [
			[
				SassPlugin({outputStyle: 'compact'}),
				CSSResourcePlugin({inline: true}),
				CSSPlugin()
			],
			BabelPlugin()
		];
	}

	if ( cmdName == 'build' ) {
		return [
			[
				SassPlugin({ outputStyle: 'compact' }),
				PostCSS([
					autoprefixer({ browsers: [ 'last 2 versions', 'ie > 8' ] }),
					postcssDiscardComments({ discardComments: { removeAll: false } })
				]),
				CSSResourcePlugin({
					dist: `./${themePath}${themePathname}/assets/static`,
					resolve: (f) => `/${themePath}${themePathname}/assets/static/${f}`
				}),
				CSSPlugin({
					outFile: (file) => `./${themePath}${themePathname}/assets/css/style.css`,
					inject: false
				})
			],
			BabelPlugin(),
			UglifyJSPlugin({
				sourceMap: false,
				beautify: false,
				comments: false,
				compress: {
					warnings: true,
					drop_console: true
				},
				mangle: false
			})
		];
	}

	return [];
}

////////////////////////

Program.version( '0.0.1' );

Program.command( 'dev' )
	.description( 'launch dev server' )
	.option( '-t, --theme <name>', 'set the working theme, if ommit default theme is "site"' )
	.action( launch );

Program.command( 'build' )
	.description( 'build assets' )
	.option( '-t, --theme <name>', 'set the working theme, if ommit default theme is "site"' )
	.action( launch );

Program.parse( process.argv );
