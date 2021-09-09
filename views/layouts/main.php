<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Sitesettings;

$img = Yii::getAlias('@web').'/images/';

AppAsset::register($this);

$settings = Sitesettings::find()->one();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style type="text/css">
        .navbar-brand {
            color: #fcba03;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div style="background: url(<?= $img ?>fade.png);">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/images/icons/' . ((!is_null($settings)) ? $settings->photo : 'logo.png'), ['height' => '40px', 'alt' => (!is_null($settings)) ? $settings->name : 'Сайт', 'style' => 'margin-top: -10px;']),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
            'style' => 'color: #fff; border-width: 0px; background: url('. $img .'fade.png) no-repeat; background-size: cover;'
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            ['label' => 'Главная', 'url' => Yii::$app->homeUrl, 'linkOptions' => ['class' => 'navbar-mainlink']],
            ['label' => 'Предприятия', 'url' => [Yii::$app->homeUrl.'/company'], 'linkOptions' => ['class' => 'navbar-company']],
            ['label' => 'Новости', 'url' => [Yii::$app->homeUrl.'/news'], 'linkOptions' => ['class' => 'navbar-news']],
            ['label' => 'О нас', 'url' => [Yii::$app->homeUrl.'/about'], 'linkOptions' => ['class' => 'navbar-about']],
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            Yii::$app->user->isGuest ? (
                ['label' => 'Регистрация', 'url' => [Yii::$app->homeUrl.'/signup'], 'linkOptions' => ['class' => 'navbar-signup']]
            ) : (['label' => 'Мой профиль', 'url' => [Yii::$app->homeUrl.'/myprofile'], 'linkOptions' => ['class' => 'navbar-profile']]),
            Yii::$app->user->isGuest ? (
                ['label' => 'Войти', 'url' => ['/login'], 'linkOptions' => ['class' => 'navbar-login']]
            ) : (
                '<li>'
                . Html::beginForm([Yii::$app->homeUrl.'/site/logout'], 'post')
                . Html::submitButton(
                    'Выйти (' . Yii::$app->user->identity->name . ')',
                    ['class' => 'btn btn-link logout navbar-logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>
    </div>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left"><?= (!is_null($settings)) ? $settings->leftfooter : '';?></p>

        <p class="pull-right"><?= (!is_null($settings)) ? $settings->rightfooter : ''; ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
