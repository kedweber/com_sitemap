<?php

/**
 * ComSitemap
 *
 * @author 		Joep van der Heijden <joep.van.der.heijden@moyoweb.nl>
 */
 
defined('KOOWA') or die('Restricted Access');

class ComSitemapModelSitemaps extends KModelAbstract
{
    public function __construct(KConfig $config)
    {
        parent::__construct($config);

        $this->_state
            ->insert('package', 'string', null, true)
            ->insert('name', 'string', null, true)
            ->insert('urlset_limit', 'int', null, true)
            ->insert('urlset_offset', 'int', null, true);
    }

    private static function getLastMod($config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'sequence' => array('modified_on', 'publish_up', 'created_on'),
            'default' => ''
        ));
        $item = $config->item;

        $date = $config->default;

        foreach($config->sequence as $property) {
            if ($item->$property && $item->$property != '0000-00-00 00:00:00') {
                $date = $item->$property;
                break;
            }
        }

        return $date;
    }

    private static function getLoc($config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'route' => array(
                'id' => ':id'
            )
        ));
        $item = $config->item;

        // strip www:
        $base = preg_replace('|www\.[a-z\.0-9]+|i', '', JURI::base());

        return $base . substr(JRoute::_('index.php?option=com_'. $item->getIdentifier()->package . '&view=' . $item->getIdentifier()->name . '&id=' . $item->id), strlen(JURI::base(true)) + 1);
    }

    public function getList()
    {
        if (!$this->_list) {
            $this->_list = array('sitemapindex' => array());

            $configs = $this->getService('com://site/sitemap.model.configs')->limit(0)->getList();

            foreach($configs as $config) {
                // Get model identifier
                $identifier = clone $this->getIdentifier();
                $identifier->package = $config->package;
                $identifier->name = $config->name;

                // Get total
                $model = $this->getService($identifier);
                $total = $model->getTotal();
                $model->sort('modified_on')->direction('asc')->limit(1);

                for($i = 0; $i < $total;) {
                    // Get first item for lastmod
                    $item = $model->offset($i)->getList()->top();

                    $sitemap = new stdClass();
                    $sitemap->loc = JUri::root() . 'index.php?option=com_sitemap&view=sitemap&urlset_offset='. $i . '&urlset_limit=500&package=' . $identifier->package .'&name=' . $identifier->name . '&format=xml';
                    $sitemap->lastmod = self::getLastMod(array('item' => $item));

                    array_push($this->_list['sitemapindex'], $sitemap);

                    $i += 500;
                }
            }
        }

        return $this->_list;
    }

    public function getItem()
    {
        if (!$this->_item) {
            $state = $this->getState();

            $this->_item = new stdClass();
            $this->_item->urlset = array();

            if ($state->package && $state->name) {
                $config = $this->getService('com://site/sitemap.model.configs')->package($state->package)->name($state->name)->getItem();

                // Get model identifier
                $identifier = clone $this->getIdentifier();
                $identifier->package = $config->package;
                $identifier->name = KInflector::pluralize($config->name);

                // Get items
                $model = $this->getService($identifier);
                $items = $model->sort('modified_on')->direction('asc')->limit($state->urlset_limit)->offset($state->urlset_offset)->getList();

                foreach($items as $item) {
                    $url = new stdClass();

                    $url->loc = self::getLoc(array('item' => $item));
                    $url->lastmod = self::getLastMod(array('item' => $item));

                    // Calculate changefreq
                    $timeDiff = date_diff(new DateTime(), new DateTime($item->modified_on));
                    if (!$timeDiff || $timeDiff->m > 1 || $timeDiff->y > 1) {
                        $url->changefreq = 'yearly';
                    } else if ($timeDiff->d > 7) {
                        $url->changefreq = 'monthly';
                    } else if ($timeDiff->d > 2) {
                        $url->changefreq = 'weekly';
                    } else {
                        $url->changefreq = 'daily';
                    }

                    array_push($this->_item->urlset, $url);
                }
            }
        }

        return $this->_item;
    }
}