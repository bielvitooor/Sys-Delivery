<?php

namespace App\Controllers;
use App\Models\Enderecos as Enderecos_model;

use App\Models\Cidades;
use App\Models\Usuarios;




class Enderecos extends BaseController
{
    private $enderecos;
    public function __construct(){
        $this->enderecos = new Enderecos_model();
        $data['title'] = 'Enderecos';
        helper('functions');
    }
    public function index(): string
    {
        $data['title'] = 'Enderecos';
    
        $data['enderecos'] = $this->enderecos
            ->select('enderecos.*, cidades.cidades_nome as cidade_nome, usuarios.usuarios_nome as usuario_nome')
            ->join('cidades', 'cidades.cidades_id = enderecos.cidades_id')
            ->join('usuarios', 'usuarios.usuarios_id = enderecos.usuarios_id')
            ->findAll();
    
        return view('enderecos/index', $data);
    }

   /* public function index(): string
    {
        $data['title'] = 'Produtos';
        $data['produtos'] = $this->enderecos->join('categorias', 'produtos_categorias_id = categorias_id')->find();
        //$data['produtos'] = $this->produtos->findAll();
        return view('produtos/index',$data);
    }*/

    public function new(): string
    {
        $data['title'] = 'Enderecos';
        $data['op'] = 'create';
        $data['form'] = 'cadastrar';
        $data['enderecos'] = (object) [
            'enderecos_id' => '',
            'logradouro'=> '',
            'numero'=> '',
            'complemento'=> '',
            'cep'=> '',
            'cidades_id'=> '',
            'status'=> '',
            'usuarios_id'=> ''
        ];

        $cidades = new \App\Models\Cidades();
        $usuarios = new \App\Models\Usuarios();

        $data['cidades'] = $cidades->findAll();
        $data['usuarios'] = $usuarios->findAll();

        return view('enderecos/form',$data);
    }
    public function create()
    {

        //  var_dump($_POST); exit;
        // Checks whether the submitted data passed the validation rules.
        if(!$this->validate([
            'logradouro' => 'required|max_length[255]|min_length[3]',
            'numero' => 'required',
            'complemento' => 'required',
            'cep' => 'required',
            'bairro' => 'required|max_length[255]|min_length[3]',
            'cidades_id' => 'required',
            'status' => 'required',
            'usuarios_id' => 'required',
        ])) {
            $cidades = new \App\Models\Cidades();
            $usuarios = new \App\Models\Usuarios();
        
            $data['title'] = 'Enderecos';
            $data['form'] = 'Cadastrar';
            $data['op'] = 'create';
            $data['enderecos'] = $this->enderecos
                ->select('enderecos.*, cidades.cidades_nome as cidade_nome, usuarios.usuarios_nome as usuario_nome')
                ->join('cidades', 'cidades.cidades_id = enderecos.cidades_id')
                ->join('usuarios', 'usuarios.usuarios_id = enderecos.usuarios_id')
                ->findAll();

            $data['cidades'] = $cidades->findAll();
            $data['usuarios'] = $usuarios->findAll();
            $data['enderecos'] = (object) $_REQUEST;
        
            return view('enderecos/form',$data);
        }
        


     $this->enderecos->save([
    'logradouro' => $_REQUEST['logradouro'],
    'numero' => $_REQUEST['numero'],
    'bairro' => $_REQUEST['bairro'],
    'complemento' => $_REQUEST['complemento'],
    'cep' => $_REQUEST['cep'],
    'cidades_id' => $_REQUEST['cidades_id'],
    'status' => $_REQUEST['status'],
    'usuarios_id' => $_REQUEST['usuarios_id'],
]);
        $cidades = new \App\Models\Cidades();
        $usuarios = new \App\Models\Usuarios();
        
        $data['msg'] = msg('Cadastrado com Sucesso!','success');
        $data['enderecos'] = $this->enderecos
            ->select('enderecos.*, cidades.cidades_nome as cidade_nome, usuarios.usuarios_nome as usuario_nome')
            ->join('cidades', 'cidades.cidades_id = enderecos.cidades_id')
            ->join('usuarios', 'usuarios.usuarios_id = enderecos.usuarios_id')
            ->findAll();
                $data['title'] = 'Enderecos';
                return view('enderecos/index',$data);

    }

    public function delete($id)
    {
        $this->enderecos->where('enderecos_id', (int) $id)->delete();
    
        $data['msg'] = msg('Deletado com Sucesso!','success');
        $data['title'] = 'Enderecos';
    
        $data['enderecos'] = $this->enderecos
            ->select('enderecos.*, cidades.cidades_nome as cidade_nome, usuarios.usuarios_nome as usuario_nome')
            ->join('cidades', 'cidades.cidades_id = enderecos.cidades_id')
            ->join('usuarios', 'usuarios.usuarios_id = enderecos.usuarios_id')
            ->findAll();
    
        return view('enderecos/index', $data); // Corrigido aqui
    }

    public function edit($id)


    {

        $cidades = new \App\Models\Cidades();
        $usuarios = new \App\Models\Usuarios();
        //$enderecos = new \App\Models\Enderecos();
    
        $data['cidades'] = $cidades->findAll();
        $data['usuarios'] = $usuarios->findAll();

        $data['enderecos'] = $this->enderecos->where(['enderecos_id' => (int) $id])->first();
        $data['title'] = 'Enderecos';
        $data['form'] = 'Alterar';
        $data['op'] = 'update';


        return view('enderecos/form',$data);
    }

    public function update()
    {
        $dataForm = [
            'logradouro' => $_REQUEST['logradouro'],
            'numero' => $_REQUEST['numero'],
            'complemento' => $_REQUEST['complemento'],
            'cep' => $_REQUEST['cep'],
            'bairro' => $_REQUEST['bairro'],
            'cidades_id' => $_REQUEST['cidades_id'],
            'status' => $_REQUEST['status'],
            'usuarios_id' => $_REQUEST['usuarios_id'],
        ];

        $cidades = new \App\Models\Cidades();
        $usuarios = new \App\Models\Usuarios();
        //$enderecos = new \App\Models\Enderecos();
    
        $data['cidades'] = $cidades->findAll();
        $data['usuarios'] = $usuarios->findAll();
        $id= $this->request->getPost('enderecos_id');
        $this->enderecos->update($id, $dataForm);
        $data['msg'] = msg('Alterado com Sucesso!','success');
        $data['enderecos'] = $this->enderecos
                    ->select('enderecos.*, cidades.cidades_nome as cidade_nome, usuarios.usuarios_nome as usuario_nome')
                    ->join('cidades', 'cidades.cidades_id = enderecos.cidades_id')
                    ->join('usuarios', 'usuarios.usuarios_id = enderecos.usuarios_id')
                    ->findAll();        $data['title'] = 'Enderecos';
                return view('enderecos/index',$data);
    }

    

    /*public function search()
    {
        //$data['usuarios'] = $this->usuarios->like('usuarios_nome', $_REQUEST['pesquisar'])->find();
        $data['usuarios'] = $this->usuarios->like('usuarios_nome', $_REQUEST['pesquisar'])->orlike('usuarios_cpf', $_REQUEST['pesquisar'])->find();
        $total = count($data['usuarios']);
        $data['msg'] = msg("Dados Encontrados: {$total}",'success');
        $data['title'] = 'Usuarios';
        return view('usuarios/index',$data);

    }*/

    


}
