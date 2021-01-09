/*
 * @author Igor A Tarasov <develop@dicr.org>
 * @version 09.01.21 18:36:31
 */

"use strict";

(function (window, $) {
    // noinspection ES6ConvertVarToLetConst
    /** @var {string} селектор класса виджета */
    var selector = '.widget-custom-select';

    // noinspection JSUnusedGlobalSymbols
    /**
     * Искусственный элемент select.
     *
     * Функции:
     *
     * $widget[0].val(), $widget.val() - получить значение
     * $widget[0].val(val) - установить значение
     * $widget[0].items(...) - установить новые элементы
     * $widget.on('change', function(e, value) {}) - событие изменения
     *
     * @param {HTMLElement} target
     * @constructor
     */
    function CustomSelectWidget(target)
    {
        // noinspection ES6ConvertVarToLetConst
        var self = this;

        /** @var {JQuery<HTMLElement>} */
        self.dom = $(target);

        /** @var {JQuery<HTMLButtonElement>} */
        self.dom.btn = $('button', self.dom);

        /** @var {JQuery<HTMLDataListElement>} */
        self.dom.list = $('datalist', self.dom);

        /**
         * обновляет кнопку текущим значением выбранного элемента
         *
         * @param {JQuery} $input активный измененный radio input
         */
        self.updateValue = function ($input) {
            if ($input.length > 0) {
                // обновляем значение виджета
                self.dom.prop('value', $input.prop('value'));

                // noinspection ES6ConvertVarToLetConst
                var $label = $input.next('label');
                if ($label.length > 0) {
                    self.dom.btn.empty().append(
                        $label.clone().removeAttr('for')
                    );
                }
            }
        };

        /**
         * Рассчитывает и обновляет ширину кнопки виджета по самой широкой из списка элементов
         */
        self.updateWidth = function () {
            // временно включаем datalist
            self.dom.addClass('open');

            // очищаем текущие ограничения ширины
            $([self.dom.btn, self.dom.list]).css('max-width', '');

            // ожидаем отрисовки
            window.requestAnimationFrame(function () {
                // noinspection ES6ConvertVarToLetConst
                var maxWidth = Math.max(self.dom.btn.width(), self.dom.list.width());

                // прячем
                self.dom.removeClass('open');

                $([self.dom.btn, self.dom.list]).css('min-width', maxWidth);
            });
        };

        /**
         * Установить/получить значение элемента.
         *
         * @param {string|undefined} value
         * @returns {string|JQuery}
         */
        self.val = function (value) {
            if (typeof value === 'undefined') {
                return self.dom[0].value;
            }

            // noinspection ES6ConvertVarToLetConst, JSStringConcatenationToES6Template
            var $input = $('input[value="' + value + '"]', self.dom.list);
            // noinspection JSUnusedGlobalSymbols
            $input[0].checked = true;
            self.updateValue($input);

            return self.dom;
        };

        // noinspection JSUnusedGlobalSymbols

        /**
         * Установить новые значения
         *
         * $widget[0].items(...)
         *
         * @param {string} name название поля ввода
         * @param {{
         *     label: string
         *     encode: boolean|undefined,
         *     class: string|undefined
         * }[]|string[]} items значения value => string| item{label, encode}
         */
        self.items = function (name, items) {
            // удаляем все элементы кроме placeholder
            $('input:not([value=""])', self.dom.list).each(function () {
                $(this).next('label').remove();
                $(this).remove();
            });

            // добавляем новые элементы
            Object.keys(items).forEach(function (value, index) {
                // noinspection ES6ConvertVarToLetConst
                var item = items[value];
                if (typeof item !== 'object') {
                    item = {label: item, encode: true};
                }

                // noinspection ES6ConvertVarToLetConst,JSStringConcatenationToES6Template
                var id = self.dom.attr('id') + '-' + index;

                // noinspection ES6ShorthandObjectProperty
                self.dom.list.append(
                    $('<input/>', {type: 'radio', id: id, name: name, value: value})
                );

                // noinspection ES6ConvertVarToLetConst
                var $label = $('<label/>', {for: id, class: item.class || undefined});
                $label[item.encode ? 'text' : 'html'](item.label);
                self.dom.list.append($label);
            });

            // устанавливаем значение первого элемента
            // noinspection ES6ConvertVarToLetConst
            var $input = $('input:first', self.dom.list);
            $input.prop('checked', true);
            self.updateValue($input);

            // пересчитываем ширину метки
            self.updateWidth();
        };

        // начальное значение элемента
        self.updateValue($('input:checked', self.dom.list));

        // обновляем ширину кнопки
        self.updateWidth();

        // клики по кнопке
        // noinspection JSStringConcatenationToES6Template
        self.dom.btn
            .off(selector)
            .on('click' + selector, function (e) {
                e.preventDefault();
                self.dom.toggleClass('open');
            });

        // клики по документу
        // noinspection JSStringConcatenationToES6Template
        $(window.document).on('click' + selector, function (e) {
            // пропускаем клики по кнопке виджета
            // noinspection ES6ConvertVarToLetConst
            var $btn = $(e.target).closest('button');
            if ($btn.length < 1 || $btn[0] !== self.dom.btn[0]) {
                self.dom.removeClass('open');
            }
        });

        // изменение выбранного значения
        // noinspection JSStringConcatenationToES6Template
        self.dom.list
            .off(selector)
            .on('change' + selector, 'input', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                // обновляем кнопку и значение элемента
                self.updateValue($(this));
                // эмулируем синтетическое событие change
                self.dom.trigger('change', $(this).val());
            });

        // получение/установка значения
        self.dom[0].val = self.val;

        // установка нового списка элементов
        self.dom[0].items = self.items;
    }

    /**
     * Инициализация всех виджетов на странице
     */
    function init()
    {
        $(window.document).off(selector);

        $(selector, window.document).each(function () {
            $(this).data('widget', new CustomSelectWidget(this));
        });
    }

    // при загрузке страницы
    $(init);

    // при загрузке Ajax
    $(window.document).ajaxComplete(init);
})(window, jQuery);
