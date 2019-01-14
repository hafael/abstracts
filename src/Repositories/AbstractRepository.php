<?php

namespace Hafael\Abstracts\Repositories;

use Hafael\Abstracts\Repositories\Contracts\AbstractRepositoryInterface;

class AbstractRepository implements AbstractRepositoryInterface
{
    protected $model;

    public function all($columns = array('*'))
    {
        return $this->model
                    ->get($columns);
    }

    public function allPaginated($perPage = 15, $columns = array('*'))
    {
        return $this->model
                    ->paginate($perPage, $columns);
    }

    public function paginate($perPage = 15, $columns = array('*')) {
        return $this->model
                    ->paginate($perPage, $columns);
    }

    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }

    public function findBy($attribute, $value, $columns = array('*')) {
        return $this->model
                    ->where($attribute, '=', $value)
                    ->first($columns);
    }

    public function findByAttributeArray($attributeArray = array(), $columns = array('*')) {
        return $this->model
            ->where($attributeArray)
            ->first($columns);
    }


    public function searchAllBy($attribute, $value, $perPage = 15, $columns = array('*')) {

        return $this->model
                    ->where($attribute, 'like', '%'.$value.'%')
                    ->paginate($perPage, $columns);
    }

    public function findAllBy($attribute, $value, $perPage = 15, $columns = array('*')) {
        return $this->model
                    ->where($attribute, '=', $value)
                    ->paginate($perPage, $columns);
    }

    public function findIdOrDocument($id, $attribute, $columns = array('*')){
        $model = $this->model
            ->where($this->model->primaryKey, $id)
            ->orWhere($attribute, '=', $id)
            ->first($columns);


        return $model;
    }

    public function getAllByIdArray($attribute, $values, $perPage = 15, $columns = array('*')) {
        return $this->model
                    ->whereIn($attribute, $values)
                    ->paginate($perPage, $columns);
    }

    public function findAllByFiltered($attribute, $value, $filters = array(), $perPage = 15, $columns = array('*')) {
        return $this->model
                    ->where($attribute, '=', $value)
                    ->filter($filters)
                    ->paginate($perPage, $columns);
    }

    public function getAllBy($attribute, $value, $columns = array('*')) {
        return $this->model
                    ->where($attribute, '=', $value)
                    ->get($columns);
    }

    public function getAllByArray($attributeArray = array(), $columns = array('*')) {
        return $this->model
                    ->where($attributeArray)
                    ->get($columns);
    }

    public function getAllByAttrsQueryAndFilters($attributeArray = array(), $query = null, $filters = array(), $perPage = 15, $columns = array('*')) {
        
        $primaryKey = $this->model->primaryKey;
        $queryString = $query;

        $filters = array_except($filters, [
            'q',
            'page',
            'per_page',
            'include'
        ]);

        return $this->model
                    ->when(!empty($attributeArray), function($query) use ($attributeArray){
                        $query->where($attributeArray);
                    })
                    ->when(!empty($filters), function($query) use ($filters){
                        $query->filter($filters);
                    })
                    ->when(!empty($query), function($query) use ($queryString){
                        $query->search($queryString, null, true);
                    }, function($query) use ($primaryKey){
                        $query->latest($primaryKey);
                    })
                    ->paginate($perPage, $columns);
    }

    public function getAllByArrayPaginated($attributeArray = array(), $perPage = 15, $columns = array('*')) {
        return $this->model
                        ->where($attributeArray)
                        ->paginate($perPage, $columns);
    }

    public function getAllByArrayFilteredAndPaginated($attributeArray = array(), $filters = array(), $perPage = 15, $columns = array('*')) {
        return $this->model
                    ->where($attributeArray)
                    ->filter($filters)
                    ->paginate($perPage, $columns);
    }

    public function findAllPaginatedBy($attribute, $value, $perPage = 15, $columns = array('*')) {
        return $this->model
                    ->where($attribute, '=', $value)
                    ->paginate($perPage, $columns);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function createMultiple(array $data)
    {
        $instances = $this->model->newCollection();

        foreach ($data['data'] as $item) {
            $instances->push($this->model->create($item));
        }

        return $instances;
    }

    public function firstOrCreate(array $data)
    {
        return $this->model->firstOrCreate($data);
    }

    public function update(array $data, $id, $attribute = "id")
    {
        return $this->model
                    ->where($this->model->primaryKey, '=', $id)
                    ->update($data);

    }

    public function updateByIdOrAttrs(array $data, string $id, array $attrs = [])
    {
        return $this->model
                    ->where($this->model->primaryKey, $id)
                    ->orWhere($attrs)
                    ->update($data);

    }

    public function updateIdOrDocument(array $data, $id, $attribute, $orWhere)
    {
        return $this->model
            ->where($attribute, '=', $id)
            ->orWhere($orWhere, '=', $id)
            ->update($data);

    }



    public function delete($id)
    {
        return $this->model
                    ->find($id)
                    ->delete();
    }

    public function deleteByIdOrAttrs(string $id, array $attrs = [])
    {
        return $this->model
                    ->where($this->model->primaryKey, $id)
                    ->orWhere($attrs)
                    ->delete();
    }

    public function deleteIdOrDocument($id, $attribute)
    {
        return $this->model
            ->where($this->model->primaryKey, $id)
            ->orWhere($attribute, '=', $id)
            ->delete();
    }

    public function searchByQuery($query, $perPage = 15, $columns = array('*'))
    {

        return $this->model
                    ->search($query)
                    ->paginate($perPage, $columns);
    }


}