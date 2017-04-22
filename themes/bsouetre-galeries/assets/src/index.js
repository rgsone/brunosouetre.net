/* CSS */
import './style/app.scss';
/* JS */
import jump from 'jump.js';
import Blazy from 'blazy/blazy.min';
import baguetteBox from 'baguettebox.js/dist/baguetteBox';

// Hello !

console.log( '%c /> galeries.brunosouetre.net ', 'background: #333; color: #fc5454' );
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
			//this.initMatchMedia();
			this.initTopAnchorLink();
			this.initBlazy();
			this.initBaguetteBox();
		}
	}
/*
	initMatchMedia()
	{
		this._mq = window.matchMedia( '( max-width: 500px )' );
	}
*/
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

				element.onload = ( evt ) => {

					const img = evt.target;
					const parent = element.parentNode;

					img.classList.add( 'imgLoaded' );

					/*
					if ( !this._mq.matches ) parent.style.minWidth = img.width + 'px';
					else parent.style.minWidth = 0;
					*/

					parent.style.minWidth = 0;

					parent.style.background = 'none';

				};

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
