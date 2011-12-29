<?php

class myUser extends sfGuardSecurityUser
{
    protected $header = null;

    public function setHeader($header)
    {
        $this->header = $header;

        sfContext::getInstance()->getResponse()->setTitle($header . sfConfig::get('project_title_delimeter') . sfConfig::get('project_name'));
    }

    public function getHeader()
    {
        return $this->header === null ? '' : $this->header;
    }

}
