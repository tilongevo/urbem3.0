<?php
/**
 * Created by PhpStorm.
 * User: longevo
 * Date: 27/07/16
 * Time: 15:40
 */

namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Licitacao;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Normas\NormaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\JulgamentoItemModel;

class EditalModel extends AbstractModel
{
    const COD_MODULO = 2;

    protected $entityManager = null;

    /**
     * @var \Urbem\CoreBundle\Repository\Patrimonio\Licitacao\EditalRepository $repository
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Licitacao\\Edital");
    }

    public function getParticipantesByLicitacao($filtros)
    {
        return $this->repository->getParticipantesByLicitacao($filtros);
    }

    public function getEditalPassivelImpugnacao($filtros)
    {
        return $this->repository->getEditalPassivelImpugnacao($filtros);
    }

    public function getEditalPassivelSuspensao($filtros)
    {
        return $this->repository->getEditalPassivelSuspensao($filtros);
    }


    public function getEditalPassivelAnulacaoImpugnacao($filtros)
    {
        return $this->repository->getEditalPassivelAnulacaoImpugnacao($filtros);
    }

    public function getEditaisDiposniveisParaAtaEncerramento($ids = null)
    {
        return $this->repository->getEditalParaAtasEncerramento($ids);
    }

    public function isConfigsSugestaoDescricaoParaAta($exercicio)
    {
        try {
            $this->getConfigsSugestaoDescricaoParaAta($exercicio);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getConfigsSugestaoDescricaoParaAta($exercicio)
    {
        $configuracaoModel = new ConfiguracaoModel($this->entityManager);
        $config = [];
        $config[] = $configuracaoModel->pegaConfiguracao('tipo_logradouro', self::COD_MODULO, $exercicio)[0]['valor'];
        $config[] = $configuracaoModel->pegaConfiguracao('cod_municipio', self::COD_MODULO, $exercicio)[0]['valor'];
        $config[] = $configuracaoModel->pegaConfiguracao('logradouro', self::COD_MODULO, $exercicio)[0]['valor'];
        $config[] = $configuracaoModel->pegaConfiguracao('numero', self::COD_MODULO, $exercicio)[0]['valor'];
        return $config;
    }

    /**
     * @param Licitacao\Edital $edital
     * @param array $params
     * @param null|string $exercicio
     * @return mixed|string
     */
    public function getSugestaoDescricaoParaAta(Licitacao\Edital $edital, array $params, $exercicio = null)
    {
        $exercicio = is_null($exercicio) ? date('Y') : $exercicio;

        $julgamentoItemModel = new JulgamentoItemModel($this->entityManager);
        $configuracaoModel = new ConfiguracaoModel($this->entityManager);
        $normaModel = new NormaModel($this->entityManager);

        $text = <<<EOT
[#data_extenso], às [#horario] horas, na sala de licitações do Município de [#municipio], na [#tipo_logradouro] [#logradouro], n.° [#numero], reuniu-se à Comissão Permanente de Licitações nomeada pela portaria n.º [#norma], a fim de proceder à abertura [#modalidade] [#licitacao], destinado a aquisição do(s) seguinte(s) item(ns): 
EOT;

        list($resTipoLogradouro,
             $resCodMunicipio,
             $resLogradouro,
             $resNumero
        ) = $this->getConfigsSugestaoDescricaoParaAta($exercicio);

        /**
         * @var SwMunicipio $swMunicipio
         */
        $swMunicipio = $this->entityManager
            ->getRepository(SwMunicipio::class)
            ->findOneBy([
                'codMunicipio' => $resCodMunicipio,
            ]);

        $norma = $normaModel->getNormaByLicitacao($edital->getFkLicitacaoLicitacao());

        $params['#tipo_logradouro'] = $resTipoLogradouro;
        $params['#logradouro'] = $resLogradouro;
        $params['#modalidade'] = $edital->getFkLicitacaoLicitacao()->getCodModalidade();
        $params['#licitacao'] = "{$edital->getFkLicitacaoLicitacao()->getCodLicitacao()}/{$edital->getFkLicitacaoLicitacao()->getExercicio()}";
        $params['#municipio'] = $swMunicipio->getNomMunicipio();
        $params['#numero'] = $resNumero;
        $params['#norma'] = "{$norma['num_norma']}/{$norma['exercicio']}";

        $items = $julgamentoItemModel->getItensDeFonecedoresQueGanharam($edital);

        if ($items != false) {
            $textItem = <<<EOT
\n
[Item] - [#item]     
[Marca] - [#marca] 
[Valor] - [#valor] 
[Vencedor] -  [#vencedor]
EOT;


            foreach ($items as $item) {
                $textItem = str_replace("[#vencedor]", $item['nom_cgm'], $textItem);
                $textItem = str_replace("[#valor]", $item['vl_total'], $textItem);
                $textItem = str_replace("[#marca]", $item['marca'], $textItem);
                $textItem = str_replace("[#item]", $item['descricao_resumida'], $textItem);

                $text .= $textItem;
            }
        }

        foreach ($params as $key => $value) {
            $text = str_replace("[{$key}]", $value, $text);
        }

        return $text;
    }

    /**
     * @param int        $codMapa
     * @param string|int $exercicio
     *
     * @return array
     */
    public function recuperaItensEditalComComplemento($codMapa, $exercicio)
    {
        $itens = $this->repository->recuperaItensEdital($codMapa, $exercicio);

        foreach ($itens as &$item) {
            $itemComplemento = '';
            $complementos = $this->repository->montaRecuperaComplementoItemMapa($codMapa, $item['cod_item'], $exercicio, $item['cod_entidade']);

            foreach ($complementos as $complemento) {
                $itemComplemento = empty($complemento['complemento']) || is_null($complemento['complemento']) ? '' : $itemComplemento . PHP_EOL . $complemento['complemento'];
            }

            $item['complemento'] = $itemComplemento;
            $item['quantidade'] = number_format($item['quantidade'], 4, ',', '.');
        }

        return $itens;
    }

    /**
     * @param $codMapa
     * @param $exercicio
     *
     * @return array
     */
    public function montaRecuperaDotacaoEdital($codMapa, $exercicio)
    {
        return $this->repository->montaRecuperaDotacaoEdital($codMapa, $exercicio);
    }

    /**
     * @param $codMapa
     * @param $exercicio
     * @param $codEntidade
     * @param $codLicitacao
     *
     * @return array
     */
    public function montaRecuperaDocumentosLicitacao($codMapa, $exercicio, $codEntidade, $codLicitacao)
    {
        return $this->repository->montaRecuperaDocumentosLicitacao($codMapa, $exercicio, $codEntidade, $codLicitacao);
    }

    /**
     * @return mixed
     */
    public function getEditalELicitacaoNaoAnulados($params)
    {
        return $this->repository->getEditalELicitacaoNaoAnulados($params);
    }
}
