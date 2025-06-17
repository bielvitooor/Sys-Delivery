<?php

namespace App\Controllers;
use App\Models\Usuarios as Usuarios_model;
use App\Models\Enderecos as Enderecos_model;
use App\Models\Cidades as Cidades_model;

class Usuarios extends BaseController
{
    private $usuarios;
    private $enderecos;
    private $cidades;
    public function __construct()
    {
        $this->usuarios = new Usuarios_model();
        $this->enderecos = new Enderecos_model();
        $this->cidades = new Cidades_model();
        $data['title'] = 'Usuarios';
        helper('functions');
    }
    public function index(): string
    {
        $data['title'] = 'Usuarios';
        $data['usuarios'] = $this->usuarios->findAll();
        return view('usuarios/index', $data);
    }

    public function new(): string
    {

        $data['title'] = 'Usuarios';
        $data['op'] = 'create';
        $data['form'] = 'cadastrar';
        $data['usuarios'] = (object) [
            'usuarios_nome' => '',
            'usuarios_sobrenome' => '',
            'usuarios_email' => '',
            'usuarios_cpf' => '',
            'usuarios_senha' => '',
            'usuarios_fone' => '',
            'usuarios_data_nasc' => '',
            'usuarios_id' => '',
            'usuarios_logradouro' => '',
            'usuarios_numero' => '',
            'usuarios_complemento' => '',
            'usuarios_cep' => '',
            'usuarios_cidades_id' => '',
            'usuarios_bairro' => '',
        ];
        $data['cidades'] = $this->cidades->findAll();
        return view('usuarios/form', $data);
    }
    public function create()
    {
        $login = session()->get('login');
        $usuario_nivel = isset($login->usuarios_nivel) ? $login->usuarios_nivel : null;
        $cliente_id_logado = isset($login->usuarios_id) ? $login->usuarios_id : null;

        if ($usuario_nivel != 1) {
            // Cliente comum: sempre usa o id da sessão
            $cliente_id = $cliente_id_logado;
        } else {
            // Admin: pega do form
            $cliente_id = $this->request->getPost('cliente_id');
        }
        // Verifica se já existe usuário com o mesmo e-mail
        $email = $_REQUEST['usuarios_email'];
        $cpf = $_REQUEST['usuarios_cpf'];
        if ($this->usuarios->where('usuarios_email', $email)->first()) {
            $data['msg'] = msg('E-mail já cadastrado!', 'danger');
            $data['usuarios'] = (object) $_REQUEST;
            $data['title'] = 'Usuarios';
            $data['form'] = 'Cadastrar';
            $data['op'] = 'create';
            $data['cidades'] = $this->cidades->findAll();
            return view('usuarios/form', $data);
        }
        // Verifica se já existe usuário com o mesmo CPF (opcional)
        if ($this->usuarios->where('usuarios_cpf', $cpf)->first()) {
            $data['msg'] = msg('CPF já cadastrado!', 'danger');
            $data['usuarios'] = (object) $_REQUEST;
            $data['title'] = 'Usuarios';
            $data['form'] = 'Cadastrar';
            $data['op'] = 'create';
            $data['cidades'] = $this->cidades->findAll();
            return view('usuarios/form', $data);
        }
        // Checks whether the submitted data passed the validation rules.
        if (
            !$this->validate([
                'usuarios_nome' => 'required|max_length[255]|min_length[3]',
                'usuarios_sobrenome' => 'required',
                'usuarios_cpf' => 'required',
                'usuarios_email' => 'required',
                'usuarios_senha' => 'required',
                'usuarios_fone' => 'required',
                'usuarios_data_nasc' => 'required',

            ])
        ) {

            // The validation fails, so returns the form.
            $data['usuarios'] = (object) [
                'usuarios_id' => '',
                'usuarios_nome' => $_REQUEST['usuarios_nome'],
                'usuarios_sobrenome' => $_REQUEST['usuarios_sobrenome'],
                'usuarios_email' => $_REQUEST['usuarios_email'],
                'usuarios_cpf' => moedaDolar($_REQUEST['usuarios_cpf']),
                'usuarios_data_nasc' => moedaDolar($_REQUEST['usuarios_data_nasc']),
                'usuarios_senha' => $_REQUEST['usuarios_senha'],
                'usuarios_fone' => $_REQUEST['usuarios_fone']
            ];

            $data['title'] = 'Usuarios';
            $data['form'] = 'Cadastrar';
            $data['op'] = 'create';
            return view('usuarios/form', $data);
        }


        $this->usuarios->save([
            'usuarios_nome' => $_REQUEST['usuarios_nome'],
            'usuarios_sobrenome' => $_REQUEST['usuarios_sobrenome'],
            'usuarios_email' => $_REQUEST['usuarios_email'],
            'usuarios_cpf' => $_REQUEST['usuarios_cpf'],
            'usuarios_data_nasc' => $_REQUEST['usuarios_data_nasc'],
            'usuarios_senha' => md5(string: $_REQUEST['usuarios_senha']),
            'usuarios_fone' => $_REQUEST['usuarios_fone'],
            'usuarios_nivel' => $_REQUEST['usuarios_nivel'] ?? 0,
        ]);
        $getIdUser = $this->usuarios->where('usuarios_cpf', $_REQUEST['usuarios_cpf'])->first()->usuarios_id;
        if (($_REQUEST['usuarios_nivel'] ?? 0) == 0) {
            $clientsModel = new \App\Models\Clientes();
            $clientsModel->insert([
                'usuario_id' => $getIdUser,
            ]);
        }
        if (($_REQUEST['usuarios_nivel'] ?? 0) == 3) {
            $funcionariosModel = new \App\Models\Funcionarios();
            $funcionariosModel->insert([
                'usuario_id' => $getIdUser,
                'cargo' => $_REQUEST['usuarios_cargo'] ?? ''
            ]);
        }


        //$getIdUser = $this->usuarios->find(['usuarios_cpf' => (int) $_REQUEST['usuarios_cpf']])[0]->usuarios_id;
        $this->enderecos->save([
            'usuarios_id' => $getIdUser,
            'logradouro' => $_REQUEST['usuarios_logradouro'],
            'numero' => $_REQUEST['usuarios_numero'],
            'bairro' => $_REQUEST['usuarios_bairro'],
            'complemento' => $_REQUEST['usuarios_complemento'],
            'cep' => $_REQUEST['usuarios_cep'],
            'cidades_id' => $_REQUEST['usuarios_cidades_id'],
            'status' => 1
        ]);

        $data['msg'] = msg('Cadastrado com Sucesso!', 'success');
        $data['usuarios'] = $this->usuarios->findAll();
        $data['title'] = 'Usuarios';
        return view('usuarios/index', $data);

    }

    public function delete($id)
    {
        $this->usuarios->where('usuarios_id', (int) $id)->delete();
        $data['msg'] = msg('Deletado com Sucesso!', 'success');
        $data['usuarios'] = $this->usuarios->findAll();
        $data['title'] = 'Usuarios';
        return view('usuarios/index', $data);
    }

    public function edit($id)
    {
         $login = session()->get('login');
    $usuario_nivel = isset($login->usuarios_nivel) ? $login->usuarios_nivel : null;
    $usuario_id_logado = isset($login->usuarios_id) ? $login->usuarios_id : null;

    // Só admin ou o próprio usuário pode editar
    if ($usuario_nivel != 1 && $usuario_id_logado != $id) {
        // Não autorizado
         return service('response')
                ->setStatusCode(403)
                ->setBody(view('errors/html/error_400', [
                    'title' => 'Acesso Negado',
                    'message' => 'Você não tem permissão para editar esse usuário.'
                ]));
    }
        $usuario = $this->usuarios->where('usuarios_id', (int) $id)->first();
        $endereco = $this->enderecos->where('usuarios_id', (int) $id)->first();

        // Preenche os campos de endereço no objeto usuário
        $usuario->usuarios_logradouro = $endereco->logradouro ?? '';
        $usuario->usuarios_numero = $endereco->numero ?? '';
        $usuario->usuarios_bairro = $endereco->bairro ?? '';
        $usuario->usuarios_complemento = $endereco->complemento ?? '';
        $usuario->usuarios_cep = $endereco->cep ?? '';
        $usuario->usuarios_cidades_id = $endereco->cidades_id ?? '';
        $data['usuarios'] = $usuario;
        $data['title'] = 'Usuarios';
        $data['form'] = 'Alterar';
        $data['op'] = 'update';
        $data['cidades'] = $this->cidades->findAll();
        return view('usuarios/form', $data);
    }

    public function update()
    {
        $dataForm = [
            'usuarios_id' => $_REQUEST['usuarios_id'],
            'usuarios_nome' => $_REQUEST['usuarios_nome'],
            'usuarios_sobrenome' => $_REQUEST['usuarios_sobrenome'],
            'usuarios_email' => $_REQUEST['usuarios_email'],
            'usuarios_cpf' => $_REQUEST['usuarios_cpf'],
            'usuarios_data_nasc' => $_REQUEST['usuarios_data_nasc'],
            'usuarios_fone' => $_REQUEST['usuarios_fone'],
            'usuarios_nivel' => $_REQUEST['usuarios_nivel'] ?? 0,
            'usuarios_logradouro' => $_REQUEST['usuarios_logradouro'],
            'usuarios_numero' => $_REQUEST['usuarios_numero'],
            'usuarios_complemento' => $_REQUEST['usuarios_complemento'],
            'usuarios_bairro' => $_REQUEST['usuarios_bairro'],
            'usuarios_cep' => $_REQUEST['usuarios_cep'],
            'usuarios_cidades_id' => $_REQUEST['usuarios_cidades_id'],
            
            
        ];
        if(!empty($_REQUEST['usuarios_senha']) && $_REQUEST['usuarios_senha'] != $this->usuarios->find($_REQUEST['usuarios_id'])->usuarios_senha) {
            // If the password is provided and is different from the current one, hash it
            $dataForm['usuarios_senha'] = md5($_REQUEST['usuarios_senha']);
        }
        

        $this->usuarios->update($_REQUEST['usuarios_id'], $dataForm);
        //verify if user already have a address, if dont have
        $endereco = $this->enderecos->where('usuarios_id', (int) $_REQUEST['usuarios_id'])->first();
        if (!$endereco) {
            $dataFormEndereco = [
                'usuarios_id' => $_REQUEST['usuarios_id'],
                'logradouro' => $_REQUEST['usuarios_logradouro'],
                'numero' => $_REQUEST['usuarios_numero'],
                'complemento' => $_REQUEST['usuarios_complemento'],
                'bairro' => $_REQUEST['usuarios_bairro'],
                'cep' => $_REQUEST['usuarios_cep'],
                'cidades_id' => $_REQUEST['usuarios_cidades_id']
            ];
            $this->enderecos->insert($dataFormEndereco);
        }
        //if user already have a address, update it
        else {
            $dataFormEndereco = [
                'usuarios_id' => $_REQUEST['usuarios_id'],
                'logradouro' => $_REQUEST['usuarios_logradouro'],
                'numero' => $_REQUEST['usuarios_numero'],
                'complemento' => $_REQUEST['usuarios_complemento'],
                'bairro' => $_REQUEST['usuarios_bairro'],
                'cep' => $_REQUEST['usuarios_cep'],
                'cidades_id' => $_REQUEST['usuarios_cidades_id']
            ];
            $this->enderecos->update($endereco->enderecos_id, $dataFormEndereco);
        }
        //if user is a client, update the client
        if (($_REQUEST['usuarios_nivel'] ?? 0) == 0) {
            $clientsModel = new \App\Models\Clientes();
            $clientsModel->update($_REQUEST['usuarios_id'], [
                'usuario_id' => $_REQUEST['usuarios_id'],
            ]);
        }
        //if user is a employee, update the employee
        if (($_REQUEST['usuarios_nivel'] ?? 0) == 3) {
            $funcionariosModel = new \App\Models\Funcionarios();
            $funcionariosModel->update($_REQUEST['usuarios_id'], [
                'usuario_id' => $_REQUEST['usuarios_id'],
                'cargo' => $_REQUEST['usuarios_cargo'] ?? ''
            ]);
        }
        $data['msg'] = msg('Alterado com Sucesso!', 'success');
        $data['usuarios'] = $this->usuarios->findAll();
        $data['title'] = 'Usuarios';
        $login = session()->get('login');
        if (isset($login->usuarios_nivel) && $login->usuarios_nivel == 1) {
            return view('usuarios/index', $data);
        } else {
            return redirect()->to(base_url('user'))->with('msg', 'Usuário atualizado com sucesso!');
        }
        
    }

    public function search()
    {
        //$data['usuarios'] = $this->usuarios->like('usuarios_nome', $_REQUEST['pesquisar'])->find();
        $data['usuarios'] = $this->usuarios->like('usuarios_nome', $_REQUEST['pesquisar'])->orlike('usuarios_cpf', $_REQUEST['pesquisar'])->find();
        $total = count($data['usuarios']);
        $data['msg'] = msg("Dados Encontrados: {$total}", 'success');
        $data['title'] = 'Usuarios';
        return view('usuarios/index', $data);

    }

    public function edit_senha(): string
    {
        $data['usuarios'] = (object) [
            'usuarios_nova_senha' => '',
            'usuarios_confirmar_senha' => ''
        ];

        $data['title'] = 'Usuarios';
        return view('usuarios/edit_senha', $data);
    }

    public function salvar_senha()
    {

        // Checks whether the submitted data passed the validation rules.
        if (
            !$this->validate([
                'usuarios_senha_atual' => 'required',
                'usuarios_nova_senha' => 'required|max_length[14]|min_length[6]',
                'usuarios_confirmar_senha' => 'required|max_length[14]|min_length[6]'
            ])
        ) {

            // The validation fails, so returns the form.
            $data['usuarios'] = (object) [
                'usuarios_senha_atual' => $_REQUEST['usuarios_senha_atual'],
                'usuarios_nova_senha' => $_REQUEST['usuarios_nova_senha'],
                'usuarios_confirmar_senha' => $_REQUEST['usuarios_confirmar_senha']
            ];
            $data['title'] = 'Usuarios';
            $data['msg'] = msg("Divergência de dados ou a senha deve ter no mínimo 6 digitos!", "danger");
            return view('usuarios/edit_senha', $data);
        }

        $data['usuarios'] = (object) [
            'usuarios_senha_atual' => $_REQUEST['usuarios_senha_atual'],
            'usuarios_nova_senha' => $_REQUEST['usuarios_nova_senha'],
            'usuarios_confirmar_senha' => $_REQUEST['usuarios_confirmar_senha']
        ];

        $data['check_senha'] = $this->usuarios->find(['usuarios_id' => (int) $_REQUEST['usuarios_id']])[0];

        if ($data['check_senha']->usuarios_senha == md5($_REQUEST['usuarios_senha_atual'])) {
            if ($_REQUEST['usuarios_nova_senha'] == $_REQUEST['usuarios_confirmar_senha']) {

                $dataForm = [
                    'usuarios_id' => $_REQUEST['usuarios_id'],
                    'usuarios_senha' => md5($_REQUEST['usuarios_nova_senha'])
                ];

                $this->usuarios->update($_REQUEST['usuarios_id'], $dataForm);
                $login = session()->get('login');
                $usuario_nivel = isset($login->usuarios_nivel) ? $login->usuarios_nivel : null;
                $data['msg'] = msg('Senha alterada!', 'success');
                $data['usuarios'] = $this->usuarios->findAll();
                $data['title'] = 'Usuarios';
                if ($usuario_nivel == 1) {
                    return view('usuarios/index', $data);
                } else {
                    return redirect()->to(base_url('user'))->with('msg', 'Senha alterada com sucesso!');
                }
                


            } else {
                $data['title'] = 'Usuarios';
                $data['msg'] = msg("As senhas não são iguais!", "danger");
                return view('usuarios/edit_senha', $data);
            }

        } else {
            $data['title'] = 'Usuarios';
            $data['msg'] = msg("A senha atual é invalida", "danger");
            return view('usuarios/edit_senha', $data);
        }
    }

    public function edit_nivel(): string
    {
        $data['nivel'] = [
            ['id' => 0, 'nivel' => "Usuário"],
            ['id' => 1, 'nivel' => "Administrador"],
            ['id' => 2, 'nivel' => "Supervisor"]
        ];

        $data['usuarios'] = $this->usuarios->findAll();
        $data['title'] = 'Usuarios';


        $data['usuarios'] = $this->usuarios->findAll();
        $data['title'] = 'Usuarios';
        return view('usuarios/edit_nivel', $data);
    }

    public function salvar_nivel(): string
    {

        $dataForm = [
            'usuarios_id' => $_REQUEST['usuarios_id'],
            'usuarios_nivel' => $_REQUEST['usuarios_nivel']
        ];

        $this->usuarios->update($_REQUEST['usuarios_id'], $dataForm);
        $data['msg'] = msg('Nivel alterada!', 'success');
        $data['usuarios'] = $this->usuarios->findAll();
        $data['title'] = 'Usuarios';
        return view('usuarios/index', $data);
    }
    public function searchNomeOuCpf(): string
    {
        $data['usuarios'] = $this->usuarios->like('usuarios_nome', $_REQUEST['pesquisar'])->orlike('usuarios_cpf', $_REQUEST['pesquisar'])->find();
        $total = count($data['usuarios']);
        $data['msg'] = msg("Dados Encontrados: {$total}", 'success');
        $data['title'] = 'Usuarios';
        return view('usuarios/index', $data);
    }

}
