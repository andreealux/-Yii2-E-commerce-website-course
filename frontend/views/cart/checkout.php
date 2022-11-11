<?php
/** @var \common\models\Order $order */
/** @var \common\models\OrderAddress $orderAddress */
/** @var array $cartItems */
/** @var int $productQuantity */

/** @var float $totalPrice */

use yii\bootstrap5\ActiveForm;

?>


<script src="https://www.paypal.com/sdk/js?client-id=AWj-tzMLB6Nvnx180-v84NZErHydk18rFf1dA-tH_rDZRswNeTXJi9bBteHmyBHJ0y1sU1pc5ZTklTjv&currency=USD&intent=capture&enable-funding=venmo"
        data-sdk-integration-source="integrationbuilder"></script>


<div class="row mt-5">
    <div class="col">
        <?php $form = ActiveForm::begin([
            'id' => 'checkout-form',
        ]) ?>
        <div class="card mb-3">
            <div class="card-header">
                <h5>Account information</h5>
            </div>

            <div class="card-body">
                <!--                --><?php //if (isset($success) && $success): ?>
                <!--                    <div class="alert alert-success">-->
                <!--                        Your account was successfully updated-->
                <!--                    </div>-->
                <!--                --><?php //endif ?>
                <div class="row pt-3">
                    <div class="col-md-6">
                        <?= $form->field($order, 'firstname')->textInput(['autofocus' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($order, 'lastname')->textInput(['autofocus' => true]) ?>
                    </div>
                </div>

                <?= $form->field($order, 'email')->textInput(['autofocus' => true]) ?>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Address information</h5>
            </div>
            <div class="card-body">
                <?= $form->field($orderAddress, 'address') ?>
                <?= $form->field($orderAddress, 'city') ?>
                <?= $form->field($orderAddress, 'state') ?>
                <?= $form->field($orderAddress, 'country') ?>
                <?= $form->field($orderAddress, 'zipcode') ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h5>Order Summary</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td colspan="2"><?php echo $productQuantity ?> Products</td>
                    </tr>
                    <tr>
                        <td>Total Price</td>
                        <td class="text-right">
                            <?php echo $totalPrice ?>
                        </td>
                    </tr>
                </table>
                <!--                <p class="mt-4" >-->
                <!--                    <button class="btn btn-secondary">Checkout</button>-->
                <!--                </p>-->
                <div id="paypal-button-container"></div>
            </div>
        </div>
    </div>
</div>


<script>
    const paypalButtonsComponent = paypal.Buttons({
        // optional styling for buttons
        // https://developer.paypal.com/docs/checkout/standard/customize/buttons-style-guide/
        style: {
            color: "gold",
            shape: "rect",
            layout: "vertical"
        },

        // set up the transaction
        createOrder: (data, actions) => {
            // pass in any options from the v2 orders create call:
            // https://developer.paypal.com/api/orders/v2/#orders-create-request-body
            const createOrderPayload = {
                purchase_units: [
                    {
                        amount: {
                            value: <?php echo $totalPrice ?>
                        }
                    }
                ]
            };

            return actions.order.create(createOrderPayload);
        },

        // finalize the transaction
        onApprove: (data, actions) => {
            // console.log(data, actions);
            const captureOrderHandler = (details) => {
                const payerName = details.payer.name.given_name;
                const $form = $('#checkout-form');
                const data = $form.serializeArray();

                data.push({
                    name: 'transactionId',
                    value: details.id
                });
                data.push({
                    name: 'status',
                    value: details.status
                });
                $.ajax({
                    method: 'post',
                    url: '<?php echo \yii\helpers\Url::to(['/cart/create-order'])?>',
                    data: data,
                    success: function (res){
                        // console.log(res);
                    }
                    error: function (err) {
                        console.log(err)
                    }
                })
                console.log('Transaction completed');
                alert('Transaction completed' + payerName);
            };

            return actions.order.capture().then(captureOrderHandler);
        },

        // handle unrecoverable errors
        onError: (err) => {
            console.log(err)
            console.error('An error prevented the buyer from checking out with PayPal');
        }
    });

    paypalButtonsComponent
        .render("#paypal-button-container")
        .catch((err) => {
            console.error('PayPal Buttons failed to render');
        });
</script>
