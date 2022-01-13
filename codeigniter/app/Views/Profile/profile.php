<?php if (!empty($media) && is_array($media)) : ?>
    <!-- media code-->
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php if ($media[0]['type'] == 'video/mp4') : ?>
                <div class="carousel-item active">
                    <video controls src="/Images/Users/<?php echo $media[0]['file']; ?>" class="d-block w-100" alt="carousel-controls">
                </div>
            <?php else : ?>
                <div class="carousel-item active">
                    <img src="/Images/Users/<?php echo $media[0]['file']; ?>" class="d-block w-100" alt="<?php echo $user['name'] ?>-picture">
                </div>
            <?php endif; ?>
            <?php array_shift($media); ?>

            <?php if (!empty($media) && is_array($media)) : ?>
                <?php foreach ($media as $media_m) : ?>
                    <?php if ($media_m['type'] == 'video/mp4') : ?>
                        <div class="carousel-item">
                            <video controls src="/Images/Users/<?php echo $media_m['file']; ?>" class="d-block w-100" alt="<?php echo $user['name'] ?>-video">
                        </div>
                    <?php else : ?>
                        <div class="carousel-item">
                            <img src="/Images/Users/<?php echo $media_m['file']; ?>" class="d-block w-100" alt="<?php echo $user['name'] ?>-picture">
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
<?php else : ?>
    <p class="d-flex justify-content-center">
        This user has no pictures!
    </p>
<?php endif; ?>
<h1 class="d-flex justify-content-center">
    <?php echo $user['name'] ?>
</h1>
<h2 class="d-flex justify-content-center">
    Description of user
</h2>
<p class="d-flex justify-content-center">
    <?php echo $user['description'] ?>
</p>
<h2 class="d-flex justify-content-center">
    User id: <?php echo $user['id'] ?>
</h2>
<p class="d-flex justify-content-center">
    You can contact me at: <?php echo $user['email'] ?>
</p>
<!-- info code-->

<?php if (isset($_SESSION['id']) && (($user['id'] == $_SESSION['id']) || $user['id'] === 0)) : ?>
    <nav>

        <div class="h3 nav-item"><a title="edit profile" href="/ProfileController/edit">Edit profile</a></div>

        <?php if ($_SESSION['slug'] === "Seller") : ?>

            <div class="h3 nav-item"><a title="edit wares" href="/ItemController/editwares">Edit wares</a></div>


        <?php endif; ?>


        <div class="h3 nav-item"><a title="messages" href="/MessageController/loadMessages">Messaging</a></div>


        <?php if ($_SESSION['slug'] == 'Seller') : ?>

            <div class="h3 nav-item"><a title="orders" href="/OrderController/loadOrdersSeller">Orders</a></div>

        <?php else : ?>

            <div class="h3 nav-item"><a title="orders" href="/OrderController/loadOrdersShopper">Orders</a></div>

        <?php endif; ?>
    </nav>
    <a type="button" class="btn btn-danger" href="/ProfileController/logout">Log out</a>
<?php endif; ?>