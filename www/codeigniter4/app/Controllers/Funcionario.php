<?php

namespace App\Controllers;


class Funcionario extends BaseController
{
    public function index(): string
    {
        return view('funcionario/index');
    }

}
