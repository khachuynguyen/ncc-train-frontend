<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Categories;

class CategoriesRepository implements CategoryRepositoryInterface
{

    public function getAll()
    {
        return Categories::all();
    }

    public function getById($id)
    {
        return Categories::find($id);
    }

    public function delete($id)
    {
        return $this->getById($id)->delele();
    }
}
