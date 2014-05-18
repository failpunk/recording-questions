<?php

class fpSphinxClient extends SphinxClient
{

	private   $res;           // result from RunQueries()
    private static $stopWords = array(
        "a",
        "able",
        "about",
        "across",
        "add",
        "again",
        "ago",
        "all",
        "am",
        "an",
        "and",
        "any",
        "anyone",
        "are",
        "as",
        "at",
        "be",
        "but",
        "both",
        "by",
        "can",
        "com",
        "de",
        "did",
        "do",
        "does",
        "en",
        "for",
        "from",
        "get",
        "had",
        "has",
        "have",
        "here",
        "how",
        "i",
        "if",
        "in",
        "is",
        "it",
        "kind",
        "la",
        "like",
        "matter",
        "me",
        "my",
        "needed",
        "no",
        "not",
        "of",
        "on",
        "or",
        "over",
        "record",
        "recording",
        "should",
        "so",
        "sound",
        "that",
        "the",
        "then",
        "there",
        "this",
        "to",
        "too",
        "u",
        "up",
        "use",
        "was",
        "way",
        "will",
        "with",
        "what",
        "what's",
        "when",
        "where",
        "which",
        "would",
        "who",
        "why",
        "www",
        "you",
        "your",
        "years"
    );

	public function __construct($options)
	{
		$this->SphinxClient();

		if(isset($options['mode']))
		$mode = $options['mode'];
		else
		$mode = SPH_MATCH_ALL;

		if(isset($options['host']))
		$host = $options['host'];
		else
		$host = "localhost";

		if(isset($options['port']))
		$port = $options['port'];
		else
		$port = 3312;

		if(isset($options['index']))
		$index = $options['index'];
		else
		$index = "*";

		if(isset($options['groupby']))
		$groupby = $options['groupby'];
		else
		$groupby = "";

		if(isset($options['groupsort']))
		$groupsort = $options['groupsort'];
		else
		$groupsort = "@group desc";

		if(isset($options['filter']))
		$filter = $options['filter'];
		else
		$filter = "group_id";

		if(isset($options['filtervals']))
		$filtervals = $options['filtervals'];
		else
		$filtervals = array();

		if(isset($options['distinct']))
		$distinct = $options['distinct'];
		else
		$distinct = "";

		if(isset($options['sortby']))
		$sortby = $options['sortby'];
		else
		$sortby = "";

		if(isset($options['limit']))
		$limit = $options['limit'];
		else
		$limit = 20;

		if(isset($options['ranker']))
		$ranker = $options['ranker'];
		else
		$ranker = SPH_RANK_PROXIMITY_BM25;

		if(isset($options['weights']))
		$weights = $options['weights'];
		else
		$weights = array ( 100, 1 );



		//$cl = new SphinxClient ();
		$this->SetServer ( $host, $port );
		$this->SetConnectTimeout ( 1 );
		$this->SetWeights ( array ( 100, 1 ) );
		$this->SetMatchMode ( $mode );
		if ( count($filtervals) )   $this->SetFilter ( $filter, $filtervals );
		if ( $groupby )             $this->SetGroupBy ( $groupby, SPH_GROUPBY_ATTR, $groupsort );
		if ( $sortby )              $this->SetSortMode ( SPH_SORT_EXTENDED, $sortby );
		//if ( $sortexpr )            $this->SetSortMode ( SPH_SORT_EXPR, $sortexpr );
		if ( $distinct )            $this->SetGroupDistinct ( $distinct );
		if ( $limit )               $this->SetLimits ( 0, $limit, ( $limit>1000 ) ? $limit : 1000 );
		$this->SetRankingMode ( $ranker );
		$this->SetArrayResult ( true );
	}

	public function search($q, $index)
	{
		$this->res = $this->Query($q, $index);
	}

	public function getRes()
	{
		return $this->res;
	}
    
    public static function removeCommonTerms($string)
	{
        $stringParts = explode(' ', $string);

        foreach($stringParts as $i => $word)
        {
            if(in_array(strtolower($word), self::$stopWords))
            {
                unset($stringParts[$i]);
            }
        }
        
        return implode(" ", $stringParts);
    }
}
