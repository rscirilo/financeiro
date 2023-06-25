<?php
// construção do view e permissão de acesso a página//
class exemploController extends Controller{

    public function __construct() {
        parent::__construct();

        $u = new Users();
        if($u->isLogged() == false) {
            header("Location: ".BASE_URL."/login");
            exit;
        }
    }

    public function index() {
        $data = array();
        $u = new Users();
        $u->setLoggedUser();
        $company = new Companies($u->getCompany());
        $data['company_name'] = $company->getName();
        $data['user_email'] = $u->getEmail();

        if($u->hasPermission('exemplo_view')) {
            
            $this->loadTemplate('exemplo', $data);
        } else {
            header("Location: ".BASE_URL);
        }
    }
}
// fim da construção do view//