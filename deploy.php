<?php
namespace Deployer;
require 'recipe/symfony4.php';

// Configuration
set('ssh_type', 'native');
set('ssh_multiplexing', true);
set('composer_action', 'install');
set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader --no-dev');
set('repository', 'https://github.com/kmonmousseau/yotl');

add('shared_files', []);
add('shared_dirs', ['public/uploads', 'public/media']);
add('writable_dirs', ['public/uploads', 'public/uploads/paintings', 'public/media']);

// Servers
host('perso')
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
task('upload:files', static function () {
    upload('.env.prod', '{{release_path}}/.env');
});
task('deploy:yarn', '
    cd {{release_path}};
    yarn;
    yarn encore prod;
');
task('fix:rights', '
    cd {{release_path}};
    HTTPDUSER=$(ps axo user,comm | grep -E \'[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx\' | grep -v root | head -1 | cut -d\  -f1);
    setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var;
    setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var;
');
task('schema:migrate', '
    cd {{release_path}};
    php bin/console do:mi:mi --no-interaction
');

before('deploy:vendors', 'upload:files');
after('deploy:vendors', 'deploy:yarn');
after('deploy:symlink', 'fix:rights');
after('deploy:symlink', 'schema:migrate');
