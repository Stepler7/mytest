<?php
$oldMessagesFirstIndex = Yii::app()->params['messagesLimit'] - Yii::app()->params['oldMessages'];
if ($oldMessagesFirstIndex < 0) $oldMessagesFirstIndex = 0;

foreach ($this->messages as $key => $message):
    if ($message instanceof MessagesModel): ?>
        <div style="padding: 5px 0px; border-bottom: 1px solid #cccccc; color: <?php echo $message->ajax ? '#008800;' : 'black'?>">
            <?php echo $message->published_at . ' | ' . $message->user->login;?>
            <br/>
            <span>
                <?php echo $message->getMessage($key >= $oldMessagesFirstIndex);?>
            </span>
        </div>
<?
    endif;
endforeach;