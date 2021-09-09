<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;

?>

<style type="text/css">
    .frm .form-control {
        width: 60%;
    }
</style>

<body>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-5" align="center">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin(); ?>

        <div class="frm">
            <?= $form->field($model, 'email')->textInput(['autofocus' => true,'title' => 'Адрес электронной почты']) ?>
        </div>

        <div class="frm">
            <?= $form->field($model, 'password')->passwordInput(['title' => 'Пароль от 6 до 12 символов'])->label('Пароль') ?>
        </div>

        <div class="frm">
            <?= $form->field($model, 'rememberMe')->checkbox(['title' => 'Запомнить меня'])->label('Запомнить меня') ?>
        </div>

        <div>
            <button type="submit" class="btn btn-info-my" title="Войти в свою учётную запись">Войти</button>
        </div>

        <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-3"></div>
    </div>
</body>
