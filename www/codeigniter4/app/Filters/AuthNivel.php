<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthNivel implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $login = session()->get('login');
        $nivel = $login->usuarios_nivel ?? null;


        if (!$login) {
            session()->set('redirect_after_login', current_url());
            return redirect()->to('/login')->with('msg', 'Faça login para acessar!');
        }

        if ($arguments) {
            $permitidos=[];
            foreach($arguments as $arg){
                foreach(explode(',',$arg)as $n){
                    $permitidos[]=trim($n);
                }
            }
            // Se o nível do usuário NÃO estiver na lista de permitidos, bloqueia
            if (!in_array($nivel, $permitidos)) {
                return service('response')
                    ->setStatusCode(400)
                    ->setBody(view('errors/html/error_400', [
                        'title' => 'Acesso Negado',
                        'message' => 'Você não tem permissão para acessar esta página.'
                    ]));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Não precisa de nada aqui
    }
}