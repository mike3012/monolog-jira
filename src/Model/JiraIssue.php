<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 12.12.17
 * Time: 20:18
 */

namespace MonologJira\Model;


class JiraIssue
{
    const PRIORITY_0 = 'Highest';
    const PRIORITY_1 = 'High';
    const PRIORITY_2 = 'Medium';
    const PRIORITY_3 = 'Low';
    const PRIORITY_4 = 'Lowest';

    const UNKNOWN_STRING = 'unknown';
    const UNKNOWN_INTEGER = 0;

    /**
     * @var string
     */
    private $summary = null;

    /**
     * @var string
     */
    private $description = null;

    /**
     * @var string
     */
    private $levelName = null;

    /**
     * @var int
     */
    private $level = null;

    /**
     * @var string
     */
    private $file = null;

    /**
     * @var int
     */
    private $line = null;

    /**
     * @var int
     */
    private $code = null;

    /**
     * @var int
     */
    private $priority = self::PRIORITY_0;

    /**
     * @var \DateTime
     */
    private $datetime = null;

    /**
     * JiraIssue constructor.
     * @param array $record
     * @throws \Exception
     */
    public function __construct(array $record)
    {
        $this->handleRecord($record);
    }

    /**
     * @param array $record
     */
    private function handleRecord(array $record)
    {
        $this->summary = $record['context'][0][''] ?? self::UNKNOWN_STRING;

        $this->description = $record['formatted'] ?? self::UNKNOWN_STRING;

        $this->levelName = $record['level_name'] ?? self::UNKNOWN_STRING;

        $this->level = $record['level'] ?? self::UNKNOWN_INTEGER;

        $this->datetime = $record['datetime'] ?? new \DateTime();

    }

    /**
     * @return string
     */
    public function getSummary(): string
    {
        return $this->summary;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getLevelName(): string
    {
        return $this->levelName;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @return int
     */
    public function getLine(): int
    {
        return $this->line;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime(): \DateTime
    {
        return $this->datetime;
    }

    /**
     * @param \DateTime $datetime
     * @return JiraIssue
     */
    public function setDatetime(\DateTime $datetime): JiraIssue
    {
        $this->datetime = $datetime;

        return $this;
    }

}