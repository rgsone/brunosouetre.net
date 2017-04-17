/* CSS */
import 'baguettebox.js/src/baguetteBox.scss';
import './style/app.scss';
/* JS */
import jump from 'jump.js';
import Blazy from 'blazy/blazy.min';
import baguetteBox from 'baguettebox.js/dist/baguetteBox';

// Hello !

console.log( '%c /> brunosouetre.net ', 'background: #333; color: #fc5454' );
console.log( '%c /> handmade by rgsone.com ', 'background: #333; color: #fc5454' );

/* App */
class App
{

	init()
	{
		let urlPath = window.location.pathname.replace( /\/+$/g, '' ).replace( /^\/+/g, '' );

		// home
		if ( urlPath == '' )
		{
			this.initTopAnchorLink();
		}
		// gallery but no handle 404/error page erf...
		else if ( urlPath.match( /^[a-z0-9_\-]+$/g ) )
		{
			this.initTopAnchorLink();
			this.initBlazy();
			this.initBaguetteBox();
		}
	}

	initTopAnchorLink()
	{
		const backToTopLink = document.querySelector( '[data-backtotop]' );
		const topAnchor = document.querySelector( '#top' );

		if ( null == backToTopLink || null == topAnchor ) return;

		backToTopLink.addEventListener( 'click', ( e ) => {
			e.preventDefault();
			backToTopLink.blur();
			jump( topAnchor, { duration: 600 });
		});
	}

	initBlazy()
	{
		this._blazy = new Blazy({
			selector: '.lazyImg',
			success: ( element ) => {
				const parent = element.parentNode;
				parent.style.minWidth = '1rem';
			}
		});
	}

	initBaguetteBox()
	{
		baguetteBox.run( '.galleryImages', {
			captions: false,
			buttons: 'auto',
			fullScreen:	false,
			noScrollbars: true,
			titleTag: false,
			async: false,
			preload: 2,
			animation: 'slideIn',
			overlayBackgroundColor:	'rgba( 0, 0, 0, .9 )'
		});
	}
}

///////////////////////////


const app = new App();
app.init();
