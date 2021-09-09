<?php

use \yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Company;
use app\models\User;
use app\models\Excursions;
use app\models\Usertoexcursion;
use kartik\select2\Select2;
use kartik\dialog\Dialog;

$number = 0;

$this->title = "Актуальные экскурсии";

?>
<head>
    <link rel="stylesheet" href="<?=Yii::getAlias('@web') . '/css/card.css'?>">
    <link href="<?=Yii::getAlias('@web') . '/css/links.css'?>" rel="stylesheet">
</head>

<style type="text/css">
	.frm .form-control {
        width: 50%;
    }
    .formdrop .form-control {
  		width: 20%;
	}
</style>

<body>
	<h4>
		Всего активно экскурсий: <?= $count;?>
	</h4>
	<p>
		<button class="btn btn-success-my" type="button" data-toggle="collapse" data-target="#addExcursion" aria-expanded="false" aria-controls="addExcursion" title="Добавить запись на экскурсию">
    		Добавить
  		</button>
  	</p>
  	<div class="collapse" id="addExcursion">
  		<div class="card card-body">
    		<?php
        		$form = ActiveForm::begin(['id' => 'excursion1']);
    		?>
            <?= $form->field($excmodel, 'action')->hiddenInput(['id' => 'exc1action', 'value' => 'new'])->label(false); ?>
            <?= $form->field($excmodel, 'dt')->hiddenInput(['id' => 'dt', 'value' => $currentDate])->label(false); ?>
    		<table cellpadding="6" class="table" style="margin-bottom: 0px;">
                <thead>
                    <tr>
                        <th scope="col">Компания</th>
                        <th scope="col">Дата и время</th>
                        <th scope="col">Участники</th>
                        <th scope="col">Количество участников</th>
                        <th scope="col">Добавить</th>
                    </tr>
                </thead>
                <tbody>
    			<tr>
    				<td width="25%">
    					<div>
							<?=
                                $form->field($excmodel,'company')->widget(Select2::classname(), [
                                    'data' => $companynames,
                                    'options' => [
                                        'placeholder' => 'Компания',
                                        'title' => 'Предприятие, проводящее экскурсию'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label(false);
							?>
						</div>
					</td>
					<td  width="15%">
                        <input class="datetime-my" type="datetime-local" id="datetime" name="datetime" title="Дата и время проведения экскурсии">       
                    </td>
                    <td>
                        <?=
                            $form->field($excmodel, 'uniquepeople')->checkbox([
                                'label' => 'Новые',
                                'labelOptions' => [
                                    'title' => 'Те, кто уже прошёл экскурсию, не будут допущены к ней',
                                ],
                                'id' => 'uniq',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'bottom',
                                'title' => 'Те, кто уже прошёл экскурсию, не будут допущены к ней',
                                'checked' => true
                            ]);
                        ?>
                    </td>
                    <td width="20%">
                        <?=
                            $form->field($excmodel,'participants')->textInput(['title' => 'Максимальное количество участников', 'type' => 'number', 'value' => '20'])->label(false);
                        ?>
                    </td>
                    <td>
                        <div class="form-group">
                            <?= HTML::button('Добавить', [
                                    'id' => 'submbutt',
                                    'class' => 'btn btn-success-my-2',
                                    'title' => 'Открыть запись на экскурсию'
                                ])
                            ?>
                        </div>

                        <?php
                            echo Dialog::widget();
                            $js = <<< JS
                                $("#submbutt").on("click", function() {
                                    if (document.getElementById("datetime").value == "")
                                        krajeeDialog.alert("Установите дату!");
                                    else {
                                        if (document.getElementById("datetime").value < document.getElementById("dt").value){
                                            krajeeDialog.alert("Установите корректную дату!");
                                        } else {
                                            document.getElementById("action").value = "new";
                                            document.forms["excursion1"].submit();
                                        }
                                    }
                                    return false;
                                });
                            JS;

                            $this->registerJs($js);
                        ?>
                    </td>
                </tr>
                <tbody>
            </table>
    	<?php
        	ActiveForm::end();
    	?>
  		</div>
	</div>

<?php if ($count != 0): ?>

<div class="row">
    <div class="col-md-12">
        <table class="table table-hover" style="border-radius: 10px">
        	<thead>
    			<tr>
      				<th scope="col">№</th>
      				<th scope="col">Предприятие</th>
      				<th scope="col">Дата</th>
                    <th scope="col">Доступ</th>
      				<th scope="col">Количество участников</th>
                    <th scope="col">Записалось на экскурсию</th>
                    <th scope="col">Дополнительно</th>
    			</tr>
  			</thead>
  			<tbody>
                <?php
                    $form = ActiveForm::begin(['id' => 'excursion2']);
                ?>
                <?= $form->field($actionExc, 'idusr')->hiddenInput(['id' => 'idusr', 'value' => ''])->label(false); ?>
                <?= $form->field($actionExc, 'idexc')->hiddenInput(['id' => 'idexc', 'value' => 'idexc'])->label(false); ?>
                <?= $form->field($actionExc, 'action')->hiddenInput(['id' => 'action', 'value' => ''])->label(false); ?>
                <?php foreach ($excursions as $excursion): ?>
                	<tr>
                		<th scope="row"><?=++$number;?></th>
                    	<td>
                        	<?= Company::find()->where('id = ' . $excursion->idcompany)->one()->companyname;?>
                        </td>
                        <td>
    						<?=Yii::$app->formatter->asDatetime($excursion->date . Yii::$app->getTimeZone());
    						?>
                        </td>
                        <td>
                            <?php echo $excursion->uniquepeople ? "Только новые" : "Все";?>
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
                        <?php if ($excursion->status):?>
                            <button class="btn btn-info-my" type="button" data-toggle="collapse" <?php echo "data-target='#Signed" . $number . "'";?> aria-expanded="false" <?php echo "aria-controls='Signed" . $number . "'";?> title="Показать записавшихся пользователей", style="margin-bottom: 1px;">
                                Участники
                            </button>
                            
                            <?= HTML::button('Изменить доступ', [
                                    'class' => 'btn btn-warning-my',
                                    'id' => 'btn-access'.$number,
                                    'title' => 'Изменить доступ',
                                    'style' => "margin-bottom: 1px;"
                                ])
                            ?>
                            <?= HTML::button('Отменить', [
                                    'class' => 'btn btn-danger',
                                    'id' => 'btn-cancel'.$number,
                                    'title' => 'Отменить экскурсию',
                                    'style' => "margin-bottom: 1px;"
                                ])
                            ?>
                            <?php
                                echo Dialog::widget();
                                $idcancel = "'#btn-cancel".$number."'";
                                $idaccess = "'#btn-access".$number."'";
                                $access = $excursion->uniquepeople ? "Открыть доступ ВСЕМ участникам?" : "Открыть доступ ТОЛЬКО НОВЫМ участникам";
                                $js = <<< JS
                                $($idcancel).on("click", function() {
                                    document.getElementById("idexc").value = $excursion->id;
                                    document.getElementById("action").value = "cancel";
                                    krajeeDialog.confirm("Вы уверены, что хотите отменить экскурсию? Процесс необратим.", function (result){
                                    if (result) {
                                        document.forms['excursion2'].submit();
                                    }
                                    });
                                });
                                $($idaccess).on("click", function() {
                                    document.getElementById("idexc").value = $excursion->id;
                                    document.getElementById("action").value = "access";
                                    krajeeDialog.confirm('$access', function (result){
                                    if (result) {
                                        document.forms['excursion2'].submit();
                                    }
                                    });
                                });
                                JS;
                                $this->registerJs($js);
                            ?>
                        <?php endif; ?>
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
                                    echo "<th scope='col'>Дополнительно</th>";
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
                                        echo "<td>" .
                                          HTML::button('Отменить запись',
                                            [
                                              'class' => 'btn btn-danger',
                                              'id' => 'btn-del'.$number.'-'.$one->iduser,
                                              'title' => 'Отменить запись']) . "</td>";
                                        echo "</tr>";

                                        echo Dialog::widget();
                                        $iddel = "'#btn-del".$number."-".$one->iduser."'";
                                        $js = <<< JS
                                        $($iddel).on("click", function() {
                                            document.getElementById("idexc").value = $excursion->id;
                                            document.getElementById("action").value = "deny";
                                            document.getElementById("idusr").value = $one->iduser;
                                            krajeeDialog.confirm("Снять пользователя с экскурсии? Процесс необратим.", function (result){
                                            if (result) {
                                                krajeeDialog.alert("Не забудьте уведомить пользователя о причинах данного решения.", function(){
                                                        document.forms['excursion2'].submit();
                                                    });
                                            }
                                            });
                                        });
                                        JS;
                                        $this->registerJs($js);
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
                <?php endforeach ?>
                <?php
                    ActiveForm::end();
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php else: ?>
    <h1 align="center">
        Экскурсий пока нет
    </h1>
<?php endif; ?>

</body>