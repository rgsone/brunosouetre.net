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

    public function registerPermissions()
    {
        return [
            'bsouetre.shop.access_shop' => [
                'tab' => 'Shop',
                'label' => 'Gestion du shop'
            ]
        ];
    }

    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'shop' => [
                'label' => 'Shop',
                'url' => Backend::url( 'bsouetre/shop/mycontroller' ),
                'icon' => 'icon-shopping-cart',
                'permissions' => [ 'bsouetre.shop.*' ],
                'order' => 500
            ],
        ];
    }
}
