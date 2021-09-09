<?php

use \yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\User;
use app\models\Company;
use app\models\Excursions;
use app\models\Usertoexcursion;
use yii\widgets\LinkPager;
use kartik\dialog\Dialog;

$this->title = "Пользователи";

?>

<head>
    <link rel="stylesheet" href="<?=Yii::getAlias('@web') . '/css/card.css'?>">
    <link href="<?=Yii::getAlias('@web') . '/css/links.css'?>" rel="stylesheet">
</head>

<body>

<div class="row">
  <form name="getform" action="" method="GET">
    <div class="col-md-4">
      <input class="form-control textinput" type="text" id="textinput" name="name" placeholder="Поиск" title="Найти пользователя">
    </div>
    <div class="col-md-6">
      <input class="btn btn-success-my" type="submit" value="Имя" onclick="document.getElementById('textinput').name = 'name';" title="Найти пользователя по имени">
      <input class="btn btn-success-my" type="submit" value="Фамилия" onclick="document.getElementById('textinput').name = 'surname';" title="Найти пользователя по фамилии">
      <input class="btn btn-success-my" type="submit" value="Почта" onclick="document.getElementById('textinput').name = 'email';" title="Найти пользователя по адресу электронной почты">
    </div>
  </form>
</div>

<?php if (!is_null($users) && count($users) !== 0): ?>   

<div class="row">
    <div class="col-md-12">
        <table class="table table-hover" style="border-radius: 10px">
            <thead>
    			<tr>
      				<th scope="col">№</th>
      				<th scope="col">Имя</th>
      				<th scope="col">Фамилия</th>
      				<th scope="col">Email</th>
      				<th scope="col">Дата регистрации</th>
              <th scope="col">Дополнительно</th>
    			</tr>
  			</thead>
  			<tbody>
          <?php
            $form = ActiveForm::begin(['id' => 'usrform']);
          ?>
            <?= $form->field($usrform, 'idusr')->hiddenInput(['id' => 'idusr', 'value' => ''])->label(false); ?>
            <?= $form->field($usrform, 'idexc')->hiddenInput(['id' => 'idexc', 'value' => ''])->label(false); ?>
            <?= $form->field($usrform, 'password')->hiddenInput(['id' => 'passwd', 'value' => ''])->label(false); ?>
            <?= $form->field($usrform, 'action')->hiddenInput(['id' => 'action', 'value' => ''])->label(false); ?>
                <?php foreach ($users as $user): ?>
                	<tr>
                		<th scope="row"><?=$number++;?></th>
                    	<td>
                        	<?= User::findOne(['id' => $user->id])->name;?>
                        </td>
                        <td>
                        	<?= User::findOne(['id' => $user->id])->surname;?>
                        </td>
                    	<td>
                        	<?= User::findOne(['id' => $user->id])->email;?>
                        </td>
                        <td>
                          <?=Yii::$app->formatter->asDatetime(User::findOne(['id' => $user->id])->date . Yii::$app->getTimeZone());
                          ?>
                        </td>
                        <td>
                          <button class="btn btn-info-my" type="button" data-toggle="collapse" <?php echo "data-target='#Excursions" . $number . "'";?> aria-expanded="false" <?php echo "aria-controls='Excursions" . $number . "'";?> title="Показать экскурсии, которые посетил пользователь">
                            Экскурсии
                          </button>
                            <?= HTML::button('Сменить пароль', ['class' => 'btn btn-warning-my', 'id' => 'btn-reset'.$number, 'title' => 'Сменить пароль'])?>
                            <?php
                              if (!$user->isAdmin){
                                echo HTML::button(
                                  $user->status ? 'Заблокировать' : 'Разблокировать' ,
                                  [
                                    'class' => $user->status ? 'btn btn-danger' : 'btn btn-success-my-2',
                                    'id' => 'btn-status'.$number,
                                    'title' => $user->status ? 'Заблокировать пользователя' : 'Разблокировать пользователя',
                                  ]
                                );
                              }
                            ?>
                            <?php
                                echo Dialog::widget();
                                $idreset = "'#btn-reset".$number."'";
                                $idstatus = "'#btn-status".$number."'";
                                $js = <<< JS
                                $($idreset).on("click", function() {
                                    krajeeDialog.prompt({label:"Введите новый пароль.", placeholder: "От 6 до 12 символов"}, function (result){
                                    if (result) {
                                      if (result.length < 6)
                                        krajeeDialog.alert("Пароль слишком короткий! Попробуйте снова.");
                                      else if (result.length > 12)
                                        krajeeDialog.alert("Пароль слишком длинный! Попробуйте снова.");
                                      else if (result.split(" ").length-1 == 6)
                                        krajeeDialog.alert("Пароль не должен содержать более 6 пробелов! Попробуйте снова.");
                                      else {
                                        krajeeDialog.alert("Пароль принят. Не забудьте отправить его пользователю!");
                                        document.getElementById("action").value = "passwd";
                                        document.getElementById("idusr").value = $user->id;
                                        document.getElementById("passwd").value = result;
                                        document.forms['usrform'].submit();
                                      }
                                    }
                                    });
                                });
                                $($idstatus).on("click", function() {
                                  document.getElementById("action").value = "status";
                                  document.getElementById("idusr").value = $user->id;
                                  if ($user->status){
                                    krajeeDialog.confirm("Заблокировать пользователя? Это действие снимет его со всех выбранных им на данный момент экскурсий.", function (result){
                                        if (result) {
                                            krajeeDialog.alert("Не забудьте уведомить пользователя о причинах данного решения.", function(){
                                                  document.forms['usrform'].submit();
                                              });
                                        }
                                      })
                                  } else {
                                      krajeeDialog.confirm("Разблокировать пользователя? ", function (result){
                                          if (result) {
                                              document.forms['usrform'].submit();
                                          }
                                        });
                                    }
                                });
                                JS;
                                $this->registerJs($js);
                            ?>
                        </td>
                	</tr>
                  <tr>
                    <td colspan="6" style="border-top-width: 0px;">
                    <div class="collapse" <?php echo "id='Excursions" . $number. "'";?>>
                      <?php
                        $excursions = Usertoexcursion::find()->where('iduser = '. $user->id . ' and idexcursion in (' . implode(",",$excArr) . ')')->all();
                      ?>
                      <?php if (count($excursions) !== 0): ?>
                        <div class="card card-body" style='background-color: transparent;'>
                        <?php
                          echo "<table class='table table-hover' style='border-radius: 10px; background-color: transparent;'>";
                          echo "<tr>";
                          echo "<th scope='col'>№</th>";
                          echo "<th scope='col'>Компания</th>";
                          echo "<th scope='col'>Дата экскурсии</th>";
                          echo "<th scope='col'>Дата записи</th>";
                          echo "<th scope='col'>Дополнительно</th>";
                          echo "</tr>";
                          foreach ($excursions as $key => $one) {
                            echo "<tr>";
                            echo "<th scope='row'>".++$key."</th>";
                            echo "<td>".
                              Company::findOne(['id' => Excursions::findOne(['id' => $one->idexcursion])->idcompany])->companyname
                            ."</td>";
                            echo "<td>". Yii::$app->formatter->asDatetime(Excursions::findOne(['id' => $one->idexcursion])->date . Yii::$app->getTimeZone()) ."</td>";
                            echo "<td>". Yii::$app->formatter->asDatetime($one->date . Yii::$app->getTimeZone()) ."</td>";
                            echo "<td>" .
                              HTML::submitButton('Удалить',
                                [
                                  'class' => 'btn btn-danger',
                                  'id' => 'btn-del'.$number,
                                  'title' => 'Удалить',
                                  'onclick' => 'document.getElementById("idexc").value = '
                                    . $one->idexcursion
                                    . '; document.getElementById("action").value = "exc";'
                                    . 'document.getElementById("idusr").value = '.$user->id.';']) . "</td>";
                            echo "</tr>";
                          }
                          echo "</table>";
                      ?>
                        </div>
                      <?php else: ?>
                        <h4 align="center">Записи отсутствуют</h4>
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
        <div class="row" align="center">
            <div class="col-md-12">
                <?php echo LinkPager::widget([
                    'pagination' => $pagination,
                ]);?>
            </div>
        </div>
    </div>
  </div>

<?php elseif (!is_null($users) && count($users) === 0 && isset($_GET['name'])): ?>
  <h3 align="center">
    Пользователей с именем "<?php echo $_GET['name'];?>" нет
  </h3>

<?php elseif (!is_null($users) && count($users) === 0 && isset($_GET['surname'])): ?>
  <h3 align="center">
    Пользователей с фамилией "<?php echo $_GET['surname'];?>" нет
  </h3>

<?php elseif (!is_null($users) && count($users) === 0 && isset($_GET['email'])): ?>
  <h3 align="center">
    Пользователей с адресом электронной почты "<?php echo $_GET['email'];?>" нет
  </h3>

<?php else: ?>
  <h1 align="center">
    Пользователей нет
  </h1>
<?php endif; ?>

</body>