<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ConfirmForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Confirm';
?>
<div class="site-confirm">
<h3>Confirm Registration</h3>
    <p class="text-primary">Please add the <b>@YourBot</b> and put the verification code</p>

    <?php $form = ActiveForm::begin([
        'id' => 'confirm-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'confirmToken')->textInput(['autofocus' => true])->hint('Введите ключ подтверждения') ?>

    <div class="form-group">
        <div class="col-lg-offset-0 col-lg-11">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'confirm-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
