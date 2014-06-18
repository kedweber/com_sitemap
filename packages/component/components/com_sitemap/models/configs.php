<?php

/**
 * ComSitemap
 *
 * @author 		Joep van der Heijden <joep.van.der.heijden@moyoweb.nl>
 */
 
defined('KOOWA') or die('Restricted Access');

class ComSitemapModelConfigs extends ComDefaultModelDefault
{
    public function __construct(KConfig $config)
    {
        parent::__construct($config);

        $this->_state
            ->insert('package', 'string', null, true)
            ->insert('name', 'string', null, true);
    }

    public function _buildQueryWhere($query)
    {
        parent::_buildQueryWhere($query);

        $query->where('tbl.enabled', '=', 1);
    }
}
