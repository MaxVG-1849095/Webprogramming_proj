<h1>
    Active orders:
</h1>

<?php if (!empty($activeorders) && is_array($activeorders)) : ?>
    <?php foreach ($activeorders as $order) : ?>
        <?php if ($order['finished'] == 0) : ?>
            <?php foreach ($shoppers as $shopper) {
                if ($shopper['id'] == $order['shopperid']) {
                    $shoppername = $shopper['name'];
                    break;
                }
            } ?>
            <?php foreach ($items as $item) {
                if ($item['itemid'] == $order['itemid']) {
                    $itemname = $item['name'];
                    break;
                }
            } ?>
            <div class="bg-success m-4 p-2 rounded">
                <h4> Order from user <?php echo $shoppername ?> with id: <?php echo $order['shopperid']; ?></h4>
                <p>Order on item <?php echo $itemname ?></p>
                <?php if($order['delivery'] == "0") :?>
                    <p>
                        Item will be picked up when the user is notified for pickup.
                    </p>
                <?php else: ?>
                    <p>
                        Item to be delivered to adress: <?php echo $order['delivery'] ?>
                    </p>
                    <?php endif;?>
                    
                
                <?php if($order['waitingDate'] == 0 && $order['ordertime'] == null):?>
                    <form action="/OrderController/setWaitingDate" method="post" class="">
                    <?= csrf_field() ?>
                    <input type="hidden" name="orderid" value="<?php echo $order['orderid'] ?>">
                    <input type="hidden" name="itemid" value="<?php echo $order['itemid'] ?>">
                    <input type="hidden" name="delivery" value="<?php echo $order['delivery']?>">
                    <button type="submit" class="btn btn-primary">update order</button>
                </form>
                <?php elseif($order['ordertime'] != null && $order['orderdate'] != null):?>
                    <p>
                        Order date: <?php echo $order['orderdate']?> Order time: <?php echo $order['ordertime']?>
                    </p>
                <form action="/OrderController/completeOrder" method="post" class="">
                    <?= csrf_field() ?>
                    <input type="hidden" name="orderid" value="<?php echo $order['orderid'] ?>">
                    <input type="hidden" name="itemid" value="<?php echo $order['itemid'] ?>">
                    <input type="hidden" name="delivery" value="<?php echo $order['delivery']?>">
                    <button type="submit" class="btn btn-primary">fulfill order</button>
                </form>
                <?php endif?>
                <form action="/OrderController/removeActiveOrderSeller" method="post" class="">
                    <?= csrf_field() ?>
                    <input type="hidden" name="orderid" value="<?php echo $order['orderid'] ?>">
                    <input type="hidden" name="itemid" value="<?php echo $order['itemid'] ?>">
                    <button type="submit" class="btn btn-danger">cancel order</button>
                </form>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else : ?>
    <h2>
        No available active orders.
    </h2>
<?php endif; ?>

<h1>
    Pending orders:
</h1>

<?php if (!empty($inactiveorders) && is_array($inactiveorders)) : ?>
    <?php foreach ($inactiveorders as $order) : ?>
        <?php if ($order['finished'] == 0) : ?>
            <?php foreach ($shoppers as $shopper) {
                if ($shopper['id'] == $order['shopperid']) {
                    $shoppername = $shopper['name'];
                    break;
                }
            } ?>
            <?php foreach ($items as $item) {
                if ($item['itemid'] == $order['itemid']) {
                    $itemname = $item['name'];
                    break;
                }
            } ?>
            <div class="bg-warning m-4 p-2 rounded">
                <h4> Order from user <?php echo $shoppername ?> with id: <?php echo $order['shopperid']; ?></h4>
                <p>Pending Order on item <?php echo $itemname ?></p>
                <?php if($order['delivery'] == "0") :?>
                    <p>
                        Item will be picked up when the user is notified for pickup.
                    </p>
                <?php else: ?>
                    <p>
                        Item to be delivered to adress: <?php echo $order['delivery'] ?>
                    </p>
                    <?php endif;?>
                <form action="/OrderController/removePendingOrderSeller" method="post" class="">
                    <?= csrf_field() ?>
                    <input type="hidden" name="orderid" value="<?php echo $order['orderid'] ?>">
                    <input type="hidden" name="itemid" value="<?php echo $order['itemid'] ?>">
                    <button type="submit" class="btn btn-danger">cancel order</button>
                </form>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else : ?>
    <h2>
        No available inactive orders.
    </h2>
<?php endif; ?>

<h1>
    Seller stats:
</h1>
<p class="m-3">
    Total orders: <?php echo $totalOrders['orderid']?>
    <br>
    Active orders: <?php echo $activeOrders['orderid']?>
    <br>
    Inactive orders: <?php echo $inactiveOrders['orderid']?>
    <br>
    Finished orders: <?php echo $finishedOrders['orderid']?>
</p>