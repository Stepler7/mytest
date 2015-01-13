<?php

class UsersModel extends CActiveRecord {

    /**
     * @param string $className
     * @return UsersModel
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'users';
    }

    public function primaryKey()
    {
        return 'ID';
    }

    public function relations()
    {
        return array();
    }

    /**
     * Подготавливает данные для складывания в кеш
     * @return string
     */
    public function prepareCacheData()
    {
        return json_encode(array('ID' => $this->ID, 'login' => $this->login));
    }


}