/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 23.07.20 21:31:29
 */

(function (window, $) {
    'use strict';

    /**
     * Искусственный элемент select.
     *
     * @constructor
     */
    function CustomSelectWidget()
    {
        /** @var {string} селектор класса виджета */
        const selector = '.dicr-widget-custom-select';

        // глобальный обработчик
        $(window.document)
            // отменяем предыдущие обработчики
            .off(selector)

            // обработка кликов
            .on('click' + selector, function (e) {
                // закрываем все виджеты по клику на документ
                $(window.document).find(selector).removeClass('active');

                // виджет на который был клик
                const $target = $(e.target);
                const $widget = $target.closest(selector);
                if ($widget.length < 1) {
                    return;
                }

                // если клик по кнопке, то открываем виджет
                if ($target.is('button')) {
                    e.preventDefault();
                    $widget.addClass('active');
                }
            })

            // смена текста кнопки при выборе значения
            .on('change' + selector, selector + ' input', function () {
                const $label = $(this).closest('label');
                const $widget = $(this).closest(selector);
                const $button = $('button', $widget);

                $button.text($label.text());
                $button.toggleClass('placeholder', $(this).val() === '');
            });
    }

    // регистрируем функцию
    window.app = window.app || {};
    window.app.dicrWidgetCustomSelect = window.app.dicrWidgetCustomSelect || new CustomSelectWidget();
})(window, jQuery);
