<?php if ($order['delivery'] == "0") : ?>
    <h2 class="d-flex justify-content-center m-5">
        Pick a time for the pickup of item: <?php echo $item['name'] ?>
    </h2>
    
    <div class="d-flex justify-content-center m-5">
        <form action="/OrderController/createOrderTime" method="post">
        <?= csrf_field() ?>
            <input type="hidden" name="orderid" value="<?php echo $order['orderid'] ?>">
            <label>Date for pickup</label>
            <input type="date" id="date" name="date" min="2021-01-01" max="2022-12-31" required>
            <label>Time for pickup</label>
            <input type="time" id="time" name="time" required>
            <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        <?php else : ?>
            <h2 class="d-flex justify-content-center m-5">
                Pick a time for the delivery of item: <?php echo $item['name'] ?>
            </h2>
            <h3 class="d-flex justify-content-center m-5">
        Delivery at: <?php echo $order['delivery']?> 
    </h3>
            <div class="d-flex justify-content-center m-5">
                <form action="/OrderController/createOrderTime" method="post">
                <?= csrf_field() ?>    
                <input type="hidden" name="orderid" value="<?php echo $order['orderid'] ?>">
                    <label>Date for delivery</label>
                    <input type="date" id="date" name="date" min="2021-01-01" max="2022-12-31" required>
                    <label>Time for delivery</label>
                    <input type="time" id="time" name="time" required>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                <?php endif ?>
                
            </div>