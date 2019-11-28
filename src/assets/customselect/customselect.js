/*
 * @copyright 2019-2019 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 09.08.19 06:11:49
 */

(function ($) {
    'use strict';

    if ($.fn.dicrWidgetsCustomSelect === 'function') {
        return;
    }

    $.fn.dicrWidgetsCustomSelect = function (options) {
        const placeholder = options.placeholder || '';

        return this.each(function () {
            const $module = $(this);
            const $input = $('input', $module);
            const $display = $('.dicr-widgets-customselect-value', $module);
            const $popup = $('.dicr-widgets-customselect-popup', $module);

            $display.on('click', function () {
                $module.addClass('open');
                $popup.css('min-width', $display.width());
            });

            $('.dicr-widgets-customselect-item', $popup).on('click', function () {
                $input.val($(this).data('value'));
                $display.text($(this).text());
                $display.toggleClass('placeholder', $(this).hasClass('placeholder'));
            });

            $(window.document).on('click', function (e) {
                if (e.target !== $display[0]) {
                    $module.removeClass('open');
                }
            });
        });
    };
})(jQuery);
