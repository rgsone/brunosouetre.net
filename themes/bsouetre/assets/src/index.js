/* CSS */
import './style/app.scss';
/* JS */
import jump from 'jump.js';
import Blazy from 'blazy/blazy.min';

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
			this.initTopLink();
			this.initTopLinkVisibilityManagement();
		}
		// archives
		else if ( urlPath.match( /^archives$/g ) )
		{
			this.initTopLink();
			this.initTopLinkVisibilityManagement();
		}
		// project
		else if ( urlPath.match( /^projet\/[a-z0-9_\-]+$/g ) )
		{
			this.initTopLink();
			this.initTopLinkVisibilityManagement();
		}
		// about
		else if ( urlPath.match( /^a\-propos$/g ) )
		{
			this.initTopLink();
			this.initTopLinkVisibilityManagement();
		}
		// contact
		else if ( urlPath.match( /^contact$/g ) )
		{

		}
	}

	initTopLink()
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

	initTopLinkVisibilityManagement()
	{
		this.isHideTopLink = true;
		this.topLinkEl = document.querySelector( '[data-backtotop]' );

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
		this.currentViewportHeight = Math.max( document.documentElement.clientHeight, window.innerHeight || 0 );
		this.setTopLinkVisibility();
	}

	setTopLinkVisibility()
	{
		const yOffset = window.scrollY || window.pageYOffset;

		if ( yOffset > this.currentViewportHeight && this.isHideTopLink )
		{
			this.topLinkEl.classList.remove( 'hide' );
			this.isHideTopLink = false;
		}
		else if ( yOffset < this.currentViewportHeight && !this.isHideTopLink )
		{
			this.topLinkEl.classList.add( 'hide' );
			this.isHideTopLink = true;
		}
	}

	initBlazy()
	{
		/*
		this._blazy = new Blazy({
			selector: '.lazyImg',
			success: ( element ) => {

				element.onload = ( evt ) => {

					const img = evt.target;
					const parent = element.parentNode;

					img.classList.add( 'imgLoaded' );

					parent.style.minWidth = 0;

					parent.style.background = 'none';

				};

			}
		});
		*/
	}
}

///////////////////////////


const app = new App();
app.init();
