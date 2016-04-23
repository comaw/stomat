<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\User;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
            [
                'attribute' => 'role',
                'format' => 'raw',
                'value' => function($data){
                    return $data->getRoleName();
                },
                'filter' => User::listRole(),
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($data){
                    return $data->getStatusName();
                },
                'filter' => User::listStatus(),
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function($data){
                    return date("d/m/Y H:i:s", $data->created_at);
                },
                'filter' => false,
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
