<?
namespace Local\Catalog;
use Local\System\ExtCache;

/**
 * Class Unit Единицы измерения
 * @package Local\Catalog
 */
class Unit
{
	/**
	 * Путь для кеширования
	 */
	const CACHE_PATH = 'Local/Catalog/Unit/';

	/**
	 * ID инфоблока
	 */
	const IBLOCK_ID = 10;

	/**
	 * Возвращает все элементы
	 * @param bool $refreshCache
	 * @return array|mixed
	 */
	public static function getAll($refreshCache = false)
	{
		$return = [];

		$extCache = new ExtCache(
			[
				__FUNCTION__,
			],
			static::CACHE_PATH . __FUNCTION__ . '/',
			8640000
		);
		if (!$refreshCache && $extCache->initCache())
			$return = $extCache->getVars();
		else
		{
			$extCache->startDataCache();

			$iblockElement = new \CIBlockElement();
			$rsItems = $iblockElement->GetList([], [
				'IBLOCK_ID' => self::IBLOCK_ID,
			    'ACTIVE' => 'Y',
			], false, false, [
				'ID', 'NAME', 'CODE',
			    'PROPERTY_SHOW',
			]);
			while ($item = $rsItems->Fetch())
			{
				$id = intval($item['ID']);
				$return['ITEMS'][$id] = [
					'ID' => $id,
					'NAME' => $item['NAME'],
					'SHOW' => $item['PROPERTY_SHOW_VALUE'],
				];
				$return['BY_NAME'][$item['NAME']] = $id;
			}

			$extCache->endDataCache($return);
		}

		return $return;
	}

	/**
	 * Возвращает элемент по Id
	 * @param $id
	 * @param bool $refreshCache
	 * @return mixed
	 */
	public static function getById($id, $refreshCache = false)
	{
		$items = self::getAll($refreshCache);
		return $items['ITEMS'][$id];
	}

	/**
	 * Возвращает элемент по названию
	 * @param $name
	 * @param bool $refreshCache
	 * @return mixed
	 */
	public static function getByName($name, $refreshCache = false)
	{
		$items = self::getAll($refreshCache);
		$id = $items['BY_NAME'][$name];
		return $items['ITEMS'][$id];
	}

}
