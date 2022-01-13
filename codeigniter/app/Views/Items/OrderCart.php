<?php if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) : ?>
    <div class="d-flex justify-content-center ">
    <div id="cartitems" class="align-content-stretch container row overflow-auto">
        <?php foreach ($_SESSION['cart'] as $order) : ?>
            <div id="cartitem" class="m-2 container-fluid border border-dark rounded bg-primary">
                <?php foreach ($items as $itemarr) {
                    if ($itemarr['itemid'] == $order['itemid']) {
                        $item = $itemarr;
                        break;
                    }
                } ?>
                    <h2 class="d-flex justify-content-center">
                        <span class="badge badge-secondary"><?php echo $item['name'] ?></span>
                    </h2>
                    <h3 class="d-flex justify-content-center">
                    <span class="badge badge-secondary">Amount ordered: <?php echo $order['amount'] ?></span>
                        
                    </h3>
                    <div class="containter-fluid bg-secondary pb-5 mx-5 d-flex justify-content-center ">

                    
                        <img class="" alt="Items" src="/Images/Items/<?php echo $item['filename']; ?>">
                    </div>
                </div>

        <?php endforeach; ?>
    </div>
            </div>
    <h2 class="d-flex justify-content-center my-5">
        Total price: <?php echo $price ?>
    </h2>


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

<?php else:?>
    <h1 class="d-flex justify-content-center my-5">
        Your cart is empty, you can add things to it by ordering items from the store!.
    </h1>
<?php endif; ?>