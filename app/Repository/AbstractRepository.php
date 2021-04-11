<?php

namespace App\Repository;
use Illuminate\Database\Eloquent\Model;


class AbstractRepository
{

    protected $model;

    public function __construct(Model $model){
        $this->model = $model;
    }

    public function selectFilter($filter){

         $this->model = $this->model->selectRaw($filter);

    }

    public function selectSearch($search){

        $expressions = explode(';', $search);
        // dd($expressions);
            foreach ($expressions as $e) {
                $exp = explode(':', $e);
                $this->model = $this->model->where($exp[0], $exp[1], $exp[2]);
            }

    }

    public function getResult(){
        return $this->model;
    }


}
