<?php

namespace BSouetre\Shop\Updates;

use BSouetre\Shop\Models\Item;
use Carbon\Carbon;
use October\Rain\Database\Updates\Seeder;
use October\Rain\Support\Facades\Config;

/**
 * Class SeedTables
 * @package BSouetre\Shop\Updates
 */
class SeedTables extends Seeder
{
	public function run()
	{
		## Add items

		Item::create([
			'title' => 'Les petites histoires',
			'description' => 'Les petites histoires, 2009
sérigraphie 2 couleurs (couleur "chocolat" + fluo rouge)
46 x 64 cm
Tirages numérotés et signés (100 ex.)
—
Éditées par la médiathèque de Roubaix à l\'occasion de son 30e anniversaire
Imprimées chez Alain Buyse à Lille

01 - Depuis son plus jeune âge il aspirait au plus haut niveau…
02 - Un beau matin elle décida de quitter la Terre…
03 - Il tâta son poulpe et découvrit avec effroi qu\'il était trop tard…

20 € pièce / 50 € la série
+ frais de port',
			'published' => true
		]);

		Item::create([
			'title' => 'Les petites histoires 2',
			'description' => 'Les petites histoires, 2009
sérigraphie 2 couleurs (couleur "chocolat" + fluo rouge)
46 x 64 cm
Tirages numérotés et signés (100 ex.)
—
Éditées par la médiathèque de Roubaix à l\'occasion de son 30e anniversaire
Imprimées chez Alain Buyse à Lille

01 - Depuis son plus jeune âge il aspirait au plus haut niveau…
02 - Un beau matin elle décida de quitter la Terre…
03 - Il tâta son poulpe et découvrit avec effroi qu\'il était trop tard…

20 € pièce / 50 € la série
+ frais de port',
			'published' => false
		]);

		Item::create([
			'title' => 'Les petites histoires 3',
			'description' => '!>[Les Petites Histoires](/storage/app/media/petites-histoires.png)

Les petites histoires, 2009  
sérigraphie 2 couleurs (couleur "chocolat" + fluo rouge)  
46 x 64 cm  
Tirages numérotés et signés (100 ex.)  
—  
[Éditées par la médiathèque de Roubaix à l\'occasion de son 30e anniversaire](http://www.brunosouetre.net/archives/projet-15.html)  
[Imprimées chez Alain Buyse à Lille](http://a-buyse.tumblr.com)

01 - Depuis son plus jeune âge il aspirait au plus haut niveau…  
02 - Un beau matin elle décida de quitter la Terre…  
03 - Il tâta son poulpe et découvrit avec effroi qu\'il était trop tard…

20 € pièce / 50 € la série  
+ frais de port',
			'published' => true
		]);

		Item::create([
			'title' => 'Les VRAIES Petites Histoires',
			'description' => '!>[Les Petites Histoires](/storage/app/media/petites-histoires.png)

Les petites histoires, 2009  
sérigraphie 2 couleurs (couleur "chocolat" + fluo rouge)  
46 x 64 cm  
Tirages numérotés et signés (100 ex.)  
—  
[Éditées par la médiathèque de Roubaix à l\'occasion de son 30e anniversaire](http://www.brunosouetre.net/archives/projet-15.html)  
[Imprimées chez Alain Buyse à Lille](http://a-buyse.tumblr.com)

01 - Depuis son plus jeune âge il aspirait au plus haut niveau…  
02 - Un beau matin elle décida de quitter la Terre…  
03 - Il tâta son poulpe et découvrit avec effroi qu\'il était trop tard…

20 € pièce / 50 € la série  
+ frais de port',
			'published' => true
		]);
	}
}
