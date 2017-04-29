<?php

namespace BSouetre\Site\Updates;

use BSouetre\Site\Models\Category;
use BSouetre\Site\Models\Link;
use BSouetre\Site\Models\Project;
use BSouetre\Site\Models\Tag;
use Carbon\Carbon;
use October\Rain\Database\Updates\Seeder;
use October\Rain\Support\Facades\Config;

class SeedTables extends Seeder
{
	public function run()
	{
		## Add few links

		Link::create([ 'name' => 'rgsone', 'url' => 'http://rgsone.com' ]);
		Link::create([ 'name' => 'Sandrine la Sardine', 'url' => 'http://www.sandrineherlin.net' ]);
		Link::create([ 'name' => 'Galerie 400%', 'url' => 'http://www.400pourcent.net' ]);

		## Add few categories

		Category::create([
			'name' => 'En cours',
			'color' => '#86ff4e',
			'description' => 'Projets/travaux en cours'
		]);

		Category::create([
			'name' => 'Images en vrac',
			'color' => '#ff4e00'
		]);

		Category::create([
			'name' => 'Projets',
			'color' => '#1420cc'
		]);

		## Add few tags

		Tag::create([ 'name' => 'Le PASS' ]);
		Tag::create([ 'name' => 'Médiathéque de Roubaix' ]);
		Tag::create([ 'name' => 'Affiches' ]);
		Tag::create([ 'name' => 'In Situ' ]);
		Tag::create([ 'name' => 'Edition' ]);
		Tag::create([ 'name' => 'Signalétique' ]);
		Tag::create([ 'name' => 'PCF' ]);

		## Add few projects

		Project::create([
			'title' => 'PARTIcipe présent',
			'category_id' => 3,

			'content' => 'Une invitation à produire  
une affiche autour de cette question :  
"Quelle affiche rêveriez-vous que le parti communiste vous commande ?"

Présentée dans l’exposition [PARTIcipe présent](http://www.pcf.fr/58455) présentée à la fête de l\'Humanité 2014

![rien qu\'du bonheur](/storage/app/media/rien-qu-du-bonheur.png)',

			'date' => Carbon::createFromDate( 2014, 9, 12, Config::get( 'app.timezone' ) )->toDateTimeString(),
			'show_date' => true,
			'date_format' => 1,

			'published' => true,
			'private' => false,
			'featured' => false
		]);

		Project::create([
			'title' => 'Signalétique du Pass',
			'category_id' => 3,

			'content' => '[http://www.pass.be, Parc d’aventures scientifiques](http://www.pass.be), Frameries (B)

**JUIN 2016**

Une nouvelle signalétique pour les 28 hectares du site! ABCD… pour un repérage simple, chaque bâtiment est maintenant identifié par une lettre.  
Le système signalétique est décliné suivant une typologie précise. Enseignes pour marquer les entrées de bâtiments, balises informatives pour s\'orienter et s\'informer, guides pour se diriger vers les différents services et zones de proximité.

La couleur est réduite au minimum. La gestion des langues se fait par le biais des 3 graisses qui composent la typographie.

Projet mené de 2015 à 2016 avec [Orane Preux](http://oranepreux.fr) (Graphisme) et Éric Verrier (Design mobilier), Design interactif [Rudy Marc](http://rgsone.com).

Photos Gilles Dupuis

![](/storage/app/media/pass-signaletique/pass-signaletique-4.jpg)
![](/storage/app/media/pass-signaletique/pass-signaletique-2.png)',

			'date' => Carbon::createFromDate( 2016, 6, 1, Config::get( 'app.timezone' ) )->toDateTimeString(),
			'show_date' => true,
			'date_format' => 1,

			'published' => true,
			'private' => false,
			'featured' => false
		]);
	}
}
