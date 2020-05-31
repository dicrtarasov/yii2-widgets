/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license proprietary
 * @version 31.05.20 06:34:05
 */

(function (window, $) {
    'use strict';

    /**
     * Искусственный элемент select.
     *
     * @param {HTMLElement|jQuery<HTMLElement>} target
     * @constructor
     */
    function CustomSelectWidget(target)
    {
        const $module = $(target);
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
    }

    /**
     * Плагин jQuery.
     *
     * @returns {jQuery}
     */
    $.fn.dicrWidgetsCustomSelect = function () {
        return this.each(function () {
            $(this).data('widget', new CustomSelectWidget(this));
        });
    };
})(window, jQuery);
