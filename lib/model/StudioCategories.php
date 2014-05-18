<?php

class StudioCategories extends BaseStudioCategories
{
    static $rack = array (
         'compressors',
         'equalizers',
         'mixers'
    );

    static $other = array (
         'instruments',
         'headphones'
    );
    
    static public function getStudioArray()
    {
        $categories = StudioCategoriesPeer::doSelect(new Criteria());
        $array = array();

        foreach ($categories as $category)
        {
            $array[$category->getKey()] = $category->getName();
        }

        return $array;
    }

    static public function getProperGroup($section)
    {
        if(in_array($section, self::$rack)) {
            return 'rack';
        }

        if(in_array($section, self::$other)) {
            return 'other';
        }

        return $section;
    }
}
