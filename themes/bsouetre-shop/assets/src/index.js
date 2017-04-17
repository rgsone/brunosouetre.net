/* CSS */
import './style/app.scss';
/* JS */
import jump from 'jump.js';
import Blazy from 'blazy/blazy.min';

// Hello !

console.log( '%c /> shop.brunosouetre.net ', 'background: #333; color: #fc5454' );
console.log( '%c /> handmade by rgsone.com ', 'background: #333; color: #fc5454' );

/* App */
class App
{

	init()
	{
		this.initTopAnchorLink();
		this.initBlazy();
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
		this._blazy = new Blazy({ selector: '.lazyImg' });
	}
}

///////////////////////////


const app = new App();
app.init();
