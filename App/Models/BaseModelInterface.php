<?php namespace Carbontwelve\ButtonBoard\App\Models;


interface BaseModelInterface
{

	public function install();

	public function getAll();

	public function update($id = null, Array $data);

}