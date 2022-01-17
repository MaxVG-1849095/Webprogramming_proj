<h1>
    System notifications:
</h1>
<div class="overflow-auto" id="messages">
<?php if (!empty($notifications) && is_array($notifications)) : ?>
    <?php foreach ($notifications as $message) : ?>
        <div class="bg-primary m-2 p-2 rounded">
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
        No available System notifications.
    </h2>
<?php endif; ?>
</div>
<h1>
    Message Filter
</h1>

<form action="/MessageController/loadSpecificMessages" method="post" class="">
    <?= csrf_field() ?>
    <div class="">
        <input type="hidden" name="senderid" value="<?php echo $_SESSION['id'] ?>">
        <div class="m-4">
            <label class="" for="receiverinput">Message receiver id (0 to undo filter)</label>
            <div class="d-flex">
                <input rows="2" class="form-control" type="number" min="0" max="<?php echo $highestid['id']; ?>" name="userid" placeholder="id of user" required></input>
            </div>
        </div>
        <button class="btn-info btn mx-4">Filter messages</button>
    </div>
</form>

<h1>
    Received messages:
</h1>
<div class="overflow-auto" id="messages">
<?php if (!empty($received_messages) && is_array($received_messages)) : ?>
    <?php foreach ($received_messages as $message) : ?>
        <?php foreach ($senders as $sender) {
            if ($sender['id'] == $message['senderid']) {
                $sendername = $sender['name'];
                break;
            }
        } ?>
        <div class="bg-secondary m-2 p-2 rounded">
            <p class="h4"> Message from user <?php echo $sendername ?> with id: <?php echo $message['senderid']; ?></p>
            <p class="h5">Sent: <?php echo $message['date']?> <?php echo $message['time']?></p>

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
</div>

<h1>
    Sent messages:
</h1>
<div class="overflow-auto" id="messages">
<?php if (!empty($sent_messages) && is_array($sent_messages)) : ?>
    <?php foreach ($sent_messages as $message) : ?>
        <?php foreach ($receivers as $receiver) {
            if ($receiver['id'] == $message['receiverid']) {
                $receivername = $receiver['name'];
                break;
            }
        } ?>
        <div class="bg-secondary m-2 p-2 rounded">
            <p class="h4"> Message to user <?php echo $receivername ?> with id: <?php echo $message['receiverid']; ?></p>
            <p class="h5">Sent: <?php echo $message['date']?> <?php echo $message['time']?></p>
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
</div>




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
            <label class="" for="receiverinput" >Message receiver id</label>
            <div class="d-flex">
                <input rows="2" class="form-control" type="number" min="1" max="<?php echo $highestid['id']; ?>" name="receiverid" placeholder="id of receiver" required></input>
            </div>
        </div>
        <div class="m-4">
            <label class="" for="contentinput">Message content</label>
            <div class="d-flex">
                <textarea rows="2" type="text" class="form-control" name="content" placeholder="content of message" required></textarea>
            </div>
        </div>
        <button class="mx-4 btn btn-success">Send message</button>
    </div>
</form>

<?php if (session()->getFlashdata('messageerror')) : ?>
    <div class="alert alert-warning">
        <?= session()->getFlashdata('messageerror') ?>
    </div>
<?php endif; ?>