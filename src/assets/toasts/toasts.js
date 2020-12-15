/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 15.12.20 22:54:14
 */

(function (window, $) {
    'use strict';

    /**
     * @param {HTMLElement|jQuery<HTMLElement>|string} container
     * @param {object} options
     * @constructor
     */
    function Toasts(container = '', options = {})
    {
        // noinspection SpellCheckingInspection
        this.options = $.extend({}, {
            animation: true,
            autohide: 5000
        }, options);

        this.container = $(container);

        if (this.container.length < 1) {
            this.container = $('.dicr-widgets-toasts', window.document.body);
            if (this.container.length < 1) {
                // noinspection XHTMLIncompatabilitiesJS
                this.container = $('<section></section>').appendTo(document.body);
            }
        }

        this.container.addClass('dicr-widgets-toasts');
    }

    /**
     * Добавляет тост с произвольным контентом и инициализирует.
     *
     * @param {jQuery<HTMLElement>|HTMLElement|string} content
     * @param {object|null} opts
     */
    Toasts.prototype.addToast = function (content, opts) {
        // noinspection AssignmentToFunctionParameterJS
        opts = $.extend({}, this.options, opts || {});

        // noinspection JSDeclarationsAtScopeStart
        const $toast = $(`<div class="toast"></div>`).append($(content));

        $toast.on('hidden.bs.toast', function (e) {
            // noinspection JSUnresolvedFunction
            $(e.target).toast('dispose');
            $(e.target).remove();
        });

        $toast.appendTo(this.container);

        // noinspection JSUnresolvedFunction,JSUnresolvedVariable,SpellCheckingInspection
        $toast.toast({
            animation: Boolean(opts.animation),
            autohide: Boolean(opts.autohide),
            delay: Number(opts.autohide),
        });

        // noinspection JSUnresolvedFunction
        $toast.toast('show');

        return $toast;
    };

    /**
     * Добавляет тост с заданным классом и текстом
     *
     * @param {string} textClass
     * @param {string} header
     * @param {string} message
     * @param {object} opts
     */
    Toasts.prototype.createToast = function (textClass, header, message, opts) {
        return this.addToast(
            `<div class="toast-header">
                <strong class="${textClass || ''}">${header}</strong>
                <button type="button" class="close" data-dismiss="toast" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body ${textClass || ''}">${message}</div>`,
            opts
        );
    };

    // noinspection JSUnusedGlobalSymbols

    /**
     * Добавить тост с ошибкой.
     *
     * @param {string} message
     * @param {string} header
     * @param {Object} opts
     */
    Toasts.prototype.error = function (message, header = 'Ошибка', opts = {}) {
        return this.createToast('text-danger', header, message, opts);
    };

    // noinspection JSUnusedGlobalSymbols

    /**
     * Добавить тост с предупреждением.
     *
     * @param {string} message
     * @param {string} header
     * @param {Object} opts
     */
    Toasts.prototype.warning = function (message, header = 'Предупреждение', opts = {}) {
        return this.createToast('text-warning', header, message, opts);
    };

    // noinspection JSUnusedGlobalSymbols

    /**
     * Добавить тост с успехом,
     *
     * @param {string} message
     * @param {string} header
     * @param {Object} opts
     */
    Toasts.prototype.success = function (message, header = 'Готово!', opts = {}) {
        return this.createToast('text-success', header, message, opts);
    };

    window.dicr = window.dicr || {};
    window.dicr.widgets = window.dicr.widgets || {};
    window.dicr.widgets.toasts = window.dicr.widgets.toasts || new Toasts();
})(window, jQuery);
