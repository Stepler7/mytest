<?php

class SiteController extends CController {

    public function actionIndex()
    {
        if (isset($_POST['taMessage']) && !Yii::app()->user->isGuest){
            MessagesModel::model()->addMessage($_POST['taMessage']);
        }

        // Если пользователь пришёл впервые, или по какой-то причине он не смог перелогиниться,
        // то создаём пользователю логин и логиним его.
        if (Yii::app()->user->isGuest){
            do { // Перебираем рандомные логины пока не найдём такой, которого ещё не было
                $login = substr(md5(uniqid(rand(), true)), 0, 8);
            } while (Yii::app()->cache->sIsMember(UserIdentity::CACHE_LOGINS_KEY, $login));

            $userIdentity = new UserIdentity($login, null);
            if ($userIdentity->authenticate()){
                Yii::app()->user->login($userIdentity, UserIdentity::SESSION_LIFETIME);
            }
        }

        $messages = MessagesModel::model()->getChatMessages();

        $this->render('SiteIndex', array('messages' => $messages));
    }

    public function actionError()
    {
        echo 'Some error happened';
    }

}