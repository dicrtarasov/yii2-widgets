/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 03.03.21 21:19:48
 */

"use strict";

(function (window, $) {
    // noinspection ES6ConvertVarToLetConst
    /** @var {string} селектор класса виджета */
    var selector = '.widget-custom-select';

    /**
     * Искусственный элемент select.
     *
     * Функции:
     *
     * ```php
     * // CustomSelectWidget
     * const widget = $widget.data('widget')
     *
     * widget.val() - получить значение
     * widget.val(val) - установить значение
     * widget.items(...) - установить новые элементы
     *
     * $widget.on('change', 'input', function(e, value) {}) - событие изменения
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

        self.dom.$input = self.dom.children('input');

        /** @var {JQuery<HTMLButtonElement>} */
        self.dom.$btn = self.dom.children('button');

        /** @var {JQuery<HTMLDataListElement>} */
        self.dom.$list = self.dom.children('datalist');

        /** @var {number} */
        self.labelWidth = undefined;

        /**
         * Рассчитывает и обновляет ширину кнопки виджета по самой широкой из списка элементов
         *
         * @return {JQueryDeferred} ожидание установки меток
         */
        self.updateWidth = function () {
            // noinspection ES6ConvertVarToLetConst
            var $def = $.Deferred();
            if (!self.dom.is(':visible')) {
                return $def.resolve(false);
            }

            // временно включаем datalist
            self.dom.addClass('open');
            self.dom.$list.css('align-items', 'flex-start');
            self.dom.$list.children('label').css({padding: 0});

            // ожидаем отрисовки
            window.requestAnimationFrame(function () {
                // рассчитываем максимальную ширину меток
                self.labelWidth = 0;

                self.dom.$list.children('label').each(function () {
                    // noinspection ES6ConvertVarToLetConst
                    var width = $(this).width();
                    if (width > self.labelWidth) {
                        self.labelWidth = width;
                    }

                    /* не помню зачем
                    $(this).css({
                        display: '',
                        whiteSpace: '',
                        padding: ''
                    });
                     */
                });

                // прячем обратно
                self.dom.removeClass('open');
                self.dom.$list.css('align-items', '');
                self.dom.$list.children('label').css({padding: ''});

                if (self.labelWidth < 1) {
                    self.labelWidth = undefined;
                } else {
                    // метка кнопки
                    // noinspection ES6ConvertVarToLetConst
                    var $btnLabel = self.dom.$btn.children('label');

                    // учитываем паддинги метки кнопки
                    // noinspection ES6ConvertVarToLetConst
                    var style = window.getComputedStyle($btnLabel[0]);
                    self.labelWidth = Math.ceil(
                        self.labelWidth + parseFloat(style.paddingLeft) + parseFloat(style.paddingRight)
                    );

                    // устанавливаем ширину метки кнопки
                    $btnLabel.css('width', self.labelWidth);
                }

                $def.resolve(!!self.labelWidth);
            });

            return $def;
        };

        /**
         * Обновляет метки виджета по состоянию текущего значения
         */
        self.updateLabels = function () {
            // удаляем пометку selected
            self.dom.$list.children('label.selected').removeClass('selected');

            // получаем текущее значение
            // noinspection ES6ConvertVarToLetConst
            var value = self.dom.$input.val();

            // находим метку с текущим значением
            // noinspection ES6ConvertVarToLetConst
            var $label = self.dom.$list.children('label[data-value="' + value + '"]');
            if ($label.length > 0) {
                // клонируем метку для кнопки
                // noinspection ES6ConvertVarToLetConst
                var $buttonLabel = $label.clone();
                if (self.labelWidth) {
                    $buttonLabel.width(self.labelWidth);
                }

                self.dom.$btn.empty().append($buttonLabel);

                // выделяем текущую метку
                $label.addClass('selected');
            } else {
                self.dom.$btn.children('label')
                    .removeAttr('data-value')
                    .addClass('unknown')
                    .html('&nbsp;');
            }
        };

        /**
         * Установить/получить значение элемента.
         *
         * @param {string|undefined} value
         * @returns {string|JQuery}
         */
        self.val = function (value) {
            if (typeof value === 'undefined') {
                return self.dom.$input.val();
            }

            self.dom.$input.val(value);
            self.updateLabels();

            return self.dom;
        };

        // noinspection JSUnusedGlobalSymbols

        /**
         * Установить новые значения
         *
         * @param {Object<{
         *     label: string
         *     encode: boolean|undefined,
         *     class: string|undefined
         * }>|Object<string>} items значения value => string| item{label, encode}
         *
         * @return {JQueryDeferred} ожидание окончания добавления
         */
        self.items = function (items) {
            // удаляем все элементы кроме placeholder
            self.dom.$list.children('label:not([data-value=""])').remove();

            // noinspection ES6ConvertVarToLetConst
            var values = Object.keys(items)
            if (values.length > 0) {
                // конвертируем в объекты
                values.forEach(function (i) {
                    if (typeof items[i] !== 'object') {
                        items[i] = {
                            label: items[i],
                            encode: true,
                            class: undefined
                        }
                    }
                });

                // сортируем по названию
                values.sort(function (k1, k2) {
                    return items[k1].label.localeCompare(items[k2].label);
                });

                // готовим новые метки
                // noinspection ES6ConvertVarToLetConst
                var labels = [];
                // noinspection ES6ConvertVarToLetConst
                var currentValue = String(self.dom.$input.val());

                // конвертируем в метки
                values.forEach(function (value) {
                    value = String(value);

                    // noinspection ES6ConvertVarToLetConst
                    var item = items[value];

                    if (value === currentValue) {
                        item.class = item.class ? item.class + ' ' + 'selected' : 'selected';
                    }

                    // noinspection ES6ConvertVarToLetConst
                    var $label = $('<label/>', {class: item.class, 'data-value': value});
                    $label[item.encode ? 'text' : 'html'](item.label);
                    labels.push($label);
                });

                // добавляем в список
                if (labels.length > 0) {
                    self.dom.$list.append(labels);
                }
            }

            // обновляем метки по новым значениям
            self.updateLabels();

            // пересчитываем ширину метки
            return self.updateWidth();
        };

        /**
         * Устанавливает master-slave связь с родительским элементом
         *
         * @param {JQuery} $master родительский элемент
         * @param {string} url адрес для получения списка items
         * @param {Object|undefined} query параметры запроса url
         * @param {string} param название параметра запроса значением master
         */
        self.setMaster = function ($master, url, query, param) {
            $master.on('change', function (e, val) {
                const masterValue = parseInt(String(val)) || 0;

                // отключенное состояние
                if (masterValue > 0) {
                    self.dom.removeAttr('disabled');
                } else {
                    self.dom.attr('disabled', 'disabled');
                }

                // сбрасываем значение
                self.val('');

                // оповещаем изменение
                self.dom.$input.trigger('change', '');

                // удаляем элементы
                self.items({});

                // загружаем элементы
                if (masterValue > 0) {
                    // параметры загрузки
                    query[param] = masterValue;

                    $.get(url, query).done(function (values) {
                        self.items(values);
                    });
                }
            });
        };

        // клики по кнопке
        // noinspection JSStringConcatenationToES6Template
        self.dom.$btn
            .on('click' + selector, function (e) {
                e.preventDefault();

                // noinspection ES6ConvertVarToLetConst
                var isOpen = self.dom.hasClass('open');
                if (isOpen) {
                    // закрываем
                    self.dom.removeClass('open');
                } else {
                    // если элемент был скрыт ранее и не рассчитался размер
                    $.when(self.labelWidth || self.updateWidth()).done(function () {
                        // открываем
                        self.dom.addClass('open');

                        // возвращаем прокрутку списка в начало (только после отображения элемента)
                        self.dom.$list.scrollTop(0);
                    });
                }
            });

        // выбор элемента в списке
        self.dom.$list
            .on('click', 'label', function (e) {
                e.preventDefault();

                // закрываем выпадающий список
                self.dom.removeClass('open');

                // выбранное значение
                // noinspection ES6ConvertVarToLetConst
                var value = $(this).data('value');

                // устанавливаем новое значение
                self.val(value);

                // оповещаем слушателей с дополнительным параметром value
                self.dom.$input.trigger('change', value);
            });

        // модифицируем события change элемента input, добавляя значение
        self.dom.$input.on('change', function (e, val) {
            // если значение события не определено
            if (val === undefined) {
                // отменяем текущее событие
                e.stopImmediatePropagation();

                // генерируем новое, со значением
                $(this).trigger('change', String($(this).val()));
            }
        });

        // клики по документу
        // noinspection JSStringConcatenationToES6Template
        $(window.document).on('click' + selector, function (e) {
            // пропускаем клики по кнопке виджета
            // noinspection ES6ConvertVarToLetConst
            var $widget = $(e.target).closest(selector);
            if ($widget.length < 1 || $widget[0] !== self.dom[0]) {
                self.dom.removeClass('open');
            }
        });

        // начальное значение элемента
        self.updateLabels();

        // обновляем ширину кнопки
        self.updateWidth();
    }

    /**
     * Инициализация всех виджетов на странице
     */
    function init()
    {
        $(selector, window.document).each(function () {
            if (!$(this).data('widget')) {
                $(this).data('widget', new CustomSelectWidget(this));
            }
        });
    }

    // при загрузке страницы
    // noinspection JSCheckFunctionSignatures
    $(window).on('load', init);

    // при загрузке Ajax
    $(window.document).ajaxComplete(init);
})(window, jQuery);
