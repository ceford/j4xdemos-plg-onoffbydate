<?php
/**
 * @package     Joomla.Console
 * @subpackage  Onoffbydate
 *
 * @copyright   Copyright (C) 2005 - 2021 Clifford E Ford. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Plugin\System\Onoffbydate\Extension;

\defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Plugin\System\Onoffbydate\Console\OnoffbydateCommand;

class Onoffbydate extends CMSPlugin
{
	public function __construct(&$subject, $config = [])
	{
		parent::__construct($subject, $config);

		$this->registerCommands();
	}

	protected function registerCommands(): void
	{
		$serviceId = 'onoffbydate.action';

		Factory::getContainer()->share(
				$serviceId,
				function (\Psr\Container\ContainerInterface $container) {
					// do stuff to create command class and return it
					return new OnoffbydateCommand('onoffbydate:action');
				},
				true
				);

		Factory::getContainer()->get(\Joomla\CMS\Console\Loader\WritableLoaderInterface::class)->add('onoffbydate:action', $serviceId);

	}

}
