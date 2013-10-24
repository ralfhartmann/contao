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
 * HOOKS
 */
$GLOBALS['TL_HOOKS']['parseTemplate'][] = array('NewsSingleFile', 'cb_parseTemplate');
