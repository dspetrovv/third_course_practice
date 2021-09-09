<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
// style="background-color: #1a1c1f;"  style="color: #fff"
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Модуль администрирования</h1>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">

</footer>

<!-- Control Sidebar -->

<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>