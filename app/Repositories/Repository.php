<?php


namespace App\Repositories;


use App\Http\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    public function index() {
        return $this->model->paginate(PAGINATION_COUNT);
    }


    public function create(array $data) {
        return $this->model->create($data);
    }


    public function update(array $data, $id) {
        $record = $this->find($id);
        return $record->update($data);
    }


    public function delete($id) {
        return $this->model->delete($id);
    }


    public function show($id) {
        return $this->model->findOrFail($id);
    }
}
