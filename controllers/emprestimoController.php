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
                header("Location: ".BASE_URL."/emprestimo");  
            }
            
        } 
    }
    public function quitar($id){
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $company = new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();

        if($u->hasPermission('emprestimo_quitar')){
            $emp = new Emprestimo();
        }
        $data['clients_list'] = $emp->getInfo($id, $u->getCompany());

        
        if(isset($_POST['valor_emprestimo']) && !empty($_POST['juros_mes'])) {
            $valor_emprestimo = (int) addslashes($_POST['valor_emprestimo']);
            $juros_mes = (int) addslashes($_POST['juros_mes']);
            $id_client = addslashes($_POST['id_client']);
            $data_emprestimo = addslashes($_POST['data_emprestimo']);
            $id_company = addslashes($_POST['id_company']);
            $total_pago = (int) addslashes($_POST['recebido']) + (int) addslashes($_POST['valor']);


            $mensalidade = (int) addslashes($_POST['mensalidade']);
            $total_mensalidade = 0;
            $meses_pagos =(int) addslashes($_POST['meses_pagos']);

            $total_mensalidade = $meses_pagos * ($valor_emprestimo * ($juros_mes/100));
                if($mensalidade > 0){
                    $total_mensalidade = $total_mensalidade + $mensalidade;}

            if($_POST['select'] == "nao"){
                
                $emp->quitar($id, $id_company, $id_client, $valor_emprestimo, $juros_mes, $data_emprestimo, $total_pago, $emprestimo);
                header("Location: ".BASE_URL."/emprestimo");  
            }
            else if($_POST['select'] == "sim"){
                
                
                $emp->mensalidade($id, $id_company, $id_client, $valor_emprestimo, $juros_mes, $data_emprestimo, $total_pago, $total_mensalidade);
                header("Location: ".BASE_URL."/emprestimo");
            }
        }
        
        $data['client_info'] = $emp->getInfo($id, $u->getCompany());
        $this->loadTemplate('quitar', $data);
    }
    public function editar($id){
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $company = new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();
        $data['id_company'] = $company->getId();


        if($u->hasPermission('emprestimo_edit')){
            $emp = new Emprestimo();
            $data['emp_info'] = $emp->getInfo($id, $u->getCompany());

            
            $this->loadTemplate('emprestimo_edit', $data);
            if(isset($_POST['valor_emprestimo']) && !empty($_POST['juros_mes'])) {
                $valor_emprestimo = addslashes($_POST['valor_emprestimo']);
                $juros_mes = addslashes($_POST['juros_mes']);
                $id_client = addslashes($_POST['id_client']);
                $data_emprestimo = addslashes($_POST['data_emprestimo']);
                $id_company = addslashes($_POST['id_company']);
                $recebido = addslashes($_POST['recebido']);

                $emp->edit($id, $id_company, $id_client, $valor_emprestimo, $juros_mes, $data_emprestimo, $recebido);
                header("Location: ".BASE_URL."/emprestimo");  
                 
            }
        }
    }
}
