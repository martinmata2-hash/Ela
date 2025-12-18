<?php
namespace Marve\Factory\Console;
class Kernel
{
	public function __construct(private ConsoleApp $application) {}

	public function handle(): int
	{
		$status = $this->application->run();

		return $status;
	}
}