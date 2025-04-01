<?php
class emprestimoController extends Controller {

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
            
            $client = new Clients();
            foreach ($data['emprestimo_list'] as $emprestimo) {
                $clientInfo = $client->getInfo($emprestimo['id_client'], $u->getCompany());
                $data['client_name'] = $clientInfo['name'];
            }

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
    
            if(isset($_POST['valor']) && !empty($_POST['id_cliente'])) {
        $id = addslashes($_POST['id_cliente']);
        $valor = addslashes($_POST['valor']);
        $juros = addslashes($_POST['juros']);
        $juros_sc = addslashes($_POST['juros_sc']);

        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        $valor = floatval($valor);

        $divida = $valor; // Inicia devendo o valor total
        $meses_pagos = 0;
        $dataemprestimo = date('Y-m-d');
        
        if($juros_sc == 'simples'){
            $juros_sc = true;
            $emp->add($u->getCompany(), $id, $valor, $juros, $dataemprestimo, $divida, $meses_pagos, true);
        }
        else if($juros_sc == 'composto'){
            $juros_sc = false;
            $emp->add($u->getCompany(), $id, $valor, $juros, $dataemprestimo, $divida, $meses_pagos, false);
        }   
        
        header("Location: ".BASE_URL."/emprestimo");
        exit();
    }
    
            if($data['clients_list'] < 1){
                $data['error_msg'] = "Nenhum cliente cadastrado";
            }
            
            $this->loadTemplate('emprestimo_add', $data);
        } 
    }
    
    public function quitar($id) {
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $company = new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();
        $data['id_company'] = $company->getId();
    
        if($u->hasPermission('emprestimo_quitar')) {
            $emp = new Emprestimo();
            $data['client_info'] = $emp->getInfo($id, $u->getCompany());
    
            if(isset($_POST['valor_emprestimo']) && !empty($_POST['juros_mes'])) {
                // Get all POST data with proper sanitization
                $id_company = (int)$_POST['id_company'];
                $id_client = (int)$_POST['id_client'];
                $juros_mes = (float)$_POST['juros_mes'];
                $juros_sc = (int)$_POST['juros_sc'];
                $data_emprestimo = $_POST['data_emprestimo'];
                $qtd_mensalidade = (int)$_POST['qtd_mensalidade'];
                $recebido = (float)$_POST['recebido'];
                $select = $_POST['select'];
                
                // Format value properly
                $valor_emprestimo = str_replace(['.', ','], ['', '.'], $_POST['valor_emprestimo']);
                $valor_emprestimo = (float)$valor_emprestimo;
                
                // Initialize variables
                $total_mensalidade = 0;
                $meses_pagos = (int)$_POST['meses_pagos'];
                $valor_pago = 0;
                
                // Calculate based on payment type
                if($select == "sim") { // Mensalidade
                    $meses_pagos = (int)$_POST['meses_pagos'];
                    
                    if($juros_sc == 0) { // Juros composto
                        $taxa_juros = $juros_mes / 100;
                        $data_atual = new DateTime(date('Y-m-d'));
                        $data_inicial = new DateTime(date('Y-m-d', strtotime($data_emprestimo)));
                        $intervalo = $data_inicial->diff($data_atual);
                        $diferenca_meses = $intervalo->m + ($intervalo->y * 12);
    
                        if($diferenca_meses > $qtd_mensalidade) {
                            $a = $valor_emprestimo * $taxa_juros;
                            $quitacao_mes = $diferenca_meses - $qtd_mensalidade;
                            $montante = $valor_emprestimo * pow(1 + $taxa_juros, $quitacao_mes);
                            $juros_total = $montante - $valor_emprestimo;
                            $total_mensalidade = $juros_total + $a;
                        } else {
                            $total_mensalidade = $valor_emprestimo * $taxa_juros;
                        }
                    } else { // Juros simples
                        $total_mensalidade = $valor_emprestimo * ($juros_mes / 100);
                    }
                    
                    // Add monthly payment if exists
                    if(isset($_POST['mensalidade']) && !empty($_POST['mensalidade'])) {
                        $mensalidade = (float)str_replace(['.', ','], ['', '.'], $_POST['mensalidade']);
                        $total_mensalidade += $mensalidade;
                    }
                    
                    // Update total paid
                    $total_pago = $recebido;
                    
                    // Update months paid
                    $meses_pagos = $qtd_mensalidade + $meses_pagos;
                    
                    // Call the method to update in database
                    $emp->mensalidade(
                        $id, 
                        $id_company, 
                        $id_client, 
                        $valor_emprestimo, 
                        $juros_mes, 
                        $data_emprestimo, 
                        $total_pago, 
                        $total_mensalidade, 
                        $meses_pagos, 
                        $valor_emprestimo
                    );
                    
                } else if($select == "nao") { // Pagamento direto
                    $valor_pago = (float)str_replace(['.', ','], ['', '.'], $_POST['valor']);
                    $total_pago = $recebido + $valor_pago;
                    $valor_emprestimo -= $valor_pago;
                    
                    // Call the method to update in database
                    $emp->quitar(
                        $id, 
                        $id_company, 
                        $id_client, 
                        $valor_emprestimo, 
                        $data_emprestimo, 
                        $juros_mes, 
                        $total_pago, 
                        isset($_POST['mensalidade']) ? (float)$_POST['mensalidade'] : 0, 
                        $qtd_mensalidade, 
                        $juros_sc
                    );
                }
                
                header("Location: ".BASE_URL."/emprestimo");
                exit();
            }
            
            $this->loadTemplate('quitar', $data);
        }
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

                $valor_emprestimo = str_replace('.', '', $valor_emprestimo);
                $valor_emprestimo = str_replace(',', '.', $valor_emprestimo);

                $valor_emprestimo = floatval($valor_emprestimo);
                $juros_mes = addslashes($_POST['juros_mes']);
                $id_client = addslashes($_POST['id_client']);
                $data_emprestimo = addslashes($_POST['data_emprestimo']);
                $id_company = addslashes($_POST['id_company']);
                $recebido = addslashes($_POST['recebido']);
                $meses_pagos = addslashes($_POST['meses_pagos']);

                $emp->edit($id, $id_company, $id_client, $valor_emprestimo, $juros_mes, $data_emprestimo, $recebido, $meses_pagos);
                header("Location: ".BASE_URL."/emprestimo");  
                 
            }
        }
    }
}
