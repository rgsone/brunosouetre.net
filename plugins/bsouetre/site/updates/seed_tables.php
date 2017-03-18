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

		Link::create([
			'name' => 'rgsone',
			'url' => 'http://rgsone.com'
		]);

		Link::create([
			'name' => 'Sandrine la Sardine',
			'url' => 'http://www.sandrineherlin.net'
		]);

		Link::create([
			'name' => 'Galerie 400%',
			'url' => 'http://www.400pourcent.net'
		]);

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

		Tag::create([ 'name' => 'le pass' ]);
		Tag::create([ 'name' => 'médiathéque de roubaix' ]);
		Tag::create([ 'name' => 'affiche' ]);
		Tag::create([ 'name' => 'in situ' ]);
		Tag::create([ 'name' => 'édition' ]);

		## Add test project

		Project::create([
			'title' => 'PARTIcipe présent',
			'content' => 'Une invitation à produire  
une affiche autour de cette question :  
"Quelle affiche rêveriez-vous que le parti communiste vous commande ?"

Présentée dans l’exposition [PARTIcipe présent](http://www.pcf.fr/58455) présentée à la fête de l\'Humanité 2014',
			'date' => Carbon::createFromDate( 2014, 9, 12, Config::get( 'app.timezone' ) )->toDateTimeString()
		]);
	}
}
