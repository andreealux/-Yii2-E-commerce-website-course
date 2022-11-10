<?php
/** @var array $items */
?>

<div class="card">
    <div class="card-header">
        <h3>Your cart items</h3>
    </div>
    <div class="card-body">
        <?php if(!empty($items)): ?>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo $item['name'] ?></td>
                    <td>
                        <img src="<?php echo \common\models\Product::formatImageUrl($item['image']) ?>"
                             alt="<?php echo $item['name'] ?>" width="100px">
                    <td><?php echo $item['price'] ?></td>
                    <td><?php echo $item['quantity'] ?></td>
                    <td><?php echo $item['total_price'] ?></td>
                    <td>
                        <?php echo \yii\helpers\Html::a('Delete', ['/cart/delete', 'id' => $item['id']], [
                            'class' => 'btn btn-outline-danger btn-sm',
                            'data-method' => 'post',
                            'data-confirm' => 'Are you sure you want to remove this product from cart?']) ?>
                    </td>
                </tr>

            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="card-body">
            <a href="<?php echo \yii\helpers\Url::to(['/cart/checkout']) ?>" class="btn btn-primary btn-sm" style="margin-left:1060px !important;">Checkout</a>
        </div>
        <?php else: ?>
            <p class="text-muted text-center p-5">There are no items in the cart</p>
        <?php endif ?>
    </div>
</div>
