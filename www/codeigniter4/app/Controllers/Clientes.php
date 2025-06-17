<?php
namespace App\Controllers;
use App\Models\UsuarioModel;
use App\Models\Clientes as ClienteModel;
use App\Models\Cidades;
use App\Models\Usuarios;

class Clientes extends BaseController
{
    public function index()
    {
       $clientes = (new ClienteModel())
    ->select('clientes.*, usuarios.usuarios_nome,usuarios.usuarios_sobrenome, usuarios.usuarios_cpf, usuarios.usuarios_fone, usuarios.usuarios_email')
    ->join('usuarios','usuarios.usuarios_id = clientes.usuario_id')
    ->findAll();
        return view('clientes/index', ['clientes'=>$clientes, 'title' => 'Clientes']);
    }


public function new()
{
    $data['cidades'] = (new \App\Models\Cidades())->findAll();
    $data['form'] = 'Cadastrar'; // ou 'Novo'
    $data['op'] = 'create';
    $data['title'] = 'Clientes';
    $data['clientes'] = (object)[
        'clientes_id' => '',
        'clientes_nome' => '',
        'clientes_email' => '',
        'clientes_cpf' => '',
        'clientes_telefone' => '',
        'clientes_data_nasc' => '',
        'endereco' => '',
        'cidade_id' => '',
        'usuario_id' => ''
        
    ];
    $data['usuarios'] = (new \App\Models\Usuarios())->findAll();
    return view('clientes/form', $data);
}

    public function create()
    {
        $um = new Usuarios();
        $cpf = $this->request->getPost('clientes_cpf');
        $existingUser = $um->where('usuarios_cpf', $cpf)->first();
        if ($existingUser) {
            return redirect()->back()->with('msg', 'CPF já cadastrado.')->withInput();
        }
        
        $uid = $um->insert([
    'usuarios_nome'      => $this->request->getPost('clientes_nome'),
    'usuarios_email'     => $this->request->getPost('clientes_email'),
    'usuarios_sobrenome' => $this->request->getPost('clientes_sobrenome'),
    'usuarios_cpf'       => $this->request->getPost('clientes_cpf'),
    'usuarios_fone'      => $this->request->getPost('clientes_telefone'),
    'usuarios_nivel'     => 0, // Nível de usuário para cliente
    // 'usuarios_nivel'     => $this->request->getPost('usuarios_nivel'), // Nível de usuário para cliente
    'usuarios_data_cadastro' => date('Y-m-d H:i:s'),
    'usuarios_senha'     => password_hash($this->request->getPost('clientes_senha'), PASSWORD_DEFAULT),
    'usuarios_data_nasc' => $this->request->getPost('clientes_data_nasc'),
        ]);

        // 2) Cria cliente
        (new ClienteModel())->insert([
            'usuario_id'=>$uid,
            'endereco'=>$this->request->getPost('endereco'),
            'cidade_id'=>$this->request->getPost('cidade_id')
        ]);
        //verify if cpf already exists
        // Se tudo estiver correto, redireciona para a lista de clientes
        return redirect()->to('/clientes');
    }
    public function edit($id)
    {
        $cliente = (new ClienteModel())
        ->select('clientes.*,usuarios.usuarios_sobrenome as clientes_sobrenome, usuarios.usuarios_nome as clientes_nome, usuarios.usuarios_cpf as clientes_cpf, usuarios.usuarios_fone as clientes_telefone, usuarios.usuarios_email as clientes_email, usuarios.usuarios_data_nasc as clientes_data_nasc')
        ->join('usuarios', 'usuarios.usuarios_id = clientes.usuario_id')
        ->where('cliente_id', $id)
        ->first();
    $data['usuarios'] = (new \App\Models\Usuarios())->findAll();
    $data['clientes'] = $cliente;
    $data['form'] = 'Alterar';
    $data['op'] = 'update';
    $data['title'] = 'Clientes';

    return view('clientes/form', $data);
    }
    
    public function delete($id)
{
    $um = new Usuarios();
    $um->delete($id);
    (new ClienteModel())->where('usuario_id', $id)->delete();
    return redirect()->to('/clientes');
}
public function search()
{
    $clientes = new ClienteModel();
    $nomeOuCpf = $this->request->getGet('nome_ou_cpf');
    
    if ($nomeOuCpf) {
        $clientes = $clientes->like('clientes_nome', $nomeOuCpf)
                             ->orLike('clientes_cpf', $nomeOuCpf);
    }
    
    $data['clientes'] = $clientes
        ->select('clientes.*, usuarios.usuarios_nome, usuarios.usuarios_sobrenome, usuarios.usuarios_cpf, usuarios.usuarios_fone, usuarios.usuarios_email')
        ->join('usuarios', 'usuarios.usuarios_id = clientes.usuario_id')
        ->findAll();
    $data['title'] = 'Clientes';
    
    return view('clientes/index', $data);}
}
?>