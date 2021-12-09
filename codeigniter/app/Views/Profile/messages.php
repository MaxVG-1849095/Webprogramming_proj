<h1>
    System notifications:
</h1>
<?php if (!empty($notifications) && is_array($notifications)) : ?>
    <?php foreach ($notifications as $message) : ?>
        <div class="bg-primary m-4 p-2 rounded">
            <p><?php echo $message['content']; ?></p>
            <?php if ($message['attachment'] == 1) : ?>
                <form action="/MessageController/reviewpage" method="post" class="">
                    <?= csrf_field() ?>
                    <input type="hidden" name="itemid" value="<?php echo $message['itemid'] ?>">
                    <input type="hidden" name="notid" value="<?php echo $message['notid'] ?>">
                    <button type="submit" class="btn btn-info">leave review</button>
                </form>
            <?php elseif ($message['attachment'] == 2) : ?>
                <form action="/MessageController/reviewpage" method="post" class="">
                    <?= csrf_field() ?>
                    <input type="hidden" name="notiId" value="<?php echo $message['notid'] ?>">
                    <button type="submit" class="btn btn-success">confirm order</button>
                </form>
                <form action="/MessageController/reviewpage" method="post" class="">
                    <?= csrf_field() ?>
                    <input type="hidden" name="notiId" value="<?php echo $message['notid'] ?>">
                    <button type="submit" class="btn btn-danger">cancel order</button>
                </form>
            <?php endif; ?>
            <form action="/MessageController/removeNotification" method="post" class="">
                <?= csrf_field() ?>
                <input type="hidden" name="notiId" value="<?php echo $message['notid'] ?>">
                <button type="submit" class="btn btn-danger">delete message</button>
            </form>
        </div>
        </br>
    <?php endforeach; ?>
<?php else : ?>
    <h2>
        No available received messages.
    </h2>
<?php endif; ?>
<h1>
    Received messages:
</h1>

<?php if (!empty($received_messages) && is_array($received_messages)) : ?>
    <?php foreach ($received_messages as $message) : ?>
        <?php foreach ($senders as $sender) {
            if ($sender['id'] == $message['senderid']) {
                $sendername = $sender['name'];
                break;
            }
        } ?>
        <div class="bg-secondary m-4 p-2 rounded">
            <h4> Message from user <?php echo $sendername ?> with id: <?php echo $message['senderid']; ?></h4>

            <p><?php echo $message['content']; ?></p>
            <form action="/MessageController/removeMessage" method="post" class="">
                <?= csrf_field() ?>
                <input type="hidden" name="messageid" value="<?php echo $message['messageid'] ?>">
                <button type="submit" class="btn btn-danger">delete message</button>
            </form>
        </div>
        </br>
    <?php endforeach; ?>
<?php else : ?>
    <h2>
        No available received messages.
    </h2>
<?php endif; ?>


<h1>
    Sent messages:
</h1>

<?php if (!empty($sent_messages) && is_array($sent_messages)) : ?>
    <?php foreach ($sent_messages as $message) : ?>
        <?php foreach ($receivers as $receiver) {
            if ($receiver['id'] == $message['receiverid']) {
                $receivername = $receiver['name'];
                break;
            }
        } ?>
        <div class="bg-secondary m-4 p-2 rounded">
            <h4> Message to user <?php echo $receivername ?> with id: <?php echo $message['receiverid']; ?></h4>
            <p><?php echo $message['content']; ?></p>
            <form action="/MessageController/removeMessage" method="post" class="">
                <?= csrf_field() ?>
                <input type="hidden" name="messageid" value="<?php echo $message['messageid'] ?>">
                <button type="submit" class="btn btn-danger">delete message</button>
            </form>
        </div>
        </br>
    <?php endforeach; ?>
<?php else : ?>
    <h2>
        No available received messages.
    </h2>
<?php endif; ?>



<h1>
    Send message
</h1>
<p>
    You can search users with the search bar "Search user" option
</p>
<form action="/MessageController/SendMessage" method="post" class="">
    <?= csrf_field() ?>
    <div class="">
        <input type="hidden" name="senderid" value="<?php echo $_SESSION['id'] ?>">
        <div class="m-4">
            <label class="" for="receiverinput">Message receiver id</label>
            <div class="d-flex">
                <input rows="2" class="form-control" type="number" min="1" max="<?php echo $highestid['id']; ?>" name="receiverid" placeholder="id of receiver"></input>
            </div>
        </div>
        <div class="m-4">
            <label class="" for="contentinput">Message content</label>
            <div class="d-flex">
                <textarea rows="2" class="form-control" name="content" placeholder="content of message"></textarea>
            </div>
        </div>
        <button class=mx-4>Send message</button>
    </div>
</form>