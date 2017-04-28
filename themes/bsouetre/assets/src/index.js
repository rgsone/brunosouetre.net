/* CSS */
import './style/app.scss';
/* JS */
import jump from 'jump.js';
import LazyLoad from 'vanilla-lazyload/dist/lazyload';
import greeed from './js/greeed';

// Hello !

console.log( '%c /> brunosouetre.net ', 'background: #333; color: #fc5454' );
console.log( '%c /> handmade by rgsone.com ', 'background: #333; color: #fc5454' );

/* App */
class App
{
	constructor()
	{
		this._topLinkTopAnchorName = '#top';
		this._topLinkSelector = '[data-backtotop]';
		this._topLinkScrollDuration = 600;
		this._topLinkVisibilityClass = 'hide';

		this._greeedSelector = '.homeSelected > ul';
		this._greeedBreakpoints = [ 45, 90 ],
		this._greeedLayout = 'float';
		this._greeedElementColumnInner = false;
		this._greeedClassFakeItem = false;

		this._lazyLoadSelector = '.lazyImg';
		this._lazyLoadDataSrc = 'src';
		this._lazyLoadTreshold = 20;

		this._currentPage = '';
	}

	init()
	{
		let urlPath = window.location.pathname.replace( /\/+$/g, '' ).replace( /^\/+/g, '' );

		// home
		if ( urlPath == '' )
		{
			this._currentPage = 'home';

			this.initTopLink();
			this.initTopLinkVisibilityManagement();
			this.initGreeed();
			this.initLazyload();
		}
		// archives
		else if ( urlPath.match( /^archives$/g ) )
		{
			this._currentPage = 'archives';

			this.initTopLink();
			this.initTopLinkVisibilityManagement();
			this.initLazyload();
		}
		// project
		else if ( urlPath.match( /^projet\/[a-z0-9_\-]+$/g ) )
		{
			this._currentPage = 'project';

			this.initTopLink();
			this.initTopLinkVisibilityManagement();
		}
		// about
		else if ( urlPath.match( /^a\-propos$/g ) )
		{
			this._currentPage = 'about';

			this.initTopLink();
			this.initTopLinkVisibilityManagement();
		}
		// contact
		else if ( urlPath.match( /^contact$/g ) )
		{
			this._currentPage = 'contact';
			// ....
		}
	}

	initTopLink()
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

	initTopLinkVisibilityManagement()
	{
		this._isHideTopLink = true;
		this._topLinkEl = document.querySelector( this._topLinkSelector );

		this.setCurrentViewportHeight();

		window.addEventListener( 'resize', ( e ) => {
			this.setCurrentViewportHeight();
		}, false );

		window.addEventListener( 'scroll', () => {
			this.setTopLinkVisibility();
		}, false );
	}

	setCurrentViewportHeight()
	{
		this._currentViewportHeight = Math.max( document.documentElement.clientHeight, window.innerHeight || 0 );
		this.setTopLinkVisibility();
	}

	setTopLinkVisibility()
	{
		const yOffset = window.scrollY || window.pageYOffset;

		if ( yOffset > this._currentViewportHeight && this._isHideTopLink )
		{
			this._topLinkEl.classList.remove( this._topLinkVisibilityClass );
			this._isHideTopLink = false;
		}
		else if ( yOffset < this._currentViewportHeight && !this._isHideTopLink )
		{
			this._topLinkEl.classList.add( this._topLinkVisibilityClass );
			this._isHideTopLink = true;
		}
	}

	initGreeed()
	{
		greeed.bind( this._greeedSelector, {
			breakpoints: this._greeedBreakpoints,
			layout: this._greeedLayout,
			elementColumnInner: this._greeedElementColumnInner,
			classFakeItem: this._greeedClassFakeItem
		});
	}

	initLazyload()
	{
		this._lazyload = new LazyLoad({
			elements_selector: this._lazyLoadSelector,
			data_src: this._lazyLoadDataSrc,
			threshold: this._lazyLoadTreshold,
			callback_load: this.lazyImgOnLoad,
			callback_error: this.lazyImgOnError,
			callback_set: this.lazyImgOnSet
		});
	}

	lazyImgOnSet( el )
	{
		if ( el.tagName.toLowerCase() == 'img' ) return;

		const imgSrc = el.getAttribute( 'data-src' );
		const imgParent = el.parentNode;
		let tmpImg = new Image();

		tmpImg.onload = ( evt ) => {;
			imgParent.classList.add( 'bgLoaded' );
			tmpImg = null;
		};

		tmpImg.src = imgSrc;
	}

	lazyImgOnLoad( el )
	{
		if ( el.tagName.toLowerCase() != 'img' ) return;

		const parent = el.parentNode;
		setTimeout( ( elem ) => { elem.classList.remove( 'loading' ); }, 1000, parent );

		// check if archives page
		if ( null == document.querySelector( 'section.archivesContent' ) ) return;

		parent.style.minWidth = 0;
		parent.style.minHeight = 0;
	}

	lazyImgOnError( el )
	{
		// handle error
	}
}

///////////////////////////

const app = new App();
app.init();
