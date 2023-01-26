<?php

namespace BSouetre\SubDomainThemeSwitch;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;
use System\Classes\PluginBase;

/**
 * Class Plugin
 * @package BSouetre\SubDomainThemeSwitch
 */
class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'SubDomainThemeSwitch',
            'description' => 'Bind theme to current subdomain',
            'author' => 'rgsone',
            'icon' => 'icon-leaf'
        ];
    }

    public function boot()
    {
    	# if backend > skip
		if (App::runningInBackend()) return;

		$currentHost = Request::getHost();
		$allowedDomains = Config::get('bsouetre.subdomainthemeswitch::allowed_domains');
		$subdomains = Config::get('bsouetre.subdomainthemeswitch::subdomains');
		$matchDomain = false;

		# check if current host match allowed domain
		foreach ($allowedDomains as $domain) {
			if (preg_match('/'.$domain.'$/i', $currentHost)) {
				$matchDomain = true;
				break;
			}
		}

		# no match > skip
		if (!$matchDomain) return;

		# check if subdomain match
		Event::listen('cms.theme.getActiveTheme', function () use ($subdomains, $currentHost) {
			foreach ($subdomains as $subdomain => $themeName) {
				# check if match defined subdomain
				if (preg_match('/'.$subdomain.'\./i', $currentHost)) return $themeName;
			}
		});
    }
}
