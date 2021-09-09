<?php

use \yii\widgets\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;

?>

<style type="text/css">
    .frm .form-control {
        width: 60%;
    }
</style>

<script type="text/javascript">
    function rulescheck() {
        if (document.getElementById('idrules').checked){
            document.getElementById('idsignup').disabled = false;
        } else if (!document.getElementById('idrules').checked){
            document.getElementById('idsignup').disabled = true;
        } 
    }
</script>

<body>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-5" align="center">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin(); ?>

        <div class="frm">
            <?= $form->field($model, 'name')->textInput(['autofocus' => true,'title' => 'Ваше имя'])->label('Имя'); ?>
        </div>

        <div class="frm">
            <?= $form->field($model, 'surname')->textInput(['title' => 'Ваша фамилия'])->label('Фамилия'); ?>
        </div>

        <div class="frm">
            <?= $form->field($model, 'email')->textInput(['title' => 'Ваш адрес электронной почты'])->label('Почта'); ?>
        </div>

        <div class="frm">
            <?= $form->field($model, 'password')->passwordInput(['title' => 'Пароль от 6 до 12 символов'])->label('Пароль') ?>
        </div>

        <p>
        <input type="checkbox" id="idrules" onclick="rulescheck();" title="Правила сайта">Я прочёл <a href="<?=Yii::$app->homeUrl . 'site/rules';?>" style="color: #6800e8; font-weight: 600;" title="Правила сайта">правила сайта</a>
        </p>

        <div class="frm">
            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(),
                [
                'captchaAction' => Yii::$app->homeUrl.'site/captcha',
                'template' => '<div class="row"><div class="col-lg-2">{image}</div><div class="col-lg-10">{input}</div></div>'
                ])->label(false);
            ?>
        </div>
        <div>
            <button type="submit" class="btn btn-success-my" id="idsignup" disabled="true" title="Зарегистрироваться">Зарегистрироваться</button>
        </div>

        <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-3"></div>
    </div>



</body>