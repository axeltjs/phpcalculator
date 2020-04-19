<?php
namespace Jakmall\Recruitment\Calculator\Interfaces;

interface CommandHistoryManagerInterface 
{
    /**
     * @param array|null $filterArray
     * 
     * @return array
     */
    public function showDBHistory(array $filterArray = null) : array ;
    public function showFileHistory();

    /**
     * save both DB and file
     * @param $history_command
     * @param $history_description
     * @param $result
     * @param $output
     * 
     * @return mixed
     */
    public function saveHistory($history_command, $history_description, $result, $output);
}