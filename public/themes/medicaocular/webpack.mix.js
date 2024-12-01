let mix = require('laravel-mix');

mix
  .js(['src/js/ckeditor.js', 'src/js/theme.js'], 'theme.js')
  .sass('src/scss/style.scss', '.')
  .options({
    processCssUrls: false,
  });