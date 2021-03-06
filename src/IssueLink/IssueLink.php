<?php

namespace JiraRestApi\IssueLink;

use JiraRestApi\ClassSerialize;
use JiraRestApi\Issue\Comment;

class IssueLink implements \JsonSerializable
{
    use ClassSerialize;

    public function jsonSerialize()
    {
        $vars = array_filter(get_object_vars($this));

        return $vars;
    }

    /**
     * @param $typeName issue type string(ex:  'Duplicate')
     * @return $this
     */
    public function setLinkTypeName($typeName)
    {
        $this->type['name'] = $typeName;

        return $this;
    }

    /**
     * @param $issueKey inward issue key or id
     * @return $this
     */
    public function setInwardIssue($issueKey)
    {
        $this->inwardIssue['key'] = $issueKey;

        return $this;
    }

    /**
     * @param $issueKey out ward issue key or id
     * @return $this
     */
    public function setOutwardIssue($issueKey)
    {
        $this->outwardIssue['key'] = $issueKey;

        return $this;
    }

    /**
     * @param $comment string or \JiraRestApi\Issue\Comment instance
     * @return $this
     */
    public function setComment($comment)
    {
        if (is_string($comment)) {
            $this->comment = new Comment();
            $this->comment->setBody($comment);
        } else if($comment instanceof Comment ) {
            $this->comment = $comment;
        }

        return $this;
    }

    /** @var array */
    public $type;

    /** @var  \JiraRestApi\Issue\Issue */
    public $inwardIssue;

    /** @var  \JiraRestApi\Issue\Issue */
    public $outwardIssue;

    /** @var \JiraRestApi\Issue\Comment */
    public $comment;
}
