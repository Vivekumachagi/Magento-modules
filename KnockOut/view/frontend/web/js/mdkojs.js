define(['jquery', 'uiComponent', 'ko'], function ($, Component, ko) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Vivek_KnockOut/knockout-test-example'
            },
            initialize: function () {
                this._super();
            }
        });
    }
);
