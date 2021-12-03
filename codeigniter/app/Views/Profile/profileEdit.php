<div class="container">
    <div class="row">
        <div class="col-5">

            <h2>
                Edit profile
            </h2>
            <p>
                Current Description: </br> <?php echo $user['description'] ?>
            </p>
            <form action="/ProfileController/editdesc" method="post" class="">
                <?= csrf_field() ?>
                <label class="" for="Descriptionedit">Edit description</label>
                <div class="d-flex">
                    <textarea rows="2" class="form-control" type="newdesc" name="newdesc"></textarea>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
                <?php if (session()->getFlashdata('signuperror')) : ?>
                    <div class="alert alert-warning">
                        <?= session()->getFlashdata('signuperror') ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>