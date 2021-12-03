<form action="/ItemController/createItem" method="post" enctype="multipart/form-data" class="">
    <?= csrf_field() ?>
    <div class="">
    <input type="hidden" name="sellerid" value="<?php echo $_SESSION['id'] ?>">
        <div class="m-4">
            <label class="" for="nameinput">Item name</label>
            <div class="d-flex">
                <input rows="2" class="form-control" name="name" placeholder="item name"></input>
            </div>
        </div>
        <div class="m-4">
            <label class="" for="descriptioninput">Item description</label>
            <div class="d-flex">
                <textarea rows="2" class="form-control" name="description" placeholder="item description"></textarea>
            </div>
        </div>
        <div class="m-4">
            <label class="" for="priceinput">Item price</label>
            <div class="d-flex">
                <input rows="2" class="form-control" type="number" name="price" placeholder="item price"></input>
            </div>
        </div>
        <div class="m-4">
            <label class="" for="fileinput">File name</label>
            <div class="d-flex">
            <input type="file" id="profile_image" name="media_file" size="33" />
            </div>
        </div>
        <div class="m-4 d-inline-flex">
            <select class="form-control" id="searchtype" name="availability">
                <option>Currently available</option>
                <option>Currently unavailable</option>
            </select>
        </div>
        <!-- ability to upload file -->
        <div class="m-4">
            <button type="submit" class="btn btn-success">create ware</button>
        </div>
        
</form>