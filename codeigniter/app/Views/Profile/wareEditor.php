<?php if (isset($_SESSION['id']) && $item['sellerid'] === $_SESSION['id']) : ?>
    <form action="/ItemController/updatename" method="post" class="">
        <?= csrf_field() ?>
        <input type="hidden" name="itemid" value="<?php echo $item['itemid'] ?>">
        <label class="" for="nameEdit">Edit name (Current name: <?php echo $item['name'] ?>)</label>
        <div class="d-flex">
            <input rows="2" class="form-control" type="newname" name="newname" placeholder="new name"></input>
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
    </form>
    <form action="/ItemController/updateprice" method="post" class="">
        <?= csrf_field() ?>
        <input type="hidden" name="itemid" value="<?php echo $item['itemid'] ?>">
        <label class="" for="priceEdit">Edit price (Current price: <?php echo $item['price'] ?>)</label>
        <div class="d-flex">
            <input rows="2" class="form-control" type="number" min="0" name="newprice" placeholder="new price"></input>
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
    </form>

    <form action="/ItemController/updateavailability" method="post" class="">
        <?= csrf_field() ?>
        <input type="hidden" name="itemid" value="<?php echo $item['itemid'] ?>">
        <label class="" for="priceEdit">Edit Amount of available items (Current amount of items available: <?php echo $item['availability'] ?>)</label>
        <div class="d-flex">
            <input rows="2" class="form-control" type="number" min="0" name="newavailable" placeholder="new amount of items available"></input>
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
    </form>

    <form action="/ItemController/updatedescription" method="post" class="">
        <?= csrf_field() ?>
        <input type="hidden" name="itemid" value="<?php echo $item['itemid'] ?>">
        <label class="" for="Descriptionedit">Edit description (Current description: <?php echo $item['description']?>)</label>
        <div class="d-flex">
            <textarea rows="2" class="form-control" type="newdesc" name="newdesc" placeholder="new description"></textarea>
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
    </form>

    <h3>Upload new picture</h3>
    <form method="post" action="/ImageController/storeItemImage" enctype="multipart/form-data" class="my-4">
    <?= csrf_field() ?>    
        <input type="hidden" name="itemid" value="<?php echo $item['itemid'] ?>">
        <input type="file" id="profile_image" name="media_file" size="33" />
        <input type="submit" value="Upload Image" />
    </form>
    <?php if (session()->getFlashdata('picturefeedback')) : ?>
    <div class="alert alert-warning">
        <?= session()->getFlashdata('picturefeedback') ?>
    </div>
<?php endif; ?>

    <form action="/ItemController/removeItem" method="post" class="">
        <?= csrf_field() ?>
        <input type="hidden" name="itemid" value="<?php echo $item['itemid'] ?>">
        <button type="submit" class="btn btn-danger">delete ware</button>
    </form>

    <?php else:?>
        <h1>
            This is not your item!
        </h1>
    <?php endif; ?>