<?php

function navigation_array($selected = false)
{

    $navigation = [
        [
            'title' => 'City Portal',
            'sections' => [
                [
                    'title' => 'Geography',
                    'id' => 'geography',
                    'pages' => [
                        [
                            'icon' => 'bm-roadview',
                            'url' => '/maps/dashboard',
                            'title' => 'Maps',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/maps/dashboard',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Map Quick Edit',
                                    'url' => '/maps/quick',
                                    'colour' => 'red'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Visit BrickMMO Maps',
                                    'url' => 'https://maps.brickmmo.com',
                                    'colour' => 'orange'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/maps',
                                    'colour' => 'orange'
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/uptime/maps',
                                    'colour' => 'orange'
                                ]
                            ]   
                        ],[
                            'icon' => 'bm-roadview',
                            'url' => '/roadview/dashboard',
                            'title' => 'Roadview',
                        ],[
                            'icon' => 'bm-roadview',
                            'url' => '/maps/places',
                            'title' => 'Places',
                        ]
                    ],
                ],[
                    'title' => 'Control',
                    'id' => 'control',
                    'pages' => [
                        [
                            'icon' => 'bm-control-panel',
                            'url' => '/control-panel',
                            'title' => 'Control Panel',
                        ],[
                            'icon' => 'bm-control-brix',
                            'url' => '/clock/dashboard',
                            'title' => 'Clock',
                        ]
                    ],
                ],[
                    'title' => 'Transportation',
                    'id' => 'transportation',
                    'pages' => [
                        [
                            'icon' => 'bm-navigation',
                            'url' => '/navigation/dashboard',
                            'title' => 'Navigation',
                        ],[
                            'icon' => 'bm-tracks',
                            'url' => '/tracks/dashboard',
                            'title' => 'Tracks',
                        ],[
                            'icon' => 'bm-train',
                            'url' => '/train/dashboard',
                            'title' => 'Train',
                        ],
                    ],
                ],[
                    'title' => 'Students',
                    'id' => 'students',
                    'pages' => [
                        [
                            'icon' => 'bm-brick-overflow',
                            'url' => '/brick-overflow/dashboard',
                            'title' => 'Brick Overflow',
                        ],[
                            'icon' => 'bm-flow',
                            'url' => '/flow/dashboard',
                            'title' => 'Flow',
                        ],[
                            'icon' => 'bm-timesheets',
                            'url' => '/timesheets/dashboard',
                            'title' => 'Timesheets',
                        ],
                    ],
                ],[
                    'title' => 'Community',
                    'id' => 'community',
                    'pages' => [
                        [
                            'icon' => 'bm-radio',
                            'url' => '/radio/dashboard',
                            'title' => 'Radio',
                        ],[
                            'icon' => 'bm-events',
                            'url' => '/events/dashboard',
                            'title' => 'Events',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/events/dashboard',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Event List',
                                    'url' => '/events/list',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Registration List',
                                    'url' => '/events/registrations/list',
                                    'colour' => 'red'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Visit Events App',
                                    'url' => 'https://events.brickmmo.com',
                                    'colour' => 'orange'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/events',
                                    'colour' => 'orange'
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/uptime/stats',
                                    'colour' => 'orange'
                                ]
                            ]
                        ],[
                            'icon' => 'bm-qr-codes',
                            'url' => '/qr-codes/dashboard',
                            'title' => 'Qr Codes',
                        ],
                    ],
                ],[
                    'title' => 'Social',
                    'id' => 'social',
                    'pages' => [
                        [
                            'icon' => 'bm-brix',
                            'url' => '/brix/dashboard',
                            'title' => 'Brix',
                        ],[
                            'icon' => 'bm-timeline',
                            'url' => '/timeline/dashboard',
                            'title' => 'Timeline',
                        ],
                    ],
                ],[
                    'title' => 'Finances',
                    'id' => 'finances',
                    'pages' => [
                        [
                            'icon' => 'bm-crypto',
                            'url' => '/crypto/dashboard',
                            'title' => 'Crypto',
                        ],
                    ],
                ],
            ],
        ],[
            'title' => 'Administration',
            'sections' => [
                [
                    'title' => 'Content',
                    'id' => 'admin-content',
                    'pages' => [
                        [
                            'icon' => 'bm-bricksum',
                            'url' => '/bricksum/dashboard',
                            'title' => 'Bricksum',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/bricksum/dashboard',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Modify Word List',
                                    'url' => '/bricksum/wordlist',
                                    'colour' => 'red'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Visit Bricksum App',
                                    'url' => 'https://bricksum.brickmmo.com',
                                    'colour' => 'orange'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/bricksum',
                                    'colour' => 'orange'
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/uptime/stats',
                                    'colour' => 'orange'
                                ]
                            ]
                        ],[
                            'icon' => 'bm-colours',
                            'url' => '/colours/dashboard',
                            'title' => 'Colours',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/colours/dashboard',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Import Colours',
                                    'url' => '/colours/import',
                                    'colour' => 'red'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Visit Colors App',
                                    'url' => 'https://colours.brickmmo.com',
                                    'colour' => 'orange'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/colours',
                                    'colour' => 'orange'
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/uptime/stats',
                                    'colour' => 'orange'
                                ]
                            ]
                        ],[
                            'icon' => 'bm-parts',
                            'url' => '/parts/dashboard',
                            'title' => 'Parts',
                        ],[
                            'icon' => 'bm-stores',
                            'url' => '/stores/dashboard',
                            'title' => 'Stores',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/stores/dashboard',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Import Stores',
                                    'url' => '/stores/import',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Import Countries',
                                    'url' => '/stores/countries',
                                    'colour' => 'red'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Visit Stores App',
                                    'url' => 'https://stores.brickmmo.com',
                                    'colour' => 'orange'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/stores',
                                    'colour' => 'orange'
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/uptime/stats',
                                    'colour' => 'orange'
                                ]
                            ]
                        ],[
                            'icon' => 'bm-media',
                            'url' => '/media/dashboard',
                            'title' => 'Media',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/media/dashboard',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Images',
                                    'url' => '/media/images',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Videos',
                                    'url' => '/media/videos',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Tags',
                                    'url' => '/media/tags',
                                    'colour' => 'red'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Visit BrickMMO Media',
                                    'url' => 'https://media.brickmmo.com',
                                    'colour' => 'orange'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/maps',
                                    'colour' => 'orange'
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/uptime/maps',
                                    'colour' => 'orange'
                                ]
                            ] 
                        ]
                    ],
                ],[
                    'title' => 'Finances',
                    'id' => 'admin-finances',
                    'pages' => [
                        [
                            'icon' => 'bm-crypto',
                            'url' => '/crypto/dashboard',
                            'title' => 'Crypto',
                        ],
                    ],
                ],[
                    'title' => 'Tools',
                    'id' => 'admin-tools',
                    'pages' => [
                        [
                            'icon' => 'bm-github',
                            'url' => '/github/dashboard',
                            'title' => 'GitHub Scanner', 
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/github/dashboard',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Scan Results',
                                    'url' => '/github/results',
                                    'colour' => 'red'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'BrickMMO on GitHub',
                                    'url' => 'https://github.com/BrickMMO',
                                    'colour' => 'orange'
                                ],[
                                    'title' => 'codeadamca on GitHub',
                                    'url' => 'https://github.com/codeadamca',
                                    'colour' => 'orange'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/stats/github',
                                    'colour' => 'orange'
                                ]
                            ],[
                                'icon' => 'bm-uptime',
                                'url' => '/uptime/dashboard',
                                'title' => 'Up Time',
                            ],[
                                'icon' => 'bm-stats',
                                'url' => '/stats/dashboard',
                                'title' => 'Stats',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ];

    if($selected)
    {
        
        $selected = '/'.$selected;
        $selected = str_replace('//', '/', $selected);
        $selected = str_replace('.php', '', $selected);
        $selected = str_replace('.', '/', $selected);
        $selected = substr($selected, 0, strrpos($selected, '/'));

        foreach($navigation as $levels)
        {

            foreach($levels['sections'] as $section)
            {

                foreach($section['pages'] as $page)
                {

                    if(strpos($page['url'], $selected) === 0)
                    {
                        return $page;
                    }

                }

            }

        }

    }

    return $navigation;

}