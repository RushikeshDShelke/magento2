define([
    'jquery',
    'collapsible',
    'matchMedia',
    'domReady!'
], function ($) {
    'use strict';

    var helpers = {
        domReady: function() {
            var accordionResize = function($accordions) {
                $accordions.forEach(function(element, index){
                    var $accordion = $(element);
                    mediaCheck({
                        media: '(min-width: 768px)',
                        entry: function() {
                            $accordion.collapsible('activate');
                            $accordion.collapsible('option', 'collapsible', false);
                        },
                        exit: function() {
                            $accordion.collapsible('deactivate');
                            $accordion.collapsible('option', 'collapsible', true);
                        }
                    });

                    if ($accordion.parent().closest('.amblog-main-content').length) {
                        $accordion.collapsible('activate');
                        $accordion.collapsible('option', 'collapsible', false);
                    }

                    $('[data-amblog-js="content"]').off("click");
                    $('[data-amblog-js="content"]').off("keydown");
                });
            };

            var $container = $('[data-amblog-js="element-block"]').find('[data-amblog-js="accordion"]'),
                $accordions = [],
                accordionOptions = {
                    collapsible: true,
                    header: '[data-amblog-js="heading"]',
                    trigger: '',
                    content: '[data-amblog-js="content"]',
                    openedState: 'active',
                    animate: false
                };

            $container.children("div").each(function(index, elem){
                var $this = $(elem),
                    $accordion = $this.collapsible(accordionOptions);

                $accordions.push($accordion);
            });

            accordionResize($accordions);
        }
    };
    helpers.domReady();
});
