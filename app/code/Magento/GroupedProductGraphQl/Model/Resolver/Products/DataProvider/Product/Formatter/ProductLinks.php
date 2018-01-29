<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\GroupedProductGraphQl\Model\Resolver\Products\DataProvider\Product\Formatter;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductLink\Link;
use Magento\CatalogGraphQl\Model\Resolver\Products\DataProvider\Product\FormatterInterface;

/**
 * Format the product links information to conform to GraphQL schema representation
 */
class ProductLinks implements FormatterInterface
{
    /**
     * @var string[]
     */
    private $linkType = 'associated';

    /**
     * Format product links data to conform to GraphQL schema
     *
     * {@inheritdoc}
     */
    public function format(Product $product, array $productData = [])
    {
        $productLinks = $product->getProductLinks();
        if ($productLinks) {
            /** @var Link $productLink */
            foreach ($productLinks as $productLinkKey => $productLink) {
                if ($productLink->getLinkType() === $this->linkType) {
                    $data = $productLink->getData();
                    $data['qty'] = $productLink->getExtensionAttributes()->getQty();
                    $productData['product_links'][$productLinkKey] = $data;
                }
            }
        } else {
            $productData['product_links'] = null;
        }

        return $productData;
    }
}
