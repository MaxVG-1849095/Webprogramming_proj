<?php if (!empty($messages) && is_array($messages)) : ?>
    <?php foreach ($messages as $message) : ?>
        <?php foreach($senders as $sender) {
                if($sender['id'] == $message['senderid']){
                    $sendername = $sender['name'];
                    break;
                }
            }?>
        <?php if($message['senderid'] == 1) : ?>
        <div class="bg-primary">
            <h4> Message from system </h4>
        <?php else :?>
        <div class="bg-secondary">
            <h4> Message from user <?php echo $sendername?> with id: <?php echo $message['senderid']; ?></h4>
            <?php endif;?>
            <p><?php echo $message['content']; ?></p>
            <button class="bg-danger">Delete Message</button>
        </div>

        </br>
    <?php endforeach; ?>
<?php endif; ?>

<h1>
    Send message
</h1>
<form action="/MessageController/SendMessage" method="post" class="">
    <?= csrf_field() ?>
    <div class="">
        <input type="hidden" name="senderid" value="<?php echo $_SESSION['id'] ?>">
        <div class="m-4">
            <label class="" for="receiverinput">Message receiver id</label>
            <div class="d-flex">
                <input rows="2" class="form-control" type="number" min="1" max="<?php echo $highestid['id'];?>" name="receiverid" placeholder="id of receiver"></input>
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