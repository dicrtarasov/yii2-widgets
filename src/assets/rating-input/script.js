/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 26.06.20 03:00:41
 */

(function (window, $) {
    'use strict';

    /**
     * @constructor
     */
    function RatingInput()
    {
        const selector = '.dicr-widget-rating-input';

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
