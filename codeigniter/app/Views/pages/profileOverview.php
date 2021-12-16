<div id="profiles" class=" align-content-stretch container d-flex justify-content-center">


    <?php if (!empty($foundusers) && is_array($foundusers)) : ?>
        <div class="row  justify-content-center ">
            <?php foreach ($foundusers as $user) : ?>
                <div class="border border-dark rounded bg-secondary">
                    <h3>
                        <?php echo $user['name']; ?>
                    </h3>
                    <h4>Id: <?php echo $user['id'] ?></h4>

                    <a class="btn btn-info" href="/profile/<?php echo $user['id'] ?>" type="button">Go to profile</a>

                </div>

            <?php endforeach; ?>
        </div>
    <?php else : ?>

        <h3>No users found</h3>

        <p>Unable to find any items for you.</p>

    <?php endif ?>

</div>