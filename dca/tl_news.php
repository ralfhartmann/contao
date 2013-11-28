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
 * Table tl_news
 */
$GLOBALS['TL_DCA']['tl_news']['fields']['source']['options_callback'] = array('tl_news_singleFile', 'getSourceOptions');

$GLOBALS['TL_DCA']['tl_news']['fields']['singlefileSRC'] = array
(
		'label'                   => &$GLOBALS['TL_LANG']['tl_news']['srcSinglefile'],
		'exclude'                 => true,
		'inputType'               => 'fileTree',
		'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'mandatory'=>true, 'tl_class'=>'clr'),
		'sql'                     => "binary(16) NULL",
);

$GLOBALS['TL_DCA']['tl_news']['subpalettes']['source_singlefile'] = 'singlefileSRC';

class tl_news_singleFile extends tl_news {

  public function getSourceOptions(DataContainer $dc)
  {

    $arrOptions = parent::getSourceOptions($dc);

    if ($this->User->isAdmin)
    {
      $arrOptions[] = 'singlefile';
      return $arrOptions;
    }

    // Add the "singlefile" option
    if ($this->User->hasAccess('tl_news::singlefileSRC', 'alexf'))
    {
      $arrOptions[] = 'singlefile';
    }

    return array_unique($arrOptions);
  }
}
