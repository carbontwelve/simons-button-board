<?php namespace Carbontwelve\ButtonBoard\Models;


interface ModelInterface
{

    public function install();

    public function getAll();

    public function update($id = null, Array $data);

}
