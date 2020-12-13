<?php

namespace App\Repositories;


use App\Models\Order;
use App\Repositories\BaseRepository;

/**
 * Class FinancialRepository
 * @package App\Repositories
 * @version November 23, 2020, 10:34 am UTC
*/

class FinancialRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'restaurant_id',
        'fc_commision'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Order::class;
    }
}
