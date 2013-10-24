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
					$strHref = \Environment::get('request');

					// Remove an existing file parameter (see #5683)
					if (preg_match('/(&(amp;)?|\?)file=/', $strHref))
					{
						$strHref = preg_replace('/(&(amp;)?|\?)file=[^&]+/', '', $strHref);
					}

					$strHref .= (($GLOBALS['TL_CONFIG']['disableAlias'] || strpos($strHref, '?') !== false) ? '&amp;' : '?') . 'file=' . \System::urlEncode($objFile->value);
				}
				catch (\Exception $e)
				{
					$strHref = "";
				}

				$objTemplate->more = sprintf('<a href="%s" title="%s">%s</a>',
						$strHref,
						specialchars(sprintf($GLOBALS['TL_LANG']['MSC']['open'], $objFile->basename)),
						$GLOBALS['TL_LANG']['MSC']['more']);

				$objTemplate->linkHeadline = sprintf('<a href="%s" title="%s">%s</a>',
						$strHref,
						specialchars(sprintf($GLOBALS['TL_LANG']['MSC']['open'], $objFile->basename)),
						$objTemplate->headline);
			}
		}
	}
}
