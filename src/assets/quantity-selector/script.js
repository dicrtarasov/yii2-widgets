/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 04.07.20 05:57:32
 */

(function (window, $) {
    "use strict";

    /**
     * @constructor
     */
    function QuantitySelectorWidget()
    {
        /**
         * Возвращает параметры поля ввода.
         *
         * @param {HTMLInputElement|jQuery<HTMLInputElement>} input
         * @returns {{val: number, min: number, max: number, step: number}}
         */
        function getInputParams(input)
        {
            const $input = $(input);

            const params = {
                min: $input[0].min === "" ? 0 : Number($input[0].min),
                max: $input[0].max === "" ? NaN : Number($input[0].max),
                step: $input[0].step === "" ? 1 : Math.abs(Number($input[0].step)),
                val: $input.val().trim() === "" ? 0 : Number($input.val())
            };

            if (isNaN(params.min)) {
                params.min = 0;
            }

            if (isNaN(params.step)) {
                params.step = 1;
            }

            if (isNaN(params.val)) {
                params.val = params.min;
            }

            return params;
        }

        /**
         * Установить новое значение поля ввода.
         *
         * @param {HTMLInputElement|jQuery<HTMLInputElement>} input
         * @param {number} value
         */
        function setInputValue(input, value)
        {
            const $input = $(input);
            const params = getInputParams(input);

            let newValue = value;

            if (newValue < params.min) {
                newValue = params.min;
            } else if (!isNaN(params.max) && newValue > params.max) {
                newValue = params.max;
            }

            if (newValue !== params.val) {
                $input.val(newValue).trigger('change');
            }
        }

        // обработка нажатий кнопок
        $(window.document).on('click', '.widget-quantity-selector .button', function (e) {
            e.preventDefault();

            const $widget = $(this).closest('.widget-quantity-selector');
            const $input = $('.input', $widget);
            const params = getInputParams($input);

            setInputValue(
                $input,
                $(this).hasClass('minus') ? params.val - params.step : params.val + params.step
            );
        });

        // корректировка значений поля ввода
        $(window.document).on('change', '.widget-quantity-selector .input', function () {
            const $widget = $(this).closest('.widget-quantity-selector');
            const $input = $('.input', $widget);
            const params = getInputParams($input);

            setInputValue($input, params.val);
        });
    }

    window.app = window.app || {};
    window.app.widgetQuantitySelector = window.app.widgetQuantitySelector || new QuantitySelectorWidget();
})(window, jQuery);
