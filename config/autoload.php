<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package News_singleFile
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'NewsSingleFile',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'NewsSingleFile\NewsSingleFile' => 'system/modules/news_singleFile/classes/NewsSingleFile.php',
));
