<?php 

class Estatistica extends Model{
    public function pegarTodosClientes($id_company){
        $array = array();
        $sql = $this->db->prepare("SELECT * FROM clients WHERE id_company = :id_company");
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();
    
        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }
        return $array;
    }
    public function pegarTodosEmprestimos($id_company){
        $array = array();
        $sql = $this->db->prepare("SELECT * FROM emprestimo WHERE id_company = :id_company");
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();
    
        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }
        return $array;
    }
}