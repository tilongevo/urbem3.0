<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Patrimonio;

use Doctrine\ORM;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Orcamento\Orgao;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Entity\Organograma\OrgaoNivel;
use Urbem\CoreBundle\Entity\Patrimonio;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\UploadHelper;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Contabilidade\PlanoAnaliticaModel;
use Urbem\CoreBundle\Model\Empenho\EmpenhoModel;
use Urbem\CoreBundle\Model\Orcamento\UnidadeModel;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Repository;

/**
 * Class BemModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Patrimonio
 */
class BemModel extends AbstractModel
{
    /** @var ORM\EntityManager|null $entityManager */
    protected $entityManager = null;

    /** @var Repository\Patrimonio\BemRepository repository */
    protected $repository = null;

    /**
     * BemModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Patrimonio\Bem::class);
    }

    public function canRemove($object)
    {
        $bemBaixadoRepository = $this->entityManager->getRepository("CoreBundle:Patrimonio\\BemBaixado");
        $res = $bemBaixadoRepository->findOneByCodBem($object->getCodBem());

        return is_null($res);
    }

    public function getBensDisponiveis($id)
    {
        return $this->repository->getBemDisponiveis($id);
    }

    /**
     * @param $paramsWhere
     */
    public function getBemDisponiveisJson($paramsWhere)
    {
        return $this->repository->getBemDisponiveisJson($paramsWhere);
    }

    public function getApoliceBem($id)
    {
        return $this->repository->getApoliceBem($id);
    }

    public function removeApoliceBem($id)
    {
        return $this->repository->removeApoliceBem($id);
    }

    public function montaRecuperaDadosUltimoOrgao($vigencia, $cod_orgao)
    {
        return $this->repository->montaRecuperaDadosUltimoOrgao($vigencia, $cod_orgao);
    }

    public function montaRecuperaSaldoBem($id)
    {
        return $this->repository->montaRecuperaSaldoBem($id);
    }

    public function getBemComManutencaoAgendada()
    {
        return $this->repository->getBemComManutencaoAgendada();
    }

    public function getBemComClassificacao()
    {
        return $this->repository->getBemComClassificacao();
    }

    public function findOneByCodBem($codBem)
    {
        return $this->repository->findOneByCodBem($codBem);
    }

    /**
     * Constroi um Bem de acordo com a regra de negocio de lancamento de materiais
     * Ref.: PRMovimentacaoOrdemCompra.php linhas 457 ~ 517
     *
     * @param Almoxarifado\LancamentoMaterial $lancamentoMaterial
     * @param Almoxarifado\CatalogoItem $catalogoItem
     * @param boolean $identificacao
     * @param string $numPlaca
     * @return Patrimonio\Bem
     */
    public function buildOneBemFromLancamentoMaterial(
        Almoxarifado\LancamentoMaterial $lancamentoMaterial,
        Almoxarifado\CatalogoItem $catalogoItem,
        $identificacao,
        $numPlaca
    ) {
        $bem = new Patrimonio\Bem();

        $bem->setCodNatureza(0);
        $bem->setCodEspecie(0);
        $bem->setCodGrupo(0);

        $bem->setDescricao($catalogoItem->getDescricaoResumida());
        $bem->setDetalhamento($catalogoItem->getDescricao());

        $bem->setDtAquisicao(new \DateTime());

        $valorBem = $lancamentoMaterial->getValorMercado() / $lancamentoMaterial->getQuantidade();
        $bem->setVlBem($valorBem);
        $bem->setVlDepreciacao(0);
        $bem->setIdentificacao($identificacao);
        $bem->setNumPlaca($numPlaca);

        return $bem;
    }

    /**
     * @return array|string
     */
    public function getAvailableNumPlaca()
    {
        $getNumPlaca = $this->repository->getAvailableNumPlaca();
        return (int) $getNumPlaca->num_placa + 1;
    }

    /**
     * @return int
     */
    public function getAvailableNumPlacaAlfanumerica()
    {
        $getNumPlaca = $this->repository->getAvailableNumPlacaAlfanumerica();
        if (is_null($getNumPlaca)) {
            return (string) 'AAA0001';
        }
        return ++$getNumPlaca->num_placa;
    }

    /**
     * @param string $numPlaca
     * @return bool
     */
    public function checkNumPlacaIsAvailable($numPlaca)
    {
        $queryBuilder = $this->repository->createQueryBuilder('bem');

        $queryBuilder
            ->where($queryBuilder->expr()->like('bem.numPlaca', ':num_placa'))
            ->setParameter('num_placa', '%' . $numPlaca)
            ->setMaxResults(1);

        $res = $queryBuilder->getQuery()->getResult();

        return empty($res);
    }

    /**
     * @param Patrimonio\Bem $bem
     * @param $fkPatrimonioReavaliacao
     */
    public function saveReavaliacao(&$bem, $fkPatrimonioReavaliacao)
    {
        /** @var $reavaliacao Patrimonio\Reavaliacao */
        $reavaliacaoModel = new ReavaliacaoModel($this->entityManager);
        foreach ($fkPatrimonioReavaliacao as $reavaliacao) {
            $reavaliacao->setFkPatrimonioBem($bem);

            $codReavaliacao = $reavaliacaoModel->getProximoCodReavaliacao($bem->getCodBem());
            $reavaliacao->setCodReavaliacao($codReavaliacao);

            $this->save($reavaliacao);
        }
    }

    /**
     * @param Patrimonio\Bem $bem
     * @param Form $form
     */
    public function saveApoliceBem(&$bem, $form)
    {
        if ($form->get('assegurado')->getData()) {
            $apoliceBem = new Patrimonio\ApoliceBem();
            $apoliceBem->setFkPatrimonioBem($bem);
            $apoliceBem->setFkPatrimonioApolice($form->get('apolicesCollection')->getData());

            $bem->addFkPatrimonioApoliceBens($apoliceBem);
        }
    }

    /**
     * @param Patrimonio\Bem $bem
     * @param Form $form
     */
    public function saveBemProcesso(&$bem, $form)
    {
        if ($form->get('codProcesso')->getData()) {
            list($codAssunto, $codClassificacao) = explode('~', $form->get('codAssunto')->getData());
            list($codProcesso, $anoExercicio) = explode('~', $form->get('codProcesso')->getData());

            $processo = $this->entityManager
                ->getRepository(SwProcesso::class)
                ->findOneBy([
                    'codClassificacao' => $codClassificacao,
                    'codAssunto' => $codAssunto,
                    'codProcesso' => $codProcesso,
                    'anoExercicio' => $anoExercicio
                ]);

            $bemProcesso = $this->getBemProcesso($bem);
            $bemProcesso->setFkPatrimonioBem($bem);
            $bemProcesso->setFkSwProcesso($processo);

            $bem->setFkPatrimonioBemProcesso($bemProcesso);
        }
    }

    /**
     * @param Patrimonio\Bem $bem
     * @param Form $form
     * @param $exercicio
     */
    public function saveBemPlanoDepreciacao(&$bem, $form, $exercicio)
    {
        if ($form->get('contaContabilAcumulada')->getData()) {
            if (strpos($form->get('contaContabilAcumulada')->getData(), '~')) {
                list($params['codPlano'], $params['exercicio']) = explode('~', $form->get('contaContabilAcumulada')->getData());
            } else {
                $conta = explode(' - ', $form->get('contaContabilAcumulada')->getData());
                list($params['codPlano'], $params['exercicio']) = explode('/', $conta[0]);
            }

            $planoAnaliticaModel = new PlanoAnaliticaModel($this->entityManager);
            $objPlanoAnalitica = $planoAnaliticaModel->getPlanoAnalitica($params);

            $bemPlanoDepreciacao = new Patrimonio\BemPlanoDepreciacao();
            $bemPlanoDepreciacao->setFkPatrimonioBem($bem);
            $bemPlanoDepreciacao->setExercicio($exercicio);
            $bemPlanoDepreciacao->setFkContabilidadePlanoAnalitica($objPlanoAnalitica);

            $bem->addFkPatrimonioBemPlanoDepreciacoes($bemPlanoDepreciacao);
        }
    }

    /**
     * @param Patrimonio\Bem $bem
     * @param Form $form
     * @param $exercicio
     */
    public function saveBemPlanoAnalitica(&$bem, $form, $exercicio)
    {
        if ($form->get('depreciavel')->getData() && $form->get('contaContabil')->getData()) {
            if (strpos($form->get('contaContabil')->getData(), '~')) {
                list($params['codPlano'], $params['exercicio']) = explode('~', $form->get('contaContabil')->getData());
            } else {
                $conta = explode(' - ', $form->get('contaContabil')->getData());
                list($params['codPlano'], $params['exercicio']) = explode('/', $conta[0]);
            }

            $planoAnaliticaModel = new PlanoAnaliticaModel($this->entityManager);
            $objPlanoAnalitica = $planoAnaliticaModel->getPlanoAnalitica($params);

            $bemPlanoAnalitica = new Patrimonio\BemPlanoAnalitica();
            $bemPlanoAnalitica->setFkPatrimonioBem($bem);
            $bemPlanoAnalitica->setExercicio($exercicio);
            $bemPlanoAnalitica->setFkContabilidadePlanoAnalitica($objPlanoAnalitica);

            $bem->addFkPatrimonioBemPlanoAnaliticas($bemPlanoAnalitica);
        }
    }

    /**
     * @param Patrimonio\Bem $bem
     * @param Form $form
     * @param OrgaoNivel $orgaoNivel
     */
    public function saveHistoricoBem($bem, $form, $orgaoNivel)
    {
        if ($form->get('situacao')->getData() && $form->get('local')->getData() && !empty($orgaoNivel)) {
            $historicoBem = new Patrimonio\HistoricoBem();
            $historicoBem->setFkPatrimonioBem($bem);
            $descSituacao = '';
            if ($form->get('descSituacao')->getData()) {
                $descSituacao = $form->get('descSituacao')->getData();
            }
            $historicoBem->setDescricao($descSituacao);
            $historicoBem->setFkPatrimonioSituacaoBem($form->get('situacao')->getData());
            $historicoBem->setFkOrganogramaLocal($form->get('local')->getData());
            $historicoBem->setFkOrganogramaOrgao($orgaoNivel->getFkOrganogramaOrgao());

            $bem->addFkPatrimonioHistoricoBens($historicoBem);
        }
    }

    /**
     * @param Patrimonio\Bem $bem
     * @param Form $form
     */
    public function saveBemResponsavel(&$bem, $form)
    {
        if ($form->get('responsavel')->getData() && $form->get('dtInicialResponsavel')->getData()) {
            if (strpos($form->get('responsavel')->getData(), '-')) {
                $responsavel = explode(' - ', $form->get('responsavel')->getData());
                $responsavel = $responsavel[0];
            } else {
                $responsavel = $form->get('responsavel')->getData();
            }

            $swCgmModel = new SwCgmModel($this->entityManager);
            $cgm = $swCgmModel->findOneByNumcgm($responsavel);

            $bemResponsavel = new Patrimonio\BemResponsavel();
            $bemResponsavel->setFkPatrimonioBem($bem);
            $bemResponsavel->setFkSwCgm($cgm);
            $bemResponsavel->setDtInicio($form->get('dtInicialResponsavel')->getData());

            $bem->addFkPatrimonioBemResponsaveis($bemResponsavel);
        }
    }

    /**
     * @param Patrimonio\Bem $bem
     * @param Form $form
     */
    public function saveBemMarca($bem, $form)
    {
        if ($form->get('marca')->getData()) {
            $bemMarca = new Patrimonio\BemMarca();

            $bemMarca->setFkPatrimonioBem($bem);
            $bemMarca->setFkAlmoxarifadoMarca($form->get('marca')->getData());

            if ($bem->getFkPatrimonioBemMarca() != $bemMarca) {
                $bem->setFkPatrimonioBemMarca($bemMarca);
            }
        }
    }

    /**
     * @param Patrimonio\Bem $bem
     * @param array $atributosDinamicos
     */
    public function saveBemAtributoEspecie(&$bem, $atributosDinamicos)
    {
        $atributoDinamicoModel = new AtributoDinamicoModel($this->entityManager);

        /** @var Patrimonio\BemAtributoEspecie $atributoNormaValor */
        foreach ($bem->getFkPatrimonioBemAtributoEspecies() as $atributoNormaValor) {
            $fkAtributo = $atributoNormaValor->getFkPatrimonioEspecieAtributo();

            $valor = $atributoDinamicoModel->processaAtributoDinamicoUpdate($fkAtributo, $atributosDinamicos);

            $atributoNormaValor->setValor($valor);
        }

        $acFkAtributo = $bem->getFkPatrimonioEspecie()->getFkPatrimonioEspecieAtributos();
        $fkAtributos = [];
        foreach ($acFkAtributo as $fkAtributo) {
            $codAtributo = $fkAtributo->getCodAtributo();
            $fkAtributos[$codAtributo] = $fkAtributo;
        }

        if (count($fkAtributos)) {
            foreach ($atributosDinamicos as $codAtributo => $valorAtributo) {
                $fkAtributo = $fkAtributos[$codAtributo];

                $valor = $atributoDinamicoModel->processaAtributoDinamicoPersist($fkAtributo, $valorAtributo);

                $objFkAtributo = new Patrimonio\BemAtributoEspecie();
                $objFkAtributo->setFkPatrimonioBem($bem);
                $objFkAtributo->setFkPatrimonioEspecieAtributo($fkAtributo);
                $objFkAtributo->setValor($valor);

                $bem->addFkPatrimonioBemAtributoEspecies($objFkAtributo);
            }
        }
    }

    /**
     * @param Patrimonio\Bem $bem
     * @param Form $form
     * @param ContainerInterface $container
     */
    public function saveBemComprado(Patrimonio\Bem $bem, $form, $container)
    {

        $entidade = $form->get('entidade')->getData();
        $codEmpenho = $form->get('numEmpenho')->getData();

        $bemComprado = $this->getBemComprado($bem);
        $bemComprado->setFkPatrimonioBem($bem);
        $bemComprado->setExercicio($form->get('exercicio')->getData());
        $bemComprado->setFkOrcamentoEntidade($entidade);
        $bemComprado->setCodEmpenho($codEmpenho);
        $bemComprado->setNotaFiscal($form->get('numNotaFiscal')->getData());
        $bemComprado->setDataNotaFiscal($form->get('dtNotaFiscal')->getData());

        $unidadeModel = new UnidadeModel($this->entityManager);
        $unidade = $unidadeModel->getOneByUnidadeOrgaoExercicio(
            $this->getUnidadeFromForm($form)->getNumUnidade(),
            $this->getOrgaoFromForm($form)->getNumOrgao(),
            $form->get('exercicio')->getData()
        );
        if ($unidade) {
            $bemComprado->setFkOrcamentoUnidade($unidade);
        }

        if ($form->get('caminhoNf')->getData() !== null) {
            $servidor = $container->getParameter("patrimonialbundle");

            $upload = new UploadHelper();
            $upload->setPath($servidor['bem']);

            $upload->setFile($form->get('caminhoNf')->getData());
            $arquivo = $upload->executeUpload();
            $bemComprado->setCaminhoNf($arquivo['name']);
        }
        $bem->setFkPatrimonioBemComprado($bemComprado);

        // BemCompradoEmpenho
        $empenhoModel = new EmpenhoModel($this->entityManager);
        $empenho = $empenhoModel->getEmpenho([
            'codEntidade' => $entidade->getCodEntidade(),
            'exercicio' => $form->get('exercicio')->getData(),
            'codEmpenho' => $codEmpenho
        ]);
        if ($empenho) {
            $bemCompradoEmpenho = new Patrimonio\BemCompradoEmpenho();
            $bemCompradoEmpenho->setFkPatrimonioBem($bem);
            $bemCompradoEmpenho->setFkEmpenhoEmpenho($empenho);
            $bem->setFkPatrimonioBemCompradoEmpenho($bemCompradoEmpenho);
        }
    }

    /**
     * @param $form
     * @return Unidade
     */
    protected function getUnidadeFromForm($form)
    {
        if ($form->get('unidade')->getData()) {
            return $form->get('unidade')->getData();
        }
        return new Unidade();
    }

    /**
     * @param $form
     * @return Orgao
     */
    protected function getOrgaoFromForm($form)
    {
        if ($form->get('orgaoOrg')->getData()) {
            return $form->get('orgaoOrg')->getData();
        }
        return new Orgao();
    }

    /**
     * @param $codBem
     * @return array
     */
    public function carregaBemProprio($codBem)
    {
        return $this->repository->carregaBemProprio($codBem);
    }

    /**
     * @param Patrimonio\Bem $bem
     * @return Patrimonio\HistoricoBem
     */
    public function getHistoricoBem(Patrimonio\Bem $bem)
    {
        return $this->repository->getHistoricoBem($bem);
    }

    /**
     * @param Patrimonio\Bem $bem
     * @return Patrimonio\BemComprado
     */
    protected function getBemComprado(Patrimonio\Bem $bem)
    {
        $bemComprado = $this->entityManager
            ->getRepository(Patrimonio\BemComprado::class)
            ->findOneBy([
                'codBem' => $bem->getCodBem()
            ]);

        if ($bemComprado) {
            return $bemComprado;
        }

        return new Patrimonio\BemComprado();
    }

    /**
     * @param Patrimonio\Bem $bem
     * @return Patrimonio\BemProcesso
     */
    protected function getBemProcesso(Patrimonio\Bem $bem)
    {
        $bemProcesso = $this->entityManager
            ->getRepository(Patrimonio\BemProcesso::class)
            ->findOneBy([
                'codBem' => $bem->getCodBem()
            ]);

        if ($bemProcesso) {
            return $bemProcesso;
        }

        return new Patrimonio\BemProcesso();
    }

    /**
     * @return mixed
     */
    public function listaBensParaManutencao()
    {
        return $this->repository->listaBenParaManutencao();
    }

    /**
     * @param $paramsWhere
     * @return array
     */
    public function carregaBemResponsavelAnterior($paramsWhere)
    {
        return $this->repository->carregaBemResponsavelAnterior($paramsWhere);
    }

    /**
     * @param $paramsWhere
     * @return array
     */
    public function carregaBemResponsavel($paramsWhere)
    {
        return $this->repository->carregaBemResponsavel($paramsWhere);
    }

    /**
     * @param $numcgm
     * @return array
     */
    public function carregaDtInicioResponsavel($numcgm)
    {
        return $this->repository->carregaDtInicioResponsavel($numcgm);
    }

    /**
     * @return array
     */
    public function getBensParaManutencaoBemIdLista()
    {
        $bens = $this->listaBensParaManutencao();
        $bensArray = [];
        foreach ($bens as $bem) {
            $bensArray[] = $bem->cod_bem;
        }
        return $bensArray;
    }
}
