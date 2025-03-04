<?php

declare(strict_types=1);

return [

    'attributes' => [

        'created_at' => 'Vytvořeno',

        'answered_at' => 'Zodpovězeno',

        'overall_rating' => 'Celkové hodnocení',

        'teacher_approach_rating' => 'Hodnocení učitelů',

        'expectation_fulfillment_rating' => 'Hodnocení očekávání',

        'school-name' => 'Škola',

        'specialization' => [

            'enum-cases' => [

                'information-technology' => 'Informační technologie',

                'mechanical-electrotechnician' => 'Mechanik elektrotechnik',

                'technical-lyceum' => 'Technické lyceum',

                'electrician' => 'Elektrikář',

                'electrotechnics' => 'Elektrotechnika',

                'electromechanic-for-devices-and-instruments' => 'Elektromechanik pro zařízení a přístoje',

                'social-administration' => 'Sociální činnost',

                'economics-and-business' => 'Ekonomika a podnikání'
            ],

            'name' => 'Obor',

        ],

    ],

    'resource' => [

        'navigation-label' => 'Odpovědi',

        'slug' => 'odpovedi',

        'title' => 'Odpovědi',

        'model-label' => 'Odpověď',

        'plural-model-label' => 'Odpovědi',

        'actions' => [

            'create' => [

                'label' => 'Přidat nový záznam',

                'modal-heading' => 'Přidáváte nový záznam',

                'modal-description' => 'Přidáním nového záznamu se návštěvníkovi zpřístupní odpovězení na otázky pomocí QR kódu'

            ],

            'export' => [

                'label' => '',

                'modal-heading' => '',

                'modal-description' => '',
            ]

        ],

        'form' => [

            'components' => [

                'specialization' => [

                    'required-validation-message' => 'Prosím vyplňte obor, na který se návštěvník hlásí',

                ],

            ]

        ],

        'table' => [

            'heading' => 'Odpovědi',

            'actions' => [

                'edit' => [

                    'modal-heading' => 'Upravit odpověď',

                    'modal-description' => 'Upravujete odpověď ze dne :date'

                ],

                'restore' => [

                    'modal-heading' => 'Obnovujete odpověď z historie',

                    'modal-description' => 'Opravdu chcete obnovit tuto odpověď z historie?'

                ],


                'delete' => [

                    'modal-heading' => 'Odstraňujete odpověď',

                    'modal-description' => 'Opravdu chcete odstranit tuto odpověď?'

                ]

            ],

            'columns' => [

                'answered-at-placeholder' => 'Nebylo zodpovězeno',

                'school-name-placeholder' => 'Nebylo uvedeno / nalezeno'

            ],

            'bulk-actions' => [

                'restore' => [

                    'modal-heading' => 'Obnovujete odpovědi z historie',

                    'modal-description' => 'Opravdu chcete obnovit tyto odpovědi z historie?'

                ],


                'delete' => [

                    'modal-heading' => 'Odstraňujete odpovědi',

                    'modal-description' => 'Opravdu chcete odstranit tuto odpovědi?'

                ]

            ]

        ]

    ]

];
