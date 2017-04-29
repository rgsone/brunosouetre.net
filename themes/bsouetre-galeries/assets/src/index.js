/* CSS */
import './style/app.scss';
/* JS */
import jump from 'jump.js';
import LazyLoad from 'vanilla-lazyload/dist/lazyload.transpiled';
import baguetteBox from 'baguettebox.js/dist/baguetteBox';

// Hello !

console.log( '%c /> galeries.brunosouetre.net ', 'background: #333; color: #fc5454' );
console.log( '%c /> handmade by rgsone.com ', 'background: #333; color: #fc5454' );

/* App */
class App
{
	constructor()
	{
		this._topLinkTopAnchorName = '#top';
		this._topLinkSelector = '[data-backtotop]';
		this._topLinkScrollDuration = 600;

		this._lazyLoadSelector = '.lazyImg';
		this._lazyLoadDataSrc = 'src';
		this._lazyLoadTreshold = 50;
	}

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
			this.initLazyload();
			this.initBaguetteBox();
		}
	}

	initTopAnchorLink()
	{
		const backToTopLink = document.querySelector( this._topLinkSelector );
		const topAnchor = document.querySelector( this._topLinkTopAnchorName );

		if ( null == backToTopLink || null == topAnchor ) return;

		backToTopLink.addEventListener( 'click', ( e ) => {
			e.preventDefault();
			backToTopLink.blur();
			jump( topAnchor, { duration: this._topLinkScrollDuration });
		});
	}

	initLazyload()
	{
		this._lazyload = new LazyLoad({
			elements_selector: this._lazyLoadSelector,
			data_src: this._lazyLoadDataSrc,
			threshold: this._lazyLoadTreshold,
			callback_load: this.lazyImgOnLoad
		});
	}

	lazyImgOnLoad( el )
	{
		if ( el.tagName.toLowerCase() != 'img' ) return;

		const parent = el.parentNode;

		parent.style.minWidth = 0;
		//parent.style.backgroundImage = 'none';
		setTimeout(( elem ) => { elem.style.background = 'none'; }, 200, parent );

		el.classList.add( 'imgLoaded' );
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
