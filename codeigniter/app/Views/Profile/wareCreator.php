<form action="/ItemController/createItem" method="post" enctype="multipart/form-data" class="">
    <?= csrf_field() ?>
    <div class="">
    <input type="hidden" name="sellerid" value="<?php echo $_SESSION['id'] ?>">
        <div class="m-4 form-group">
            <label class="" for="nameinput">Item name</label>
            <div class="d-flex">
                <input rows="2" class="form-control" name="name" placeholder="item name" required></input>
            </div>
        </div>
        <div class="m-4 form-group">
            <label class="" for="descriptioninput">Item description</label>
            <div class="d-flex">
                <textarea rows="2" class="form-control" name="description" placeholder="item description" required></textarea>
            </div>
        </div>
        <div class="m-4 form-group">
            <label class="" for="priceinput">Item price</label>
            <div class="d-flex">
                <input rows="2" class="form-control" type="number" name="price" placeholder="item price" required></input>
            </div>
        </div>
        <div class="m-4 form-group">
            <label class="" for="fileinput">File name</label>
            <div class="d-flex">
                
            <input type="file" id="profile_image" name="media_file" size="33" required/>
            </div>
        </div>
        <div class="m-4 d-inline-flex form-group">
            <input rows="2" class="form-control" type="number" min="0" name="availability" placeholder="new amount of items available"></input>
        </div>
        <!-- ability to upload file -->
        <div class="m-4">
            <button type="submit" class="btn btn-success">create ware</button>
        </div>
        
</form>