<?php

namespace Vivek\CodilarProject\Api;

use Vivek\CodilarProject\Api\Data\CarsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface CarsRepositoryInterface
{

    public function save(CarsInterface $model);

    public function getList(SearchCriteriaInterface $criteria);

    public function getByDate($date);



}
