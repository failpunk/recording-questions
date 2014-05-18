<?php

class fpSphinxPager extends sfSphinxPropelPager
{

	/**
	 * Return an array of result on the given page
	 * @return array
	 */
	public function getResults($sortByRes = true)
	{
		$res = $this->sphinx->getRes();
		$items = parent::getResults();

		$result = array();
		$idItems = array();

		if($sortByRes && isset( $res['matches'] ))
		{
			// key = model->id
			foreach ($items as $model)
			{
				$idItems[$model->getId()] = $model;
			}

			// ordering

			foreach ($res['matches'] as $item)
			{
				$id = $item['id'];
				if(isset($idItems[$id]))
				{
					$result[] = $idItems[$id];
				}
			}
		}
		else
		$result = $items;
		$perPage = $this->getMaxPerPage();
		$page = $this->getPage();

		$result = array_splice($result, ($perPage * $page - $perPage), $perPage );

		return $result;

	}
}

