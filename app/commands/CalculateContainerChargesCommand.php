<?php

use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use LLPM\Containers\CalculateContainerCharges;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CalculateContainerChargesCommand extends ScheduledCommand {

	protected $calculateContainerCharges;

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
	public function __construct(CalculateContainerCharges $calculateContainerCharges)
	{
		$this->calculateContainerCharges = $calculateContainerCharges;

		parent::__construct();
	}


	/**
	 * When a command should run
	 *
	 * @param Scheduler $scheduler
	 * @return \Indatus\Dispatcher\Scheduling\Schedulable
	 */
	public function schedule(Schedulable $scheduler)
	{
		return $scheduler->everyMinutes(10);
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		Log::info('Calculate container charges');
		$this->calculateContainerCharges->fire();
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
