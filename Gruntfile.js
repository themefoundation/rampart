/*global module:false*/
module.exports = function(grunt) {
	grunt.initConfig({

		// JSHint: https://github.com/gruntjs/grunt-contrib-jshint
		jshint: {
			src: ['js/*.js']
		},

		// grunt-wp-i18n by Brady Vercher: https://github.com/blazersix/grunt-wp-i18n
		makepot: {
			target: {
				options: {
					domainPath: '/languages', // Where to save the POT file.
					mainFile: 'style.css', // Main project file.
					type: 'wp-theme' // Type of project (wp-plugin or wp-theme).
				}
			}
		},

		// grunt-sass by Sindre Sorhus: https://github.com/sindresorhus/grunt-sass
		sass: {
			dist: {
				// options: {
				// 	outputStyle: 'nested'
				// },
				files: {
					'css/src/cadence.css': 'css/src/cadence.scss',
					'css/src/style.css': 'css/src/style.scss',
					'css/src/lines.css': 'css/src/lines.scss',
					'css/src/custom-content-portfolio.css': 'css/src/custom-content-portfolio.scss'
				}
			}
		},

		// grunt-pixrem by Rob Wierzbowski: https://github.com/robwierzbowski/grunt-pixrem
		pixrem: {
			cadence: {
				src: 'css/src/cadence.css',
				dest: 'css/cadence.css'
			},
			style: {
				src: 'css/src/style.css',
				dest: 'style.css',
			},
			lines: {
				src: 'css/src/lines.css',
				dest: 'css/lines.css'
			},
			portfolio: {
				src: 'css/src/custom-content-portfolio.css',
				dest: 'css/custom-content-portfolio.css'
			}
		},

		watch: {
			sass: {
				files: ['css/src/*.scss'],
				tasks: ['sass', 'pixrem'],
				options: {
					spawn: false,
				},
			},
		}

	});

	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-wp-i18n');
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-pixrem');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('default', ['jshint']);
};