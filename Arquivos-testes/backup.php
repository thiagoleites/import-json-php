<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Template</title>
  <link rel="stylesheet" href="./css/styles.css">
    <style>
        .xdebug-var-dump {
            padding: 15px;
        }
        .xdebug-var-dump pre {
            border-left: 3px solid #9ca3af;
            padding-left: 15px;
        }
    </style>
</head>
<body class="bg-slate-100">
  <header class="w-[1000px] mx-auto mt-10 p-10 mb-4 border-b-4 rounded text-center text-5xl">
    <h1 class="font-bold">JSON importer</h1>
    <p class="text-slate-400 text-2xl">Importando dados através de um arquivo JSON</p>

  </header>
  <main>
    <section class="w-[980px] mx-auto p-6">
      <form action="" method="post" class="p-5">
      <div class="mb-3">
        <label class="block p-2 mb-3 font-mono mr-3">JSON file select</label>
          <input class="p-2 border rounded-md" type="file" name="json" id="json">
        </div>

        <div>
          <input class="p-2 border rounded-md bg-blue-600 hover:bg-sky-800 text-white py-3 px-4 cursor-pointer" type="submit" value="Importar">
        </div>
      </form>
    </section>
    <section class="w-[980px] mx-auto p-6">
        <?php
        // $data = 'clientes.json';
        $data = $_POST['jsonFile']['tmp_name']['name'];
        $get_value = file_get_contents($data);
        $json = json_decode($get_value, true);
        
        function isArrayJson($json_file){
          if($json_file){
            foreach($json_file as $value){
              if(is_array($value)){
                isArrayJson(($value));
              }else {
                echo $value;
              }
            }
          }
        }

          isArrayJson($json);


        // function display_list_json($json) {
        //   $list = [];
        //   foreach($json as $key => $value){
        //     foreach($value as $val) {
        //       $list[] = $val;
        //     }
        //   }
        //   return $list;
        // }
        // $list = display_list_json($json);
        // var_dump($list);
        echo "<hr class='mb-3 mt-5' />"
        ?>
      <span class="text-3xl font-semibold mb-3">Dados</span>

      <ul class="mt-4 space-y-4 lg:space-y-2 border-l border-slate-100">
        <li>
          <a class="block border-l pl-4 -ml-px border-transparent hover:border-slate-400 dark:hover:border-slate-500 text-slate-700 hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-300">
            Dados obtidos através da tabela    
          </a>
        </li>
        <li>
          <a class="block border-l pl-4 -ml-px border-transparent hover:border-slate-400 dark:hover:border-slate-500 text-slate-700 hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-300">
            Dados obtidos através da tabela    
          </a>
        </li>
        <li>
          <a class="block border-l pl-4 -ml-px border-transparent hover:border-slate-400 dark:hover:border-slate-500 text-slate-700 hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-300">
            Dados obtidos através da tabela    
          </a>
        </li>
        <li>
          <a class="block border-l pl-4 -ml-px border-transparent hover:border-slate-400 dark:hover:border-slate-500 text-slate-700 hover:text-slate-900 dark:text-slate-400 dark:hover:text-slate-300">
            Dados obtidos através da tabela    
          </a>
        </li>
      </ul>
    </section>
  </main>
</body>
</html>

foreach($json as $key => $value) {
              $sql = "INSERT INTO clientes (nome, email, telefone, endereco, cidade, estado, cep) VALUES (:nome, :email, :telefone, :endereco, :cidade, :estado, :cep)";
              $stmt = $conn->prepare($sql);
              $stmt->bindParam(':nome', $value['nome']);
              $stmt->bindParam(':email', $value['email']);
              $stmt->bindParam(':telefone', $value['telefone']);
              $stmt->bindParam(':endereco', $value['endereco']);
              $stmt->bindParam(':cidade', $value['cidade']);
              $stmt->bindParam(':estado', $value['estado']);
              $stmt->bindParam(':cep', $value['cep']);
              $stmt->execute();
            }