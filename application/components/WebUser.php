<?php

class WebUser extends CWebUser{

    /**
     * Проверяем, существует ли запись с данной sessionId в редисе и совпадает ли имя пользователя
     *
     * @param mixed $id
     * @param array $states
     * @param bool $fromCookie
     * @return bool
     */
    protected function beforeLogin($id,$states,$fromCookie)
    {
        if (!isset($states['sessionId'])) return false;

        $userInfo = Yii::app()->cache->getValue(UserIdentity::CACHE_AUTH_PREFIX . $states['sessionId']);
        if (empty($userInfo)) return false;

        $data = json_decode($userInfo, true);
        if ($data['login'] != $states['login']) return false;

        Yii::app()->cache->expire('auth:' . $states['sessionId'], UserIdentity::SESSION_LIFETIME);
        return true;
    }

}