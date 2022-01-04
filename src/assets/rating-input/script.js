/*
 * @copyright 2019-2022 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 04.01.22 18:18:02
 */

((window, $) => {
    'use strict';

    /**
     * @constructor
     */
    function RatingInput()
    {
        const selector = '.dicr-widget-rating-input';

        // noinspection JSStringConcatenationToES6Template
        $(window.document)
            // отключение предыдущих обработчиков
            .off(selector)

            // реакция на переключение
            .on('change' + selector, selector + ' input', function () {
                const val = Number($(this).val());
                const $widget = $(this).closest(selector);

                $('label', $widget).each(function (i) {
                    $(this).toggleClass('far', i >= val).toggleClass('fas', i < val);
                });
            });
    }

    window.app = window.app || {};
    window.app.dicrWidgetRatingInput = window.app.dicrWidgetRatingInput || new RatingInput();
})(window, jQuery);
