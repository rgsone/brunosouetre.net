<?php

namespace BSouetre\Site\Updates;

use BSouetre\Site\Models\Link;
use October\Rain\Database\Updates\Seeder;

class SeedTables extends Seeder
{
	public function run()
	{
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
	}
}
