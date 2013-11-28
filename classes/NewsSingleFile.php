<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package   NewsSingleFile
 * @author    Ralf Hartmann
 * @license   LGPL
 * @copyright Ralf Hartmann 2013
 */


/**
 * Namespace
 */
namespace NewsSingleFile;


/**
 * Class NewsSingleFile
 *
 * @copyright  Ralf Hartmann 2013
 * @author     Ralf Hartmann <RalfHartmann@gmx.net>, Leo Feyer <https://contao.org>
 * @package    NewsSingleFile
 */
class NewsSingleFile
{
	public function cb_parseTemplate(\Template &$objTemplate)
	{
		global $objPage;

		if (strpos($objTemplate->getName(), 'news_' ) === 0)
		{
			if ($objTemplate->source == 'singlefile')
			{
				$modelFile = \FilesModel::findByUuid($objTemplate->singlefileSRC);

				try
				{
					if ($modelFile === null)
					{
						throw new \Exception("no file");
					}
					$allowedDownload = trimsplit(',', strtolower($GLOBALS['TL_CONFIG']['allowedDownload']));

					if (!in_array($modelFile->extension, $allowedDownload))
					{
						throw new Exception("download not allowed by extension");
					}
					$objFile = new \File($modelFile->path, true);

					$strHref = \System::urlEncode($objFile->value);
				}
				catch (\Exception $e)
				{
					$strHref = "";
				}

				$target = ($objPage->outputFormat == 'xhtml') ? ' onclick="return !window.open(this.href)"' : ' target="_blank"';


				$objTemplate->more = sprintf('<a %s href="%s" title="%s">%s</a>',
						$target,
						$strHref,
						specialchars(sprintf($GLOBALS['TL_LANG']['MSC']['open'], $objFile->basename)),
						$GLOBALS['TL_LANG']['MSC']['more']);

				$objTemplate->linkHeadline = sprintf('<a %s href="%s" title="%s">%s</a>',
						$target,
						$strHref,
						specialchars(sprintf($GLOBALS['TL_LANG']['MSC']['open'], $objFile->basename)),
						$objTemplate->headline);
			}
		}
	}
}
