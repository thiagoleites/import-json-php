<?php

//Função genérica para inserir dados
function create($tabela, array $data){
    global $connect;
    $campos = implode(', ', array_keys($data));
    $valores = "'".implode("', '", $data)."'";
    $query = "INSERT INTO {$tabela} ({$campos}) VALUES ({$valores})";
    return mysqli_query($connect, $query) or die ('Erro ao inserir dados em '.$tabela.' '.mysqli_error($connect));
}

//Função leitura no banco de dados
function read($tabela, $cond = null) {
    global $connect;
    $query = "SELECT * FROM {$tabela} {$cond}";
    $result = mysqli_query($connect, $query) or die ('Erro ao ler dados de '.$tabela.' '.mysqli_error($connect));
    while($res = mysqli_fetch_assoc($result)){
        $data[] = $res;
    }
    return $data;
}

//Função para atualizar dados
function update($tabela, array $data, $cond) {
    global $connect;
    foreach ($data as $chave => $valor) {
        $campos[] = "{$chave} = '{$valor}'";
    }
    $campos = implode(', ', $campos);
    $query = "UPDATE {$tabela} SET {$campos} WHERE {$cond}";
    return mysqli_query($connect, $query) or die ('Erro ao atualizar dados em '.$tabela.' '.mysqli_error($connect));
}

//Função para deletar dados
function delete($tabela, $where) {
  global $connect;
  $query = "DELETE FROM {$tabela} WHERE {$where}";
  $delete = mysqli_query($connect, $query) or die ('Erro ao deletar dados de '.$tabela.' '.mysqli_error($connect));
}