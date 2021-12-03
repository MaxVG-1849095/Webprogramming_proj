
<form action="/ItemController/updateprice" method="post" class="">
        <?= csrf_field() ?>
        <a type="button" class="btn btn-success" href="/ItemController/createItemRedirect">Create ware</a>
</form>
<div id="allwares" class=" align-content-stretch container d-flex justify-content-center">
    <?php if (! empty($wares) && is_array($wares)) : ?>
    <div class="row  justify-content-center d-inline-flex">
    <?php foreach ($wares as $wares_ware): ?>
        <div id="sepitem" class="row container-fluid border border-dark rounded m-auto p-auto bg-primary col">
            <a class="column d-inline-flex justify-content-center"href="/ItemController/wareEditor/<?= esc($wares_ware['itemid'], 'url') ?>">
                <img alt="wares" src="/Images/Items/<?php echo $wares_ware['filename']; ?>"
                width="120" height="120">
            </a>
            <h3 class="column d-inline-flex justify-content-center"><?= esc($wares_ware['name']) ?></h3>

            <div class="main">
            </div>
        </div>
        

    <?php endforeach; ?>
    </div>
    <?php else : ?>

    <h3>No wares</h3>

    <p>Unable to find any wares for you.</p>

    <?php endif ?>

</div>