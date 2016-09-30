module.exports = function(grunt) {
	'use strict';

	require('load-grunt-tasks')(grunt);

	grunt.initConfig({

		checktextdomain: {
			standard: {
				options:{
					text_domain: 'footer-text',
					keywords: [
						'__:1,2d',
						'_e:1,2d',
						'_x:1,2c,3d',
						'esc_html__:1,2d',
						'esc_html_e:1,2d',
						'esc_html_x:1,2c,3d',
						'esc_attr__:1,2d',
						'esc_attr_e:1,2d',
						'esc_attr_x:1,2c,3d',
						'_ex:1,2c,3d',
						'_n:1,2,4d',
						'_nx:1,2,4c,5d',
						'_n_noop:1,2,3d',
						'_nx_noop:1,2,3c,4d'
					]
				},
				files: [{
					src: ['**/*.php', '!node_modules/**/*.php', '!build/**/*.php'],
					expand: true,
				}],
			}
		},

		pot: {
			options: {
				text_domain: 'footer-text',
				dest: 'languages/',
				keywords: ['__','_e','esc_html__','esc_html_e','esc_attr__', 'esc_attr_e', 'esc_attr_x', 'esc_html_x', 'ngettext', '_n', '_ex', '_nx']
			},
			files: {
				src: ['**/*.php', '!node_modules/**/*.php', '!build/**/*.php'],
				expand: true
			}
		},

		po2mo: {
			files: {
				src: 'languages/*.po',
				expand: true
			}
		},

		clean: {
			build: ['build']
		},

		copy: {
			build: {
				src: [
					'readme.txt',
					'license.txt',
					'screenshot-*.{png,jpg}',
					'footer-text.php',
					'uninstall.php',
					'includes/**/*',
					'languages/**/*'
				],
				dest: 'build',
				expand: true
			}
		},

		wp_deploy: {
			deploy: {
				options: {
					plugin_slug: 'footer-text',
					svn_user: 'bungeshea',
					build_dir: 'build'
				}
			}
		}

	});

	grunt.registerTask( 'l18n', ['checktextdomain', 'pot', 'newer:po2mo'] );
	grunt.registerTask( 'build', ['clean:build', 'copy:build'] );
	grunt.registerTask( 'default', ['l18n', 'build'] );
};
