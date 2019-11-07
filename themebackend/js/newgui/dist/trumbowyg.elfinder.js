(function ($) {
    'use strict';

    // Plugin default options
    var defaultOptions = {
    };

    // If the plugin is a button
    function buildButtonDef (trumbowyg) {
        return {
            fn: function () {
              //  alert('123123123');
                // Plugin button logic
            }
        }
    }

    $.extend(true, $.trumbowyg, {
        // Add some translations
        langs: {
            en: {
                elfinder: 'Elfinder'
            }
        },
        // Register plugin in Trumbowyg
        plugins: {
            elfinder: {
                // Code called by Trumbowyg core to register the plugin
                init: function (trumbowyg) {
                 
                    // Fill current Trumbowyg instance with the plugin default options
                    trumbowyg.o.plugins.elfinder = $.extend(true, {},
                        defaultOptions,
                        trumbowyg.o.plugins.elfinder || {}
                    );

                    // If the plugin is a paste handler, register it
                    trumbowyg.pasteHandlers.push(function(pasteEvent) {
                        // My plugin paste logic
                    });

                    // If the plugin is a button
                    trumbowyg.addBtnDef('elfinder', buildButtonDef(trumbowyg));
                },
                // Return a list of button names which are active on current element
                tagHandler: function (element, trumbowyg) {
                    return [];
                },
                destroy: function (trumbowyg) {
                }
            }
        }
    })
})(jQuery);