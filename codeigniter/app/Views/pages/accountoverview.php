<h2><?= esc($title) ?></h2>

<?php if (! empty($users) && is_array($users)) : ?>

    <?php foreach ($users as $users_item): ?>

        <h3><?= esc($users_item['name']) ?></h3>

        <div class="main">
            <?= esc($users_item['description']) ?>
        </div>
        <p><a href="/users/<?= esc($users_item['id'], 'url') ?>">View article</a></p>

    <?php endforeach; ?>

<?php else : ?>

    <h3>No users</h3>

    <p>Unable to find any users for you.</p>

<?php endif ?>