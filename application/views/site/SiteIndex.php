<h2>The chat</h2>
<h3>Hello, <?php echo Yii::app()->user->login ?></h3>
<form action="/" method="post">
    <span>Enter your message:</span>
    <br/>
    <textarea name="taMessage" id="taMessage" cols="50" rows="5" maxlength="1000"></textarea>
    <br/><br/>
    <input type="submit" id="inputSubmit" value="Отправить"/>
</form>
<?php $this->widget('MessagesWidget', array('messages' => $messages)); ?>

<script type="text/javascript">
    $(function(){
        if ($("#NoJSCheck").length == 0){
            $("#inputSubmit").on('click', function(e){
                e.preventDefault();
                var message = $("#taMessage").val();
                if (message.length > 0){
                    $.post('/messageAPI/addMessage', {message: message}, function (data) {
                        if (data.errorCode == 0){
                            window.location.reload();
                        }
                    });
                }
            });
        }
    });
</script>