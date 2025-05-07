<?php
require_once 'C:\Turma2\xampp\htdocs\Projeto-de-Vida---Roberto\MVC\Model.php\Model.php';

class Controller
{
    private $Model;

    public function __construct($pdo)
    {
        // Passa o PDO para o modelo
        $this->Model = new Model($pdo);
    }

    public function sobre_mim($user_id, $sobre_mim)
    {
        return $this->Model->sobremim($user_id, $sobre_mim);
    }

    public function salvarQuemSou(
        $user_id, $fale_sobre_voce, $minhas_lembrancas, $pontos_fortes, $pontos_fracos, $meus_valores, 
        $minhas_aptidoes, $meus_relacionamentos, $o_que_gosto, $o_que_nao_gosto, $rotina_lazer_estudos, 
        $minha_vida_escolar, $visao_fisica, $visao_intelectual, $visao_emocional, $visao_pessoas_sobre_mim, 
        $autovalorizacao
    ) {
        return $this->Model->salvarQuemSou(
            $user_id, $fale_sobre_voce, $minhas_lembrancas, $pontos_fortes, $pontos_fracos, $meus_valores, 
            $minhas_aptidoes, $meus_relacionamentos, $o_que_gosto, $o_que_nao_gosto, $rotina_lazer_estudos, 
            $minha_vida_escolar, $visao_fisica, $visao_intelectual, $visao_emocional, $visao_pessoas_sobre_mim, 
            $autovalorizacao
        );
    }

    // Método que chama o Model para listar os dados
    public function listarQuemSou($user_id) {
        return $this->Model->listarQuemSou($user_id);
    }
}
?>