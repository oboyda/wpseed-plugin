<?php return array(
    'root' => array(
        'pretty_version' => '1.0.0',
        'version' => '1.0.0.0',
        'type' => 'library',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'reference' => NULL,
        'name' => 'oboyda/wp-plugin-bootstrap',
        'dev' => true,
    ),
    'versions' => array(
        'oboyda/wp-plugin-bootstrap' => array(
            'pretty_version' => '1.0.0',
            'version' => '1.0.0.0',
            'type' => 'library',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'reference' => NULL,
            'dev_requirement' => false,
        ),
        'oboyda/wp-seed' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'type' => 'library',
            'install_path' => __DIR__ . '/../oboyda/wp-seed',
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'reference' => 'a5fbacc06a40e5898cb8ad34dc5fbcb2e8b05920',
            'dev_requirement' => false,
        ),
    ),
);
