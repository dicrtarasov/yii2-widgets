/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 03.10.21 20:01:28
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
        const self = this;
        self.$dom = $(container);

        // нормализуем опции
        self.options = $.extend({}, {
            animation: true,
            autohide: 5000
        }, options);

        /**
         * Добавляет тост с произвольным контентом и инициализирует.
         *
         * @param {jQuery<HTMLElement>|HTMLElement|string} content
         * @param {object|null} opts
         * @return {JQuery}
         */
        self.addToast = function (content, opts = {}) {
            opts = $.extend({}, self.options, opts || {});

            // noinspection JSCheckFunctionSignatures
            const $toast = $(`<div class="toast"></div>`).append(content);

            $toast.on('hidden.bs.toast', function (e) {
                // noinspection JSUnresolvedFunction
                $(e.target).toast('dispose');
                $(e.target).remove();
            });

            $toast.appendTo(self.$dom);

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
         * @return {JQuery}
         */
        self.createToast = function (textClass, header, message, opts) {
            return self.addToast(
                `<div class="toast-header">
                <strong class="${textClass || ''}">${header}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body ${textClass || ''}">${message}</div>`,
                opts
            );
        };

        /**
         * Добавить тост с ошибкой.
         *
         * @param {string} message
         * @param {string} header
         * @param {Object} opts
         * @return {JQuery}
         */
        self.error = function (message, header = 'Ошибка', opts = {}) {
            return this.createToast('text-danger', header, message, opts);
        };

        /**
         * Добавить тост с предупреждением.
         *
         * @param {string} message
         * @param {string} header
         * @param {Object} opts
         * @return {JQuery}
         */
        self.warning = function (message, header = 'Предупреждение', opts = {}) {
            return this.createToast('text-warning', header, message, opts);
        };

        /**
         * Добавить тост с успехом,
         *
         * @param {string} message
         * @param {string} header
         * @param {Object} opts
         * @return {JQuery}
         */
        self.success = function (message, header = 'Готово!', opts = {}) {
            return this.createToast('text-success', header, message, opts);
        };

        // создаем тосты из опций
        options.success && options.success.forEach(function (msg) {
            self.success(msg);
        });

        // noinspection JSUnresolvedVariable
        options.warnings && options.warnings.forEach(function (msg) {
            self.warning(msg);
        });

        // noinspection JSUnresolvedVariable
        options.errors && options.errors.forEach(function (msg) {
            self.error(msg);
        });

        // noinspection JSUnresolvedVariable
        options.toasts && options.toasts.forEach(function (content) {
            self.addToast(content);
        });
    }

    window.dicr = window.dicr || {};
    window.dicr.widgets = window.dicr.widgets || {};
    window.dicr.widgets.Toasts = Toasts;
})(window, jQuery);
