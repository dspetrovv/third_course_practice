<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Предприятия';
$this->params['breadcrumbs'][] = $this->title;
//#fcba03
?>
                   
<body>
    <div class="row">
        <div class="col-md-12" style='background-color: transparent;'>
<?php if (!is_null($companyname) && count($companyname) !== 0): ?>            
    <?php foreach ($companyname as $key => $company): ?>
        <?php if ($key==0 || $key%2==0): ?><div class="row"><?php endif;?>
            <div class="col-md-6">
                <a href="<?=Yii::$app->homeUrl . 'company/company?id=' . $company->id?>">
                    <h3 align="justify">
                        <?php echo $company->companyname;?>
                    </h3>
                    <?= Html::img('@web/images/'. $company->companyphoto,['class' => 'image-company']);?>
                </a>
            </div>
        <?php if ($key==1 || ($key+1)%2==0  || $count==1): ?></div><?php endif;?>
    <?php endforeach ?>

            <div class="row" align="center">
                <div class="col-md-12">
                    <?php echo LinkPager::widget([
                        'pagination' => $pagination,'linkOptions' => ['class' => 'myclass']
                    ]);?>
                </div>
            </div>
    
<?php else: ?>
    <h1>Предприятий пока нет</h1>
<?php endif; ?>

        </div>
    </div>
</body>