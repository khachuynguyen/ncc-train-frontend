<?php

namespace App\Repositories;

use App\Interfaces\ManufacturerRepositoryInterface;
use App\Models\Manufacturers;

class ManufacturersRepository implements ManufacturerRepositoryInterface
{

    public function getAll()
    {
        return Manufacturers::all();
    }

    public function getById($id)
    {
        return Manufacturers::find($id);
    }

    public function delete($id)
    {
        return $this->getById($id)->delele();
    }
}
