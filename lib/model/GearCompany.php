<?php

class GearCompany extends BaseGearCompany
{
    public function getSmallImagePath()
    {
        $imagePath = sfConfig::get('app_gear_company_images') . '/' .$this->getId() . '-100.gif';

        if($this->hasImage($imagePath))
            return $imagePath;
        else
            return sfConfig::get('app_gear_company_images') . '/default-100.jpg';
    }

    public function getLargeImagePath()
    {
        return sfConfig::get('app_gear_company_images') . '/' .$this->getId() . '-400.jpg';
    }

    public function getFullImagePath()
    {
        return sfConfig::get('app_gear_company_images') . '/' .$this->getId() . '-full.jpg';
    }

    private function hasImage($imagePath)
    {
        return file_exists(sfConfig::get('sf_web_dir') . '/images/' . $imagePath);
    }

    public function getRoute()
    {
        $route =  '@gear_company';
        $route .= '?company_name=' . myUtil::slugify($this->getName());

        return $route;
    }

    public function getTagName()
    {
        $tagInfo = GearCompanyTagPeer::getTagName($this->getId());
        if($tagInfo)
            return $tagInfo->getName();
        else
            return "";
    }

    public function createImages($imageName)
    {
        myUtil::resizeGearImages($imageName, sfConfig::get('app_gear_company_images'), $this->getId());
    }

    public function addTags()
    {
        // Add a new tag for this gear, if needed
        $tag = myTag::getTagByName($this->getName());

        if(!$tag)
        {
            $tagName = myUtil::slugify($this->getName());
            
            $tag = new Tag();
            $tag->setName($tagName);
            $tag->save();
        }
        
        $companyTag = new GearCompanyTag();
        $companyTag->setCompanyId($this->getId());
        $companyTag->setTagId($tag->getID());
        $companyTag->save();
    }

    public function setupNewCompany($companyName)
    {
        $this->setName($companyName);
        $this->setFullName($companyName);
        $this->save();

        $this->addTags();

        $user_id = myUser::getCurrentUser()->getId();

        if($user_id)
          RecentActivity::addActivity($user_id, 'created', array('CompanyId' => $this->getId()));
    }
}
