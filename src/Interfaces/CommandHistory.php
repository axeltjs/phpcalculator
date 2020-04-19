<?php 
namespace Jakmall\Recruitment\Calculator\Interfaces;

use Carbon\Carbon;
use PDO;
use PDOException;

class CommandHistory implements CommandHistoryManagerInterface
{ 
  
     /**
     * PDO instance
     */
    private $pdo;

    protected $storageSqliteDbFile;
    protected $storageFile;

    public function __construct()
    {
        $this->storageSqliteDbFile = './storage/db.sqlite';
        $this->storageFile = './storage/db.txt';
        try {
            $this->pdo = new PDO("sqlite:" . $this->getStorageSqliteDbFile());
            if($this !== null) {
                $this->createTable();
                // var_dump($this->showDBHistory(['add', 'multiply']));
            }
        } catch (PDOException $e) {
            // handle the exception here
            throw $e;
        }
    }


    /**
     * @return mixed
     */
    protected function getStorageSqliteDbFile()
    {
        return $this->storageSqliteDbFile;
    }


    /**
     * @return mixed
     */
    public function getStorageFile()
    {
        return $this->storageFile;
    }

    /**
     * @param string $storageFile file path of file
     */
    public function setStorageFile($storageFile): void
    {
        $this->storageFile = $storageFile;
    }

    /**
     * if need select all data just fill param with null or with empty array like this []
     * if need filter with some keyword fill that param with array ex. ['find_one', 'find_two']
     * @param array|null $filterArray
     * @return array
     */
    public function showDBHistory(array $filterArray = null) : array
    {
        $query = 'SELECT history_id, history_command, history_description, result, output, history_time FROM command_history';
        $extraQuery = ($filterArray != null ?  " WHERE history_command IN ('" . implode("','", $filterArray) . "')" : '');
        $pdoQry = $this->pdo
            ->query($query . $extraQuery);
        $history = [];
        while ($row = $pdoQry->fetch(\PDO::FETCH_ASSOC)) {
            $history[] = [
                'history_id' => $row['history_id'],
                'history_command' => $row['history_command'],
                'history_description' => $row['history_description'],
                'result' => $row['result'],
                'output' => $row['output'],
                'history_time' => Carbon::createFromFormat('Y-m-d H:i:s', $row['history_time'])
                                    ->format('Y-m-d H:i:s')
            ];
        }
        return $history;
    }

    public function showFileHistory()
    {
        // TODO: Implement showFileHistory() method.
    }

    private function createTable(): void
    {
        $queryCreateTable = [
            'CREATE TABLE IF NOT EXISTS command_history (
                history_id INTEGER PRIMARY KEY,
                history_command TEXT NOT NULL,
                history_description TEXT NOT NULL,
                result  INTEGER NOT NULL,
                output TEXT NOT NULL,
                history_time TEXT NOT NULL
             )'
        ];
        foreach ($queryCreateTable as $query) {
            $this->pdo->exec($query);
        }
    }

    /**
     * @param string $history_command
     * @param string $history_description
     * @param int $result
     * @param string $output
     * @return string Last Table command_history id
     */
    private function saveHistoryToDB($history_command, $history_description, $result, $output) {
        $sql = 'INSERT INTO command_history(history_command,history_description,result,output,history_time)'
            .'VALUES(:history_command,:history_description,:result,:output,:history_time)';
        $qryPdq = $this->pdo->prepare($sql);
        $qryPdq->bindValue(':history_command', $history_command);
        $qryPdq->bindValue(':history_description', $history_description);
        $qryPdq->bindValue(':result', $result);
        $qryPdq->bindValue(':output', $output);
        $qryPdq->bindValue(':history_time', date('Y-m-d H:i:s'));
        $qryPdq->execute();
        return $this->pdo->lastInsertId();
    }

    private function saveHistoryToFile($history_command, $history_description, $result, $output) {
        // TODO: Yet
    }

    /**
     * Insert a new history into command_history table
     * @param string $history_command
     * @param string $history_description
     * @param string $result
     * @param string $output
     */
    public function saveHistory($history_command, $history_description, $result, $output)
    {
        $this->saveHistoryToDB($history_command, $history_description, $result, $output);
        $this->saveHistoryToFile($history_command, $history_description, $result, $output);
    }

    /**
     * @return void
     */
    public function clearHistory()
    {
        if(file_exists($this->storageSqliteDbFile)){
            unlink($this->storageSqliteDbFile);
        }

        if(file_exists($this->storageFile)){
            unlink($this->storageFile);
        }
    }
}  
  