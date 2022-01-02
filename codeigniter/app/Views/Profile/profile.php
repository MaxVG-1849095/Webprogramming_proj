    <!-- seller pagina -->

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
                        <img src="/Images/Users/<?php echo $media[0]['file']; ?>" class="d-block w-100" alt="<?php echo $user['name']?>-picture">
                    </div>
                <?php endif; ?>
                <?php array_shift($media); ?>

                <?php if (!empty($media) && is_array($media)) : ?>
                    <?php foreach ($media as $media_m) : ?>
                        <?php if ($media_m['type'] == 'video/mp4') : ?>
                            <div class="carousel-item">
                                <video controls src="/Images/Users/<?php echo $media_m['file']; ?>" class="d-block w-100" alt="<?php echo $user['name']?>-video">
                            </div>
                        <?php else : ?>
                            <div class="carousel-item">
                                <img src="/Images/Users/<?php echo $media_m['file']; ?>" class="d-block w-100" alt="<?php echo $user['name']?>-picture">
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
        <h3 class="d-flex justify-content-center">
            This user has no pictures!
        </h3>
    <?php endif; ?>
    <h3 class="d-flex justify-content-center">
        <?php echo $user['name'] ?>
    </h3>
    <h4 class="d-flex justify-content-center">
        Description of user
    </h4>
    <p class="d-flex justify-content-center">
        <?php echo $user['description'] ?>
    </p>
    <h4 class="d-flex justify-content-center">
        User id: <?php echo $user['id'] ?>
    </h4>
    <h5 class="d-flex justify-content-center">
        You can contact me at: <?php echo $user['email'] ?>
    </h5>
    <!-- info code-->

<?php if (isset($_SESSION['id']) && (($user['id'] == $_SESSION['id']) || $user['id'] === 0)) : ?>
    <h3>
        <div class="nav-item"><a tabindex=0 title="ab" href="/ProfileController/edit">Edit profile</a></div>
    </h3>
    <?php if ($_SESSION['slug'] === "Seller") : ?>
        <h3>
            <div class="nav-item"><a tabindex=0 title="ab" href="/ItemController/editwares">Edit wares</a></div>
        </h3>

    <?php endif; ?>

    <h3>
        <div class="nav-item"><a tabindex=0 title="ab" href="/MessageController/loadMessages">Messaging</a></div>
    </h3>

    <?php if ($_SESSION['slug'] == 'Seller') : ?>
        <h3>
            <div class="nav-item"><a tabindex=0 title="ab" href="/OrderController/loadOrdersSeller">Orders</a></div>
        </h3>
    <?php else : ?>
        <h3>
            <div class="nav-item"><a tabindex=0 title="ab" href="/OrderController/loadOrdersShopper">Orders</a></div>
        </h3>
    <?php endif; ?>
    <a tabindex=0 type="button" class="btn btn-danger" href="/ProfileController/logout">Log out</a>
<?php endif; ?>