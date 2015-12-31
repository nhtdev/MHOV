module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({    
	  
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
                src: ['html/*', 'src/*'],
                dest: '/www/Mountyhall/MHOV'
              }
            ]
          }
        }

  });

  grunt.loadNpmTasks('grunt-ftpscript');

  // Default task(s).
  //grunt.registerTask('default', []);
  grunt.registerTask('deploy', ['ftpscript']);

};