<?php
/** @var \common\models\Product $model */
?>

    <div class="card h-100">
        <!-- Product image-->
        <img class="card-img-top" src="<?php echo $model->getImageUrl() ?>" alt="..." />
        <!-- Product details-->
        <div class="card-body p-4">
            <div class="text-center">
                <!-- Product name-->
                <h5 class="fw-bolder text-primary"><?php echo $model->name ?></h5>
                <!-- Product price-->
                <?php echo $model->price ?>
                <p><?php echo $model->getShortDescription() ?></p>
            </div>
        </div>
        <!-- Product actions-->
        <div class="card-footer pt-0 border-top-0 bg-transparent " style="background-color: #EAEAEA !important;" >
            <div class="text-center m-3 ">
                <a href="<?php echo \yii\helpers\Url::to(['/cart/add']) ?>"
                class="btn btn-primary mt-auto btn-add-to-cart" >Add to Cart</a></div>
        </div>
    </div>

