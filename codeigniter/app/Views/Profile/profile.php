<h1> Currently signed in user: <?php if (isset($_SESSION['name'])) {
                                    echo $_SESSION['name'];
                                } else {
                                    echo "How did you get here?";
                                } ?>
</h1>
<h3>
<div class="nav-item"><a title="ab" href="/ProfileController/edit">Edit profile</a></div>
</h3>
<?php if ($_SESSION['slug'] === "Seller"):?>
<h3>
<div class="nav-item"><a title="ab" href="/ItemController/editwares">Edit wares</a></div>
</h3>

<?php endif;?>

<h3>
<div class="nav-item"><a title="ab" href="/MessageController/loadMessages">Messaging</a></div>
</h3>









<a type="button" class="btn btn-danger" href="/ProfileController/logout">Log out</a>