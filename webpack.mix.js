const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/client/js')
	.vue()
	.copy('resources/js/auth.js', 'public/client/js')
    .sass('resources/sass/client/app.scss', 'public/client/css')
    .sass('resources/sass/client/auth.scss', 'public/client/css')
    .sourceMaps()
    .copy('node_modules/admin-lte/dist/img', 'public/client/img')
    .copy('resources/img/client', 'public/client/img')

    // design-2022
    .copy('resources/design-2022/images', 'public/design-2022/images')
    .copy('resources/design-2022/fonts', 'public/design-2022/fonts')
    // js of libs
    .combine([
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/swiper/swiper-bundle.min.js',
        'node_modules/gsap/dist/gsap.min.js',
        'node_modules/slick-slider/slick/slick.js',
        'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.js',
        'node_modules/jquery.maskedinput/src/jquery.maskedinput.js',
        'node_modules/air-datepicker/air-datepicker.js',
        'node_modules/select2/dist/js/select2.min.js',
    ], 'public/design-2022/js/libs.js')
    // custom js
    .combine('resources/design-2022/js/*.js', 'public/design-2022/js/index.js')
    // includes
    .js('resources/design-2022/js/app/includes.js', 'public/design-2022/js/app.js')
    // css of libs
    .combine([
        'node_modules/swiper/swiper-bundle.min.css',
        'node_modules/slick-slider/slick/slick.css',
        'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.css',
        'node_modules/air-datepicker/air-datepicker.css',
        'node_modules/select2/dist/css/select2.min.css',
    ], 'public/design-2022/css/libs.css')
    // custom css
    .sass('resources/design-2022/scss/index.scss', 'public/design-2022/css/index.css')
    .sourceMaps()
