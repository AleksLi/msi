<?php

namespace Magento\ProductAlert\Block\Adminhtml\Catalog\Product\Edit\Tab\Alerts;

use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\ProductAlert\Block\Adminhtml\Catalog\Product\Edit\Tab\Alerts\Renderer\Stock as StockRenderer;

class StockColumn extends Extended
{
    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Backend\Helper\Data $backendHelper, array $data = [])
    {
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _prepareColumns()
    {
        die('312321312');
    }
    protected function _construct()
    {

        die('1312332');
        parent::_construct();

        $this->addColumn(
            'stock',
            [
                'header' => __('Stock'),
                'index' => 'stock_data',
                'renderer' => StockRenderer::class
            ]
        );
    }
}