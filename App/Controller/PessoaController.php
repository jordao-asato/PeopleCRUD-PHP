<?php

namespace App\Controller;

use App\Model\PessoaModel;

/**
 * Classes Controller são responsáveis por processar as requisições do usuário.
 * Isso significa que toda vez que um usuário chama uma rota, um método (função)
 * de uma classe Controller é chamado.
 * O método poderá devolver uma View (fazendo um include), acessar uma Model (para
 * buscar algo no banco de dados), redirecionar o usuário de rota, ou mesmo,
 * chamar outra Controller.
 */
class PessoaController extends Controller {
// cada método aqui será responsável por uma rota, e são estáticos

    /**
     * Os métodos index serão usados para devolver uma View.
     */
    public static function index()
    {
        // juntar model e view 
        
        $model = new PessoaModel();
        $model->getAllRows(); // obtendos todos os registros, abastecendo a propriedade
                             // $rows da model

        parent::render('Pessoa/ListaPessoa', $model);
        //include 'View/modules/Pessoa/ListaPessoa.php'; // propriedade $rows da Model pode
                                                      // ser acessafa na View
    }

    // Devolve uma View contendo um formulário para o usuário
    public static function form() {

        $model = new PessoaModel();

        // Se existir GET id...
        if (isset($_GET['id'])) 
            $model = $model->getById((int) $_GET['id']); // typecast: superglobal GET para int

        parent::render('Pessoa/FormPessoa', $model);
    }

    // Preenche um Model para que seja enviado ao banco de dados para salvar
    public static function save() {

        $model = new PessoaModel();

        // preenche as propriedades com os dados que vieram do formulário
        $model->id = $_POST['id'];
        $model->nome = $_POST['nome'];
        $model->cpf = $_POST['cpf'];
        $model->data_nascimento = $_POST['data_nascimento'];

        // salva
        $model->save();

        // redireciona
        header("Location: /pessoa");

    }

    public static function delete()
    {
        $model = new PessoaModel();

        $model->delete( (int) $_GET['id']);

        // redireciona
        header("Location: /pessoa");
    }

}