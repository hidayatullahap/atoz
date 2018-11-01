<?php namespace Atoz\Commerce;

use Backend;
use System\Classes\PluginBase;

/**
 * commerce Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'commerce',
            'description' => 'No description provided yet...',
            'author'      => 'Hidayatullah Agung P',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Atoz\Commerce\Components\Orders' => 'AtozAccount',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'atoz.commerce.some_permission' => [
                'tab' => 'commerce',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'commerce' => [
                'label'       => 'commerce',
                'url'         => Backend::url('atoz/commerce/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['atoz.commerce.*'],
                'order'       => 500,
            ],
        ];
    }
}
