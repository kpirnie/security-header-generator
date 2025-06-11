// require gulp
const { src, dest, series, parallel, task } = require('gulp');

// require gulp cleaner
const cleanc = require('gulp-clean');

// require sass plugin
const dartSass = require('sass');
const gulpSass = require('gulp-sass');
const sass = gulpSass(dartSass);

// require js concat and minify plugins
const uglify = require('gulp-uglify');
const gconcat = require('gulp-concat');
const grename = require('gulp-rename');

// require css minifier
const cssnano = require('gulp-cssnano');

// require image optimizer
const imagemin = import('gulp-imagemin');

// translations
const wpPot = require('gulp-wp-pot');

// svgs
const svgo = require('gulp-svgo');

// fs
const fs = require('fs');

// read in our package json file
const pkg = JSON.parse(fs.readFileSync('./package.json'));

// directory structure
const dirs = {
  src: {
    root: pkg.source,
    assets: `${pkg.source}/assets`,
    scss: `${pkg.source}/assets/scss`,
    css: `${pkg.source}/assets/css`,
    fonts: `${pkg.source}/assets/fonts`,
    js: `${pkg.source}/assets/js`,
    images: `${pkg.source}/assets/images`,
    vendor: `${pkg.source}/vendor/**/*`
  },
  dist: {
    root: pkg.distribution,
    assets: `${pkg.distribution}/assets`,
    css: `${pkg.distribution}/assets/css`,
    fonts: `${pkg.distribution}/assets/fonts`,
    js: `${pkg.distribution}/assets/js`,
    images: `${pkg.distribution}/assets/images`,
    vendor: `${pkg.distribution}/vendor/`
  }
};

// file patterns
const globs = {
  js: [
    `${dirs.src.js}/*.js`,
    `!${dirs.src.js}/custom.js`
  ],
  scss: [
    `${dirs.src.scss}/*.scss`
  ],
  css: [
    `${dirs.src.css}/*.css`,
    `!${dirs.src.css}/custom.css`
  ],
  fonts: [
    `${dirs.src.fonts}/**/*`
  ],
  img: [
    `${dirs.src.images}/*.+(png|jpg|jpeg|gif)`
  ],
  svgs: [
    `${dirs.src.images}/*.+(svg|svgz)`
  ],
  php: [
    `${dirs.src.root}/*.php`,
    `${dirs.src.root}/**/*.php`
  ],
  templates: [
    `${dirs.src.root}/*.php`,
    `${dirs.src.root}/**/*.php`,
    `${dirs.src.root}/screenshot.png`,
    `${dirs.src.root}/style.css`,
    `${dirs.src.root}/readme.txt`,
    `${dirs.src.root}/readme.md`,
  ],
};

// Tasks
function cleanDist() {
  console.log('# Cleaning Up Distribution');
  return src([`${dirs.dist.root}/`, `!${dirs.dist.root}`], { 
    read: false, 
    allowEmpty: true, 
    force: true 
  }).pipe(cleanc());
}

function compileSass() {
  console.log('# Working on SASS');
  return src(globs.scss)
    .pipe(sass.sync().on('error', sass.logError))
    .pipe(dest(`${dirs.src.css}`));
}

function processStyles() {
  console.log('# Working on Stylesheets');
  return src(globs.css)
    .pipe(gconcat('concat.css'))
    .pipe(dest(`${dirs.dist.css}`))
    .pipe(grename('style.min.css'))
    .pipe(cssnano())
    .pipe(dest(`${dirs.dist.css}`));
}

function processScripts() {
  console.log('# Working on JS');
  return src(globs.js)
    .pipe(gconcat('concat.js'))
    .pipe(dest(`${dirs.dist.js}`))
    .pipe(grename('script.min.js'))
    .pipe(uglify())
    .pipe(dest(`${dirs.dist.js}`));
}

function copyFonts() {
  console.log('# Working on Fonts');
  return src(globs.fonts)
    .pipe(dest(`${dirs.dist.fonts}`));
}

function optimizeImages() {
  console.log('# Working on Images');
  return src(globs.img)
    .pipe(imagemin())
    .pipe(dest(`${dirs.dist.images}`));
}

function optimizeSvgs() {
  console.log('# Working on SVGs');
  return src(globs.svgs)
    .pipe(svgo())
    .pipe(dest(`${dirs.dist.images}`));
}

function generateLanguages() {
  console.log('# Working on Languages');
  return src(globs.php)
    .pipe(wpPot({
      domain: pkg.name,
      package: pkg.package,
    }))
    .pipe(dest(`${dirs.dist.root}/languages/${pkg.name}.pot`));
}

function copyTemplates() {
  console.log('# Working on Templates');
  return src(globs.templates, { allowEmpty: true })
    .pipe(dest(`${dirs.dist.root}`));
}

function copyCustoms() {
  console.log('# Working on Custom Assets');
  return src([
    `${dirs.src.css}/custom.css`,
    `${dirs.src.js}/custom.js`,
    `${dirs.src.js}/script.js`,
    `${dirs.src.css}/style.css`
  ], { allowEmpty: true })
    .pipe(dest(file => {
      return file.extname === '.css' ? dirs.dist.css : dirs.dist.js;
    }));
}

function copyVendor() {
  console.log('# Working on Vendor');
  return src(dirs.src.vendor, { allowEmpty: true })
    .pipe(dest(dirs.dist.vendor));
}

function cleanConcat() {
  console.log('# Cleaning Up Concatenated Files');
  return src([
    `${dirs.dist.css}/concat.css`,
    `${dirs.src.css}/temp.css`,
    `${dirs.dist.js}/concat.js`
  ], { 
    read: false, 
    allowEmpty: true, 
    force: true 
  }).pipe(cleanc());
}

function copyToProduction(done) {
  if (pkg.production?.shouldcopy) {
    console.log('# Copying to Production');
    return src(`${dirs.dist.root}/**/*`, { allowEmpty: true })
      .pipe(dest(pkg.production.path));
  }
  return done();
}

// Define tasks using gulp.task for backward compatibility
task('clean_dist', cleanDist);
task('sass', compileSass);
task('stylesheets', processStyles);
task('javascripts', processScripts);
task('fonts', copyFonts);
task('images', optimizeImages);
task('svgs', optimizeSvgs);
task('languages', generateLanguages);
task('templates', copyTemplates);
task('customs', copyCustoms);
task('vendor', copyVendor);
task('clean_concat', cleanConcat);
task('production_copy', copyToProduction);

// Default task
task('default', series(
  'clean_dist',
  'stylesheets',
  'javascripts',
  'clean_concat',
  parallel('languages', 'templates', 'customs'),
  'vendor',
  'production_copy'
));
