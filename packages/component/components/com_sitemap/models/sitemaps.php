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
            ->insert('urlser_offset', 'int', null, true);
    }

    public function getList()
    {
        if (!$this->_list) {
            $this->_list = array('sitemapindex' => array());

            $configs = $this->getService('com://site/sitemap.model.configs')->limit(0)->getList();

            foreach($configs as $config) {
                $identifier = clone $this->getIdentifier();
                $identifier->package = $config->package;
                $identifier->name = $config->name;

                $model = $this->getService($identifier);
                $total = $model->getTotal();
                $model->sort('modified_on')->direction('asc')->limit(1);

                for($i = 0; $i < $total;) {
                    $item = $model->offset($i)->getList()->top();

                    $sitemap = new stdClass();
                    $sitemap->loc = JUri::root() . 'index.php?option=com_sitemap&view=sitemap&urlset_offset='. $i . '&urlset_limit=500&package=' . $identifier->package .'&name=' . $identifier->name . '&format=xml';
                    $sitemap->lastmod = $item->modified_on;

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

                $identifier = clone $this->getIdentifier();
                $identifier->package = $config->package;
                $identifier->name = $config->name;

                $model = $this->getService($identifier);
                $items = $model->sort('modified_on')->direction('asc')->limit($state->urlset_limit)->offset($state->urlset_offset)->getList();

                $router = JApplicationSite::getRouter();

                foreach($items as $item) {
                    $url = new stdClass();
                    $route = $router->build('index.php?option=com_'. $item->getIdentifier()->package . '&view=' . $item->getIdentifier()->name . '&id=' . $item->id);
                    $uri = JUri::getInstance();

                    $url->loc = $uri->getScheme() . '://' . $uri->getHost() . $route;
                    $url->lastmod = $item->modified_on;

                    $timeDiff = date_diff(new DateTime(), new DateTime($item->modified_on));

                    if (!$timeDiff || $timeDiff->m > 1 || $timeDiff->y > 1) {
                        $url->changefreq = 'yearly';
                    } else if ($timeDiff->d > 7) {
                        $url->changefreq = 'monthly';
                    } else if ($timeDiff->d > 2) {
                        $url->changefreq = 'weekly';
                    } else {
                        $url->changefreq = 'dayly';
                    }

                    array_push($this->_item->urlset, $url);
                }
            }
        }

        return $this->_item;
    }
}