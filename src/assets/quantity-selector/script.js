/*
 * @copyright 2019-2022 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 04.01.22 18:18:01
 */

"use strict";

((window, $) => {
    /**
     * Виджет выбора количества.
     *
     * @constructor
     */
    function QuantitySelectorWidget()
    {
        const self = this;
        const selector = '.widget-quantity-selector';

        /**
         * Обработка клика по кнопкам.
         *
         * @param {Event} e
         */
        self.handleButton = function (e) {
            e.preventDefault();

            const $button = $(this);
            const $input = $button.closest(selector).find('.input');
            const value = parseInt(String($input.val())) || 1;
            const step = parseInt($input.prop('step')) || 1;
            const side = $button.hasClass('minus') ? -1 : 1;

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

            const $input = $(this);
            const val = parseInt(String($input.val()));
            let newVal = val || 1;

            const min = parseInt($input.prop("min")) || 1;
            if (newVal < min) {
                newVal = min;
            }

            const max = parseInt($input.prop("max"));
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
        self.init = () => {
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
