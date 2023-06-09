<?php
class homeController extends Controller {

    public function __construct() {
        parent::__construct();

        $u = new Users();
        if($u->isLogged() == false) {
            header("Location: ".BASE_URL."/login");
            exit;
        }
    }

    public function index(){
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $company = new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();

        
        if($u->hasPermission('home_view')){
            $stc = new Estatistica();

            $data['quantidade_clientes'] = $stc->pegarTodosClientes($u->getCompany());
            $data['quantidade_emprestimos'] = $stc->pegarTodosEmprestimos($u->getCompany());

        }$this->loadTemplate('home', $data);
    }

}