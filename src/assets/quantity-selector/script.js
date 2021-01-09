/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 09.01.21 18:07:54
 */

"use strict";

(function (window, $) {
    /**
     * Виджет выбора количества.
     *
     * @constructor
     */
    function QuantitySelectorWidget()
    {
        // noinspection ES6ConvertVarToLetConst
        var self = this;
        // noinspection ES6ConvertVarToLetConst
        var selector = '.widget-quantity-selector';

        /**
         * Обработка клика по кнопкам.
         *
         * @param {Event} e
         */
        self.handleButton = function (e) {
            e.preventDefault();

            // noinspection ES6ConvertVarToLetConst
            var $button = $(this);
            // noinspection ES6ConvertVarToLetConst
            var $input = $button.closest(selector).find('.input');
            // noinspection ES6ConvertVarToLetConst
            var value = parseInt(String($input.val())) || 1;
            // noinspection ES6ConvertVarToLetConst
            var step = parseInt($input.prop('step')) || 1;
            // noinspection ES6ConvertVarToLetConst
            var side = $button.hasClass('minus') ? -1 : 1;

            $input.val(value + step * side);
            $input.trigger('change');
        };

        /**
         * Проверка значения поля ввода.
         *
         * @param {Event} e
         */
        self.handleInput = function (e) {
            e.preventDefault();
            e.stopPropagation();

            // noinspection ES6ConvertVarToLetConst
            var $input = $(this);
            // noinspection ES6ConvertVarToLetConst
            var val = parseInt(String($input.val()));
            // noinspection ES6ConvertVarToLetConst
            var newVal = val || 1;

            // noinspection ES6ConvertVarToLetConst
            var min = parseInt($input.prop("min")) || 1;
            if (newVal < min) {
                newVal = min;
            }

            // noinspection ES6ConvertVarToLetConst
            var max = parseInt($input.prop("max"));
            if (!isNaN(max) && newVal > max) {
                newVal = max;
            }

            if (newVal !== val) {
                $input.val(newVal);
            }

            $input.closest(selector).trigger('update', newVal);
        };

        /**
         * Инициализация виджета.
         */
        self.init = function () {
            // noinspection JSCheckFunctionSignatures,JSStringConcatenationToES6Template
            $(window.document)
                .off(selector)

                // обработка нажатий кнопок
                .on('click' + selector, selector + ' .button', self.handleButton)

                // корректировка значений поля ввода
                .on('change' + selector, selector + ' .input', self.handleInput);
        };
    }

    window.app = window.app || {};
    window.app.widgetQuantitySelector = new QuantitySelectorWidget();

    $(window.app.widgetQuantitySelector.init);
    $(window.document).ajaxComplete(window.app.widgetQuantitySelector.init);
})(window, jQuery);
