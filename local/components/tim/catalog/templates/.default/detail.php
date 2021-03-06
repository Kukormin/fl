<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @var Local\Catalog\TimCatalog $component */

$offer = $component->offer;

$sections = \Local\Catalog\Section::getChain($offer['SECTION']);
foreach ($sections as $section)
	$APPLICATION->AddChainItem($section['NAME'], CATALOG_PATH . $section['CODE'] . '/');
$APPLICATION->AddChainItem($offer['NAME'], $offer['DETAIL_PAGE_URL']);

$APPLICATION->SetTitle($offer['NAME']);
$APPLICATION->SetPageProperty('title', $offer['TITLE']);
$APPLICATION->SetPageProperty('description', $offer['DESCRIPTION']);

$user = new \CUser();
$isAdmin = $user->IsAdmin();

?>
<div class="heading-container">
	<div class="container heading-standar">
		<div class="page-breadcrumb"><?

			$APPLICATION->IncludeComponent('bitrix:breadcrumb', '', [
					'START_FROM' => '0',
					'PATH' => '',
					'SITE_ID' => '-'
				],
				false,
				['HIDE_ICONS' => 'Y']
			);

			?>
		</div>
	</div>
</div>

<div class="content-container no-padding">
<div class="container-full">
<div class="row">
<div class="col-md-12">
<div class="main-content">
<div class="commerce">
<div class="style-1 product">
<div class="container">
	<div class="row summary-container">
		<div class="col-md-7 col-sm-6 entry-image">
            <div class="single-product-images"><?

                // TODO: акция
                if (false)
                {
                    ?>
                    <span class="onsale">Акция!</span><?
                }

                ?>
                <div class="single-product-images-slider">
                    <div class="caroufredsel product-images-slider"
                         data-synchronise=".single-product-images-slider-synchronise" data-scrollduration="500"
                         data-height="variable" data-scroll-fx="none" data-visible="1" data-circular="1"
                         data-responsive="1">
                        <div class="caroufredsel-wrap">
                            <ul class="caroufredsel-items"><?

                                $images = $offer['PHOTOS'];
                                $file = new \CFile();
                                foreach ($images as $img)
                                {
                                    $resize = $file->ResizeImageGet($img, ['width' => 1000, 'height' => 1000]);

                                    ?>
                                    <li class="caroufredsel-item">
                                        <a href="<?= $resize['src'] ?>"
                                           data-rel="magnific-popup-verticalfit">
                                            <img width="600" height="685" src="<?= $resize['src'] ?>" />
                                        </a>
                                    </li><?
                                }

                                ?>
                            </ul>
                            <a href="#" class="caroufredsel-prev"></a>
                            <a href="#" class="caroufredsel-next"></a>
                        </div>
                    </div>
                </div>
                <div class="single-product-thumbnails">
                    <div class="caroufredsel product-thumbnails-slider" data-visible-min="2" data-visible-max="4"
                         data-scrollduration="500" data-direction="up" data-height="100%" data-circular="1"
                         data-responsive="0">
                        <div class="caroufredsel-wrap">
                            <ul class="single-product-images-slider-synchronise caroufredsel-items"><?

                                foreach ($images as $img)
                                {
                                    $resize = $file->ResizeImageGet($img, ['width' => 72, 'height' => 72]);

                                    ?>
                                    <li class="caroufredsel-item selected">
                                        <div class="thumb">
                                            <a href="#" data-rel="0">
                                                <img src="<?= $resize['src'] ?>" />
                                            </a>
                                        </div>
                                    </li><?
                                }

                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <? /*
            <div class="row">
                <div class="after-slider-list">
                    <a class="rk-text-underline"><span class="rk-icon add-chat"></span> <span>Чат с экспертом</span></a>
                    <a class="rk-text-underline"><span class="rk-icon add-auto"></span> <span>Доставка</span></a>
                    <a class="rk-text-underline"><span class="rk-icon add-phone"></span> <span>Позвоните мне</span></a>
                    <a class="rk-text-underline"><span class="rk-icon add-money"></span> <span>Оплата</span></a>
                    <a class="rk-text-underline"><span class="rk-icon add-compare"></span> <span>Сравнить</span></a>
                    <a class="rk-text-underline"><span class="rk-icon add-services"></span> <span>Услуги</span></a>
                </div>
            </div>
            */
            ?>
            <div class="row">
                <div class="_tabs">
                    <ul class="_tabs-nav _underlines">
                        <li><a href="#elIndex-news-1"><span>Описание</span></a></li>
                        <li><a href="#elIndex-news-2"><span>Отзывы</span></a></li>
                    </ul>
                    <div class="_tabs-content css-padding">
                        <div class="_tab" id="elIndex-news-1">
                            <div class="_tab_content">
                                <p>
                                    Данных нет.
                                </p>
                            </div>
                        </div>
                        <div class="_tab" id="elIndex-news-2">
                            <div class="_tab_content">
                                <p>Данных нет.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="features-menu">
                    <ul>
                        <li><a> <i class="icon icon-2">&nbsp;</i> </a>
                            <div><a>Бесплатная доставка по Москве </a></div>
                        </li>
                        <li><a> <i class="icon icon-3">&nbsp;</i> </a>
                            <div><a>Возврат-обмен товара </a></div>
                        </li>
                        <li><a> <i class="icon icon-4">&nbsp; </i> </a>
                            <div><a>Бесплатное хранение товара </a></div>
                        </li>
                        <li><a> <i class="icon icon-5">&nbsp;</i> </a>
                            <div><a>Расширенная гарантия </a></div>
                        </li>
                        <li><a> <i class="icon icon-6">&nbsp;</i> </a>
                            <div><a>Любые аксессуары в цвет пола </a></div>
                        </li>
                        <? /*
                        <li><a> <i class="icon icon-7">&nbsp;</i> </a>
                            <div><a>Гарантия<br> лучшей цены </a></div>
                        </li>
                        <li><a class="features-menu-readmore" href="info/pochemu_my.html"><i class="icon">&nbsp;</i> </a>
                            <div><a class="features-menu-readmore" href="info/pochemu_my.html">Посмотреть<br> все преимущества </a></div>
                            <a class="features-menu-readmore" href="info/pochemu_my.html"> </a>
                        </li>
                        */ ?>
                    </ul>
                </div>
            </div>
		</div>
		<div class="col-md-5 col-sm-6 entry-summary">
			<div class="summary elDetail">
				<h1 class="product_title entry-title"><?= $offer['NAME'] ?></h1>

				<div class="product_meta row"><?

					$brand = \Local\Catalog\Brand::getById($offer['BRAND']);
					$country = \Local\Catalog\Country::getById($offer['COUNTRY']);
					$wood = \Local\Catalog\Wood::getById($offer['WOOD']);
					$collection = \Local\Catalog\Collection::getById($offer['COLLECTION']);

					?>
					<span class="meta-brand">
						Производитель:
						<a href="<?= $brand['DETAIL_PAGE_URL'] ?>"><?= $brand['NAME'] ?></a>
					</span><?

					if ($offer['COLLECTION'])
					{
					    ?>
                        <span class="meta-collection">
                            Коллекция:
                            <b><?= $collection['NAME'] ?></b>
                        </span><?
					}

					?>
					<span class="meta-country">
						Страна:
						<b><?= $country['NAME'] ?></b>
					</span>
					<span class="meta-wood">
						Порода дерева:
						<a href="<?= $wood['DETAIL_PAGE_URL'] ?>"><?= $wood['NAME'] ?></a>
					</span><?

					if ($offer['DIM'])
					{
						?>
                        <span class="meta-dim">
                            Размеры:
							<b><?= $offer['DIM'] ?></b>
                        </span><?
					}
					if ($offer['ARTICLE'])
					{
						?>
						<span class="meta-article">
							Артикул:
							<b><?= $offer['ARTICLE'] ?></b>
						</span><?
					}
					if ($offer['COATING'])
					{
						?>
						<span class="meta-coating">
							Покрытие:
							<b><?= $offer['COATING'] ?></b>
						</span><?
					}
					if ($offer['FLAGS']['WATER'])
					{
						?>
                        <span class="meta-coating">
                            Влагостойкость:
							<b>Да</b>
                        </span><?
					}
					foreach ($offer['PROPS'] as $k => $v)
					{
						?>
						<span class="meta-props">
							<?= $k ?>:
							<b><?= $v ?></b>
						</span><?
					}

					?>
				</div>
                <p class="price">
                    <b>Цена: </b>
                    <?

                    $unit = \Local\Catalog\Unit::getById($offer['UNIT']);
                    $forUnit = '';
                    $labelUnit = '';
                    if ($unit['SHOW'])
                    {
                        $forUnit = '/' . $unit['NAME'];
                        $labelUnit = ', ' . $unit['NAME'];
                    }

                    $price = number_format($offer['PRICE'], 0, '', ' ');
                    $dPrice = '';
                    if ($offer['PRICE_WO_DISCOUNT'] > $offer['PRICE'])
                        $dPrice = number_format($offer['PRICE_WO_DISCOUNT'], 0, '', ' ');
                    $pPrice = '';
                    if ($isAdmin && $offer['PRICE_P'])
                    {
                        $pPrice = number_format($offer['PRICE_P'], 0, '', ' ');
                        $pPrice = ' (' . $pPrice . ' руб.' . $forUnit . ')';
                    }

                    if ($dPrice)
                    {
                        ?>
                        <del><span class="amount"><?= $dPrice ?>  руб.</span></del><?
                    }

                    ?>
                    <ins><span class="amount"><?= $price ?> руб.<?= $forUnit ?><?= $pPrice ?></span></ins>
                </p>
				<div class="clear"></div>
                <form class="cart" data-id="<?= $offer['ID'] ?>"><?

					if ($offer['INPACK'] != 1)
					{
						?>
                        <div class="add-to-cart-table">
                            <div class="left-info">Сколько <?= $unit['NAME'] ?> вам нужно</div>
                            <div class="quantity">
                                <input type="number" step="1" min="1" name="qty" value="<?= floor($offer['INPACK']) ?>"
                                       title="Количество<?= $labelUnit ?>" id="qty"
                                       class="input-text qty text" size="4"/>
                            </div>
                        </div><?
					}

					?>
                    <div class="add-to-cart-table">
                        <div class="left-info">или сразу можно ввести количество упаковок</div>
                        <div class="quantity">
                            <input type="number" step="1" min="1" name="cnt" value="1" title="Количество"
                                   class="input-text qty text" size="4" id="cnt" />
                        </div>
                    </div>
					<div class="product_meta"><?

						if ($offer['INPACK'] != 1)
						{
							$price = number_format(round($offer['INPACK'] * $offer['PRICE']), 0, '', ' ');
							?>
							<span class="meta-inpack">
								В упаковке<?= $labelUnit ?>:
								<b><?= $offer['INPACK'] ?></b>
							</span>
							<span class="meta-qty">
								Количество<?= $labelUnit ?>:
								<b id="js-qty" data-inpack="<?= $offer['INPACK'] ?>"><?= $offer['INPACK'] ?></b>
							</span>
							<span class="meta-sum">
								Сумма:
								<b id="js-total" data-price="<?= $offer['PRICE'] ?>"><?= $price ?> руб.</b>
							</span><?
						}

						?>
					</div>
                    <div class="add-to-cart-table">
                        <button type="submit" class="button">В корзину</button>
                    </div>
                    <div class="">
                        <button type="submit" class="button button-white">ПОДЕЛИТЬСЯ КОРЗИНОЙ</button>
                    </div>
                </form><?

				$wishCartId = \Local\Sale\Wish::getCartId($offer['ID']);
				$wlAdded = $wishCartId ? ' added' : '';
				$text = $wishCartId ? 'Удалить из избранного' : 'Добавить в избранное';
                ?>
				<p><a class="detail_wl<?= $wlAdded ?>" href="#"
                      data-id="<?= $offer['ID'] ?>" data-cid="<?= $wishCartId ?>"><strong><?= $text ?></strong></a></p><?

                /*
                ?>
				<div class="share-links">
					<div class="share-icons">
						<span class="facebook-share">
							<a href="#" title="Share on Facebook">
								<i class="fa fa-facebook"></i>
							</a>
						</span>
						<span class="twitter-share">
							<a href="#" title="Share on Twitter">
								<i class="fa fa-twitter"></i>
							</a>
						</span>
						<span class="google-plus-share">
							<a href="#" title="Share on Google +">
								<i class="fa fa-google-plus"></i>
							</a>
						</span>
						<span class="linkedin-share">
							<a href="#" title="Share on Linked In">
								<i class="fa fa-linkedin"></i>
							</a>
						</span>
					</div>
                </div><?*/

                ?>
			</div>
		</div>
	</div>
</div><?

    /*
    ?>
<div class="commerce-tab-container">
	<div class="container">
		<div class="col-md-12">
			<div class="tabbable commerce-tabs">
				<ul class="nav nav-tabs">
					<li class="vc_tta-tab active">
						<a data-toggle="tab" href="#tab-1">Описание</a>
					</li>
					<li class="vc_tta-tab">
						<a data-toggle="tab" href="#tab-2">Отзывы</a>
					</li>
				</ul>
				<div class="tab-content">
					<div id="tab-1" class="tab-pane fade in active">
						<?= $offer['DETAIL_TEXT'] ?>
					</div>
					<div id="tab-2" class="tab-pane fade">
						<div id="comments" class="comments-area">
							<h2 class="comments-title">There are <span>3</span> Comments</h2>
							<ol class="comments-list">
								<li class="comment">
									<div class="comment-wrap">
										<div class="comment-img">
											<img alt="" src="http://placehold.it/80x80" class='avatar' height='80'
											     width='80'/>
										</div>
										<div class="comment-block">
											<header class="comment-header">
												<cite class="comment-author">
													John Doe
												</cite>

												<div class="comment-meta">
													<span class="time">10 days ago</span>
												</div>
											</header>
											<div class="comment-content">
												<p>
													Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis
													suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis
													autem vel eum iure reprehenderit qui in ea voluptate velit esse quam
													nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo
													voluptas nulla pariatur
												</p>
												<span class="comment-reply">
													<a class='comment-reply-link'
													   href='#'>Reply</a>
												</span>
											</div>
										</div>
									</div>
									<ol class="children">
										<li class="comment">
											<div class="comment-wrap">
												<div class="comment-img">
													<img alt="" src="http://placehold.it/80x80" class='avatar'
													     height='80' width='80'/>
												</div>
												<div class="comment-block">
													<header class="comment-header">
														<cite class="comment-author">
															Jane Doe
														</cite>

														<div class="comment-meta">
															<span class="time">10 days ago</span>
														</div>
													</header>
													<div class="comment-content">
														<p>
															Ut enim ad minima veniam, quis nostrum exercitationem ullam
															corporis suscipit laboriosam, nisi ut aliquid ex ea commodi
															consequatur? Quis autem vel eum iure reprehenderit qui in ea
															voluptate velit esse quam nihil molestiae consequatur, vel
															illum qui dolorem eum fugiat quo voluptas nulla pariatur
														</p>
														<span
															class="comment-reply">
															<a class='comment-reply-link'
															   href='#'>Reply</a>
														</span>
													</div>
												</div>
											</div>
										</li>
									</ol>
								</li>
								<li class="comment">
									<div class="comment-wrap">
										<div class="comment-img">
											<img alt="" src="http://placehold.it/80x80" class='avatar' height='80'
											     width='80'/>
										</div>
										<div class="comment-block">
											<header class="comment-header">
												<cite class="comment-author">
													David Platt
												</cite>

												<div class="comment-meta">
													<span class="time">5 days ago</span>
												</div>
											</header>
											<div class="comment-content">
												<p>
													Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis
													suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis
													autem vel eum iure reprehenderit qui in ea voluptate velit esse quam
													nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo
													voluptas nulla pariatur
												</p>
												<span class="comment-reply">
													<a class='comment-reply-link'
													   href='#'>Reply</a>
												</span>
											</div>
										</div>
									</div>
								</li>
							</ol>
							<div class="comment-respond">
								<h3 class="comment-reply-title">
									<span>Leave your thought</span>
								</h3>

								<form class="comment-form">
									<div class="row">
										<div class="comment-form-author col-sm-12">
											<input id="author" name="author" type="text" placeholder="Your name"
											       class="form-control" value="" size="30"/>
										</div>
										<div class="comment-form-email col-sm-12">
											<input id="email" name="email" type="text" placeholder="email@domain.com"
											       class="form-control" value="" size="30"/>
										</div>
										<div class="comment-form-comment col-sm-12">
											<textarea class="form-control" placeholder="Comment" id="comment"
											          name="comment" cols="40" rows="6"></textarea>
										</div>
									</div>
									<div class="form-submit">
										<a class="btn btn-default-outline btn-outline" href="#">
											<span>Post Comment</span>
										</a>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><?*/

    ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12"><?

			//
			// Подобные товары
			//

			$sameItems = [];

			if ($offer['YA_URL'])
			{
				$navParams = [
					'iNumPage' => 1,
					'nPageSize' => 1000
				];
				$filter = [
					'YA_URL' => $offer['YA_URL'],
				];

				$tmp = \Local\Catalog\Offer::get(1, $filter, ['PROPERTY_RATING' => 'desc'], $navParams);
				foreach ($tmp['ITEMS'] as $id => $item)
					if ($id != $offer['ID'])
						$sameItems[$id] = $item;

				$cnt = count($sameItems);

				if ($cnt)
					$APPLICATION->IncludeComponent('tim:empty', 'similar', [
						'ITEMS' => $sameItems,
						'TITLE' => 'Подобные товары',
					]);
			}

            //
			// Похожие товары
			//

			$cntNeed = 12;

			$sectionId = $offer['SECTION'];
			$navParams = ['iNumPage' => 1, 'nPageSize' => 13];
			$initFilter = [
				'COLOR' => $offer['COLOR'],
				'BRAND' => $offer['BRAND'],
				'WOOD' => $offer['WOOD'],
			];
			$filter = $initFilter;

			$items = [];
			$cnt = 0;
			while ($sectionId)
			{
				$filter['CATEGORY'] = [$sectionId];
				$tmp = \Local\Catalog\Offer::get(1, $filter, ['PROPERTY_RATING' => 'desc'], $navParams);
				foreach ($tmp['ITEMS'] as $id => $item)
					if ($id != $offer['ID'] && !$items[$id] && !$sameItems[$id])
						$items[$id] = $item;

				$cnt = count($items);
				if ($cnt >= $cntNeed)
					break;

				if ($filter['BRAND'] && $filter['WOOD'])
					unset($filter['BRAND']);
				elseif ($filter['WOOD'])
				{
					$filter['BRAND'] = $offer['BRAND'];
					unset($filter['WOOD']);
				}
				elseif ($filter['BRAND'])
					unset($filter['BRAND']);
				else
				{
					$filter = $initFilter;
					$section = \Local\Catalog\Section::getById($sectionId);
					$sectionId = $section['PARENT'];
				}
			}

			if ($cnt)
				$APPLICATION->IncludeComponent('tim:empty', 'similar', [
					'ITEMS' => $items,
					'TITLE' => 'Похожие товары',
					'COUNT' => $cntNeed,
				]);

			?>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
