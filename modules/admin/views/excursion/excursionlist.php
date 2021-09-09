<?php

use \yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Company;
use app\models\User;
use yii\widgets\LinkPager;
use app\models\Excursions;
use app\models\Usertoexcursion;
use kartik\dialog\Dialog;
use kartik\select2\Select2;

$this->title = "Список прошедших экскурсий";

?>
<head>
    <link rel="stylesheet" href="<?=Yii::getAlias('@web') . '/css/card.css'?>">
    <link href="<?=Yii::getAlias('@web') . '/css/links.css'?>" rel="stylesheet">
	<style type="text/css">
		.frm .form-control {
	        width: 50%;
	    }
	    .formdrop .form-control {
	  		width: 20%;
		}
	</style>
</head>

<body>
	<p>
		<div class="row">
			<form name="getcompanyform" method="GET">
				<div class="col-md-4">
					<?php
						echo Select2::widget([
						    'name' => 'company',
						    'data' => $companynames,
						    'value' => is_null($defvalue) ? null : $defvalue,
						    'options' => [
						        'placeholder' => 'Выберите предприятие',
						        'multiple' => false,
						        'title' => 'Выбрать предприятие'
						    ],
						]);
					?>
				</div>
				<div class="col-md-4">
					<?= HTML::submitButton('Найти', ['class' => 'btn btn-success-my','title' => 'Найти предприятие']);?>
				</div>
			</form>
		</div>
  	</p>

<?php if ($count != 0): ?>

<div class="row">
    <div class="col-md-12">
        <table class="table table-hover" style="border-radius: 10px">
        	<thead>
    			<tr>
      				<th scope="col">№</th>
      				<th scope="col">Предприятие</th>
      				<th scope="col">Статус</th>
      				<th scope="col">Доступ</th>
      				<th scope="col">Дата</th>
      				<th scope="col">Количество участников</th>
      				<th scope="col">Записалось на экскурсию</th>
      				<th scope="col">Дополнительно</th>
    			</tr>
  			</thead>
  			<tbody>
                <?php foreach ($excursions as $excursion): ?>
                	<?php
						$form = ActiveForm::begin(['id' => 'excursionform']);
					?>

					<?= $form->field($companyform, 'idexcursion')->hiddenInput(['value' => $excursion->id])->label(false); ?>
                	<tr>
                		<th scope="row"><?=$number++;?></th>
	                	<td>
	    					<?= Company::findOne(['id' => $excursion->idcompany])->companyname;
	    					?>
	                    </td>
	                    <td>
                        	<?php echo $excursion->status ? 'Прошла' : 'Отменена';?>
                        </td>
                        <td>
                            <?php echo $excursion->uniquepeople ? "Только новые" : "Все";?>
                        </td>
                        <td>
    						<?=Yii::$app->formatter->asDatetime($excursion->date . Yii::$app->getTimeZone());
    						?>
                        </td>
                        <td>
                        	<?= $excursion->participants;?>
                        </td>
                        <td>
                        	<?= Usertoexcursion::find()->where(
                    'idexcursion = ' . $excursion->id . ''
                    			)->count()?>
                        </td>
                        <td>
                        	<button class="btn btn-info-my" type="button" data-toggle="collapse" <?php echo "data-target='#Signed" . $number . "'";?> aria-expanded="false" <?php echo "aria-controls='Signed" . $number . "'";?> style="margin-bottom: 1px;" title="Показать участников экскурсии">
					    		Участники
					  		</button>
					        <?= HTML::submitButton('Удалить', ['class' => 'btn btn-danger','title' => 'Удалить запись','style' => "margin-bottom: 1px;"])?>				    
                        </td>
                	</tr>
                	<tr>
                		<td colspan="7" style="border-top-width: 0px;">
	                	<div class="collapse" <?php echo "id='Signed" . $number. "'";?>>
	                		<?php
	  							$people = Usertoexcursion::findAll(['idexcursion' => $excursion->id]);
	  						?>
	  						<?php if (count($people) !== 0): ?>
	  							<div class="card card-body" style='background-color: transparent;'>
	  							<?php
	  								echo "<table class='table table-hover' style='border-radius: 10px; background-color: transparent;'>";
	  								echo "<tr>";
			                        echo "<th scope='col'>№</th>";
			                        echo "<th scope='col'>Имя</th>";
			                        echo "<th scope='col'>Фамилия</th>";
			                        echo "<th scope='col'>Почта</th>";
			                        echo "<th scope='col'>Дата записи</th>";
			                        echo "</tr>";
			                        foreach ($people as $key => $one) {
			                            echo "<tr>";
			                            echo "<th scope='row'>".++$key."</th>";
			                            echo "<td>".
			                              User::findOne(['id' => $one->iduser])->name
			                            ."</td>";
			                            echo "<td>". User::findOne(['id' => $one->iduser])->surname ."</td>";
			                            echo "<td>". User::findOne(['id' => $one->iduser])->email ."</td>";
			                            echo "<td>". Yii::$app->formatter->asDatetime($one->date . Yii::$app->getTimeZone()) ."</td>";
			                            echo "</tr>";
			                        }
			                        echo "</table>";
								?>
	  							</div>
	  						<?php else: ?>
	  							<h4 align="center">Никто не записался</h4>
	  						<?php endif; ?>
	  					</div>
	  				</td>
  					</tr>
                <?php
					ActiveForm::end();
				?>
                <?php endforeach ?>
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
	<h1 align="center">
		Пусто
	</h1>
<?php endif; ?>
</body>