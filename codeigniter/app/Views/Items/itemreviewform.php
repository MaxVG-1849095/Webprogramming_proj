<div class="container">
    <div class="row">
        <div class="col-5">
            
            <h2>
                Leave review for <?php echo $item['name']?>
            </h2>
            <form action="/MessageController/createReview" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="itemid" value="<?php echo $item['itemid'] ?>">
                <input type="hidden" name="notid" value="<?php echo $notid?>">
                <div class="form-group">
                    <label for="customerType">Rating out of 5</label>
                    <select class="form-control" id="rating" name="rating">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputName1">Description</label>
                    <textarea rows="2" class="form-control" type="description" name="description" placeholder="Review content"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>