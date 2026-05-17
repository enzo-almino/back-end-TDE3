<?php

require_once __DIR__ . '/../models/PacoteModel.php';

class PacoteController
{
    private PacoteModel $model;

    public function __construct(PDO $pdo)
    {
        if (empty($_SESSION['usuario_id'])) {
            header('Location: index.php?route=auth&action=login');
            exit;
        }
        $this->model = new PacoteModel($pdo);
    }

    private function exigirAdmin(): void
    {
        if (($_SESSION['nivel_acesso'] ?? '') !== 'admin') {
            header('Location: index.php?route=pacotes');
            exit;
        }
    }

    private function validarPrecoMinimo(array $dados): ?string
    {
        $transporte = $dados['tipo_transporte'];
        $preco = (float) $dados['preco'];
        $vagasTotais = (int) $dados['vagas_totais'];
        $idaVolta = !empty($dados['data_volta']);

        if ($transporte === 'Cruzeiro') {
            if (!$idaVolta) {
                return 'Cruzeiro só permite viagens de ida e volta.';
            }
            if ($vagasTotais < 100) {
                return 'Cruzeiro deve ter no mínimo 100 vagas totais.';
            }
            if ($preco < 440) {
                return 'O preço mínimo para cruzeiro (ida e volta) é R$ 440,00.';
            }
        } elseif ($transporte === 'Avião') {
            if ($vagasTotais < 100) {
                return 'Avião deve ter no mínimo 100 vagas totais.';
            }
            if ($idaVolta && $preco < 350) {
                return 'O preço mínimo para avião (ida e volta) é R$ 350,00.';
            }
            if (!$idaVolta && $preco < 150) {
                return 'O preço mínimo para avião (somente ida) é R$ 150,00.';
            }
        } elseif ($transporte === 'Ônibus') {
            if ($vagasTotais < 20) {
                return 'Ônibus deve ter no mínimo 20 vagas totais.';
            }
            if ($idaVolta && $preco < 210) {
                return 'O preço mínimo para ônibus (ida e volta) é R$ 210,00.';
            }
            if (!$idaVolta && $preco < 120) {
                return 'O preço mínimo para ônibus (somente ida) é R$ 120,00.';
            }
        }

        return null;
    }

    public function index(): void
    {
        $pacotes = $this->model->listarTodos();
        require __DIR__ . '/../views/pacotes/listar.php';
    }

    public function criar(): void
    {
        $this->exigirAdmin();
        $erro = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'titulo'            => $_POST['titulo'],
                'descricao'         => $_POST['descricao'] ?? null,
                'tipo_transporte'   => $_POST['tipo_transporte'],
                'preco'             => $_POST['preco'],
                'vagas_totais'      => (int) $_POST['vagas_totais'],
                'vagas_disponiveis' => (int) $_POST['vagas_disponiveis'],
                'data_ida'          => $_POST['data_ida'],
                'data_volta'        => !empty($_POST['data_volta']) ? $_POST['data_volta'] : null,
                'imagem_url'        => $_POST['imagem_url'] ?? null,
            ];

            if ($dados['vagas_disponiveis'] > $dados['vagas_totais']) {
                $erro = 'Vagas disponíveis não podem ser maiores que as vagas totais.';
            } elseif ($dados['data_volta'] && (strtotime($dados['data_volta']) - strtotime($dados['data_ida'])) < 3600) {
                $erro = 'A data de volta deve ser pelo menos 1 hora após a data de ida.';
            } else {
                $erro = $this->validarPrecoMinimo($dados);
            }

            if (!$erro) {
                $this->model->criar($dados);
                header('Location: index.php?route=pacotes');
                exit;
            }
        }

        require __DIR__ . '/../views/pacotes/criar.php';
    }

    public function editar(): void
    {
        $this->exigirAdmin();
        $erro = null;
        $id = (int) ($_GET['id'] ?? 0);
        $pacote = $this->model->buscarPorId($id);

        if (!$pacote) {
            header('Location: index.php?route=pacotes');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'titulo'            => $_POST['titulo'],
                'descricao'         => $_POST['descricao'] ?? null,
                'tipo_transporte'   => $_POST['tipo_transporte'],
                'preco'             => $_POST['preco'],
                'vagas_totais'      => (int) $_POST['vagas_totais'],
                'vagas_disponiveis' => (int) $_POST['vagas_disponiveis'],
                'data_ida'          => $_POST['data_ida'],
                'data_volta'        => !empty($_POST['data_volta']) ? $_POST['data_volta'] : null,
                'imagem_url'        => $_POST['imagem_url'] ?? null,
            ];

            if ($dados['vagas_disponiveis'] > $dados['vagas_totais']) {
                $erro = 'Vagas disponíveis não podem ser maiores que as vagas totais.';
            } elseif ($dados['data_volta'] && (strtotime($dados['data_volta']) - strtotime($dados['data_ida'])) < 3600) {
                $erro = 'A data de volta deve ser pelo menos 1 hora após a data de ida.';
            } else {
                $erro = $this->validarPrecoMinimo($dados);
            }

            if (!$erro) {
                $this->model->atualizar($id, $dados);
                header('Location: index.php?route=pacotes');
                exit;
            }
        }

        require __DIR__ . '/../views/pacotes/editar.php';
    }

    public function excluir(): void
    {
        $this->exigirAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=pacotes');
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);
        $this->model->excluir($id);
        header('Location: index.php?route=pacotes');
        exit;
    }
}
