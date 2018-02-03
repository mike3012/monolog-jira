<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 12.12.17
 * Time: 18:26
 */

namespace MonologJira\Handler;


use JiraRestApi\Issue\IssueField;
use JiraRestApi\JiraException;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use JiraRestApi\Issue\IssueService;
use MonologJira\Formatter\JiraFormatter;
use MonologJira\Model\JiraIssue;

/**
 * Class JiraHandler
 * @package MonologJira\Handler
 */
class JiraHandler extends AbstractProcessingHandler
{

    private $initialized = false;
    private $issueService = null;

    /**
     * JiraHandler constructor.
     * @param IssueService $issueService
     * @param bool|int $level
     * @param bool $bubble
     */
    public function __construct(IssueService $issueService, $level = Logger::DEBUG, $bubble = true)
    {
        $this->issueService = $issueService;
        parent::__construct($level, $bubble);

    }

    /**
     * @param array $record
     * @return \JiraRestApi\Issue\created|void
     */
    protected function write(array $record)
    {
        if (!$this->initialized) {
            $this->initialize();
        }

        try {
            $issueField = new IssueField();

            $issue = new JiraIssue($record);

            $issueField
                ->setProjectKey("MONOJIRA")
                ->setSummary($issue->getSummary())
                ->setPriorityName($issue->getPriority())
                ->setIssueType("Bug")
                ->setDescription($record['formatted']);

            $issueService = new IssueService();

            $ret = $issueService->create($issueField);

            //If success, Returns a link to the created issue.

            echo "<pre>";
            var_dump($record);
            echo "</pre>";


            return $ret;

        } catch (JiraException $e) {
            print("Error Occured! " . $e->getMessage());
        }
    }

    /**
     *
     */
    private function initialize()
    {
        $this->initialized = true;
    }


    /**
     * Gets the default formatter.
     *
     * @return FormatterInterface
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new JiraFormatter();
    }
}