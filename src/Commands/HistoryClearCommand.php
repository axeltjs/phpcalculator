<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Interfaces\CommandHistory;

class HistoryClearCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = "history:clear";

    /**
     * @var string
     */
    protected $description = "Clear saved history";

    /**
     * @var object
     */
    protected $commandHistory;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->commandHistory = new CommandHistory();
        $this->commandHistory->clearHistory();

        $this->comment('History cleared!');
    }

}
