<?php

/**
 * ComSitemap
 *
 * @author 		Joep van der Heijden <joep.van.der.heijden@moyoweb.nl>
 */

defined('KOOWA') or die('Restricted Access');

class ComSitemapDatabaseTableConfigs extends KDatabaseTableDefault
{
    /**
     * @param KConfig $config
     */
    protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'behaviors' => array(
                'lockable',
                'com://admin/moyo.database.behavior.creatable',
                'modifiable',
                'identifiable'
            )
        ));

        parent::_initialize($config);
    }
}