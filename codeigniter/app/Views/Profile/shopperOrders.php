
<h1>
    Active orders:
</h1>

<?php if (!empty($activeorders) && is_array($activeorders)) : ?>
    <?php foreach ($activeorders as $order) : ?>
        <?php if ($order['finished'] == 0) : ?>
            <?php foreach ($sellers as $seller) {
                if ($seller['id'] == $order['sellerid']) {
                    $sellername = $seller['name'];
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
                <h4> Order for user <?php echo $sellername ?> with id: <?php echo $order['sellerid']; ?></h4>
                <p>Order on item <?php echo $itemname ?></p>
                <?php if ($order['delivery'] == "0") : ?>
                    <p>
                        Item has to be picked up when you get notified for pickup.
                    </p>
                <?php else : ?>
                    <p>
                        Item will be delivered to adress: <?php echo $order['delivery'] ?>
                    </p>
                <?php endif; ?>
                <?php if($order['ordertime'] != null && $order['orderdate'] != null):?>
                    <p>
                        Order date: <?php echo $order['orderdate']?> Order time: <?php echo $order['ordertime']?>
                    </p>
                    <?php endif;?>
                <?php if ($order['waitingDate'] == "1") : ?>
                    <form action="/OrderController/orderdateredirect" method="post" class="">
                        <?= csrf_field() ?>
                        <input type="hidden" name="orderid" value="<?php echo $order['orderid'] ?>">
                        <input type="hidden" name="itemid" value="<?php echo $order['itemid'] ?>">
                        <button type="submit" class="btn btn-primary">choose date</button>
                    </form>
                <?php endif; ?>
                <form action="/OrderController/removeActiveOrderShopper" method="post" class="">
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
            <?php foreach ($sellers as $seller) {
                if ($seller['id'] == $order['sellerid']) {
                    $sellername = $seller['name'];
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
                <h4> Order for user <?php echo $sellername ?> with id: <?php echo $order['sellerid']; ?></h4>
                <p>Pending Order on item <?php echo $itemname ?>. If one becomes available your order will start.</p>
                <?php if ($order['delivery'] == "0") : ?>
                    <p>
                        Order for pickup at store
                    </p>
                <?php else : ?>
                    <p>
                        Item will be delivered to adress <?php echo $order['delivery'] ?>
                    </p>
                <?php endif; ?>
                
                <form action="/OrderController/removePendingOrderShopper" method="post" class="">
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
