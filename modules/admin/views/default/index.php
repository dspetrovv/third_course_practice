<?php

use app\models\User;
use app\models\Company;
use app\models\Excursions;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Администраторская";

?>
<head>
    <link href="<?=Yii::getAlias('@web') . '/css/links.css'?>" rel="stylesheet">
<style type="text/css">
        .frm .form-control {
            width: 30%;
        }
        .formdrop .form-control {
            width: 40%;
        }
        .formdscr .form-control {
            width: 50%;
        }
        .formtxt .form-control {
            width: 70%;
        }
    </style>
</head>

<body>

<div class="row">
    <div class="col-md-6">
        <h4 align="center"><b>Новые пользователи</b></h4>
        <?php if (!is_null($registrations) && count($registrations) !== 0): ?>
            <table class="table table-hover" style="border-radius: 10px">
                <tbody>
                    <?php foreach ($registrations as $user): ?>
                    <tr>
                        <td>
                            <?= User::findOne(['id' => $user->id])->name;?>
                            <?= User::findOne(['id' => $user->id])->surname;?>
                            зарегистрировался на сайте
                        </td>
                    </tr>
                    <?php endforeach ?>
                    <tr>
                        <td>
                            <a href="<?= Yii::$app->homeUrl . 'admin/users'?>">
                                Посмотреть всех пользователей
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <h3 align="center">Пользователей пока нет</h3>
        <?php endif; ?>
    </div>

    <div class="col-md-6">
        <h4 align="center"><b>Статистика сайта</b></h4>
        <table id="table1" class="table table-hover" style="border-radius: 10px">
            <tbody>
                <tr>
                    <th scope="row">Имя сайта</th>
                    <td><?= (!is_null($settings)) ? $settings->name : 'Сайт';?></td>
                </tr>
                <tr>
                    <th scope="row">Количество предприятий</th>
                    <td><?=Company::find()->count();?></td>
                </tr>
                <tr>
                    <th scope="row">Количество пользователей</th>
                    <td><?=User::find()->count();?></td>
                </tr>
                <tr>
                    <th scope="row">Активно экскурсий</th>
                    <td><?=Excursions::find()->where('date > "'. Yii::$app->formatter->asDatetime($newDate->getDate(),'YYYY-MM-dd HH:mm:ss') .'" and status = 1')->count();?></td>
                </tr>
                <tr>
                    <th scope="row">Прошло экскурсий</th>
                    <td><?=Excursions::find()->where('date < "'. Yii::$app->formatter->asDatetime($newDate->getDate(),'YYYY-MM-dd HH:mm:ss') .'" or status = 0')->count();?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

</body>