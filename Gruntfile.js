module.exports = function(grunt) {

  // Je préfère définir mes imports tout en haut
  grunt.loadNpmTasks('grunt-contrib-sass')
  grunt.loadNpmTasks('grunt-contrib-concat')
  grunt.loadNpmTasks('grunt-contrib-uglify')
  grunt.loadNpmTasks('grunt-contrib-watch')
  grunt.loadNpmTasks("grunt-autoprefixer")
  grunt.loadNpmTasks('grunt-contrib-cssmin')

  var jsSrc = ['src/js/general.js']
  var jsDist = 'dist/js/built.js'

  // Configuration de Grunt
  grunt.initConfig({
    sass: {
      dist: {
        options: {
          style: 'expanded'
        },
        files: [{
          "expand": true,
          "cwd": "src/css/",
          "src": ["*.scss"],
          "dest": "dist/css/",
          "ext": ".css"
        }]
      },
      dev: {} // A vous de le faire ! vous verrez que certaines options Sass sont plus intéressantes en mode dev que d'autres.
    },
    concat: {
      options: {
        separator: ';'
      },
      compile: { // On renomme vu qu'on a pas de mode dev/dist. Dist étant une autre tâche : uglify
        src: jsSrc, // Vu qu'on doit l'utiliser deux fois, autant en faire une variable.
        dest: jsDist // Il existe des hacks plus intéressants mais ce n'est pas le sujet du post.
      }
    },
    uglify: {
      options: {
        separator: ';'
      },
      compile: {
        src: jsSrc,
        dest: jsDist
      }
    },
    watch: {
      scripts: {
        files: 'src/js/*.js',
        tasks: ['scripts:dist_scripts']
      },
      styles: {
        files: 'src/css/*.scss',
        tasks: ['styles:dist_styles']
      }
    },
    autoprefixer: {
      options: {
        browsers: ["last 2 versions", "> 1%", "Explorer 7", "Android 2"]
      },
      dist: {
        expand: true,
        flatten: true,
        cwd: "./dist/css",
        src: ["*.css"],
        dest: "./dist/css/"
      }
    },
    cssmin: {
      my_target: {
        files: [{
          expand: true,
          cwd: './dist/css/',
          src: ['*.css', '!*.min.css'],
          dest: './dist/css/',
          ext: '.min.css'
        }]
      }
    }
  })

  grunt.registerTask('dev', ['styles:dev_styles', 'scripts:dev_scripts'])
  grunt.registerTask('dist', ['styles:dist_styles', 'scripts:dist_scripts'])

  // J'aime bien avoir des noms génériques
  grunt.registerTask('scripts:dev_scripts', ['concat:compile'])
  grunt.registerTask('scripts:dist_scripts', ['uglify:compile'])

  grunt.registerTask('styles:dev_styles', ['sass:dev','autoprefixer:dev'])
  grunt.registerTask('styles:dist_styles', ['sass:dist','autoprefixer:dist','cssmin'])
}