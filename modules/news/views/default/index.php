<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;

?>

<body>
    <div class="row">
        <div class="col-md-12" style='background-color: transparent;'>
<?php if (!is_null($news) && count($news) !== 0): ?> 
    <?php foreach ($news as $key => $newsvalue): ?>
        <?php if ($key==0 || $key%2==0): ?><div class="row"><?php endif;?>
            <div class="col-md-6">
                <a href="<?=Yii::$app->homeUrl . 'news/news?id=' . $newsvalue->id?>">
                    <h3 align="justify">
                        <?php echo $newsvalue->name;?>
                    </h3>
                    <?= Html::img('@web/images/'. $newsvalue->photo,['class' => 'image-news']);?>
                </a>
            </div>
        <?php if ($key==1 || ($key+1)%2==0 || $count==1): ?></div><?php endif;?>
    <?php endforeach ?>

            <div class="row" align="center">
                <div class="col-md-12">
                    <?php echo LinkPager::widget([
                        'pagination' => $pagination
                    ]);?>
                </div>
            </div>

<?php else: ?>
    <h1>Новостей пока нет</h1>
<?php endif; ?>

        </div>
    </div>
</body>