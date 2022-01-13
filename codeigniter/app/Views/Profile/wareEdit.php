
<form action="/ItemController/createItemRedirect" method="post" class="">
        <?= csrf_field() ?>
        <a type="button" class="btn btn-success" href="/ItemController/createItemRedirect">Create ware</a>
</form>
<div class="d-flex justify-content-center">
<div id="allwares" class="align-content-stretch container d-flex justify-content-center row overflow-auto">
    <?php if (! empty($wares) && is_array($wares)) : ?>
    <?php foreach ($wares as $wares_ware): ?>
        <div id="sepitem" class="p-auto m-0 column container-fluid border border-dark rounded bg-primary col">
            <a tabindex=0 class=""href="/wareeditor/<?= esc($wares_ware['itemid'], 'url') ?>">
                <img class="d-flex justify-content-center" alt="<?php echo $wares_ware['name']; ?>-picture" src="/Images/Items/<?php echo $wares_ware['filename']; ?>">
            </a>
            <p id="itemtitle" class="d-flex justify-content-center text-justify overflow-auto"><?= esc($wares_ware['name']) ?></p>

        
        </div>
        

    <?php endforeach; ?>
    <?php else : ?>

    <h1>No wares</h1>

    <p>Unable to find any wares for you.</p>

    <?php endif ?>

</div>