<?php

namespace Jakmall\Recruitment\Calculator\History\Infrastructure;

//TODO: create implementation.
interface CommandHistoryManagerInterface
{
    /**
     * Returns array of command history.
     *
     * @return array
     */
    public function find($params = null): array;

    /**
     * Log command data to storage.
     *
     * @param mixed $command The command to log.
     *
     * @return int|bool Returns id when command is logged successfully, or false if something bad happened.
     */
    public function log($command);

    /**
     * Clear all data from storage.
     *
     * @return bool Returns true if all data is cleared successfully, false otherwise.
     */
    public function clearAll():bool;
}
