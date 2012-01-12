<?php

class myUser extends sfGuardSecurityUser
{
    protected $header = null;

    public function setHeader($header)
    {
        $this->header = $header;

        sfContext::getInstance()->getResponse()->setTitle(strip_tags($header) . sfConfig::get('project_title_delimeter') . sfConfig::get('project_name'));
    }

    public function getHeader()
    {
        return $this->header === null ? '' : $this->header;
    }

    public function getSymmetricKey()
    {
        $guardUser = $this->getGuardUser();
        
        //we use 3 params the won't change (id, email_address and created_at)
        return md5('$up3RRR S@@@@l777' . $guardUser->id . sha1($guardUser->email_address . 'g11111b3333r1111sh' . $guardUser->created_at . '$333c000nDDD $@lll77'));
    }

}
