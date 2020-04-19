<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Interfaces\CommandHistory;

class HistoryListCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = "history:list {commands?* : Filter the history by command} 
                            {--D|--driver= : Driver for storage connection [default: database]}";
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
        $driver = $this->input->getOption('driver');
        $commands = $this->getCommand();

        $this->commandHistory = new CommandHistory();
        
        if($driver === null || $driver === 'database'){
            $data = $this->commandHistory->showDBHistory($commands);

            if(!empty($data)) {
                $tableContent = [];
                $i = 0;
                foreach ($data as $key => $row) {
                    $i++;
                    $tableContent[] = [
                        'no' => $i,
                        'command' => ucfirst($row['history_command']),
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
            $data = $this->commandHistory->showFileHistory($commands);

            if(!$data->isEmpty()) {
                $tableContent = [];
                $i = 0;
                foreach ($data as $key => $row) {
                    $i++;
                    $tableContent[] = [
                        'no' => $i,
                        'command' => ucfirst($row['history_command']),
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
        }

    }

    protected function getCommand(): array
    {
        return $this->argument('commands') ?? array();
    }
}
