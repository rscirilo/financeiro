<?php


class Emprestimo extends model{
    public function getList($offset, $id_company){
        $array = array();


        $sql = $this->db->prepare("SELECT * FROM emprestimo WHERE id_company = :id_company LIMIT $offset,10");
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll();
        }
        return $array;
    }
    public function getListNome($id_company){
        $array = array();
        $sql = $this->db->prepare("SELECT name, id FROM clients WHERE id_company = :id_company ");
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();
        $array = $sql->fetchAll();
    
        return $array;
    }

    public function add($id_company, $id_client, $valor_emprestimo, $juros_mes, $data_emprestimo, $recebido){
        $sql = $this->db->prepare("INSERT INTO emprestimo 
                                   SET id_client = :id_client, id_company = :id_company,
                                   valor_emprestimo = :valor_emprestimo, juros_mes = :juros_mes, data_emprestimo = :data_emprestimo, 
                                   recebido = :recebido");
        $sql->bindValue(':id_client',$id_client);
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':valor_emprestimo', $valor_emprestimo);
        $sql->bindValue(':juros_mes', $juros_mes);
        $sql->bindValue(':data_emprestimo', $data_emprestimo);
        $sql->bindValue(':recebido', $recebido);
        $sql->execute();
        
    }
    
        
}