<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\Helper;
use yii\helpers\ArrayHelper;
use app\modules\entidades_academicas\models\Programa;
use app\modules\espacios_fisicos\models\Plantel;
use app\modules\configuraciones\models\ElementoLista;


$programas = ArrayHelper::map(Programa::find()->orderBy('programa_id')->all(), 'programa_id', 'nombre');
$planteles = ArrayHelper::map(Plantel::find()->orderBy('plantel_id')->all(), 'plantel_id', 'nombre');
$sistemas = ArrayHelper::map(
    ElementoLista::find()->where(['lista' => ElementoLista::LST_SISTEMA, 'activo' => true])->orderBy('elemento_lista_id')->all(), 
    'nombre', 'nombre');


/* @var $this yii\web\View */
/* @var $searchModel app\modules\entidades_academicas\models\PlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Planes de Estudio';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if(Helper::checkRoute('create')):?>
    <p>
        <?= Html::a('<i class = "fa fa-plus"></i>&nbsp; Nuevo Plan de Estudio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif?>

    <?= $this->render('@app/views/layouts/mensaje') ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'clave',
            [
                'filter' => $programas,
                'attribute' => 'programa_id',
                'value' => 'programa.nombre'
            ],
            /*[
                'filter' => $planteles,
                'attribute' => 'plantel_id',
                'value' => 'plantel.nombre'
            ],*/
			[
                'attribute' => 'especialidad',
                'value' => function ($data) {
                    return ($data->especialidad != "") ? $data->especialidad : '';
                }
            ],
            'anio',
            'rvoe',
            [
                'filter' => $sistemas,
                'attribute' => 'sistema',
                'value' => 'sistema'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '<div style="text-align: center;">' .Helper::filterActionColumn('{view} &emsp;{update} &emsp; {delete} '),
               
                'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                'contentOptions' => ['style' => 'text-align: center;'],
            ],
        ],
        'pager' => [
            'class' => 'yii\bootstrap5\LinkPager'
        ]
    ]); ?>
</div>
