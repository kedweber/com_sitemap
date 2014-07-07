<?php

/**
 * ComSitemap
 *
 * @author 		Joep van der Heijden <joep.van.der.heijden@moyoweb.nl>
 */

defined('KOOWA') or die('Restricted Access');

class ComSitemapViewSitemapXml extends KViewAbstract
{
    public function display()
    {
        header('Content-Type: application/xml');

        $sitemap = $this->getModel()->getItem();

        $xmlRoot = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

        foreach($sitemap->urlset as $url) {
            $xmlUrl = $xmlRoot->addChild('url');
            $xmlUrl->addChild('loc', htmlentities($url->loc));
            $date = new DateTime($url->lastmod);
            $xmlUrl->addChild('lastmod', $date->format('Y-m-d'));
            $xmlUrl->addChild('changefreq', $url->changefreq);
        }

        echo $xmlRoot->asXML();
		exit;
    }
}