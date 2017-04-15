/* CSS */
import './style/app.scss';
import 'baguettebox.js/src/baguetteBox.scss'
/* JS */
import jump from 'jump.js';
import Blazy from 'blazy/blazy.min';
import baguetteBox from 'baguettebox.js/dist/baguetteBox'

console.log( '%c /> brunosouetre.net ', 'background: #333; color: #fc5454' );
console.log( '%c /> handmade by rgsone.com ', 'background: #333; color: #fc5454' );

class App
{
	init()
	{
		// back to top

		const backToTopLink = document.querySelector( '[data-backtotop]' );
		const topAnchor = document.querySelector( '#top' );

		if ( null !== backToTopLink && null !== topAnchor ) {
			backToTopLink.addEventListener( 'click', ( e ) => {

				e.preventDefault();
				backToTopLink.blur();

				jump( topAnchor, {
					duration: 600
				});

			});
		}

		if ( null == document.querySelector( '.galleryImages' ) ) return;

		// Blazy

		const blazy = new Blazy({
			selector: '.lazyImg'
		});

		// BaguetteBox

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
