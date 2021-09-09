<?php
use yii\helpers\Html;

$img = Yii::getAlias('@web').'/images/';
$style = '';
$style = 'border-width: 0px; background: url('. $img .'reverse-fade.png) no-repeat; background-size: cover;';
/* @var $this \yii\web\View */
/* @var $content string */

?>

<style type="text/css">
    .hover-icon:hover {
        opacity: 0.65;
    }
    li.user-header {
        height: 15px;
        text-align: center;
    }
</style>

<header class="main-header" >

    <?= Html::a('<span class="logo-mini" style="background-color: #5300a8;">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo', 'style' => "background-color: #5300a8;"]) ?>

    <nav class="navbar navbar-static-top" role="navigation" style="<?=$style;?>">

        <a href="#" data-toggle="push-menu" role="button">
            <?= Html::img('@web/images/align.png',['class' => 'hover-icon' ,'style' => 'width: 25px; padding-top: 12px; margin-left: 10px;']) ?>
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs" style="color: #6800e8; font-weight: 600;"><?=Yii::$app->user->identity->name?>&nbsp<?=Yii::$app->user->identity->surname?></span>
                    </a>
                    <ul class="dropdown-menu custiom-user-footer">
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a(
                                    'Мой профиль',
                                    [Yii::$app->homeUrl.'/myprofile'],
                                    ['data-method' => 'post', 'class' => 'btn btn-info-my']
                                ) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Выйти',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-success-my']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>
