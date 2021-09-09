<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\News;
use kartik\dialog\Dialog;

$request = Yii::$app->getRequest();
$req = '';
$req .= ''.$request->getCsrfToken().'';

$this->title = "Список новостей";

?>
<head>
    <link href="<?=Yii::getAlias('@web') . '/css/links.css'?>" rel="stylesheet">
</head>

<body>

<p>
    <div class="row">
        <div class="col-md-8">
            <?= HTML::a('Добавить новость', ['new'], ['class' => 'btn btn-success-my', 'title' => 'Добавить новость'])?>
        </div>
    </div>
</p>

<?php if (!is_null($news) && count($news) !== 0): ?>   
<div class="row">
    <div class="col-md-12">
        <form name='newsform' method="POST">
            <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" id="req" value='<?=$req;?>'>
            <input type="hidden" name="del" id="del" value=''>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover" style="border-radius: 10px">
                         <thead>
                            <tr>
                                <th scope="col">№</th>
                                <th scope="col">Заголовок</th>
                                <th scope="col">Изменить/Удалить</th>
                            </tr>
                        </thead>
                        <tbody>
            <?php foreach ($news as $key => $newsvalue): ?>
                <input type="hidden" id="<?=$newsvalue->id;?>" value='<?=$newsvalue->id;?>'>
                <tr>
                    <th scope="row"><?=$number++;?></th>
                    <td>
                        <?=$newsvalue->name;?>
                    </td>
                    <td>
                        <?= HTML::a('Изменить',
                            ['edit?id=' . $newsvalue->id],
                            ['class' => 'btn btn-info-my','title' => 'Изменить новость']
                        )?>
                        <?= HTML::button('Удалить',[
                            'class' => 'btn btn-danger',
                            'id' => 'btn-delete'. $newsvalue->id,
                            'title' => 'Удалить новость'
                        ])?>
                        <?php
                            echo Dialog::widget();
                            $id = "'#btn-delete".$newsvalue->id."'";
                            $js = <<< JS
                            $($id).on("click", function() {
                                document.getElementById("del").value = document.getElementById($newsvalue->id).value;
                                krajeeDialog.confirm("Вы уверены, что хотите удалить новость? Процесс необратим.", function (result){
                                if (result) {
                                    document.forms['newsform'].submit();
                                }
                                });
                            });
                            JS;
                            $this->registerJs($js);
                        ?>
                    </td>
                </tr>
            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
        <div class="row" align="center">
            <div class="col-md-12">
                <?php echo LinkPager::widget([
                    'pagination' => $pagination,
                ]);?>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
    <h1>Новостей пока нет</h1>
<?php endif; ?>
 
</body>