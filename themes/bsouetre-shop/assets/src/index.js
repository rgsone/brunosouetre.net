/* CSS */
import './style/app.scss';
/* JS */
import jump from 'jump.js';

// Hello !

console.log( '%c /> shop.brunosouetre.net ', 'background: #333; color: #fc5454' );
console.log( '%c /> handmade by rgsone.com ', 'background: #333; color: #fc5454' );

/* App */
class App
{

	init()
	{
		this.initTopAnchorLink();
		this.initTopLinkVisibilityManagement();
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
}

///////////////////////////


const app = new App();
app.init();
