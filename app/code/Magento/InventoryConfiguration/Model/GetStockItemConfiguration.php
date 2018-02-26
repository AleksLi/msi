<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\InventoryConfiguration\Model;

use Magento\InventoryConfigurationApi\Api\Data\StockItemConfigurationInterface;
use Magento\InventoryConfigurationApi\Api\GetStockItemConfigurationInterface;
use Magento\InventoryCatalog\Model\GetProductIdsBySkusInterface;
use Magento\CatalogInventory\Api\Data\StockItemInterface;
use Magento\CatalogInventory\Api\StockItemCriteriaInterfaceFactory;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;

/**
 * @inheritdoc
 */
class GetStockItemConfiguration implements GetStockItemConfigurationInterface
{
    /**
     * @var StockItemConfigurationFactory
     */
    private $stockItemConfigurationFactory;

    /**
     * @var StockItemCriteriaInterfaceFactory
     */
    private $stockItemCriteriaFactory;

    /**
     * @var GetProductIdsBySkusInterface
     */
    private $getProductIdsBySkus;

    /**
     * @var StockItemRepository
     */
    private $stockItemRepository;

    /**
     * @param StockItemConfigurationFactory $stockItemConfigurationFactory
     * @param StockItemCriteriaInterfaceFactory $stockItemCriteriaFactory
     * @param StockItemRepository $stockItemRepository
     * @param GetProductIdsBySkusInterface $getProductIdsBySkus
     */
    public function __construct(
        StockItemConfigurationFactory $stockItemConfigurationFactory,
        StockItemCriteriaInterfaceFactory $stockItemCriteriaFactory,
        StockItemRepository $stockItemRepository,
        GetProductIdsBySkusInterface $getProductIdsBySkus
    ) {
        $this->stockItemConfigurationFactory = $stockItemConfigurationFactory;
        $this->stockItemCriteriaFactory = $stockItemCriteriaFactory;
        $this->stockItemRepository = $stockItemRepository;
        $this->getProductIdsBySkus = $getProductIdsBySkus;
    }

    /**
     * @inheritdoc
     */
    public function execute(string $sku, int $stockId): StockItemConfigurationInterface
    {
        return $this->stockItemConfigurationFactory->create(
            [
                'stockItem' => $this->getLegacyStockItem($sku, $stockId),
            ]
        );
    }

    /**
     * @param string $sku
     * @param int $stockId
     * @return StockItemInterface
     */
    private function getLegacyStockItem(string $sku, int $stockId)
    {
        $productId = $this->getProductIdsBySkus->execute([$sku])[$sku];
        $searchCriteria = $this->stockItemCriteriaFactory->create();
        $searchCriteria->addFilter(StockItemInterface::PRODUCT_ID, StockItemInterface::PRODUCT_ID, $productId);
        $searchCriteria->addFilter(StockItemInterface::STOCK_ID, StockItemInterface::STOCK_ID, $stockId);
        $legacyStockItem = $this->stockItemRepository->getList($searchCriteria)->getItems()[0];
        return $legacyStockItem;
    }
}
