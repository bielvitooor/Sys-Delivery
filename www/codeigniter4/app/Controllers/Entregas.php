<?php
namespace App\Controllers;
use App\Models\Entrega as EntregaModel;
use App\Models\Vendas as VendaModel;
use App\Models\Funcionarios as FuncionarioModel;
use App\Models\Itens_pedido as ItensPedidos;

class Entregas extends BaseController
{
    public function index()
    {
        $login = session()->get('login');
        switch ($login->usuarios_nivel ?? null) {
            case 1:
                $template = 'Templates_admin';
                break;
            case 3:
                $template = 'Templates_funcionario';
                break;
            case 0:
                $template = 'Templates_user';
                break;
            default:
                $template = 'Templates';
        }
        $data['template'] = $template;
        $data['entregas'] = (new EntregaModel())
            ->select('entregas.*, vendas.venda_id, usuarios.usuarios_nome, usuarios.usuarios_sobrenome, entregas.data_saiu_entrega, entregas.data_entrega, entregas.status')
            ->join('vendas', 'vendas.venda_id = entregas.venda_id')
            ->join('funcionarios', 'funcionarios.funcionario_id = entregas.funcionario_id')
            ->join('usuarios', 'usuarios.usuarios_id = funcionarios.usuario_id')
            ->findAll();

        return view('entregas/index', $data);
    }

    public function new()
    {
        $login = session()->get('login');
        switch ($login->usuarios_nivel ?? null) {
            case 1:
                $template = 'Templates_admin';
                break;
            case 3:
                $template = 'Templates_funcionario';
                break;
            case 0:
                $template = 'Templates_user';
                break;
            default:
                $template = 'Templates';
        }
        $data['template'] = $template;
        $entregas = (new \App\Models\Entrega())->select('venda_id')->findAll();
        $vendasComEntrega = array_column($entregas, 'venda_id');

        // Busca apenas vendas que ainda não têm entrega
        $vendaModel = new VendaModel();
        if (!empty($vendasComEntrega)) {
            $vendaModel->whereNotIn('venda_id', $vendasComEntrega);
        }
        $data['vendas'] = $vendaModel->findAll();

        $data['funcionarios'] = (new FuncionarioModel())
            ->select('funcionarios.*, usuarios.usuarios_nome')
            ->join('usuarios', 'usuarios.usuarios_id = funcionarios.usuario_id')
            ->findAll();
        $data['form'] = 'Cadastrar';
        $data['op'] = 'create';
        return view('entregas/form', $data);
    }

    public function create()
    {
        $status = $this->request->getPost('status');
        $data
            = [
                'venda_id' => $this->request->getPost('venda_id'),
                'funcionario_id' => $this->request->getPost('funcionario_id'),
                'status' => $status,
            ];
        if ($status === 'Entregue') {
            $data['data_entrega'] = date('Y-m-d H:i:s');
        }
        if ($status === 'Saiu para Entrega') {
            $data['data_saiu_entrega'] = date('Y-m-d H:i:s');
        }
        $entregaModel = new EntregaModel();
        $entregaModel->insert($data);

        return redirect()->to('/entregas');
    }
    public function edit($id)
    {
        $login = session()->get('login');
        switch ($login->usuarios_nivel ?? null) {
            case 1:
                $template = 'Templates_admin';
                break;
            case 3:
                $template = 'Templates_funcionario';
                break;
            case 0:
                $template = 'Templates_user';
                break;
            default:
                $template = 'Templates';
        }
        $data['template'] = $template;
        $entregaModel = new EntregaModel();
        $data['entrega'] = $entregaModel->find($id);
        if (!$data['entrega']) {
            return redirect()->to('/entregas');
        }

        $data['vendas'] = (new VendaModel())->findAll();
        $data['funcionarios'] = (new FuncionarioModel())
            ->select('funcionarios.*, usuarios.usuarios_nome')
            ->join('usuarios', 'usuarios.usuarios_id = funcionarios.usuario_id')
            ->findAll();
        $data['form'] = 'Editar';
        $data['op'] = 'update';

        return view('entregas/form', $data);
    }

    public function update()
    {
        $entregaModel = new EntregaModel();
        $entrega_id = $this->request->getPost('entrega_id');
        $nova_status = $this->request->getPost('status');

        // Busca o registro atual
        $entrega = $entregaModel->find($entrega_id);

        $data = [
            'venda_id' => $this->request->getPost('venda_id'),
            'funcionario_id' => $this->request->getPost('funcionario_id'),
            'status' => $nova_status,
        ];

        // Só atualiza a data_saiu_entrega se mudou para "Saiu para Entrega" e ainda não tinha data
        if ($nova_status === 'Saiu para Entrega') {
            $data['data_saiu_entrega'] = date('Y-m-d H:i:s');
        }
        if ($nova_status === 'Entregue' && empty($entrega->data_entrega)) {
            $data['data_entrega'] = date('Y-m-d H:i:s');
        }

        $entregaModel->update($entrega_id, $data);
        return redirect()->to('/entregas');
    }
    public function delete($id)
    {
        $entregaModel = new EntregaModel();
        $entregaModel->delete($id);
        return redirect()->to('/entregas');
    }
}