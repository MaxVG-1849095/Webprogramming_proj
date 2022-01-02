<?php if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) : ?>
    <div id="cartitems" class="overflow-auto">
        <?php foreach ($_SESSION['cart'] as $order) : ?>
            <div id="cartitem" class="m-5 container-fluid">
                <?php foreach ($items as $itemarr) {
                    if ($itemarr['itemid'] == $order['itemid']) {
                        $item = $itemarr;
                        break;
                    }
                } ?>
                <div class="pb-2 col m-3 bg-primary rounded" id="order">
                    <h2 class="d-flex justify-content-center">
                        <span class="badge badge-secondary"><?php echo $item['name'] ?></span>
                    </h2>
                    <h3 class="d-flex justify-content-center">
                    <span class="badge badge-secondary">Amount ordered: <?php echo $order['amount'] ?></span>
                        
                    </h3>
                    <img class="row .img-fluid. max-width: 100%; height: auto;" alt="Items" src="/Images/Items/<?php echo $item['filename']; ?>">
                </div>
            </div>

        <?php endforeach; ?>
    </div>
    <h2 class="d-flex justify-content-center">
        Total price: <?php echo $price ?>
    </h2>
<?php endif; ?>

<form action="/OrderController/makeOrdersFromCart" method="post" class="d-flex justify-content-center">
    <?= csrf_field() ?>
    <div class="form-group d-flex">
        <label>delivery options:</label>
        <select class="form-control" id="delivery" name="delivery">
            <option>Pickup at store</option>
            <option>Delivery at account adress</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">place order(s)</button>
</form>
<a type="button" class="btn btn-danger" href="/OrderController/emptyCart">Empty Cart</a>