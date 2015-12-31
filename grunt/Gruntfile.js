module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({    
	  
	    sass: {
	      dist: {
	    	files: {
	    		'../html/built/css/main.css': '../sass/main.scss'
	    	}
	      }
	    },
	    
	    watch: {
	    	sass: {
	    		files: ['../sass/*.scss'],
	    		tasks: ['sass', 'notify:sass']
	    	}
	    },
	    
	    notify: {
	    	sass: {
	    		options: {
	    			message: 'CSS built'
	    		}
	    	}
	    },
	  
        ftpscript: {
          upload: {
            options: {
              host: 'ftp.hugames.fr',
              passive: true
            },
            files: [
              {
                expand: true,
                cwd: '../',
                src: ['html/*', 'src/*', 'pages/*'],
                dest: '/www/Mountyhall/MHOV'
              }
            ]
          }
        }

  });

  grunt.loadNpmTasks('grunt-ftpscript');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-notify');

  // Default task(s).
  grunt.registerTask('default', ['sass', 'watch']);
  grunt.registerTask('deploy', ['sass', 'ftpscript']);

};