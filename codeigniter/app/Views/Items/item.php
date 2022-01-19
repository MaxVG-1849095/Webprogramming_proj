<h1 class="d-flex justify-content-center"><?= esc($item['name']) ?></h1>


<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="/Images/Items/<?php echo $item['filename']; ?>" class="d-block w-100" alt="<?php echo $item['name'] ?>-picture">
        </div>
        <?php if (!empty($media) && is_array($media)) : ?>
            <?php foreach ($media as $media_m) : ?>
                <?php if ($media_m['type'] == 'video/mp4') : ?>
                    <div class="carousel-item">
                        <video controls src="/Images/Items/<?php echo $media_m['file']; ?>" class="d-block w-100" alt="<?php echo $item['name'] ?>-video">
                    </div>
                <?php else : ?>
                    <div class="carousel-item">
                        <img src="/Images/Items/<?php echo $media_m['file']; ?>" class="d-block w-100" alt="...">
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<noscript>
    <p class="d-flex justify-content-center">
    Please turn on javascript to use image carousel!
    </p>
</noscript>
<h2 class="d-flex justify-content-center">
    Description:
</h2>
<p class="d-flex justify-content-center">
    <?= esc($item['description']) ?>
</p>
<p class="d-flex justify-content-center">
    Sold by seller <?= esc($nameid['name']) ?> with id: <?= esc($item['sellerid']) ?>
                </p>
<h3 class="d-flex justify-content-center">
    Price:<?= esc($item['price']) ?>$
</h3>
<h4 class="d-flex justify-content-center">
    Currently available: <?=esc($item['availability'])?>
</h4>
<?php if (isset($_SESSION['id']) && $_SESSION['slug'] == "Shopper") : ?>

    <noscript>
    <form action="/OrderController/placeordernoscript" method="post" class="d-flex justify-content-center">
                <?= csrf_field() ?>
                <div class="justify-content-center">
            <input type="hidden" id="itemid" name="itemid" value="<?php echo $item['itemid'] ?>">
            <label>Amount to order? 1-3</label>
            <div class="d-flex">
            <input rows="2" class="form-control d-inline-flex" type="number" min="0" max="3" id="orderamount" name="orderamount" placeholder="amount of items you want to order" required></input>
            <button type="submit" id="btn-order" class="btn btn-primary">place order</button>
            </div>
        </div>
    </noscript>
    <form class="js-content" type="get" id="amount_form" onsubmit="event.preventDefault();ajaxOrder()">
        <div class="justify-content-center">
            <input type="hidden" id="itemid" name="itemid" value="<?php echo $item['itemid'] ?>">
            <label>Amount to order? 1-3</label>
            <div class="d-flex">
            <input rows="2" class="form-control d-inline-flex ml-3" type="number" min="0" max="3" id="orderamount" name="orderamount" placeholder="amount of items you want to order" required></input>
            <button type="submit" id="btn-order" class="btn btn-primary mr-3">place order</button>
            </div>
        </div>
    </form>

    <div id="succesOrder" class="d-flex justify-content-center">
    </div>
    <script type="text/javascript">
        function ajaxOrder() {
            console.log("success in items");
            var itemid = document.getElementById("itemid").value;
            var orderamount = document.getElementById("orderamount").value;
            var params = "?itemid=" + itemid + "&orderamount=" + orderamount;
            console.log(params);
            console.log(orderamount);
            var linkstr = "/item/" + itemid + "/ajaxorder"
            var link = "<?php echo base_url(); ?>" + "/item/" + itemid + "/ajaxorder";
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (orderamount == 0) {
                        document.getElementById("succesOrder").innerHTML = "Succesfully removed this item from your cart!";
                    } else {
                        document.getElementById("succesOrder").innerHTML = "Succesfully added " + orderamount + " units to cart!";
                    }
                }
            }
            xmlhttp.open("GET", link + params, true);
            xmlhttp.send();



        }
    </script>

<?php endif ?>

<h2 class="m-4">
    Reviews:
</h2>
<h3 class="m-4">
    This item has an average review score of <?php echo round($average['score'], 1) ?>
</h3>
<?php if (!empty($reviews) && is_array($reviews)) : ?>
    <?php foreach ($reviews as $reviews_review) : ?>
        <?php foreach ($reviewers as $reviewer) {
            if ($reviewer['id'] == $reviews_review['userID']) {
                $reviewername = $reviewer['name'];
                break;
            }
        } ?>
        <div class="bg-secondary m-4 p-2 rounded">
            <h4> Review by user <?php echo $reviewername ?> with userid: <?php echo $reviews_review['userID']; ?></h4>
            <p><?php echo $reviews_review['reviewtext']; ?></p>
            <h5><?php echo $reviews_review['score']; ?> /5</h5>
        </div>

        </br>
    <?php endforeach; ?>
<?php else : ?>

    <h3 class="m-4">No reviews</h3>

    <p class="m-4">Unable to find any reviews for this item.</p>

<?php endif ?>