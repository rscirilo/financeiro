<?php
class emprestimoController extends controller {

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

        if($u->hasPermission('emprestimo_view')) {
            $emp = new Emprestimo();
            $offset = 0;

            $data['emprestimo_list'] = $emp->getList($offset, $u->getCompany());
            
            $data['edit_permission'] = $u->hasPermission('emprestimo_edit');
            $data['add_permission'] = $u->hasPermission('emprestimo_add');
            
            $this->LoadTemplate('emprestimo',$data);
            }
            else {
                header("Location: ".BASE_URL);
            }
        // $this->loadTemplate('emprestimo', $data);
    }
    public function add() {
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $company = new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();
        $data['id_company'] = $company->getId();
        

        if($u->hasPermission('emprestimo_add')) {
            $emp = new Emprestimo();
            $data['clients_list'] = $emp->getListNome($u->getCompany());
            if($data['clients_list'] < 1){
                echo "vazio";}
                $this->loadTemplate('emprestimo_add', $data);

            if(isset($_POST['valor']) && !empty($_POST['id_cliente'])) {
                $id = addslashes($_POST['id_cliente']);
                $valor = addslashes($_POST['valor']);
                $juros = addslashes($_POST['juros']);
                $divida = 0;
                $dataemprestimo = date('Y-m-d');
                $emp->add($u->getCompany(), $id, $valor, $juros, $dataemprestimo, $divida);
                echo $id;
            }
            
        } 
    }
    public function quitar(){
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $company = new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();
        $data['id_company'] = $company->getId();

        if($u->hasPermission('emprestimo_edit')){
            $emp = new Emprestimo();
            $data['clients_list'] = $emp->getListNome($u->getCompany());
            if($data['clients_list'] < 1){
                echo "vazio";}
                $this->loadTemplate('quitar', $data);
        }
    }
    public function editar(){
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $company = new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();
        $data['id_company'] = $company->getId();

        if($u->hasPermission('emprestimo_edit')){
            $emp = new Emprestimo();
            $data['clients_list'] = $emp->getListNome($u->getCompany());
            if($data['clients_list'] < 1){
                echo "vazio";}
                $this->loadTemplate('emprestimo_edit', $data);
        }
    }
}
