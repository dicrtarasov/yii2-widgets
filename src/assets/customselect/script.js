/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 11.06.20 22:25:28
 */

(function (window, $) {
    'use strict';

    /**
     * Искусственный элемент select.
     *
     * @param {HTMLElement} widget
     * @constructor
     */
    function CustomSelectWidget(widget)
    {
        const $widget = $(widget);
        const $button = $widget.children('button');

        $button.on('click', function (e) {
            e.preventDefault();
            $widget.toggleClass('active');
        });

        $('input', $widget).on('change', function () {
            $button.text($(this).closest('label').text());
            $button.toggleClass('placeholder', $(this).val() === '');
        });

        $(window.document).on('click', function (e) {
            if (e.target !== $button[0]) {
                $widget.removeClass('active');
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
