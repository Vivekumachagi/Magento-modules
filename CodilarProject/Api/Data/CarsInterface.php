<?php

namespace Vivek\CodilarProject\Api\Data;

interface CarsInterface
{

    const ID            = 'booking_id';
    const DATE          = 'date';
    const TIME          = 'time_details';

    public function getId();

    public function getDate();

    public function getTime();

    public function setId($id);

    public function setDate($id);

    public function setTime($name);

    public function getItems();

    public function setItems(array $items);








}



































