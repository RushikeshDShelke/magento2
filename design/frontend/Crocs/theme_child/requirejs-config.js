var config = {

    // When load 'requirejs' always load the following files also
    deps: [
        "js/custom",
        'js/theme',


    ],

    shim: {
        jquery: {
            exports: '$'
        },
        'fancybox/js/jquery.fancybox':
        {
            deps: ['jquery']
        },
        'bootstrap/js/bootstrap.min':
            {
                deps: ['jquery']
            },
        'Smartwave_Megamenu/js/sw_megamenu':
            {
                deps: ['jquery']
            },
        'owl.carousel/owl.carousel.min':
            {
                deps: ['jquery']
            },
        'js/jquery.stellar.min':
            {
                deps: ['jquery']
            },
        'js/jquery.parallax.min':
            {
                deps: ['jquery']
            }
    }

};