import './style/app.scss';
import jump from 'jump.js';

console.log( '%c /> brunosouetre.net ', 'background: #333; color: #fc5454' );
console.log( '%c /> handmade by rgsone.com ', 'background: #333; color: #fc5454' );

class App
{
	init()
	{
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
	}
}

///////////////////////////


const app = new App();
app.init();
