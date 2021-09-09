<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title)=='Not Found (#404)' ? 'Такой страницы не существует' : Html::encode($this->title) ?></h1>

    <?= nl2br(Html::encode($message)) ?>

    <p>
        Свяжитесь с нами, если вы считаете, что это ошибка сервера. Спасибо.
    </p>

</div>
