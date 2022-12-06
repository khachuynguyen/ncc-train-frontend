<?php
namespace App\Interfaces;

interface RepositoryInterface{

    public function getAll();

    public function getById($id);

    public function delete($id);

}
