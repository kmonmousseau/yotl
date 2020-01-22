<?php
namespace Deployer;
require 'recipe/symfony4.php';

// Configuration
set('ssh_type', 'native');
set('ssh_multiplexing', true);
set('composer_action', 'install');
set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader --no-dev');
set('repository', 'https://github.com/kmonmousseau/yotl');

set('dump_assets', true);

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', ['public/uploads/paintings']);

// Servers
host('prod')
    ->hostname('perso')
    ->set('branch', 'master')
    ->set('deploy_path', '/var/www/html/yolaine-trichetloiseau.com')
    ->set('writable_use_sudo', false)
    ->set('writable_chmod_mode', 777)
    ->set('writable_chmod_recursive', false)
    ->set('writable_mode', 'chmod')
    ->stage('prod')
;

/**
 * Upload the shared files
 */
task('upload:files', function () {
    upload('.env.prod', '{{release_path}}/.env');
});

before('deploy:vendors', 'upload:files');
