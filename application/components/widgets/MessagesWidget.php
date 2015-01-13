<?php

class MessagesWidget extends CWidget
{
    /**
     * @var array массив MessagesModel
     */
    public $messages = array();

    public function run()
    {
        if (!empty($this->messages)){
            $this->render('MessagesWidget');
        }
    }
}