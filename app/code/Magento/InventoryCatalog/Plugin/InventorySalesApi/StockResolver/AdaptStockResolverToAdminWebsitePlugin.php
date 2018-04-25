<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\InventoryCatalog\Plugin\InventorySalesApi\StockResolver;

use Magento\InventoryApi\Api\Data\StockInterface;
use Magento\InventoryCatalog\Api\DefaultStockProviderInterface;
use Magento\InventorySalesApi\Api\Data\SalesChannelInterface;
use Magento\Store\Api\Data\WebsiteInterface;
use Magento\InventorySalesApi\Api\StockResolverInterface;
use Magento\InventoryApi\Api\StockRepositoryInterface;
use Magento\InventorySales\Model\ResourceModel\StockIdResolver;

/**
 * Adapt Stock resolver to admin website
 */
class AdaptStockResolverToAdminWebsitePlugin
{
    /**
     * @var StockRepositoryInterface
     */
    private $stockRepository;

    /**
     * @var DefaultStockProviderInterface
     */
    private $defaultStockProviderInterface;

    /**
     * @var StockIdResolver
     */
    private $stockIdResolver;

    public function __construct(
        DefaultStockProviderInterface $defaultStockProviderInterface,
        StockRepositoryInterface $stockRepositoryInterface,
        StockIdResolver $stockIdResolver
    ) {
        $this->defaultStockProviderInterface = $defaultStockProviderInterface;
        $this->stockRepository = $stockRepositoryInterface;
        $this->stockIdResolver = $stockIdResolver;
    }

    /**
     * @param StockResolverInterface $stockResolverInterface
     * @param callable $proceed
     * @param string $type
     * @param string $code
     * @return StockInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundGet(
        StockResolverInterface $stockResolverInterface,
        callable $proceed,
        string $type,
        string $code
    ) {
        if (SalesChannelInterface::TYPE_WEBSITE === $type && WebsiteInterface::ADMIN_CODE === $code) {
            return $this->stockRepository->get($this->defaultStockProviderInterface->getId());
        }
        $stockId = $this->stockIdResolver->resolve(SalesChannelInterface::TYPE_WEBSITE, $code);
        if (null === $stockId) {
            return $this->stockRepository->get($this->defaultStockProviderInterface->getId());
        }
        return $proceed($type, $code);
    }
}
