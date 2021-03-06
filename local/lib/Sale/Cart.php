<?
namespace Local\Sale;

use Bitrix\Main\Loader;
use Local\Catalog\Offer;

/**
 * Class Cart Корзина
 * @package Local\Sale
 */
class Cart
{
	/**
	 * Путь для кеширования
	 */
	const CACHE_PATH = 'Local/Sale/Cart/';

/*
	private static $propNames = [
		'SIT' => 'ID Места',
		'SECTOR' => 'Сектор',
		'ROW' => 'Ряд',
		'NUM' => 'Место',
		'SECRET' => 'Проверочный код',
	];*/

	/**
	 * Возвращает корзину текущего пользователя или товары заказа
	 * @param string $orderId
	 * @return array
	 * @throws \Bitrix\Main\LoaderException
	 */
	public static function getCart($orderId = 'NULL')
	{
		$return = [
			'COUNT' => 0,
			'QUANTITY' => 0,
			'PRICE' => 0,
			'ITEMS' => [],
		];
		Loader::IncludeModule('sale');

		$basket = new \CSaleBasket();
		$basket->Init();
		if ($orderId && $orderId != 'NULL')
			$filter = [
				'ORDER_ID' => $orderId,
			];
		else
			$filter = [
				'DELAY' => 'N',
				'ORDER_ID' => 'NULL',
				'FUSER_ID' => $basket->GetBasketUserID(),
			];
		$rsCart = $basket->GetList([], $filter);
		$ids = [];
		while ($item = $rsCart->Fetch())
		{
			$id = intval($item['ID']);
			$price = intval($item['PRICE']);
			$cnt = intval($item['PRODUCT_PRICE_ID']);
			$qnt = floatval($item['QUANTITY']);
			$return['ITEMS'][$id] = [
				'ID' => $id,
				'PRICE' => $price,
				'CNT' => $cnt,
				'QNT' => $qnt,
				'OFFER' => $item['PRODUCT_ID'],
			];

			$return['COUNT']++;
			$return['QUANTITY'] += $cnt;
			$return['PRICE'] += $price * $qnt;

			$ids[] = $id;
		}

		if ($ids)
		{
			$rsProps = $basket->GetPropsList([], ["@BASKET_ID" => $ids]);
			while ($prop = $rsProps->Fetch())
			{
				$id = $prop['BASKET_ID'];
				$return['ITEMS'][$id]['PROPS'][$prop['CODE']] = $prop['VALUE'];
			}
		}

		return $return;
	}

	/**
	 * Возвращает товары заказа
	 * @param $orderId
	 * @return array
	 */
	public static function getOrderItems($orderId)
	{
		return self::getCart($orderId);
	}

	/**
	 * Возвращает сводку по корзине
	 */
	public static function getSummaryDB()
	{
		$cart = self::getCart();
		return [
			'COUNT' => $cart['COUNT'],
			'QUANTITY' => $cart['QUANTITY'],
			'PRICE' => $cart['PRICE'],
		];
	}

	/**
	 * Обновляет сводку по корзине
	 */
	public static function updateSessionCartSummary()
	{
		$_SESSION['CART_SUMMARY'] = self::getSummaryDB();
	}

	/**
	 * Возвращает сводку по корзине
	 */
	public static function getSummary()
	{
		Loader::IncludeModule('sale');

		if (!isset($_SESSION['CART_SUMMARY']))
			self::updateSessionCartSummary();

		return $_SESSION['CART_SUMMARY'];
	}

	/**
	 * Добавление предложения в корзину
	 * @param $offerId
	 * @param $cnt
	 * @return bool|int
	 */
	public static function add($offerId, $cnt)
	{

		$offerId = intval($offerId);
		if ($offerId <= 0)
			return false;

		$offer = Offer::getById($offerId);
		if (!$offer)
			return false;

		$cnt = intval($cnt);
		if ($cnt < 1)
			$cnt = 1;

		$inpack = $offer['INPACK'];
		$qnt = $cnt * $inpack;

		Loader::IncludeModule('sale');

		$props = [];
		/*$props[] = [
			'NAME' => self::$propNames['SIT'],
			'CODE' => 'SIT',
			'VALUE' => $sitId,
		];
		$props[] = [
			'NAME' => self::$propNames['SECTOR'],
			'CODE' => 'SECTOR',
			'VALUE' => $sit[3],
		];
		$props[] = [
			'NAME' => self::$propNames['ROW'],
			'CODE' => 'ROW',
			'VALUE' => $sit[4],
		];
		$props[] = [
			'NAME' => self::$propNames['NUM'],
			'CODE' => 'NUM',
			'VALUE' => $sit[5],
		];*/

		$fields = [
			'PRODUCT_ID' => $offerId,
			'PRICE' => $offer['PRICE'],
			'PRODUCT_PRICE_ID' => $cnt,
			'QUANTITY' => $qnt,
			'CURRENCY' => 'RUB',
			'LID' => SITE_ID,
			'DELAY' => 'N',
			'CAN_BUY' => 'Y',
			'NAME' => $offer['NAME'],
			'MODULE' => 'main',
			'DETAIL_PAGE_URL' => $offer['DETAIL_PAGE_URL'],
			'PROPS' => $props,
		];

		$basket = new \CSaleBasket();
		$cartId = $basket->Add($fields);

		if ($cartId)
		{
			// Корректируем сводку
			self::updateSessionCartSummary();
		}

		return $cartId;
	}

	/**
	 * Удаление товара из корзины
	 * @param $cartId
	 * @return bool|int
	 */
	public static function delete($cartId)
	{
		Loader::IncludeModule('sale');

		$basket = new \CSaleBasket();
		$return = $basket->delete($cartId);

		if ($return)
		{
			// Корректируем сводку
			self::updateSessionCartSummary();
		}

		return $return;
	}

	/**
	 * Изменение
	 * @param $cartId
	 * @param $cnt
	 * @return bool
	 * @throws \Bitrix\Main\LoaderException
	 */
	public static function updateCnt($cartId, $cnt)
	{
		Loader::IncludeModule('sale');

		$basket = new \CSaleBasket();
		$item = $basket->GetByID($cartId);
		if (!$item)
			return false;

		$offer = Offer::getById($item['PRODUCT_ID']);
		if (!$offer)
			return false;

		$inpack = $offer['INPACK'];
		$qnt = $cnt * $inpack;

		$return = $basket->Update($cartId, [
			'PRODUCT_PRICE_ID' => $cnt,
			'QUANTITY' => $qnt,
		]);

		if ($return)
		{
			// Корректируем сводку
			self::updateSessionCartSummary();
		}

		return $return;
	}

}