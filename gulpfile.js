var bower = require('gulp-bower');
var cleanCSS = require('gulp-clean-css');
var concat = require('gulp-concat');
var gulp = require('gulp');
var rev = require('gulp-rev');
var revDel = require('rev-del');
var runSequence = require('run-sequence');
var sourcemaps = require('gulp-sourcemaps');
var gutil = require('gulp-util');
var uglify = require('gulp-uglify');

var vendor = {
    jquery: "assets/components/jquery/",
    "gsap": "assets/components/gsap/"
};

//note that files css_sub_group and js_sub_group should be placed in expected orders
var src = {
    css_path: [
        "assets/css/**/*.css"
    ],
    js_path: [
        "assets/js/**/*.js"
    ],
    bower: ["bower.json", ".bowerrc"],
    css_sub_group:
    {
        "client_main.css":
        [
            "assets/css/reset.css",
            "assets/css/zindex.css",
            "assets/css/page_loading.css",
            "assets/css/main.css"
        ]
    },
    js_sub_group:
    {
        "client_main.js":
        [
            vendor.jquery + "dist/jquery.js",
            "assets/js/jquery-migrate-3.0.0.min.js",
            vendor.gsap + "src/uncompressed/TweenMax.js",
            vendor.gsap + "src/uncompressed/TimelineMax.js",
            "assets/js/Responsive.js",
            "assets/js/common.js"
        ],
        "base.js":
        [
            "assets/js/base.js"
        ],
        "home.js":
        [
            "assets/js/home.js"
        ],
        "about.js":
        [
            "assets/js/about.js"
        ],
        "album.js":
        [
            "assets/js/album.js"
        ]
    }
};


var dist_dir = "public";
var version_js = [];
var version_css = [];

for (var css_file in src.css_sub_group) {
    version_css.push(dist_dir + "/css/" + css_file);
}

for (var js_file in src.js_sub_group) {
    version_js.push(dist_dir + "/js/" + js_file);
}

var dist = {
    css: dist_dir + '/css/',
    js: dist_dir + '/js/'
};


gulp.task('bower', function () {
    return bower();
});

function buildCSS() {
    return gulp.src(src["css_path"])
        .pipe(gulp.dest(dist.css));
}


function buildGroupCSS(compress) {
    if (typeof(compress) === 'undefined') {
        compress = false;
    }
    return function () {
        var defaultTasks = [];

        for (var css_file_name in src.css_sub_group) {
            var css_file_group = src.css_sub_group[css_file_name];
            if (compress) {
                defaultTasks.push(gulp.src(css_file_group)
                    .pipe(concat(css_file_name))
                    .pipe(gulp.dest(dist.css))
                    .pipe(sourcemaps.init({loadMaps: true})) //Note put this prior to concat if you wanna see the source of each individual css in the grouped css!
                    .pipe(cleanCSS({processImport: false}))
                    .pipe(sourcemaps.write('../maps'))
                    .pipe(gulp.dest(dist.css)));
            } else {
                defaultTasks.push(gulp.src(css_file_group)
                    .pipe(concat(css_file_name))
                    .pipe(gulp.dest(dist.css)));
            }
        }

        return defaultTasks;
    }
}


function buildCompressCSS() {
    return gulp.src(src["css_path"])
        .pipe(sourcemaps.init())
        .pipe(cleanCSS({processImport: false}))
        .pipe(sourcemaps.write('../maps'))
        .pipe(gulp.dest(dist.css));
}


function revCSS() {
    return gulp.src(version_css, {base: "public/css"})
        .pipe(rev())
        .pipe(gulp.dest('public/css'))
        .pipe(rev.manifest())
        .pipe(revDel({dest: 'public/css'}))
        .pipe(gulp.dest('public/css'));
}

function buildJS() {
    return gulp.src(src["js_path"])
        .pipe(gulp.dest(dist.js));
}


function buildGroupJS(compress) {
    if (typeof(compress) === 'undefined') {
        compress = false;
    }
    return function () {
        var defaultTasks = [];

        for (var js_file_name in src.js_sub_group) {
            var js_file_group = src.js_sub_group[js_file_name];
            if (compress) {
                defaultTasks.push(gulp.src(js_file_group)
                    .pipe(concat(js_file_name))
                    .pipe(sourcemaps.init()) //Note put this prior to concat if you wanna see the source of each individual js in the grouped js!
                    .pipe(uglify()).on('error', gutil.log)
                    .pipe(sourcemaps.write('../maps'))
                    .pipe(gulp.dest(dist.js)));
            } else {
                defaultTasks.push(gulp.src(js_file_group)
                    .pipe(concat(js_file_name))
                    .pipe(gulp.dest(dist.js)));
            }
        }

        return defaultTasks;
    }
}

function buildCompressJS() {
    return gulp.src(src["js_path"])
        .pipe(sourcemaps.init())
        .pipe(uglify().on('error', gutil.log))
        .pipe(sourcemaps.write('../maps'))
        .pipe(gulp.dest(dist.js));
}

function revJS() {
    return gulp.src(version_js, {base: "public/js"})
        .pipe(rev())
        .pipe(gulp.dest('public/js'))
        .pipe(rev.manifest())
        .pipe(revDel({dest: 'public/js'}))
        .pipe(gulp.dest('public/js'));
}

function copyMainImages()
{
    return gulp.src(['assets/images/**/*']).pipe(gulp.dest('public/images'));
}


function copyCssImages()
{
    return gulp.src(['assets/css/images/**/*']).pipe(gulp.dest('public/css/images'));
}

function gulpWatch() {
    gulp.watch(src.bower, function () {
        gulp.start("default");
    });
    gulp.watch(src["css_path"], function () {
        gulp.start("default");
    });
    gulp.watch(src["js_path"], function () {
        gulp.start("default");
    });
}

gulp.task('watch', gulpWatch);

gulp.task('css_main', buildCSS);
gulp.task('js_main', buildJS);

gulp.task('css_group', buildGroupCSS(false));
gulp.task('js_group', buildGroupJS(false));

gulp.task('copy_main_images', copyMainImages);
gulp.task('copy_css_images', copyCssImages);

gulp.task("rev-css", revCSS);
gulp.task("rev-js", revJS);

gulp.task('compress_css_main', buildCompressCSS);
gulp.task('compress_js_main', buildCompressJS);

gulp.task('compress_css_group', buildGroupCSS(true));
gulp.task('compress_js_group', buildGroupJS(true));

// development
gulp.task('default', function () {
    runSequence
    (
        'bower',
        'css_main',
        'css_group',
        'js_main',
        'js_group',
        'copy_main_images',
        'copy_css_images',
        'rev-css',
        'rev-js'
    );
});

// build for production
gulp.task('build', function () {
    runSequence
    (
        'bower',
        'compress_css_main',
        'compress_css_group',
        'compress_js_main',
        'compress_js_group',
        'copy_main_images',
        'copy_css_images',
        'rev-css',
        'rev-js'
    );
});