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

    <form action="/ItemController/updatedescription" method="post" class="">
        <?= csrf_field() ?>
        <input type="hidden" name="itemid" value="<?php echo $item['itemid'] ?>">
        <label class="" for="Descriptionedit">Edit description</label>
        <div class="d-flex">
            <textarea rows="2" class="form-control" type="newdesc" name="newdesc" placeholder="new description"></textarea>
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
    </form>


    <div class="my-4">
        <form action="/ItemController/setAvailability" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="itemid" value="<?php echo $item['itemid'] ?>">
            <?php if ($item['availability'] == 1) : ?>
                <input type="hidden" name="availability" value="0">
                <button type="submit" class="btn btn-danger">Set Unavailable</button>
            <?php else : ?>

                <input type="hidden" name="availability" value="1">
                <button type="submit" class="btn btn-success">Set Available</button>
            <?php endif; ?>
        <?php endif; ?>
        </form>
    </div>
    <h3>Upload new picture</h3>
    <form method="post" action="/ImageController/storeItemImage" enctype="multipart/form-data" class="my-4">
    <?= csrf_field() ?>    
        <input type="hidden" name="itemid" value="<?php echo $item['itemid'] ?>">
        <input type="file" id="profile_image" name="media_file" size="33" />
        <input type="submit" value="Upload Image" />
    </form>

    <form action="/ItemController/removeItem" method="post" class="">
        <?= csrf_field() ?>
        <input type="hidden" name="itemid" value="<?php echo $item['itemid'] ?>">
        <input type="hidden" name="itemid" value="<?php echo $item['itemid'] ?>">
        <button type="submit" class="btn btn-danger">delete ware</button>
    </form>