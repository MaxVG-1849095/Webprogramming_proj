<div id="allitems" class=" align-content-stretch container d-flex justify-content-center">
    <?php if (! empty($items) && is_array($items)) : ?>
    <div class="row  justify-content-between d-flex overflow-auto">
    <?php foreach ($items as $items_item): ?>
        <div id="sepitem" class="py-auto row container-fluid border border-dark rounded bg-primary col">
            <a tabindex=0 class=""href="/item/<?= esc($items_item['itemid'], 'url') ?>">
                <img class="d-flex justify-content-center" alt="<?= esc($items_item['name'])?>-itemthumbnail" src="/Images/Items/<?php echo $items_item['filename']; ?>">
            </a>
            <h2 class="overflow-auto"><span class="badge badge-secondary"><?= esc($items_item['name']) ?></span></h2>

        </div>
        

    <?php endforeach; ?>
    </div>
    <?php else : ?>

    <h1 class="d-flex justify-content-center">No items</h1>
        <br/>
    <p class="d-flex justify-content-center">Unable to find any items for you.</p>

    <?php endif ?>

</div>

