<?php

namespace App\Controllers;
use App\Models\Funcionarios as FuncionarioModel;
use App\Models\Usuarios;


class Funcionarios extends BaseController
{
    public function index()
    {
        $funcionarios = (new FuncionarioModel())
             ->select('funcionarios.*, usuarios.usuarios_id, usuarios.usuarios_nome,usuarios_sobrenome, usuarios.usuarios_email, usuarios.usuarios_cpf as cpf, usuarios.usuarios_data_nasc, usuarios.usuarios_fone, usuarios.usuarios_nivel,')
    ->join('usuarios', 'usuarios.usuarios_id = funcionarios.usuario_id')
    ->findAll();

        return view('funcionarios/index', ['funcionarios' => $funcionarios, 'title' => 'Funcionários']);
    }

    public function new()
    {
        $usuarios = (new \App\Models\Usuarios())->findAll();
    $data = [
        'title' => 'Novo Funcionário',
        'form' => 'Cadastrar',
        'op' => 'create',
        'usuarios' => $usuarios,
    ];
    return view('funcionarios/form', $data);
}

    public function create()
    {
        // 1) Cria o usuário
        $usuario_id=$this->request->getPost('usuario_id');
        

        // 2) Cria o funcionário
        (new FuncionarioModel())->insert([
            'usuario_id' => $usuario_id,
            'cargo' => $this->request->getPost('cargo'),
            'status' => $this->request->getPost('status', FILTER_SANITIZE_STRING)
        ]);

        return redirect()->to('/funcionarios');
    }
    public function edit($id)
    {
        
        $funcionario = (new FuncionarioModel())
            ->select('funcionarios.*, usuarios.usuarios_id, usuarios.usuarios_nome, usuarios.usuarios_sobrenome, usuarios.usuarios_email, usuarios.usuarios_cpf as cpf, usuarios.usuarios_data_nasc as data_nasc, usuarios.usuarios_fone as fone, usuarios.usuarios_nivel as nivel')
            ->join('usuarios', 'usuarios.usuarios_id = funcionarios.usuario_id')
            ->find($id);
        if (!$funcionario) {
            return redirect()->to('/funcionarios')->with('msg', 'Funcionário não encontrado.');
        }

        $usuario = (new Usuarios())->find($funcionario->usuario_id);
        $usuarios = (new Usuarios())->findAll();
        $data = [
            'title' => 'Editar Funcionário',
            'form' => 'Editar',
            'op' => 'update',
            'funcionario' => $funcionario,
            'usuario' => $usuario,
            'usuarios' => $usuarios
        ];

        return view('funcionarios/form', $data);
    }
    public function update()
    {
        $usuario_id = $this->request->getPost('usuario_id');
        $funcionario_id = $this->request->getPost('usuarios_id');

        // Atualiza o funcionário
        (new FuncionarioModel())->update($funcionario_id, [
            'usuario_id' => $usuario_id,
            'cargo' => $this->request->getPost('cargo'),
            'status' => $this->request->getPost('status', FILTER_SANITIZE_STRING)
        ]);

        return redirect()->to('/funcionarios');
    }
    public function delete($id)
    {
        $funcionario = (new FuncionarioModel())->find($id);
        if (!$funcionario) {
            return redirect()->to('/funcionarios')->with('msg', 'Funcionário não encontrado.');
        }

        // Exclui o funcionário
        (new FuncionarioModel())->delete($id);

        return redirect()->to('/funcionarios')->with('msg', 'Funcionário excluído com sucesso.');
    }
}
