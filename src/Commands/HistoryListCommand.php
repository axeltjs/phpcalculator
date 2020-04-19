<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Interfaces\CommandHistory;

class HistoryListCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = "history:list {--driver= : Driver for storage connection [default: database]}";

    /**
     * @var string
     */
    protected $description = "Show calculator history";

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
        $option = $this->input->getOption('driver');
        $this->commandHistory = new CommandHistory();
        if($option === null || $option === 'database'){
            $data = $this->commandHistory->showDBHistory(null);
            if(!empty($data)) {
                $tableContent = [];
                $i = 0;
                foreach ($data as $key => $row) {
                    $i++;
                    $tableContent[] = [
                        'no' => $i,
                        'command' => $row['history_command'],
                        'history_description' => $row['history_description'],
                        'Result' => $row['result'],
                        'Output' => $row['output'],
                        'Time' => $row['history_time']
                    ];
                }
                $headers = ['No', 'Command', 'Description', 'Result', 'Output', 'Time'];
                $this->table($headers, $tableContent);
            }else{
                $this->comment('History is empty.');
            }
        }else{
            $this->commandHistory->showFileHistory();
        }

    }

}
