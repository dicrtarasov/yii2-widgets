'use strict';

window.dicr = (function(dicr)
{
    function Toasts(container, options)
    {
        this.options = $.extend({}, {
            aimate: true,
            autohide: 500
        }, options)

        this.container = $(container);
        if (this.container.length < 1) {
            this.container = $('.dicr-widgets.toasts', window.document.body);
            if (this.container.length < 1) {
                this.container = $('<section></section>').appendTo(document.body);
            }
        }

        this.container.addClass('dicr-widgets-toasts');
    }

    /**
     * Добавляет тост с произвольным контентом и инициализирует
     * 
     * @param {jQueryObject|string} content
     * @param {object|null} opts
     */
    Toasts.prototype.addToast = function(content, opts)
    {
        opts = $.extend({}, this.options, opts || {});

        const $toast = $(`<div class="toast"></div>`).append(
            $(content)
        );
        
        $toast.on('hidden.bs.toast', function(e) {
            $(e.target).toast('dispose');
            $(e.target).remove();
        });

        $toast.appendTo(this.container);
        
        $toast.toast({
            delay: parseInt(opts.autohide) || 0,
            autohide: Boolean(opts.autohide),
            animation: Boolean(opts.animation)
        });
        
        $toast.toast('show');

        return $toast;
    };

    /**
     * Добавляет тост с заданным классом и текстом
     * 
     * @param {*} textClass 
     * @param {*} header 
     * @param {*} message 
     * @param {*} opts 
     */
    Toasts.prototype.createToast = function(textClass, header, message, opts)
    {
        return this.addToast(
            `<div class="toast-header">
                <strong class="mr-auto ${textClass||''}">${header}</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body ${textClass||''}">${message}</div>`,
            opts
        );
    };

    /**
     * Добавить тост с ошибкой
     */
    Toasts.prototype.error = function(message, header = 'Ошибка', opts = {})
    {
        return this.createToast('text-danger', header, message, opts);
    };

    /**
     * Добавить тост с предупреждением
     */
    Toasts.prototype.warning = function(message, header = 'Предупреждение', opts = {})
    {
        return this.createToast('text-warning', header, message, opts);
    };

    /**
     * Добавить тост с успехом
     */
    Toasts.prototype.success = function(message, header = 'Готово!', opts)
    {
        return this.createToast('text-success', header, message, opts);
    };

    dicr.widgets = dicr.widgets || {};
    dicr.widgets.toasts = new Toasts();

    return dicr;
})(window.dicr || {});
