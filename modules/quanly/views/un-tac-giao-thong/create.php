<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\quanly\models\UnTacGiaoThong */

?>
<div class="un-tac-giao-thong-create">
    <?= $this->render('_form', [
        'model' => $model,
        'filedinhkem' => $filedinhkem,
    ]) ?>
</div>
