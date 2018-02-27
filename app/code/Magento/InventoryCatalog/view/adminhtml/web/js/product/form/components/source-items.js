/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'Magento_Ui/js/form/components/fieldset',
    'underscore'
], function (Fieldset, _) {
    'use strict';

    return Fieldset.extend({
        defaults: {
            imports: {
                // onStockChange: '${ $.provider }:data.product.stock_data.manage_stock'
            }
        },

        manageStockOption: true,

        /**
         * Disable all child elements if manage stock is zero
         * @param {Integer} canManageStock
         */
        onStockChange: function (canManageStock) {
            if (canManageStock === 0) {
                this.manageStockOption = canManageStock;
                this.delegate('disabled', true);
            } else {
                this.delegate('disabled', false);
            }
        }


        /**
         * Calls parent's initElement method.
         * Assignes callbacks on various events of incoming element.
         *
         * @param  {Object} elem
         * @return {Object} - reference to instance
         */
        /*initElement: function (elem) {
            this._super();

            if (!this.manageStockOption) {
                this.delegate('disabled',true);
                if (elem.hasChild()) {
                    elem.delegate('disabled', true);
                } else {
                    elem.disabled(true);
                }
            }

            return this;
        }*/

    });
});
