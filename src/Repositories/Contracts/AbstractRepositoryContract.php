<?php

namespace Hafael\Abstracts\Repositories\Contracts;


interface AbstractRepositoryContract
{
    public function all($columns = array('*'));

    public function allPaginated($perPage = 15, $columns = array('*'));

    public function paginate($perPage = 15, $columns = array('*'));

    public function findAllBy($attribute, $value, $columns = array('*'));

    public function findAllByFiltered($attribute, $value, $filters = array(), $columns = array('*'));

    public function findAllPaginatedBy($attribute, $value, $perPage = 15, $columns = array('*'));

    public function searchAllBy($attribute, $value, $perPage = 15, $columns = array('*'));

    public function getAllBy($attribute, $value, $columns = array('*'));

    public function getAllByArray($attributeArray = array(), $columns = array('*'));

    public function getAllByArrayPaginated($attributeArray = array(), $perPage = 15, $columns = array('*'));

    public function getAllByArrayFilteredAndPaginated($attributeArray = array(), $filters = array(), $perPage = 15, $columns = array('*'));

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function find($id, $columns = array('*'));

    public function findBy($field, $value, $columns = array('*'));
}