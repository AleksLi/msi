/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * @api
 */
define([
    'jquery',
    'Magento_Ui/js/form/components/button',
    'underscore'
], function ($, Button, _) {
    'use strict';

    return Button.extend({
        defaults: {
            // false by default
            // disabled: false,
            imports: {
                onStockChange: '${ $.provider }:data.product.stock_data.manage_stock'
            }
        },

        manageStockOption: false,

        /**
         * Disable all child elements if manage stock is zero
         * @param {Integer} canManageStock
         */
        onStockChange: function (canManageStock) {
            if (canManageStock === 0) {
                this.manageStockOption = canManageStock;
                this.disabled = true;
            } else {
                this._super().disabled = false;
            }
        },

        /**
         * Initializes component.
         *
         * @returns {Object} Chainable.
         */
        initialize: function () {
             this._super()
                ._setClasses()
                ._setButtonClasses();

            /*if (!this.manageStockOption) {
                this.disabled = true;
            }*/

            return this;
        }
    });
});
