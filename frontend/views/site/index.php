<?php

/** @var yii\web\View $this */
/** @var \yii\data\ActiveDataProvider $dataProvider */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="container px-4 px-lg-5 mt-5">
            <?php echo \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'layout' => '{summary}<div class="row">{items}</div>{pager}',
                'itemView' => '_product_item',
                'options' => [
                    'class' => 'row'
                ],
                'itemOptions' => [
                    'class' => 'col mb-5'
                ],
                'pager' => [
                        'class' => \yii\bootstrap5\LinkPager::class
                ]
            ]) ?>
    </div>
</div>
