<h2><?= esc($item['name']) ?></h2>


<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="/Images/Items/<?php echo $item['filename']; ?>" class="d-block w-100" alt="...">
        </div>
        <?php if (!empty($media) && is_array($media)) : ?>
            <?php foreach ($media as $media_m) : ?>
                <?php if ($media_m['type'] == 'video/mp4') : ?>
                    <div class="carousel-item">
                        <video controls src="/Images/Items/<?php echo $media_m['file']; ?>" class="d-block w-100" alt="...">
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

<h3 class="d-flex justify-content-center">
    Description:
</h3>
<p class="d-flex justify-content-center">
    <?= esc($item['description']) ?>
</p>
<h3 class="d-flex justify-content-center">
    Sold by seller <?= esc($nameid['name']) ?> with id: <?= esc($item['sellerid']) ?>
</h3>
<h3 class="d-flex justify-content-center">
    Price:<?= esc($item['price']) ?>$
</h3>
<?php if (isset($_SESSION['id']) && $_SESSION['slug'] == "Shopper") : ?>
    <div class="d-flex justify-content-center row">
        <?php if ($item['availability'] > 0) : ?>
            <form action="/OrderController/placeorder" method="post" class="d-flex justify-content-center">
                <?= csrf_field() ?>
                <input type="hidden" name="itemid" value="<?php echo $item['itemid'] ?>">
                <button type="submit" class="btn btn-success">place order</button>
        <?php else : ?>
            <form action="/OrderController/placeorder" method="post" class="d-flex justify-content-center">
                <?= csrf_field() ?>
                <input type="hidden" name="itemid" value="<?php echo $item['itemid'] ?>">
                <button type="submit" class="btn btn-danger">place reservation</button>
        <?php endif; ?>
        <div class="form-group">
                    <select class="form-control" id="delivery" name="delivery">
                    <option>Pickup at store</option>
                    <option>Delivery at account adress</option>
                    </select>
                </div>
        </form>
    </div>

<?php endif ?>

<h3>
    Reviews:
</h3>
<h4>
    This item has an average review score of <?php echo round($average['score'], 1)?>
</h4>
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

    <h3>No reviews</h3>

    <p>Unable to find any reviews for this item.</p>

<?php endif ?>