// Paths to project folders
const paths = {
  base: {
    base: "./",
    node: "./node_modules",
  },
  src: {
    basesrc: "./src",
    basesrcfiles: "./src/**/*",
    scss: "./assets/scss/**/*.scss",
    css: "./assets/css",
    js: "./assets/js/**/*.js",
    html: "./**/*.html",
    images: "./assets/images/**/*",
    fonts: "./assets/fonts/**/*",
    assets: "./assets/**/*",
    partials: ".src/partials/**/*",
  },
  temp: {
    basetemp: "./.temp",
  },
  dist: {
    basedist: "./dist",
    js: "./dist/assets/js",
    images: "./dist/assets/images",
    css: "./dist/assets/css",
    fonts: "./dist/assets/fonts",
    libs: "./dist/assets/libs",
  },
};

const { src, dest, watch, parallel, series } = require("gulp");
const sass = require('gulp-sass')(require('sass'));
const browsersync = require("browser-sync").create();
const gulpautoprefixer = require('gulp-autoprefixer');

// SCSS to CSS
function scss(callback) {
  return src(paths.src.scss)
    .pipe(sass().on("error", sass.logError))
    .pipe(gulpautoprefixer())
    .pipe(dest(paths.src.css))
    .pipe(browsersync.stream());
  callback();
}

// SyncReload
function syncReload(callback) {
  browsersync.reload();
  callback();
}

// Watch Task
function watchTask() {
  watch([paths.src.scss], series(scss, syncReload));
}

// Default Task Preview
exports.default = series(watchTask);

// export tasks
exports.scss = scss;
