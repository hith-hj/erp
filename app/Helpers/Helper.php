<?php

namespace App\Helpers;

use App\Models\Bill;
use App\Models\Cashier;
use App\Models\Client;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\Ledger;
use App\Models\Material;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Unit;
use App\Models\UserSetting;
use App\Models\Vendor;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class Helper
{
    public static function settings($key = null, $default = null)
    {
        ['inventory_minimum_quantity'];

        return $default;
    }

    public static function applClasses()
    {
        // Demo
        // $fullURL = request()->fullurl();
        // if (App()->environment() === 'production') {
        //     for ($i = 1; $i < 7; $i++) {
        //         $contains = Str::contains($fullURL, 'demo-' . $i);
        //         if ($contains === true) {
        //             $data = config('custom.' . 'demo-' . $i);
        //         }
        //     }
        // } else {
        //     $data = config('custom.main-dark');
        // }
        // $data = config('custom.main-dark');
        $data = [];
        if (auth()->check()) {
            $settings = UserSetting::where('user_id', auth()->user()->id)->get(['key', 'value'])->toArray();
            foreach ($settings as $setting) {
                match ($setting['key']) {
                    'theme' => $data[$setting['key']] = str_replace('-layout', '', $setting['value']),
                    'navbarColor' => $data[$setting['key']] = $setting['value'],
                    'verticalMenuNavbarType' => $data[$setting['key']] = str_replace('navbar-', '', $setting['value']),
                    default => '',
                };
            }
        }
        $data = count($data) > 0 ? $data : [
            'theme' => 'dark',
            'navbarColor' => '',
            'verticalMenuNavbarType' => 'floating',
        ];
        // default data array
        $DefaultData = [
            'mainLayoutType' => 'vertical',
            'theme' => 'light',
            'sidebarCollapsed' => false,
            'navbarColor' => '',
            'horizontalMenuType' => 'floating',
            'verticalMenuNavbarType' => 'floating',
            'footerType' => 'static', // footer
            'layoutWidth' => 'boxed',
            'showMenu' => true,
            'bodyClass' => '',
            'pageClass' => '',
            'pageHeader' => true,
            'contentLayout' => 'default',
            'blankPage' => false,
            'defaultLanguage' => 'en',
            'direction' => env('MIX_CONTENT_DIRECTION', 'ltr'),
        ];

        // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
        $data = array_merge($DefaultData, $data);

        // All options available in the template
        $allOptions = [
            'mainLayoutType' => ['vertical', 'horizontal'],
            'theme' => ['light' => 'light', 'dark' => 'dark-layout', 'bordered' => 'bordered-layout', 'semi-dark' => 'semi-dark-layout'],
            'sidebarCollapsed' => [true, false],
            'showMenu' => [true, false],
            'layoutWidth' => ['full', 'boxed'],
            'navbarColor' => ['bg-primary', 'bg-secondary', 'bg-info', 'bg-warning', 'bg-success', 'bg-danger', 'bg-dark'],
            'horizontalMenuType' => ['floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky'],
            'horizontalMenuClass' => ['static' => '', 'sticky' => 'fixed-top', 'floating' => 'floating-nav'],
            'verticalMenuNavbarType' => ['floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky', 'hidden' => 'navbar-hidden'],
            'navbarClass' => ['floating' => 'floating-nav', 'static' => 'navbar-static-top', 'sticky' => 'fixed-top', 'hidden' => 'd-none'],
            'footerType' => ['static' => 'footer-static', 'sticky' => 'footer-fixed', 'hidden' => 'footer-hidden'],
            'pageHeader' => [true, false],
            'contentLayout' => ['default', 'content-left-sidebar', 'content-right-sidebar', 'content-detached-left-sidebar', 'content-detached-right-sidebar'],
            'blankPage' => [false, true],
            'sidebarPositionClass' => ['content-left-sidebar' => 'sidebar-left', 'content-right-sidebar' => 'sidebar-right', 'content-detached-left-sidebar' => 'sidebar-detached sidebar-left', 'content-detached-right-sidebar' => 'sidebar-detached sidebar-right', 'default' => 'default-sidebar-position'],
            'contentsidebarClass' => ['content-left-sidebar' => 'content-right', 'content-right-sidebar' => 'content-left', 'content-detached-left-sidebar' => 'content-detached content-right', 'content-detached-right-sidebar' => 'content-detached content-left', 'default' => 'default-sidebar'],
            'defaultLanguage' => ['en' => 'en', 'fr' => 'fr', 'de' => 'de', 'pt' => 'pt'],
            'direction' => ['ltr', 'rtl'],
        ];

        // if mainLayoutType value empty or not match with default options in custom.php config file then set a default value
        foreach ($allOptions as $key => $value) {
            if (array_key_exists($key, $DefaultData)) {
                if (gettype($DefaultData[$key]) === gettype($data[$key])) {
                    // data key should be string
                    if (is_string($data[$key])) {
                        // data key should not be empty
                        if (isset($data[$key]) && $data[$key] !== null) {
                            // data key should not be exist inside allOptions array's sub array
                            if (! array_key_exists($data[$key], $value)) {
                                // ensure that passed value should be match with any of allOptions array value
                                $result = array_search($data[$key], $value, true);
                                if (empty($result) && $result !== 0) {
                                    $data[$key] = $DefaultData[$key];
                                }
                            }
                        } else {
                            // if data key not set or
                            $data[$key] = $DefaultData[$key];
                        }
                    }
                } else {
                    $data[$key] = $DefaultData[$key];
                }
            }
        }

        // layout classes
        $layoutClasses = [
            'theme' => $data['theme'],
            'layoutTheme' => $allOptions['theme'][$data['theme']],
            'sidebarCollapsed' => $data['sidebarCollapsed'],
            'showMenu' => $data['showMenu'],
            'layoutWidth' => $data['layoutWidth'],
            'verticalMenuNavbarType' => $allOptions['verticalMenuNavbarType'][$data['verticalMenuNavbarType']],
            'navbarClass' => $allOptions['navbarClass'][$data['verticalMenuNavbarType']],
            'navbarColor' => $data['navbarColor'],
            'horizontalMenuType' => $allOptions['horizontalMenuType'][$data['horizontalMenuType']],
            'horizontalMenuClass' => $allOptions['horizontalMenuClass'][$data['horizontalMenuType']],
            'footerType' => $allOptions['footerType'][$data['footerType']],
            'sidebarClass' => '',
            'bodyClass' => $data['bodyClass'],
            'pageClass' => $data['pageClass'],
            'pageHeader' => $data['pageHeader'],
            'blankPage' => $data['blankPage'],
            'blankPageClass' => '',
            'contentLayout' => $data['contentLayout'],
            'sidebarPositionClass' => $allOptions['sidebarPositionClass'][$data['contentLayout']],
            'contentsidebarClass' => $allOptions['contentsidebarClass'][$data['contentLayout']],
            'mainLayoutType' => $data['mainLayoutType'],
            'defaultLanguage' => $allOptions['defaultLanguage'][$data['defaultLanguage']],
            'direction' => $data['direction'],
        ];
        // set default language if session hasn't locale value the set default language
        if (! session()->has('locale')) {
            app()->setLocale($layoutClasses['defaultLanguage']);
        }

        // sidebar Collapsed
        if ($layoutClasses['sidebarCollapsed'] == 'true') {
            $layoutClasses['sidebarClass'] = 'menu-collapsed';
        }

        // blank page class
        if ($layoutClasses['blankPage'] == 'true') {
            $layoutClasses['blankPageClass'] = 'blank-page';
        }

        return $layoutClasses;
    }

    public static function updatePageConfig($pageConfigs)
    {
        $demo = 'custom';
        $fullURL = request()->fullurl();
        if (App()->environment() === 'production') {
            for ($i = 1; $i < 7; $i++) {
                $contains = Str::contains($fullURL, 'demo-' . $i);
                if ($contains === true) {
                    $demo = 'demo-' . $i;
                }
            }
        }
        if (isset($pageConfigs)) {
            if (count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    Config::set('custom.' . $demo . '.' . $config, $val);
                }
            }
        }
    }

    public static function getTreeData()
    {
        $maxItemCount = 200;
        return [
            'Materials' => [
                'route' => 'material.show',
                'data' => Material::select(['id', 'name'])->take($maxItemCount)->get(),
            ],

            'Inventories' => [
                'route' => 'inventory.show',
                'data' => Inventory::select(['id', 'name'])->take($maxItemCount)->get(),
            ],

            'Cashiers' => [
                'route' => 'cashier.show',
                'data' => Cashier::with(['ledgers.records'])->take($maxItemCount)->get(['id', 'name'])
                    ->map(function ($cashier) {
                        return (object) [
                            'id' => $cashier->id,
                            'name' => $cashier->name,
                            'sub' => [
                                'route' => 'ledger.records',
                                'items' => $cashier->ledgers->map(function ($ledger) {
                                    return (object) [
                                        'id' => $ledger->id,
                                        'name' => $ledger->created_at  ?? 'Ledger #' . $ledger->id,
                                    ];
                                })
                            ]
                        ];
                    }),
            ],

            'Bills' => [
                'route' => 'bill.show',
                'data' => Bill::all(['id', 'serial','billable_type',])
                    ->take($maxItemCount)
                    ->map(function ($bill) {
                        return (object) [
                            'id' => $bill->id,
                            'name' => $bill->getGetTypeAttribute() .' - '.$bill->serial,
                        ];
                    }),
            ],

            'Purchases' => [
                'route' => 'purchase.show',
                'data' => Purchase::with(['bill','vendor'])->take($maxItemCount)->get(['id','vendor_id'])
                    ->map(function ($purchase) {
                        return (object) [
                            'id' => $purchase->id,
                            'name' => $purchase->vendor->fullName.' - '.$purchase->bill->serial ?? 'No Serial',
                        ];
                    }),
            ],

            'Sales' => [
                'route' => 'sale.show',
                'data' => Sale::with(['bill','client'])->take($maxItemCount)->get(['id','client_id'])
                    ->map(function ($sale) {
                        return (object) [
                            'id' => $sale->id,
                            'name' => $sale->client->fullName.' - '.$sale->bill->serial ?? 'No Serial',
                        ];
                    }),
            ],

            'Clients' => [
                'route' => 'client.show',
                'data' => Client::select(['id', 'first_name', 'last_name'])->take($maxItemCount)->get()
                    ->map(function ($client) {
                        return (object) [
                            'id' => $client->id,
                            'name' => $client->first_name . ' ' . $client->last_name,
                        ];
                    }),
            ],

            'Vendors' => [
                'route' => 'vendor.show',
                'data' => Vendor::select(['id', 'first_name', 'last_name'])->take($maxItemCount)->get()
                    ->map(function ($vendor) {
                        return (object) [
                            'id' => $vendor->id,
                            'name' => $vendor->first_name . ' ' . $vendor->last_name,
                        ];
                    }),
            ],

            'Currency' => [
                'route' => 'currency.show',
                'data' => Currency::select(['id', 'name'])->take($maxItemCount)->get(),
            ],

            'Units' => [
                'route' => 'unit.show',
                'data' => Unit::select(['id', 'name'])->take($maxItemCount)->get(),
            ],
        ];
    }
}
