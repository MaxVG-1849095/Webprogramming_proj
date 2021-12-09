<div class="container">

            <h2>
                Edit profile
            </h2>
            <div>
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
                </form>
            </div>
            <div >
                <p>
                    Current Adress: </br> <?php echo $user['adress'] ?>
                </p>
                <form action="/ProfileController/editadress" method="post" class="">
                    <?= csrf_field() ?>
                    <label class="" for="adressedit">Edit adress(street number city)</label>
                    <div class="d-flex">
                        <textarea rows="2" class="form-control" type="newadress" name="newadress"></textarea>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
            <br>
            <?php if ($_SESSION['slug'] == "Seller") : ?>
                <h3>Upload picture/video</h3>
                <form method="post" action="/ImageController/storeProfileImage" enctype="multipart/form-data" class="my-4">
                    <?= csrf_field() ?>
                    <input type="hidden" name="userid" value="<?php echo $_SESSION['id'] ?>">
                    <input type="file" id="profile_image" name="media_file" size="33" />
                    <input type="submit" value="Upload Image" />
                </form>
            <?php endif; ?>
</div>