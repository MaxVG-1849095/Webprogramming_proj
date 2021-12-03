<h2>Login</h2>
<?= service('validation')->listErrors() ?>

<form action="/LoginController/login" method="post" class="">
    <?= csrf_field() ?>
    <div class="">
    <label for="email">Email</label>
<input type="email" class="form-control" name="email" aria-describedby="nameHelp" placeholder="Enter Email">
    </div>
    <div class="">
    <label for="password">Password</label>
<input type="password" class="form-control" name="password" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <?php if (session()->getFlashdata('signuperror')) : ?>
        <div class="alert alert-warning">
            <?= session()->getFlashdata('signuperror') ?>
        </div>
    <?php endif; ?>
</form>

<div>
    <a href="/signup">
        Don't have an account yet? Signup here.
    </a>
</div>
<?php if (session()->getFlashdata('loginerror')) : ?>
    <div class="alert alert-warning">
        <?= session()->getFlashdata('loginerror') ?>
    </div>
<?php endif; ?>

