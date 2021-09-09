<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use app\models\Excursions;
use app\models\Company;
use yii\widgets\LinkPager;

$this->title = 'Мой профиль';
$this->params['breadcrumbs'][] = $this->title;

?>

<body>
    <div class="row">
        <div align=center class="col-md-12">
            <h1>
                <?= $profile->getUserData()->name?>
            </h1>
            <h1>
                <?= $profile->getUserData()->surname?>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-md-5">
            <?php if (!is_null($excursions) && count($excursions) !== 0) : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">
                            Текущие записи
                        </th>
                        <th scope="col">
                            Дата
                        </th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php foreach ($excursions as $excurs): ?>
                    <tr>
                        <td>
                            <?php
                            $currentexcurs = Excursions::findBySql('Select * From Excursions Where id = '. $excurs->idexcursion . ' and date >= "'. $date . '" order by date ASC')->one();
                            echo 
                                Company::find()->where('id = ' .
                                    $currentexcurs->idcompany
                                )->one()->companyname;
                            ?>
                        </td>
                        <td>
                            <?php
                                echo is_null($currentexcurs) ? 
                                    '' : 
                                Yii::$app->formatter->asDatetime($currentexcurs->date. Yii::$app->getTimeZone())
                            ?>
                        </td>
                    </tr>
                    <?php endforeach ?>  
                </tbody>
            </table>
            <div class="row" align="center">
                <div class="col-md-12">
                    <?php echo LinkPager::widget([
                        'pagination' => $paginationActiveExc,'linkOptions' => ['class' => 'myclass']
                    ]);?>
                </div>
            </div>
            <?php else : echo '<h3>Вы ещё никуда не записались</h3>';?>
            <?php endif; ?>
        </div>

        <div class="col-md-5">
            <?php if (!is_null($lastExcursions) && count($lastExcursions) !== 0) : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">
                            Посещённые экскурсии
                        </th>
                        <th scope="col">
                            Дата
                        </th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php foreach ($lastExcursions as $excurs): ?>
                    <tr>
                        <td>
                            <?php
                            $lastexcurs = Excursions::findBySql('Select * From Excursions Where id = '. $excurs->idexcursion . ' and date <= "'. $date . '" order by date ASC')->one();
                                if (!is_null($lastexcurs))
                                echo Company::find()->where('id = ' .
                                    $lastexcurs->idcompany
                                )->one()->companyname;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo is_null($lastexcurs) ? 
                                '' : 
                            Yii::$app->formatter->asDatetime($lastexcurs->date. Yii::$app->getTimeZone())
                            ?>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <div class="row" align="center">
                <div class="col-md-12">
                    <?php echo LinkPager::widget([
                        'pagination' => $paginationPastExc,'linkOptions' => ['class' => 'myclass']
                    ]);?>
                </div>
            </div>
            <?php else : echo '<h3>Вы ещё не посетили ни одной экскурсии</h3>';?>
            <?php endif;?>
        </div>
        <div class="col-md-1">
        </div>
    </div>
</body>