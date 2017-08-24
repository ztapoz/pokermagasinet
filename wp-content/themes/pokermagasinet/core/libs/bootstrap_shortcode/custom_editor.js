(function(){
	"use strict";
    var colums = [
        {
            name: "Column-1",
            shortcode: '[col-1][/col-1]'
        },
        {
            name: "Column-2",
            shortcode: '[col-2][/col-2]'
        },
        {
            name: "Column-3",
            shortcode: '[col-3][/col-3]'
        },
        {
            name: "Column-4",
            shortcode: '[col-4][/col-4]'
        },
        {
            name: "Column-5",
            shortcode: '[col-5][/col-5]'
        },
        {
            name: "Column-6",
            shortcode: '[col-6][/col-6]'
        },
        {
            name: "Column-7",
            shortcode: '[col-7][/col-7]'
        },
        {
            name: "Column-8",
            shortcode: '[col-8][/col-8]'
        },
        {
            name: "Column-9",
            shortcode: '[col-9][/col-9]'
        },
        {
            name: "Column-10",
            shortcode: '[col-10][/col-10]'
        },
        {
            name: "Column-11",
            shortcode: '[col-11][/col-11]'
        },
        {
            name: "Column-12",
            shortcode: '[col-12][/col-12]'
        }
    ];
	tinymce.PluginManager.add('section_button', function(editor, url) {
        var columList = [];

        tinymce.each(colums, function (column) {
            columList.push({
                text: column.name,
                onclick: function () {
                    editor.insertContent(column.shortcode);
                }
            });
        }); 

        editor.addButton('section_button', {
            text: false,
            tooltip: 'Add section',
            icon: 'section',
            onclick: function () {
                editor.insertContent('[section][/section]');
            }
        });

        editor.addButton('casino_list_button', {
            text: false,
            tooltip: 'Add casino list',
            icon: 'casino-list',
            onclick: function () {
                editor.insertContent('[casino-list][/casino-list]');
            }
        });

        editor.addButton('casino_boxes_button', {
            text: false,
            tooltip: 'Add casino boxes',
            icon: 'casino-boxes',
            onclick: function () {
                editor.insertContent('[casino-boxes][/casino-boxes]');
            }
        });

        editor.addButton('column_button', {
            type: 'menubutton',
            tooltip: 'Add column',
            icon: 'column',
            menu: columList
        });

        editor.addMenuItem('column_list', {
            icon: false,
            text: 'Colums',
            menu: columList,
            context: 'insert',
            prependToContext: true
        });
    });

})();