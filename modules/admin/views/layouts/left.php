<aside class="main-sidebar">

    <section class="sidebar">
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    ['label' => 'Главная', 'url' => [Yii::$app->homeUrl . 'admin']],
                    ['label' => 'Предприятия', 'url' => [Yii::$app->homeUrl . 'admin/company']],
                    ['label' => 'Новости', 'url' => [Yii::$app->homeUrl . 'admin/news']],
                    ['label' => 'Пользователи', 'url' => [Yii::$app->homeUrl . 'admin/users']],
                    ['label' => 'Экскурсии', 'icon' => 'share',
                        'items' => [
                            ['label' => 'Актуальные', 'url' => [Yii::$app->homeUrl . 'admin/excursion']],
                            ['label' => 'Прошедшие', 'url' => [Yii::$app->homeUrl . 'admin/excursion/excursionlist']]
                        ],
                    ],
                    ['label' => 'Настройки сайта', 'icon' => 'share',
                        'items' => [
                            ['label' => 'Основные', 'url' => [Yii::$app->homeUrl . 'admin/settings/main']],
                            ['label' => 'Правила сайта', 'url' => [Yii::$app->homeUrl . 'admin/settings/rules']],
                            ['label' => 'О нас', 'url' => [Yii::$app->homeUrl . 'admin/settings/about']]
                        ],
                    ],
                    ['label' => 'Приложение', 'icon' => 'share',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']]
                        ],
                    ],
                ]
            ]
        ) ?>

    </section>

</aside>
