<?php
/**
 * @package     Joomla.Console
 * @subpackage  Onoffbydate
 *
 * @copyright   Copyright (C) 2005 - 2021 Clifford E Ford. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Plugin\System\Onoffbydate\Console;

\defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Factory;
use Joomla\Console\Command\AbstractCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

class OnoffbydateCommand extends AbstractCommand
{
	/**
	 * @var InputInterface
	 * @since version
	 */
	private $cliInput;

	/**
	 * SymfonyStyle Object
	 * @var SymfonyStyle
	 * @since 4.0.0
	 */
	private $ioStyle;

	/**
	 * Configures the IO
	 *
	 * @param   InputInterface   $input   Console Input
	 * @param   OutputInterface  $output  Console Output
	 *
	 * @return void
	 *
	 * @since 4.0.0
	 *
	 */
	private function configureIO(InputInterface $input, OutputInterface $output)
	{
		$this->cliInput = $input;
		$this->ioStyle = new SymfonyStyle($input, $output);
	}

	/**
	 * Initialise the command.
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	protected function configure(): void
	{
		$this->addArgument('action',
				InputArgument::REQUIRED,
				'name of action');

				$this->addArgument('module_id',
						InputArgument::REQUIRED,
						'module id');

				$help = "<info>%command.name%</info> Toggles module Enabled/Disabled state
				\nUsage: <info>php %command.full_name% action_id module_id
				\nwhere action_id is one of winter or weekend</info>";

				$this->setDescription('Called by cron to set the enabled state of a module.');
				$this->setHelp($help);

	}

	/**
	 * Internal function to execute the command.
	 *
	 * @param   InputInterface   $input   The input to inject into the command.
	 * @param   OutputInterface  $output  The output to inject into the command.
	 *
	 * @return  integer  The command exit code
	 *
	 * @since   4.0.0
	 */
	protected function doExecute(InputInterface $input, OutputInterface $output): int
	{
		$this->configureIO($input, $output);

		$action = $this->cliInput->getArgument('action');
		$module_id = $this->cliInput->getArgument('module_id');

		switch ($action) {
			case 'winter' :
				$result = $this->winter($module_id);
				break;
			case 'weekend' :
				$result = $this->weekend($module_id);
				break;
			default:
				$this->ioStyle->error("Unknwon action: {$action}");
				return 0;
		}

		return 1;
	}

	protected function weekend($module_id)
	{
		// get the day of the week
		$day = date('w');
		if (in_array($day, array(0,6)))
		{
			$msg = "Today is a weekend.";
			$published = 1;
		}
		else
		{
			$msg = "Today is not a weekend.";
			$published = 0;
		}

		$this->publish($module_id, $published);

		$state = empty($published) ? 'Unpublished' : 'Published';

		$this->ioStyle->success("That seemed to work. {$msg} Module {$module_id} has been {$state}");

	}

	protected function winter($module_id)
	{
		// get the month of the month
		$month = date('n');
		if (in_array($month, array(1,2,11,12)))
		{
			$msg = "Today is in winter.";
			$published = 0;
		}
		else
		{
			$msg = "Today is not in winter.";
			$published = 1;
		}

		$this->publish($module_id, $published);

		$state = empty($published) ? 'Unpublished' : 'Published';

		$this->ioStyle->success("That seemed to work. {$msg} Module {$module_id} has been {$state}");

	}

	protected function publish ($module_id, $published)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->update('#__modules')
		->set('published = ' . $published)
		->where('id = ' . $module_id);
		$db->setQuery($query);
		$db->execute();
	}
}
