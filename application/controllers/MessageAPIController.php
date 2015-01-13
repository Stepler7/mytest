<?php

class MessageAPIController extends CController {

    public function actionAddMessage()
    {
        if (isset($_POST['message']) && !Yii::app()->user->isGuest){
            MessagesModel::model()->addMessage($_POST['message'], true);
            $result = array('errorCode' => 0);
        } else {
            $result = array('errorCode' => 1, 'errorMessage' => 'some_error_happened');
        }

        header("Content-type: application/json; charset=utf-8");
        echo json_encode($result);
    }

}