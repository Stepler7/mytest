<?php

class UserIdentity extends CUserIdentity {

    const SESSION_LIFETIME = 28800;
    const CACHE_AUTH_PREFIX = 'auth:';
    const CACHE_LOGINS_KEY = 'cache:mytest:logins';

    public function authenticate()
    {
        if (isset($this->username)){
            // Проверяем на всякий случай (ранее есть проверка по редису), не существует ли пользователь с таким логином в БД
            if (UsersModel::model()->exists('login = :login', array(':login' => $this->username))) return false;

            // Создаём нового пользователя
            $user = new UsersModel();
            $user->login = $this->username;
            $user->save();

            // Записываем в set редиса логин пользователя (для того, чтоб в дальнейшем можно было быстро проверить существование логина)
            Yii::app()->cache->sAdd(self::CACHE_LOGINS_KEY, $user->login);

            // Создаём уникальный идентификатор сессии и складываем данные пользователя в редис
            $sessionId = md5(uniqid(rand(), true));
            Yii::app()->cache->setValue(self::CACHE_AUTH_PREFIX . $sessionId, $user->prepareCacheData(), self::SESSION_LIFETIME);

            // Устанавливаем данные, сохраняемые в куку
            $this->setState('id', $user->ID);
            $this->setState('login', $user->login);
            $this->setState('sessionId', $sessionId);

            return true;
        } else {
            return false;
        }
    }

}