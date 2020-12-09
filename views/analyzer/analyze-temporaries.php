<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\AnalyzeTemporariesForm */

/* @var $books */
/* @var $columns */
/* @var $result */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Analizar temporalidad';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'temporary')->textInput(['autofocus' => true, 'type' => 'number']) ?>

    <?= $form->field($model, 'book')->dropDownList($books, ['prompt'=>'Escoja']) ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Aceptar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="col-lg-offset-1">
        <table width="100%">
            <thead class="dropdown-header"><?= count($result) ?> registros</thead>
            <tbody>
            <tr>
                <?php
                foreach ($columns as $column) {
                    echo "<td class='table-header'>$column</td>";
                } ?>
            </tr>
            </tbody>
            <?php
            foreach ($result as $row) { ?>
                <tr>
                    <?php
                    foreach ($row as $cell) { ?>
                        <td class="table-content"><?= $cell ?></td>
                        <?php
                    }
                    ?>
                </tr>
                <?php
            }
            ?>
        </table>

    </div>
</div>
