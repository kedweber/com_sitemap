# com_sitemap

## Introduction

This component aids sitemap generation for items created in the [Moyo](http://moyoweb.nl) CCK.

## Requirements
* Joomla 3.X . Untested in Joomla 2.5.
* Koowa 0.9 or 1.0 (as yet, Koowa 2 is not supported)
* PHP 5.3.10 or better
* Composer
* Moyo components
    * com_cck
    * com_translations
    * any CCK-compatible components you want to crawl

## Installation
### Composer

Installation is done through composer. In your `composer.json` file, you should add the following lines to the repositories
section:

```json
{
    "name": "moyo/sitemap",
    "type": "vcs",
    "url": "https://git.assembla.com/moyo-content.sitemap.git"
}
```

The require section should contain the following line:

```json
    "moyo/sitemap": "1.0.*",
```

Afterward, just run `composer update` from the root of your Joomla project.

### jsymlinker

Another option, currently only available for Moyo developers, is by using the jsymlink script from the [Moyo Git
Tools](https://github.com/derjoachim/moyo-git-tools).

## Usage

The content manager has to tell com_sitemap which packages and elements are to be crawled. This is done by creating
configs per package. All that needs to be done, is give the package name and element name for the sitemap.

In the case of Google, the webmaster needs to log into webmaster tools and configure the sitemaps for each language. The
URL would look something like `/XX/?option=com_sitemap&view=sitemaps&format=xml`, where XX refers to the language to be
crawled.