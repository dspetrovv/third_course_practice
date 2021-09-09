<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\models\Company;
use app\models\Excursions;
use kartik\dialog\Dialog;

$request = Yii::$app->getRequest();
$req = '';
$req .= ''.$request->getCsrfToken().'';

$this->title = "Список предприятий";
//excursion
?>
<head>
    <link href="<?=Yii::getAlias('@web') . '/css/links.css'?>" rel="stylesheet">
</head>

<body>

<p>
	<div class="row">
		<div class="col-md-8">
			<?= HTML::a('Добавить предприятие', ['new'], ['class' => 'btn btn-success-my', 'title' => 'Добавить предприятие'])?>
		</div>
    </div>
</p>

<?php if (!is_null($companies) && count($companies) !== 0): ?>    
<div class="row">
    <div class="col-md-12">
        <table class="table table-hover" style="border-radius: 10px">
        	 <thead>
    			<tr>
      				<th scope="col">№</th>
      				<th scope="col">Наименование</th>
      				<th scope="col">Ближайшая экскурсия</th>
      				<th scope="col">Изменить/Удалить</th>
    			</tr>
  			</thead>
  			<tbody>
  				<form name='companyform' method="POST">
  					<input type="hidden" name="<?=Yii::$app->request->csrfParam?>" id="req" value='<?=$req;?>'>
  					<input type="hidden" name="del" id="del" value=''>
                <?php foreach ($companies as $company): ?>
                	<input type="hidden" id="<?=$company->id;?>" value='<?=$company->id;?>'>
                	<tr>
                		<th scope="row"><?=$number++;?></th>
                    	<td>
                        	<?= $company->companyname;?>
                        </td>
                        <td>
						    <?php 
						        echo
						            is_null(Excursions::findBySql('Select * From Excursions Where idcompany = ' . $company->id . ' and date > "'. $date . '" order by date ASC')->one())

						            ? 'Не задано'

						            : Yii::$app->formatter->asDatetime(Excursions::findBySql('Select date From Excursions Where idcompany = ' . $company->id . ' and date > "'. $date . '" order by date ASC')->one()->date . Yii::$app->getTimeZone());
						    ?>
                        </td>
                        <td>
                        	<?= HTML::a('Изменить',
                        		['edit?id=' . $company->id],
                        		['class' => 'btn btn-info-my']
                        	)?>
                        	<?= HTML::button('Удалить',[
                        		'class' => 'btn btn-danger',
                                'id' => 'btn-delete'. $company->id,
                                is_null(Excursions::findBySql('Select * From Excursions Where idcompany = ' . $company->id)->one())
                                ? 'enabled'
                                : 'disabled' => 'true',
                                'title' => 'Для удаления предприятия необходимо удалить все экскурсии'
							])?>
							<?php
                                echo Dialog::widget();
                                $id = "'#btn-delete".$company->id."'";
                                $js = <<< JS
                                $($id).on("click", function() {
                                    document.getElementById("del").value = document.getElementById($company->id).value;
                                    krajeeDialog.confirm("Вы уверены, что хотите удалить предприятие? Процесс необратим.", function (result) {
                                    if (result) {
                                        document.forms['companyform'].submit();
                                    }
                                    });
                                });
                                JS;
                                $this->registerJs($js);
                            ?>
                        </td>
                	</tr>
                <?php endforeach ?>
            	</form>
            </tbody>
        </table>
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
    <h1>Предприятий пока нет</h1>
<?php endif; ?>

</body>