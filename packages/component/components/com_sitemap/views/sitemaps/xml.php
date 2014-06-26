<?php

/**
 * ComSitemap
 *
 * @author 		Joep van der Heijden <joep.van.der.heijden@moyoweb.nl>
 */

defined('KOOWA') or die('Restricted Access');

class ComSitemapViewSitemapsXml extends KViewAbstract
{
    public function display()
    {
		header('Content-Type: application/xml');

        $list = $this->getModel()->getList();

        $sitemapIndex = $list['sitemapindex'];

        $xmlRoot = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></sitemapindex>');

        foreach($sitemapIndex as $sitemap) {
            $xmlSitemap = $xmlRoot->addChild('sitemap');
            $xmlSitemap->addChild('loc', htmlentities($sitemap->loc));
            $date = new DateTime($sitemap->lastmod);
            $xmlSitemap->addChild('lastmod', $date->format('Y-m-d\TH:i:s'));
        }

		// This forces no caching!
        echo $xmlRoot->asXML();
		exit;
    }
}