<?php

use JiraRestApi\Dumper;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\Issue\IssueField;
use JiraRestApi\Issue\Comment;
use JiraRestApi\Issue\Transition;
use JiraRestApi\JiraException;
use JiraRestApi\Field\FieldService;
use JiraRestApi\Field\Field;

class CustomFieldsTest extends PHPUnit_Framework_TestCase
{
    public function testGetFields()
    {
        $this->markTestSkipped();
        try {
            $fieldService = new FieldService();

            $ret = $fieldService->getAllFields(Field::CUSTOM);
            Dumper::dump($ret);
        } catch (JiraException $e) {
            $this->assertTrue(false, 'testSearch Failed : ' . $e->getMessage());
        }
    }

    public function testCreateFields()
    {
        $this->markTestSkipped();
        try {
            $field = new Field();

            $field->setName("New custom field")
                ->setDescription("Custom field for picking groups")
                ->setType("com.atlassian.jira.plugin.system.customfieldtypes:grouppicker")
                ->setSearcherKey("com.atlassian.jira.plugin.system.customfieldtypes:grouppickersearcher");

            $fieldService = new FieldService();

            $ret = $fieldService->create($field);
            Dumper::dump($ret);
        } catch (JiraException $e) {
            $this->assertTrue(false, 'Field Create Failed : ' . $e->getMessage());
        }
    }

    public function testGetCreateMeta()
    {
        $issueService = new IssueService();

        $ret = $issueService->getCreateMeta();
        Dumper::dump($ret);
    }

    public function testCreateIssueWithCustomFields()
    {
        try {
            $issueField = new IssueField();

            $issueField->setProjectKey('TEST')
                ->setSummary("something's wrong")
                ->setAssigneeName('lesstif')
                ->setPriorityName('Critical')
                ->setIssueType('Bug')
                ->setDescription('Full description for issue')
                ->addVersion('1.0.1')
                ->addVersion('1.0.3')
                ->addCustomField(10401, 'XP')
                ->addCustomField(10403, '1.6')
                ->addCustomField(10700, ['Safari', 'Chrome'])
               // ->addCustomField(11006, "06/Jul/11 3:25 PM")
            ;

            $issueService = new IssueService();

            $ret = $issueService->create($issueField);

            //If success, Returns a link to the created issue.
            print_r($ret);

            $issueKey = $ret->{'key'};

            return $issueKey;
        } catch (JiraException $e) {
            $this->assertTrue(false, 'Create Failed : '.$e->getMessage());
        }
    }
}
