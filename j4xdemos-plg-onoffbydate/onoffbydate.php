<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.onoffbydate
 *
 * @copyright   (C) 2021 Clifford E Ford.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;
use Joomla\Event\SubscriberInterface;
use Joomla\CMS\Console\OnoffbydateCommand;

class Plgsystemonoffbydate extends CMSPlugin implements SubscriberInterface
{

	public static function getSubscribedEvents(): array
	{
		return [
				\Joomla\Application\ApplicationEvents::BEFORE_EXECUTE => 'registerCommands',
		];
	}

	public function registerCommands(): void
	{
		$serviceId = 'onoffbydate.action';

		Factory::getContainer()->share(
				$serviceId,
				function (\Psr\Container\ContainerInterface $container) {
					// do stuff to create command class and return it
					return new OnoffbydateCommand;
				},
				true
				);

		Factory::getContainer()->get(\Joomla\CMS\Console\Loader\WritableLoaderInterface::class)->add('onoffbydate:action', $serviceId);

	}

}