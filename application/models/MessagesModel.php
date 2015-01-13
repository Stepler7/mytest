<?php

class MessagesModel extends CActiveRecord {

    /**
     * @param string $className
     * @return MessagesModel
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'messages';
    }

    public function primaryKey()
    {
        return 'ID';
    }

    public function relations()
    {
        return array(
            'user' => array(self::HAS_ONE, 'UsersModel', array('ID' => 'FK_user')),
        );
    }

    public function scopes()
    {
        return array(
            'latest' => array(
                'order' => 'published_at DESC',
            ),
            'chatLimited' => array(
                'limit' => Yii::app()->params['messagesLimit'],
            ),
        );
    }

    /**
     * Возвращает сообщения для чата
     *
     * @return mixed
     */
    public function getChatMessages()
    {
        return $this->latest()->chatLimited()->with('user')->findAll();
    }

    /**
     * Добавляет новое сообщение
     *
     * @param $message
     * @param bool $fromAjax
     */
    public function addMessage($message, $fromAjax = false)
    {
        $message = htmlentities($message, ENT_QUOTES, 'UTF-8');

        $model = new self();
        $model->FK_user = Yii::app()->user->id;
        $model->published_at = date('Y-m-d H:i:s');
        $model->message = $message;
        $model->ajax = (int)$fromAjax;
        $model->save();
    }

    /**
     * Возвращает сообщение, подготовленное к выводу
     *
     * @param bool $cut
     * @return mixed|string
     */
    public function getMessage($cut = false)
    {
        $result = $this->message;
        if ($cut){
            $result = mb_substr($result, 0, Yii::app()->params['oldMessagesSymbols'], 'UTF-8');
        }

        // Если нашли символ @ с текстом, проверяем, является ли текст одним из существующих логинов
        $result = preg_replace_callback('/(@[a-z0-9]{8})/is', function($matches){
            $match = substr($matches[0], 1);
            if (Yii::app()->cache->sIsMember(UserIdentity::CACHE_LOGINS_KEY, $match)){
                return '<b>' . $matches[0] . '</b>';
            } else {
                return $matches[0];
            }
        }, $result);

        return $result;
    }

}