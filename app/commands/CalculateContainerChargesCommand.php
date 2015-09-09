<?php

use Illuminate\Console\Command;
use LLPM\Containers\CalculateContainerChargesCommandHandler;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CalculateContainerChargesCommand extends Command {

	protected $calculateCharges;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'llpm:calculate-container-charges';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Recalculate days and charges for active containers in the port';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(CalculateContainerChargesCommandHandler $calculateCharges)
	{
		$this->calculateCharges = $calculateCharges;

		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->calculateCharges->handle([]);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			// array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			// array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
