<div class="d-flex justify-content-center">


    <div id="allitems" class="align-content-stretch container d-flex justify-content-center row overflow-auto">
        <?php if (!empty($items) && is_array($items)) : ?>

            <?php foreach ($items as $items_item) : ?>
                <div class="sepitem p-auto m-0 column container-fluid border border-dark rounded bg-primary col">
                    <a tabindex=0 class="" href="/item/<?= esc($items_item['itemid'], 'url') ?>">
                        <img class="d-flex justify-content-center" alt="<?= esc($items_item['name']) ?>-itemthumbnail" src="/Images/Items/<?php echo $items_item['filename']; ?>">
                    </a>
                    <p  class="itemtitle d-flex justify-content-center text-justify overflow-auto"><?= esc($items_item['name']) ?></p>
                </div>


            <?php endforeach; ?>

        <?php else : ?>

            <h1 class="d-flex justify-content-center">No items</h1>
            <br />
            <p class="d-flex justify-content-center">Unable to find any items for you.</p>

        <?php endif ?>

    </div>

</div>