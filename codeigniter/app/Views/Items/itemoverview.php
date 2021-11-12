<div id="allitems" class="d-flex align-content-stretch flex-wrap">


    <?php if (! empty($items) && is_array($items)) : ?>
    <div class="row justify-content-center">


    <?php foreach ($items as $items_item): ?>
        <div id="sepitem" class="border border-dark rounded px-3 bg-secondary">
            <a class="d-flex justify-content-center"href="/item/<?= esc($items_item['itemid'], 'url') ?>">
                <img alt="Qries" src="<?php echo $items_item['link']; ?>"
                width="120" height="150">
            </a>
            <h3 class="d-flex"><?= esc($items_item['name']) ?></h3>

            <div class="main">
                <?= esc($items_item['description']) ?>
            </div>
        </div>
        

    <?php endforeach; ?>
    </div>
    <?php else : ?>

    <h3>No items</h3>

    <p>Unable to find any items for you.</p>

    <?php endif ?>

</div>