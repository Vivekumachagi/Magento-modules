define([
    'Magento_Ui/js/grid/columns/column',
    'Magento_Catalog/js/product/list/column-status-validator'
], function (Column, columnStatusValidator) {
    'use strict';

    return Column.extend({

        /**
         * @param row
         * @returns {boolean}
         */
        hasValue: function (row) {
            return "filter_price" in row['extension_attributes'];
        },

        /**
         * @param row
         * @returns {*}
         */
        getValue: function (row) {
            let symbol = '';
            const currencyCode = row['currency_code'];
            let price = Math.trunc(row['extension_attributes']['filter_price']);
            if (currencyCode === "USD") {
                symbol = '$';
            }
            if (!isNaN(price)) {
                return symbol.concat(price);
            } else {
                return symbol.concat('0');
            }
        },

        /**
         * @param row
         * @returns {*|boolean}
         */
        isAllowed: function (row) {
            return (columnStatusValidator.isValid(this.source(), 'filter_price', 'show_attributes') && this.hasValue(row) );
        }

    });
});
