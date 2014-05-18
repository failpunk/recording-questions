<?php

class myTag extends Tag
{
	static function getTagByName($tagName)
	{
        $result = DbFinder::from("Tag")
                       ->where("name", $tagName)
                       ->findOne();
        return $result;
	}

	static function getObjIdByTagName($tagName)
	{
        $results = DbFinder::from('Tagging')
                            ->leftJoin('Tag')
                            ->where('Tag.Name', $tagName)
                            ->find();
        $modelId = array();
        foreach ($results as $result)
        {
            $modelId[] = $result->getTaggableId();
        }

        return $modelId;
	}

	static function getObjIdByTagId($tagId)
	{
        $results = DbFinder::from('Tagging')
                            ->leftJoin('Tag')
                            ->where('Tag.ID', $tagId)
                            ->find();
        $modelId = array();
        foreach ($results as $result)
        {
            $modelId[] = $result->getTaggableId();
        }

        return $modelId;
	}

    static function getMixedTags($questionId)
	{
        $result = DbFinder::from("Tag")
                    ->join('Tagging')
                    ->leftJoin('GearTag')
                    ->leftJoin('GearCompanyTag')
                    ->where("Tagging.TaggableId", $questionId)
                    ->where("Tagging.TaggableModel", 'Question')
                    ->select(array('Tag.Name', 'GearTag.GearId', 'GearCompanyTag.CompanyId'))
                    ->find();
                    
        return $result;
	}
}
