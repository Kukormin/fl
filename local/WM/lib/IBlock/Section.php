<?php

namespace WM\IBlock;

\Bitrix\Main\Loader::includeModule('iblock');

/**
 * Class Section
 * @package WM\IBlock
 */
class Section
{
    const CLASS_NAME = '\\Bitrix\\IBlock\\SectionTable';
    const OLD_CLASS_NAME = '\\CIBlockSection';

    /**
     * @param $name
     * @param $arguments
     * @return bool
     */
    public static function __callStatic($name, $arguments)
    {
        if(method_exists(static::CLASS_NAME, $name))
            return call_user_func_array(array(static::CLASS_NAME, $name), $arguments);
        return false;
    }

    public static function getListD7($iblockId, array $params = array())
    {
        $params['filter']['IBLOCK_ID'] = $iblockId;
        $params['filter']['ACTIVE'] = 'Y';
        $className = static::CLASS_NAME;
        $res = $className::getList($params);
        $ret = array();
        while($row = $res->fetch())
            $ret[$row['ID']] = $row;
        return $ret;
    }

    public static function getList($iblockId, array $params = array())
    {
        $arOrder            = static::getData($params, 'order',             array('SORT' => 'ASC'));
        $arFilter           = static::getData($params, 'filter',            array('IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'));
        $bIncCnt            = static::getData($params, 'bIncCnt',           false);
        $arSelect           = static::getData($params, 'arSelect',          array());
        $arNavStartParams   = static::getData($params, 'arNavStartParams',  false);

        $ret = array();
        $className = static::OLD_CLASS_NAME;
        $res = $className::GetList($arOrder, $arFilter, $bIncCnt, $arSelect, $arNavStartParams);
        while($row = $res->GetNext())
            $ret[$row['ID']] = $row;

        return $ret;
    }

    public static function getAllD7($iblockId, array $params = array())
    {
        $params['filter']['IBLOCK_ID'] = $iblockId;
        $className = static::CLASS_NAME;
        $res = $className::getList($params);
        $ret = array();
        while($row = $res->fetch())
            $ret[$row['ID']] = $row;
        return $ret;
    }
    public static function getAll($iblockId, array $params = array())
    {
        $params['filter']['IBLOCK_ID'] = $iblockId;
        return static::getList($iblockId, $params);
    }

    protected static function getData(array $params = array(), $key, $defValue = null)
    {
        return isset($params[$key]) ? $params[$key] : $defValue;
    }
}