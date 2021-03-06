<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$cart = \Local\Sale\Cart::getCart();

?>
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="main-content">
    <div class="commerce"><?

        if (!count($cart['ITEMS']))
        {
			?>
            <p class="cart-empty">Ваша корзина пуста.</p>
			<p class="return-to-shop"><a class="button wc-backward rounded" href="<?= CATALOG_PATH ?>">Каталог товаров</a></p><?
        }
        else
		{

			?>
            <form>
                <table id="cart" class="table shop_table cart">
                    <thead>
                    <tr>
                        <th class="product-thumbnail hidden-xs">&nbsp;</th>
                        <th class="product-name">Название</th>
                        <th class="product-price text-center">Цена</th>
                        <th class="product-quantity text-center">Количество</th>
                        <th class="product-subtotal text-center hidden-xs">Сумма</th>
                        <th class="product-remove hidden-xs">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody><?

					$file = new \CFile();
					foreach ($cart['ITEMS'] as $item)
					{
						$offer = \Local\Catalog\Offer::getById($item['OFFER']);
						$img = $file->GetFileArray($offer['PREVIEW_PICTURE']);
						$price = number_format($item['PRICE'], 0, '', ' ');
						$dPrice = '';
						if ($offer['PRICE_WO_DISCOUNT'] > $item['PRICE'])
							$dPrice = number_format($offer['PRICE_WO_DISCOUNT'], 0, '', ' ');
						$sum = number_format($item['PRICE'] * $item['QNT'], 0, '', ' ');
						$unit = \Local\Catalog\Unit::getById($offer['UNIT']);
						$forUnit = '';
						$labelUnit = '';
						if ($unit['SHOW'])
						{
							$forUnit = '/' . $unit['NAME'];
							if ($offer['INPACK'] != 1)
							    $labelUnit = $unit['NAME'];
						}
                        $qnt = '';
					    if ($offer['INPACK'] != 1)
					        $qnt = $item['QNT'];
						?>
                        <tr class="cart_item" data-id="<?= $item['ID'] ?>">
                            <td class="product-thumbnail hidden-xs">
                                <a href="<?= $offer['DETAIL_PAGE_URL'] ?>">
                                    <img width="<?= $img['WIDTH'] ?>" height="<?= $img['HEIGHT'] ?>"
                                         src="<?= $img['SRC'] ?>" alt="<?= $offer['NAME'] ?>"/>
                                </a>
                            </td>
                            <td class="product-name">
                                <a href="<?= $offer['DETAIL_PAGE_URL'] ?>"><?= $offer['NAME'] ?></a><?

                                /*
                                ?>
                                <dl class="variation">
                                    <dt class="variation-Color">Color:</dt>
                                    <dd class="variation-Color"><p>Green</p></dd>
                                    <dt class="variation-Size">Size:</dt>
                                    <dd class="variation-Size"><p>Extra Large</p></dd>
                                </dl><?*/

                                ?>
                            </td>
                            <td class="product-price text-center"><?

								if ($dPrice)
								{
									?>
                                    <del><span class="amount"><?= $dPrice ?> руб.<?= $forUnit ?></span></del><br /><?
								}

								?>
                                <span class="amount"><?= $price ?> руб.<?= $forUnit ?></span>
                            </td>
                            <td class="product-quantity text-center">
                                <div class="quantity"><?

									if ($unit['SHOW'])
									{
										?>
                                        <input type="number" step="1" min="0" name="qnt"
                                               value="<?= floor($item['QNT']) ?>" title="Количество, <?= $labelUnit ?>"
                                               class="input-text qty text" size="4" data-price="<?= $item['PRICE'] ?>"/><?
									}

									?><input type="number" step="1" min="0" name="cnt" data-price="<?= $item['PRICE'] ?>"
                                           value="<?= $item['CNT'] ?>" title="Количество упаковок" class="input-text qty text"
                                           size="4"/>
                                    <span class="amount js-qnt" data-inpack="<?= $offer['INPACK'] ?>"><?= $qnt ?></span> <?= $labelUnit ?>
                                </div>
                            </td>
                            <td class="product-subtotal hidden-xs text-center">
                                <span class="amount js-total"><?= $sum ?></span> руб.
                            </td>
                            <td class="product-remove hidden-xs">
                                <a href="#" class="remove" title="Удалить">&times;</a>
                            </td>
                        </tr><?
					}

					/*
					?>
					<tr>
						<td colspan="6" class="actions">
							<div class="coupon">
								<label for="coupon_code">Coupon:</label>
								<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="Coupon code"/>
								<input type="submit" class="button rounded" name="apply_coupon" value="Apply Coupon"/>
							</div>
							<input type="submit" class="button update-cart-button rounded" name="update_cart" value="Update Cart"/>
						</td>
					</tr><?*/

					?>
                    </tbody>
                </table>
            </form>
			<?

			$price = number_format($cart['PRICE'], 0, '', ' ');
			$deliveryPrice = 0;
			$total = number_format($cart['PRICE'] + $deliveryPrice, 0, '', ' ');

			?>
            <div class="cart-collaterals">
            <div class="cart_totals">
            <h2>Итого по корзине</h2>
            <table>
                <tr class="cart-subtotal">
                    <th>Товары</th>
                    <td><span class="amount js-cart-price"><?= $price ?></span> руб.</td>
                </tr>
                <tr class="shipping">
                    <th>Доставка</th>
                    <td><span class="amount">0</span></td>
                </tr>
                <tr class="order-total">
                    <th>Итого</th>
                    <td><strong><span class="amount js-cart-total"><?= $total ?></span></strong> руб.</td>
                </tr>
            </table>
            <div class="wc-proceed-to-checkout">
                <a href="/personal/order/" class="checkout-button button alt wc-forward rounded">Оформить заказ</a>
            </div>
            </div><?

			/*
			?>
			<div class="cross-sells">
				<h2>Возможно, вас заинтересует&hellip;</h2>
				<ul class="products columns-2">
					<li class="product style-2">
						<div class="product-container">
							<figure>
								<div class="product-wrap">
									<div class="product-images">
										<div class="shop-loop-thumbnail shop-loop-front-thumbnail">
											<a href="shop-detail-1.html"><img width="450" height="450"
																			  src="/images/products/product_328x328.jpg" alt=""/></a>
										</div>
										<div class="shop-loop-thumbnail shop-loop-back-thumbnail">
											<a href="shop-detail-1.html"><img width="450" height="450"
																			  src="/images/products/product_328x328alt.jpg" alt=""/></a>
										</div>
									</div>
								</div>
								<figcaption>
									<div class="shop-loop-product-info">
										<div class="info-meta clearfix">
											<div class="star-rating">
												<span style="width:100%"></span>
											</div>
											<div class="loop-add-to-wishlist">
												<div class="yith-wcwl-add-to-wishlist">
													<div class="yith-wcwl-add-button">
														<a href="#" class="add_to_wishlist">
															Add to Wishlist
														</a>
													</div>
												</div>
											</div>
										</div>
										<div class="info-content-wrap">
											<h3 class="product_title">
												<a href="shop-detail-1.html">Florence Knoll Credenza</a>
											</h3>
											<div class="info-price">
																					<span class="price">
																						<span class="amount">£17.50</span>
																					</span>
											</div>
											<div class="loop-action">
												<div class="loop-add-to-cart">
													<a href="#" class="add_to_cart_button">
														Add to cart
													</a>
												</div>
											</div>
										</div>
									</div>
								</figcaption>
							</figure>
						</div>
					</li>
					<li class="product style-2">
						<div class="product-container">
							<figure>
								<div class="product-wrap">
									<div class="product-images">
										<div class="shop-loop-thumbnail shop-loop-front-thumbnail">
											<a href="shop-detail-1.html"><img width="450" height="450"
																			  src="/images/products/product_328x328.jpg" alt=""/></a>
										</div>
										<div class="shop-loop-thumbnail shop-loop-back-thumbnail">
											<a href="shop-detail-1.html"><img width="450" height="450"
																			  src="/images/products/product_328x328alt.jpg" alt=""/></a>
										</div>
									</div>
								</div>
								<figcaption>
									<div class="shop-loop-product-info">
										<div class="info-meta clearfix">
											<div class="star-rating">
												<span style="width:100%"></span>
											</div>
											<div class="loop-add-to-wishlist">
												<div class="yith-wcwl-add-to-wishlist">
													<div class="yith-wcwl-add-button">
														<a href="#" class="add_to_wishlist">
															Add to Wishlist
														</a>
													</div>
												</div>
											</div>
										</div>
										<div class="info-content-wrap">
											<h3 class="product_title">
												<a href="shop-detail-1.html">Citterio Grand Repos</a>
											</h3>
											<div class="info-price">
																					<span class="price">
																						<span class="amount">£12.00</span>
																						–
																						<span class="amount">£20.00</span>
																					</span>
											</div>
											<div class="loop-action">
												<div class="loop-add-to-cart">
													<a href="#" class="add_to_cart_button">
														Add to cart
													</a>
												</div>
											</div>
										</div>
									</div>
								</figcaption>
							</figure>
						</div>
					</li>
				</ul>
			</div><?*/

			?>
            </div><?
		}

        ?>
</div>
</div>
</div>
</div>
</div>