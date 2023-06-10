<?php


class Emprestimo extends model{

    //PEGA LISTA DE EMPRESTIMOS DA COMPANIA
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

    //PEGA A LISTA DE CLIENTES DA COMPANIA
    public function getListNome($id_company){
        $array = array();
        $sql = $this->db->prepare("SELECT name, id FROM clients WHERE id_company = :id_company ");
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();
        $array = $sql->fetchAll();
    
        return $array;
    }
    public function getListNomeUnique($id, $id_company){
        $array = array();
        $sql = $this->db->prepare("SELECT * FROM clients WHERE id_company = :id_company AND id = :id");
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();
        $array = $sql->fetchAll();
    
        return $array;
    }

    public function getInfo($id, $id_company) {
		$array = array();

		$sql = $this->db->prepare("SELECT * FROM emprestimo WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(":id", $id);
		$sql->bindValue(":id_company", $id_company);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetch();
		}

		return $array;
	}

    ///PEGA O EMPRESTIMO PELO ID
    public function getEmprestimo($id, $id_company){
        $array = array();
        $sql = $this->db->prepare("SELECT * FROM emprestimo WHERE id = :id AND id_company = :id_company");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();
        $array = $sql->fetch();
    }

    //PEGA O ID DO CLIENTE PELO ID DO PRODUTO
    public function getIdClient($id, $id_company) {

		$sql = $this->db->prepare("SELECT id_client FROM emprestimo WHERE id = :id AND id_company = :id_company");
		$sql->bindValue(":id", $id);
		$sql->bindValue(":id_company", $id_company);
		$sql->execute();

		return $sql;
	}

    //ADICIONA UM EMPRESTIMO A UM CLIENTE
    public function add($id_company, $id_client, $valor_emprestimo, $juros_mes, $data_emprestimo, $recebido, $meses_pagos, $juros_sc){
        $sql = $this->db->prepare("INSERT INTO emprestimo 
                                   SET id_client = :id_client, id_company = :id_company,
                                   valor_emprestimo = :valor_emprestimo, juros_mes = :juros_mes, data_emprestimo = :data_emprestimo, 
                                   recebido = :recebido, qtd_mensalidade = :qtd_mensalidade, juros_sc = :juros_sc");
        $sql->bindValue(':id_client',$id_client);
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':valor_emprestimo', $valor_emprestimo);
        $sql->bindValue(':juros_mes', $juros_mes);
        $sql->bindValue(':data_emprestimo', $data_emprestimo);
        $sql->bindValue(':qtd_mensalidade', $meses_pagos);
        $sql->bindValue(':recebido', $recebido);
        $sql->bindValue(':juros_sc', $juros_sc);
        $sql->execute();
        
    }
    public function edit($id, $id_company, $id_client, $valor_emprestimo, $juros_mes, $data_emprestimo, $recebido, $meses_pagos){
        $sql = $this->db->prepare("UPDATE emprestimo SET id_client = :id_client, valor_emprestimo = :valor_emprestimo, juros_mes = :juros_mes, data_emprestimo = :data_emprestimo, recebido = :recebido, qtd_mensalidade = :qtd_mensalidade WHERE id = :id AND id_company = :id_company");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':id_client', $id_client);
        $sql->bindValue(':valor_emprestimo', $valor_emprestimo);
        $sql->bindValue(':juros_mes', $juros_mes);
        $sql->bindValue(':qtd_mensalidade', $meses_pagos);
        $sql->bindValue(':data_emprestimo', $data_emprestimo);
        $sql->bindValue(':recebido', $recebido);
        $sql->execute();
    }      
    public function quitar($id, $id_company, $id_client, $valor_emprestimo, $data_emprestimo, $juros_mes, $recebido, $mensalidade, $qtd_mensalidade, $juros_sc){
        $sql = $this->db->prepare("UPDATE emprestimo SET id_client = :id_client, valor_emprestimo = :valor_emprestimo, juros_mes = :juros_mes, recebido = :recebido, data_emprestimo = :data_emprestimo, mensalidade = :mensalidade, qtd_mensalidade = :qtd_mensalidade, juros_sc = :juros_sc WHERE id = :id AND id_company = :id_company");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':id_client', $id_client);
        $sql->bindValue(':valor_emprestimo', $valor_emprestimo);
        $sql->bindValue(':juros_mes', $juros_mes);
        //$sql->bindValue(':total_pago', $total_pago);
        $sql->bindValue(':data_emprestimo', $data_emprestimo);
        $sql->bindValue(':recebido', $recebido);
        $sql->bindValue(':juros_sc', $juros_sc);
        $sql->bindValue(':qtd_mensalidade', $qtd_mensalidade);
        $sql->bindValue(':mensalidade', $mensalidade);
        $sql->execute();
    }
    public function mensalidade($id, $id_company, $id_client, $valor_emprestimo, $juros_mes, $data_emprestimo, $total_pago, $mensalidade, $meses_pagos){
        $sql = $this->db->prepare("UPDATE emprestimo SET id_client = :id_client, valor_emprestimo = :valor_emprestimo, juros_mes = :juros_mes, data_emprestimo = :data_emprestimo, recebido = :recebido, mensalidade = :mensalidade, qtd_mensalidade = :qtd_mensalidade  WHERE id = :id AND id_company = :id_company");
        $sql->bindValue(':id', $id);
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':id_client', $id_client);
        $sql->bindValue(':valor_emprestimo', $valor_emprestimo);
        $sql->bindValue(':juros_mes', $juros_mes);
        $sql->bindValue(':data_emprestimo', $data_emprestimo);
        $sql->bindValue(':recebido', $total_pago);
        $sql->bindValue(':qtd_mensalidade', $meses_pagos);
        $sql->bindValue(':mensalidade', $mensalidade);
        $sql->execute();
    }
}