<div id="allitems" class=" align-content-stretch container d-flex justify-content-center">


    <?php if (! empty($items) && is_array($items)) : ?>
    <div class="row  justify-content-center ">
    <?php foreach ($items as $items_item): ?>
        <div id="sepitem" class="row container-fluid border border-dark rounded bg-primary col">
            <a class=""href="/item/<?= esc($items_item['itemid'], 'url') ?>">
                <img alt="Items" src="/Images/Items/<?php echo $items_item['filename']; ?>">
            </a>
            <h3 class=""><?= esc($items_item['name']) ?></h3>

            <div class="main">
            </div>
        </div>
        

    <?php endforeach; ?>
    </div>
    <?php else : ?>

    <h3 class="d-flex justify-content-center">No items</h3>
        <br/>
    <p class="d-flex justify-content-center">Unable to find any items for you.</p>

    <?php endif ?>

</div>

