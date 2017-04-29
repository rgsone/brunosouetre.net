<?php

namespace BSouetre\Shop;

use Backend\Facades\Backend;
use System\Classes\PluginBase;

/**
 * Class Plugin
 * @package BSouetre\Shop
 */
class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'BrunoSouetreShop',
            'description' => 'Gestion du shop',
            'author' => 'rgsone',
            'icon' => 'icon-shopping-cart'
        ];
    }

	public function registerComponents()
	{
		return [
			'BSouetre\Shop\Components\HomePage' => 'shopHomePage'
		];
	}

    public function registerPermissions()
    {
        return [
            'bsouetre.shop.access_shop' => [
                'tab' => 'Shop',
                'label' => 'Gestion du shop'
            ],
			'bsouetre.shop.access_items' => [
				'tab' => 'Shop',
				'label' => 'Gestion des articles'
			]
        ];
    }

    public function registerNavigation()
    {
        return [
            'shop' => [

                'label' => 'Shop',
                'url' => Backend::url( 'bsouetre/shop/items' ),
                'icon' => 'icon-shopping-cart',
                'permissions' => [ 'bsouetre.shop.*' ],
                'order' => 12,

				'sideMenu' => [

					'items' => [
						'label' => 'Articles',
						'icon' => 'icon-cart-plus',
						'url' => Backend::url( 'bsouetre/shop/items' ),
						'permissions' => [ 'bsouetre.shop.access_items' ]
					]

				]

            ]
        ];
    }
}
