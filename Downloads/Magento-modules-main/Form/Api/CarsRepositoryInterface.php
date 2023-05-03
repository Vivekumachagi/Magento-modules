<?php

namespace Vivek\Form\Api;

use Vivek\Form\Api\Data\CarsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface CarsRepositoryInterface
{

    public function save(CarsInterface $model);


    public function delete(CarsInterface $model);


    public function deleteById($id);


    public function getById($id);


    public function getList(SearchCriteriaInterface $criteria);
}
