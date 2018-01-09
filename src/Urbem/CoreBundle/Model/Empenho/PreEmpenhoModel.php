<?php

namespace Urbem\CoreBundle\Model\Empenho;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Compras\Fornecedor;
use Urbem\CoreBundle\Entity\Empenho\AtributoEmpenhoValor;
use Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho;
use Urbem\CoreBundle\Entity\Empenho\AutorizacaoReserva;
use Urbem\CoreBundle\Entity\Empenho\CategoriaEmpenho;
use Urbem\CoreBundle\Entity\Empenho\ContrapartidaAutorizacao;
use Urbem\CoreBundle\Entity\Empenho\ContrapartidaResponsavel;
use Urbem\CoreBundle\Entity\Empenho\Historico;
use Urbem\CoreBundle\Entity\Empenho\PreEmpenho;
use Urbem\CoreBundle\Entity\Empenho\PreEmpenhoDespesa;
use Urbem\CoreBundle\Entity\Empenho\TipoEmpenho;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;
use Urbem\CoreBundle\Entity\Orcamento\Despesa;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Helper\DocumentNumberConverterHelper;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Model\Orcamento\ReservaSaldosModel;
use Urbem\CoreBundle\Repository\Empenho\PreEmpenhoRepository;

class PreEmpenhoModel extends AbstractModel
{
    /** @var ORM\EntityManager|null  */
    protected $entityManager = null;
    /** @var PreEmpenhoRepository|null  */
    protected $repository = null;
    protected $codModulo = 10;
    protected $codAtributoJoinValor = 120;
    protected $codAtributoJoinValorAno = 121;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(PreEmpenho::class);
    }

    public function getUltimoPreEmpenho($exercicio)
    {
        return $this->repository->getUltimoPreEmpenho($exercicio);
    }

    public function getUltimoNumItem($codPreEmpenho, $exercicio)
    {
        $sql = "
        SELECT COALESCE(MAX(num_item), 0) AS CODIGO
        FROM empenho.item_pre_empenho
        WHERE cod_pre_empenho = :cod_pre_empenho
        	AND exercicio = :exercicio
        ;";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue('cod_pre_empenho', $codPreEmpenho);
        $query->bindValue('exercicio', $exercicio);
        $query->execute();

        $res = $query->fetch(\PDO::FETCH_OBJ);

        return (int) $res->codigo + 1;
    }

    public function getDtAutorizacao($codEntidade, $exercicio)
    {
        $sql = "
        SELECT CASE
        		WHEN max(dt_autorizacao) < to_date('01/01/{$exercicio}', 'dd/mm/yyyy')
        			THEN '01/01/{$exercicio}'
        		ELSE to_char(max(dt_autorizacao), 'dd/mm/yyyy')
        		END AS data_autorizacao
        FROM empenho.autorizacao_empenho
        WHERE cod_entidade IN (:cod_entidade);
        ";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue('cod_entidade', $codEntidade);
        $query->execute();

        $res = $query->fetch(\PDO::FETCH_OBJ);

        if (! $res->data_autorizacao) {
            $sql = "
            SELECT exercicio
            	, cod_entidade
            	, cod_modulo
            	, parametro
            	, valor AS data_autorizacao
            FROM administracao.configuracao_entidade
            WHERE exercicio = :exercicio
            	AND cod_entidade = :cod_entidade
            	AND cod_modulo = 10
            	AND parametro = 'data_fixa_autorizacao';";

            $query = $this->entityManager->getConnection()->prepare($sql);
            $query->bindValue('cod_entidade', $codEntidade);
            $query->bindValue('exercicio', $exercicio);
            $query->execute();

            $res = $query->fetch(\PDO::FETCH_OBJ);
        }

        if ($res) {
            return $res->data_autorizacao;
        } else {
            return '';
        }
    }

    public function getDotacaoOrcamentaria($exercicio, $numcgm, $codEntidade, $sonata = false)
    {
        $despesas = $this->entityManager->getRepository("CoreBundle:Empenho\PreEmpenho")
        ->getDotacaoOrcamentaria($exercicio, $numcgm, $codEntidade);

        $lista = array();
        foreach ($despesas as $despesa) {
            if ($sonata) {
                $lista[$despesa->cod_despesa . " - " . $despesa->descricao] = $despesa->cod_despesa;
            } else {
                $lista[$despesa->cod_despesa] = $despesa->cod_despesa . " - " . $despesa->descricao;
            }
        }

        return $lista;
    }

    public function getDesdobramento($codDespesa, $exercicio, $sonata = false)
    {
        $sql = "
        SELECT DISTINCT D.cod_conta
        	, CD.cod_estrutural
        	, D.dt_criacao
        	, publico.fn_mascarareduzida(CD.cod_estrutural) AS mascara_reduzida
        	, CD.descricao
        FROM orcamento.despesa AS D
        	, orcamento.conta_despesa AS CD
        WHERE D.cod_conta = CD.cod_conta
        	AND D.exercicio = CD.exercicio
        	AND D.cod_despesa = :cod_despesa
        	AND D.exercicio = :exercicio
        ";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('cod_despesa', $codDespesa);
        $query->execute();

        $codEstrutural = $query->fetch(\PDO::FETCH_OBJ);

        $sql = "
        SELECT conta_despesa.cod_estrutural
        	, conta_despesa.cod_conta
        	, publico.fn_mascarareduzida(conta_despesa.cod_estrutural) AS mascara_reduzida
        	, conta_despesa.descricao
        FROM orcamento.conta_despesa
        WHERE conta_despesa.exercicio = :exercicio
        	AND publico.fn_mascarareduzida(conta_despesa.cod_estrutural) LIKE publico.fn_mascarareduzida(:cod_estrutural) || '%'
        ORDER BY conta_despesa.cod_estrutural
        	, conta_despesa.cod_conta
        ";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('cod_estrutural', $codEstrutural->cod_estrutural);
        $query->execute();

        $desdobramentos = $query->fetchAll(\PDO::FETCH_OBJ);

        $desdobramentoChoices = array();
        foreach ($desdobramentos as $desdobramento) {
            if ($sonata) {
                $desdobramentoChoices[$desdobramento->cod_estrutural . " - " . $desdobramento->descricao] = $desdobramento->cod_estrutural;
            } else {
                $desdobramentoChoices[$desdobramento->cod_estrutural] = $desdobramento->cod_estrutural . " - " . $desdobramento->descricao;
            }
        }

        return $desdobramentoChoices;
    }

    /**
     * @param string $exercicio
     * @param int $codDespesa
     * @param string $dataEmpenho
     * @param int $codEntidade
     * @return float
     */
    public function getSaldoDotacaoDataAtual($exercicio, $codDespesa, $dataEmpenho, $codEntidade)
    {
        return (float) $this->repository->getSaldoDotacaoDataAtual($exercicio, $codDespesa, $dataEmpenho, $codEntidade);
    }

    public function getSaldoDotacao($stExercicio, $inCodDespesa, $stDataEmpenho, $inEntidade, $locale = 'pt_BR')
    {
        $fmt = new \NumberFormatter($locale, \NumberFormatter::DECIMAL);

        $saldoDotacao = $this->entityManager->getRepository("CoreBundle:Empenho\PreEmpenho")
        ->getSaldoDotacao($stExercicio, $inCodDespesa, $stDataEmpenho, $inEntidade);

        return $fmt->format($saldoDotacao->saldo_anterior);
    }

    public function getOrgaoOrcamentario($exercicio, $codEntidade, $numcgm, $sonata = false)
    {
        $orgaos = $this->entityManager->getRepository("CoreBundle:Empenho\PreEmpenho")
        ->getOrgaoOrcamentario($exercicio, $codEntidade, $numcgm);

        $lista = array();
        foreach ($orgaos as $orgao) {
            if ($sonata) {
                $lista[$orgao->nom_orgao] = $orgao->num_orgao;
            } else {
                $lista[$orgao->num_orgao] = $orgao->nom_orgao;
            }
        }

        return $lista;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $numcgm
     * @param $codDespesa
     * @return mixed
     */
    public function getOrgaoOrcamentarioDespesa($exercicio, $codEntidade, $numcgm, $codDespesa)
    {
        return $this->entityManager->getRepository("CoreBundle:Empenho\PreEmpenho")
            ->getOrgaoOrcamentarioDespesa($exercicio, $codEntidade, $numcgm, $codDespesa);
    }

    public function getUnidadeOrcamentaria($codEntidade, $numOrgao, $sonata = false)
    {
        $unidades = $this->entityManager->getRepository("CoreBundle:Empenho\PreEmpenho")
        ->getUnidadeOrcamentaria($codEntidade, $numOrgao);

        $lista = array();
        foreach ($unidades as $unidade) {
            if ($sonata) {
                $lista[$unidade->nom_unidade] = $unidade->num_unidade;
            } else {
                $lista[$unidade->num_unidade] = $unidade->nom_unidade;
            }
        }

        return $lista;
    }
    
    public function getUnidadeNumOrgao($exercicio, $numOrgao, $sonata = false)
    {
        $unidades = $this->entityManager->getRepository("CoreBundle:Orcamento\Unidade")
        ->getUnidadeNumOrgao($exercicio, $numOrgao);

        $lista = array();
        foreach ($unidades as $unidade) {
            if ($sonata) {
                $lista[$unidade->nom_unidade] = $unidade->num_unidade;
            } else {
                $lista[$unidade->num_unidade] = $unidade->nom_unidade;
            }
        }

        return $lista;
    }

    public function getContraPartida($exercicio, $numcgm, $sonata = false)
    {
        $contas = $this->entityManager->getRepository("CoreBundle:Empenho\PreEmpenho")
        ->getContraPartida($exercicio, $numcgm);

        $lista = array();
        foreach ($contas as $conta) {
            if ($sonata) {
                $lista[$conta->conta_contrapartida . " - " . $conta->nom_conta] = $conta->conta_contrapartida;
            } else {
                $lista[$conta->conta_contrapartida] = $conta->conta_contrapartida . " - " . $conta->nom_conta;
            }
        }

        return $lista;
    }

    /**
     * @return array
     */
    public function getAtributosDinamicos()
    {
        return $this->repository->getAtributosDinamicos();
    }

    /**
     * @param integer $codItem
     * @return array
     */
    public function getUnidadeMedidaByItem($codItem)
    {
        /** @var CatalogoItem $catalogoItem */
        $catalogoItem = $this->entityManager->getRepository(CatalogoItem::class)->find($codItem);
        $unidadeMedida = $catalogoItem->getFkAdministracaoUnidadeMedida();
        return array(
            'codUnidade' => $unidadeMedida->getCodUnidade(),
            'codGrandeza' => $unidadeMedida->getCodGrandeza(),
            'codigoComposto' => $unidadeMedida->getCodigoComposto(),
            'nomUnidade' => $unidadeMedida->getNomUnidade(),
            'simbolo' => $unidadeMedida->getSimbolo()
        );
    }


    /**
     * @param integer $codItem
     * @return string
     */
    public function getUnidadeMedida($codItem)
    {
        /** @var CatalogoItem $catalogoItem */
        $catalogoItem = $this->entityManager->getRepository('CoreBundle:Almoxarifado\CatalogoItem')
            ->findOneByCodItem($codItem);

        $unidadeMedida = $catalogoItem->getFkAdministracaoUnidadeMedida();

        return $unidadeMedida->__toString();
    }

    public function getItemPreEmpenhoByPreEmpenho($codPreEmpenho, $exercicio)
    {
        $sql = "
        SELECT ipe.*
        FROM empenho.item_pre_empenho ipe
        WHERE ipe.cod_pre_empenho = :cod_pre_empenho
        	AND ipe.exercicio = :exercicio;";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue(':cod_pre_empenho', $codPreEmpenho, \PDO::PARAM_INT);
        $query->bindValue(':exercicio', $exercicio);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $object
     * @param $formData
     * @return mixed
     */
    public function getSaldoAnterior($object, $formData)
    {
        return $this->entityManager->getRepository(PreEmpenho::class)
            ->getSaldoDotacao(
                $object->getExercicio(),
                $object->getFkEmpenhoPreEmpenhoDespesa()->getCodDespesa(),
                $formData->get('dtEmpenho')->getData()->format("d/m/Y"),
                $formData->get('codEntidade')->getData()->getCodEntidade()
            );
    }

    /**
     * @param AutorizacaoEmpenho $autorizacaoEmpenho
     * @param Unidade $unidade
     * @param $formData
     */
    public function manterAutorizacaoEmpenho($autorizacaoEmpenho, $unidade, $formData)
    {
        $autorizacaoEmpenho->setFkOrcamentoEntidade($formData->get('codEntidade')->getData());
        $autorizacaoEmpenho->setFkOrcamentoUnidade($unidade);
        $autorizacaoEmpenho->setDtAutorizacao(new DateTimeMicrosecondPK($formData->get('dtAutorizacao')->getData()->format('Y-m-d H:i:s.u')));
        $autorizacaoEmpenho->setFkEmpenhoCategoriaEmpenho($formData->get('codCategoria')->getData());
    }

    /**
     * @param ReservaSaldos $reservaSaldos
     * @param Despesa $despesa
     * @param AutorizacaoEmpenho $autorizacaoEmpenho
     * @param $formData
     */
    public function manterReservaSaldos($reservaSaldos, $despesa, $autorizacaoEmpenho, $formData)
    {
        $reservaSaldos->setFkOrcamentoDespesa($despesa);
        $reservaSaldos->setDtValidadeInicial($formData->get('dtAutorizacao')->getData());
        $reservaSaldos->setDtValidadeFinal($formData->get('dtValidadeFinal')->getData());
        $reservaSaldos->setDtInclusao($formData->get('dtAutorizacao')->getData());
        $reservaSaldos->setMotivo(sprintf("Autorização de Empenho %s/%s", $autorizacaoEmpenho->getCodAutorizacao(), $formData->get('exercicio')->getData()));
    }

    /**
     * @param PreEmpenho $preEmpenho
     * @param Form $formData
     */
    public function after($preEmpenho, $formData)
    {
        $em = $this->entityManager;

        /** @var Entidade $entidade */
        $entidade = $formData->get('codEntidade')->getData();

        /** @var Unidade $unidade */
        $unidade = $this->entityManager->getRepository(Unidade::class)
            ->findOneBy([
                'exercicio' => $formData->get('exercicio')->getData(),
                'numUnidade' => $formData->get('numUnidade')->getData(),
                'numOrgao' => $formData->get('numOrgao')->getData()
            ]);

        if ($preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->isEmpty()) {
            $codAutorizacao = (new AutorizacaoEmpenhoModel($em))->getProximoCodAutorizacao($entidade->getExercicio(), $entidade->getCodEntidade());
            $autorizacaoEmpenho = new AutorizacaoEmpenho();
            $autorizacaoEmpenho->setCodAutorizacao($codAutorizacao);
            $this->manterAutorizacaoEmpenho($autorizacaoEmpenho, $unidade, $formData);
            $preEmpenho->addFkEmpenhoAutorizacaoEmpenhos($autorizacaoEmpenho);
        } else {
            /** @var AutorizacaoEmpenho $autorizacaoEmpenho */
            $autorizacaoEmpenho = $preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last();
            $this->manterAutorizacaoEmpenho($autorizacaoEmpenho, $unidade, $formData);
        }

        if ($formData->get('codDespesa')->getData()) {
            $this->newPreEmpenhoDespesa($preEmpenho, $formData);

            $despesa = $preEmpenho->getFkEmpenhoPreEmpenhoDespesa()->getFkOrcamentoDespesa();

            if ($autorizacaoEmpenho->getFkEmpenhoAutorizacaoReserva()) {
                /** @var ReservaSaldos $reservaSaldos */
                $reservaSaldos = $autorizacaoEmpenho->getFkEmpenhoAutorizacaoReserva()->getFkOrcamentoReservaSaldos();
                $this->manterReservaSaldos($reservaSaldos, $despesa, $autorizacaoEmpenho, $formData);
            } else {
                $codReserva = (new ReservaSaldosModel($em))->getProximoCodReserva($preEmpenho->getExercicio());
                $reservaSaldos = new ReservaSaldos();
                $reservaSaldos->setCodReserva($codReserva);
                $this->manterReservaSaldos($reservaSaldos, $despesa, $autorizacaoEmpenho, $formData);

                $autorizacaoReserva = new AutorizacaoReserva();
                $autorizacaoReserva->setFkOrcamentoReservaSaldos($reservaSaldos);

                $autorizacaoEmpenho->setFkEmpenhoAutorizacaoReserva($autorizacaoReserva);
            }
        }

        if ($formData->get('contaContrapartida')->getData()) {
            /** @var ContrapartidaResponsavel $contaContrapartida */
            $contrapartidaResponsavel = $em->getRepository(ContrapartidaResponsavel::class)->findOneBy([
                'contaContrapartida' => $formData->get('contaContrapartida')->getData(),
                'exercicio' => $formData->get('exercicio')->getData()
            ]);

            if ($autorizacaoEmpenho->getFkEmpenhoContrapartidaAutorizacao()) {
                $contrapartidaAutorizacao = $autorizacaoEmpenho->getFkEmpenhoContrapartidaAutorizacao();
                $contrapartidaAutorizacao->setFkEmpenhoContrapartidaResponsavel($contrapartidaResponsavel);
            } else {
                $contrapartidaAutorizacao = new ContrapartidaAutorizacao();
                $contrapartidaAutorizacao->setFkEmpenhoAutorizacaoEmpenho($autorizacaoEmpenho);
                $contrapartidaAutorizacao->setFkEmpenhoContrapartidaResponsavel($contrapartidaResponsavel);
                $autorizacaoEmpenho->setFkEmpenhoContrapartidaAutorizacao($contrapartidaAutorizacao);
            }
        } elseif ($autorizacaoEmpenho->getFkEmpenhoContrapartidaAutorizacao()) {
            $em->remove($autorizacaoEmpenho->getFkEmpenhoContrapartidaAutorizacao());
        }

        // AtributoEmpenhoValor
        $atributos = $this->getAtributosDinamicos();
        $timestamp = new DateTimeMicrosecondPK();
        foreach ($atributos as $atributo) {
            $field_name = 'Atributo_' . $atributo->cod_atributo . '_' . $atributo->cod_cadastro;
            /** @var AtributoDinamico $atributoDinamico */
            $atributoDinamico = $this->entityManager->getRepository(AtributoDinamico::class)
                ->findOneBy([
                    'codModulo' => Modulo::MODULO_EMPENHO,
                    'codAtributo' => $atributo->cod_atributo,
                    'codCadastro' => $atributo->cod_cadastro
                ]);
            
            $atributoEmpenhoValor = new AtributoEmpenhoValor();
            $atributoEmpenhoValor->setTimestamp($timestamp);
            $atributoEmpenhoValor->setFkAdministracaoAtributoDinamico($atributoDinamico);
            $atributoEmpenhoValor->setValor($formData->get($field_name)->getData());
            $preEmpenho->addFkEmpenhoAtributoEmpenhoValores($atributoEmpenhoValor);
        }

        $em->persist($preEmpenho);
        $em->flush();
        $em->clear();
    }

    public function afterEmitirEmpenhoDiversos($object, $formData)
    {
        $this->newPreEmpenhoDespesa($object, $formData);

        // AtributoEmpenhoValor
        $atributos = $this->getAtributosDinamicos();
        $timestamp = new \DateTime('now');
        foreach ($atributos as $atributo) {
            $field_name = 'Atributo_' . $atributo->cod_atributo . '_' . $atributo->cod_cadastro;

            $atributoEmpenhoValor = new \Urbem\CoreBundle\Entity\Empenho\AtributoEmpenhoValor();
            $atributoEmpenhoValor->setFkEmpenhoPreEmpenho($object);
            
            $fkAdministracaoAtributoDinamico = $this->entityManager
            ->getRepository("CoreBundle:Administracao\AtributoDinamico")
            ->findOneBy(
                array(
                    'codModulo' => Empenho::CODMODULO,
                    'codCadastro' => $atributo->cod_cadastro,
                    'codAtributo' => $atributo->cod_atributo
                )
            );
            
            $atributoEmpenhoValor->setFkAdministracaoAtributoDinamico($fkAdministracaoAtributoDinamico);
            $atributoEmpenhoValor->setValor($formData->get($field_name)->getData());
            $this->entityManager->persist($atributoEmpenhoValor);
        }

        $codEmpenho = $this->entityManager->getRepository("CoreBundle:Empenho\Empenho")
        ->getProximoCodEmpenho();

        $vlSaldoAnterior = $this->getSaldoAnterior($object, $formData);

        $vlSaldoAnterior = (float) $vlSaldoAnterior->saldo_anterior;

        if ($vlSaldoAnterior < 0) {
            $vlSaldoAnterior = (float) $this->getSaldoAnterior($object, $formData)->saldo_anterior * -1;
        }

        $empenho = new \Urbem\CoreBundle\Entity\Empenho\Empenho();
        $empenho->setCodEmpenho($codEmpenho);
        $empenho->setFkEmpenhoPreEmpenho($object);
        $empenho->setFkOrcamentoEntidade($formData->get('codEntidade')->getData());
        $empenho->setFkEmpenhoCategoriaEmpenho($formData->get('codCategoria')->getData());
        $empenho->setDtEmpenho(new DateTimeMicrosecondPK($formData->get('dtEmpenho')->getData()->format('Y-m-d H:i:s.u')));
        $empenho->setDtVencimento(new DateTimeMicrosecondPK($formData->get('dtValidadeFinal')->getData()->format('Y-m-d H:i:s.u')));
        $empenho->setVlSaldoAnterior($vlSaldoAnterior);
        $this->entityManager->persist($empenho);

        $this->entityManager->flush();
    }

    /**
     * @param PreEmpenho $preEmpenho
     * @return float|int
     */
    public function saveReservaSaldoVlTotal($preEmpenho)
    {
        $items = $this->getItemPreEmpenhoByPreEmpenho($preEmpenho->getCodPreEmpenho(), $preEmpenho->getExercicio());
        
        $vlTotal = 0;
        foreach ($items as $item) {
            $vlTotal += (float) $item->vl_total;
        }

        /** @var AutorizacaoEmpenho $autorizacaoEmpenho */
        $autorizacaoEmpenho = $preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last();

        $reservaSaldos = $autorizacaoEmpenho->getFkEmpenhoAutorizacaoReserva()->getFkOrcamentoReservaSaldos();
        $reservaSaldos->setVlReserva($vlTotal);

        $this->entityManager->persist($reservaSaldos);
        $this->entityManager->flush();
        
        return $vlTotal;
    }

    public function getReservaSaldoPerfil($object)
    {
        $itensPreEmpenho = $this->entityManager->getRepository("CoreBundle:Empenho\ItemPreEmpenho")
        ->findBy(
            array(
                'exercicio' => $object->getExercicio(),
                'codPreEmpenho' => $object->getCodPreEmpenho(),
            )
        );
        
        $vlTotal = 0;
        foreach ($itensPreEmpenho as $itemPreEmpenho) {
            $vlTotal += (float) $itemPreEmpenho->getVlTotal();
        }

        $reservaSaldos =  new \Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos();
        $reservaSaldos->setVlReserva($vlTotal);
        
        if (count($itensPreEmpenho) > 0) {
            return $reservaSaldos;
        }
        
        return null;
    }

    /**
     * @param $filter
     * @param $numcgm
     * @return array
     */
    public function filterPreEmpenho($filter, $numcgm)
    {
        $res = $this->entityManager->getRepository("CoreBundle:Empenho\PreEmpenho")
        ->filterPreEmpenho($filter, $numcgm);

        return $res;
    }
    
    public function getDespesa($object)
    {
        $preEmpenhoDespesa = $this->entityManager->getRepository("CoreBundle:Empenho\PreEmpenhoDespesa")
        ->findOneBy(
            array(
                'exercicio' => $object->getExercicio(),
                'codPreEmpenho' => $object->getCodPreEmpenho(),
            )
        );

        $contaDespesa = $codDespesa = $codigoReduzido = $pao = $codRecurso = $numUnidade = $numOrgao = null;
        if ($preEmpenhoDespesa) {
            $contaDespesa = $this->entityManager->getRepository("CoreBundle:Orcamento\ContaDespesa")
                ->findOneBy(
                    array(
                        'exercicio' => $preEmpenhoDespesa->getExercicio(),
                        'codConta' => $preEmpenhoDespesa->getCodConta(),
                    )
                );

            $codDespesa = $this->entityManager->getRepository("CoreBundle:Orcamento\Despesa")
                ->findOneBy(
                    array(
                        'exercicio' => $preEmpenhoDespesa->getExercicio(),
                        'codDespesa' => $preEmpenhoDespesa->getCodDespesa(),
                    )
                );

            $codigoReduzido = $this->entityManager->getRepository("CoreBundle:Orcamento\ContaDespesa")
                ->getDotacaoPorDespesa($preEmpenhoDespesa->getExercicio(), $preEmpenhoDespesa->getCodDespesa());

            $pao = $this->entityManager->getRepository("CoreBundle:Orcamento\Pao")
                ->findOneBy(
                    array(
                        'exercicio' => $object->getExercicio(),
                        'numPao' => $codDespesa->getNumPao()
                    )
                );

            $codRecurso = $this->entityManager->getRepository("CoreBundle:Orcamento\Recurso")
                ->findOneBy(
                    array(
                        'exercicio' => $object->getExercicio(),
                        'codRecurso' => $codDespesa->getCodRecurso()
                    )
                );

            $numUnidade = $this->entityManager->getRepository("CoreBundle:Orcamento\Unidade")
                ->findOneBy(
                    array(
                        'exercicio' => $object->getExercicio(),
                        'numUnidade' => $codDespesa->getNumUnidade(),
                        'numOrgao' => $codDespesa->getNumOrgao()
                    )
                );

            $numOrgao = $this->entityManager->getRepository("CoreBundle:Orcamento\Orgao")
            ->findOneBy(
                array(
                    'exercicio' => $object->getExercicio(),
                    'numOrgao' => $codDespesa->getNumOrgao()
                )
            );
        }

        $despesa = array();
        $despesa['codDespesa'] = "";
        $despesa['codPrograma'] = "";
        $despesa['despesa'] = "";
        $despesa['pao'] = "";
        $despesa['codigoReduzido'] = "";
        $despesa['codClassificacao'] = "";
        $despesa['codRecurso'] = "";
        $despesa['numUnidade'] = "";
        $despesa['unidade'] = "";
        $despesa['numOrgao'] = "";
        $despesa['orgao'] = "";
        
        if ($codDespesa) {
            $despesa['codDespesa'] = $codDespesa->getCodDespesa() . " - " . $codDespesa->getFkOrcamentoContaDespesa()->getDescricao();
            $despesa['codPrograma'] = $codDespesa->getFkOrcamentoPrograma()->getCodPrograma() . " - " . $codDespesa->getFkOrcamentoPrograma()->getDescricao();
            $despesa['despesa'] = $codDespesa->getCodDespesa();
        }
        
        if ($pao) {
            $despesa['pao'] =  $pao->getNumPao() . " - " . $pao->getNomPao();
        }
        
        if ($contaDespesa) {
            $despesa['codClassificacao'] = $contaDespesa->getCodEstrutural() . " - " . $contaDespesa->getDescricao();
        }
        
        if ($codigoReduzido) {
            $despesa['codigoReduzido'] = $codigoReduzido->dotacao;
        }
        
        if ($codRecurso) {
            $despesa['codRecurso'] = $codRecurso->getCodRecurso() . " - " . $codRecurso->getNomRecurso();
            $despesa['recurso'] = $codRecurso->getCodRecurso();
        }
        
        if ($numUnidade) {
            $despesa['numUnidade'] = $numUnidade->getNumUnidade() . " - " . $numUnidade->getNomUnidade();
            $despesa['unidade'] = $numUnidade->getNumUnidade();
        }
        
        if ($numOrgao) {
            $despesa['numOrgao'] = $numOrgao->getNumOrgao() . " - " . $numOrgao->getNomOrgao();
            $despesa['orgao'] = $numOrgao->getNumOrgao();
        }

        return $despesa;
    }
    
    public function getEmpenhoOriginal($codEntidade, $numCgm, $exercicio, $codEmpenhoInicial, $codEmpenhoFinal, $periodoInicial, $periodoFinal, $sonata = false)
    {
        $empenhoOriginal = $this->entityManager->getRepository("CoreBundle:Empenho\Empenho")
        ->getEmpenhoOriginal(
            $codEntidade,
            $numCgm,
            $exercicio,
            $codEmpenhoInicial,
            $codEmpenhoFinal,
            $periodoInicial,
            $periodoFinal
        );
        
        $empenhoOriginalList = array();
        foreach ($empenhoOriginal as $empenho) {
            if ($sonata) {
                $empenhoOriginalList[$empenho->cod_empenho . " - " . $empenho->nom_fornecedor] =  $empenho->cod_empenho;
            } else {
                $empenhoOriginalList[$empenho->cod_empenho] =  $empenho->cod_empenho . " - " . $empenho->nom_fornecedor;
            }
        }
        
        return $empenhoOriginalList;
    }
    
    public function getInformacaoEmpenhoOriginal($codEmpenho, $codEntidade, $numCgm, $exercicio, $locale = 'pt_BR')
    {
        $fmt = new \NumberFormatter($locale, \NumberFormatter::DECIMAL);
        
        $empenhoOriginal = $this->entityManager->getRepository("CoreBundle:Empenho\Empenho")
        ->getInformacaoEmpenhoOriginal(
            $codEmpenho,
            $codEntidade,
            $numCgm,
            $exercicio
        );
        
        $retorno = array();
        
        // Dotação Orçamentária
        $despesa = $this->entityManager->getRepository("CoreBundle:Orcamento\Despesa")
        ->findOneByCodDespesa($empenhoOriginal->cod_despesa);
        
        $contaDespesa = $this->entityManager->getRepository("CoreBundle:Orcamento\ContaDespesa")
        ->getContaDespesa($exercicio, $despesa->getFkOrcamentoContaDespesa()->getCodConta());
        
        $codClassificacao = $this->entityManager->getRepository("CoreBundle:Orcamento\ContaDespesa")
        ->getContaDespesa($exercicio, $empenhoOriginal->cod_conta);
        
        $numOrgao = $this->entityManager->getRepository("CoreBundle:Orcamento\Orgao")
        ->findOneBy(
            array(
                'numOrgao' => $empenhoOriginal->num_orgao,
                'exercicio' => $exercicio
            )
        );
        
        $numUnidade = $this->entityManager->getRepository("CoreBundle:Orcamento\Unidade")
        ->findOneBy(
            array(
                'numUnidade' => $empenhoOriginal->num_unidade,
                'exercicio' => $exercicio
            )
        );
        
        $codCategoria = $this->entityManager->getRepository("CoreBundle:Empenho\CategoriaEmpenho")
        ->findOneByCodCategoria($empenhoOriginal->cod_categoria);
        
        $codHistorico = $this->entityManager->getRepository("CoreBundle:Empenho\Historico")
        ->findOneByCodHistorico($empenhoOriginal->cod_historico);
        
        $retorno['codDespesa'] = $despesa->getCodDespesa() . " - " . $contaDespesa->descricao;
        $retorno['codClassificacao'] = $codClassificacao->cod_conta . " - " . $codClassificacao->descricao;
        $retorno['saldoDotacao'] = $fmt->format($empenhoOriginal->vl_saldo_anterior);
        $retorno['numOrgao'] = $numOrgao->getNumOrgao() . " - " . $numOrgao->getNomOrgao();
        $retorno['numUnidade'] = $numUnidade->getNumUnidade() . " - " . $numUnidade->getNomUnidade();
        $retorno['cgmBeneficiario'] = $empenhoOriginal->credor . " - " . $empenhoOriginal->nom_fornecedor;
        $retorno['codCategoria'] = $empenhoOriginal->cod_categoria . " - " . $codCategoria->getDescricao();
        $retorno['dtEmpenho'] = $empenhoOriginal->dt_empenho;
        $retorno['dtValidadeFinal'] = $empenhoOriginal->dt_vencimento;
        $retorno['descricao'] = $empenhoOriginal->descricao;
        $retorno['codHistorico'] = $empenhoOriginal->cod_historico . " - " . $codHistorico->getNomHistorico();
        
        $atributos = $this->getAtributosDinamicos();
        
        foreach ($atributos as $atributo) {
            $field_name = 'Atributo_' . $atributo->cod_atributo . '_' . $atributo->cod_cadastro;
            
            $data = $this->entityManager->getRepository('CoreBundle:Empenho\AtributoEmpenhoValor')
            ->findOneBy(
                array(
                    'codPreEmpenho' => $empenhoOriginal->cod_pre_empenho,
                    'exercicio' => $exercicio,
                    'codModulo' => Empenho::CODMODULO,
                    'codCadastro' => $atributo->cod_cadastro,
                    'codAtributo' => $atributo->cod_atributo,
                ),
                array(
                    'timestamp' => 'DESC'
                )
            );
            
            $valor = null;
            if ($data) {
                $valor = $data->getValor();
            }
            
            $retorno[$field_name] = $valor;
        }
        
        return $retorno;
    }

    /**
     * @param $object
     * @param $formData
     * @param $currentUser
     * @throws \Exception
     */
    public function saveEmitirEmpenhoComplementar($object, $formData, $currentUser)
    {
        $empenhoOriginal = $this->entityManager->getRepository(Empenho::class)
        ->getInformacaoEmpenhoOriginal(
            $formData->get('codEmpenho')->getData(),
            $formData->get('codEntidade')->getData()->getCodEntidade(),
            $currentUser->getFkSwCgm()->getNumcgm(),
            $formData->get('exercicio')->getData()
        );

        $codPreEmpenho = $this->getUltimoPreEmpenho($formData->get('exercicio')->getData());
        if (!empty($empenhoOriginal)) {
            $codHistorico = $this->entityManager->getRepository(Historico::class)
                ->findOneBy(['codHistorico' => $empenhoOriginal->cod_historico, 'exercicio' => $formData->get('exercicio')->getData()]);
        }

        if (!empty($empenhoOriginal)) {
            $cgmBeneficiario = $this->entityManager->getRepository("CoreBundle:SwCgm")->findOneByNumcgm($empenhoOriginal->credor);
        }

        $codTipo = 0;
        if (!empty($empenhoOriginal)) {
            $codTipo = $empenhoOriginal->cod_tipo;
        }

        $codTipo = $this->entityManager->getRepository(TipoEmpenho::class)
            ->findOneBy(array('codTipo' => $codTipo));

        $object->setExercicio($formData->get('exercicio')->getData());
        $object->setCodPreEmpenho($codPreEmpenho);
        $object->setFkSwCgm($cgmBeneficiario);
        $object->setFkEmpenhoHistorico($codHistorico);
        $object->setFkEmpenhoTipoEmpenho($codTipo);
        $object->setCgmUsuario($currentUser->getNumcgm());

        // PreEmpenhoDespesa
        $fkOrcamentoContaDespesa = $this->entityManager->getRepository(ContaDespesa::class)
            ->findOneBy(['codConta' => $empenhoOriginal->cod_conta, 'exercicio' => $object->getExercicio()])
        ;

        $fkOrcamentoDespesa = $this->entityManager->getRepository(Despesa::class)
            ->findOneBy(['codDespesa' => $empenhoOriginal->cod_despesa, 'exercicio' => $object->getExercicio()])
        ;

        $preEmpenhoDespesa = new \Urbem\CoreBundle\Entity\Empenho\PreEmpenhoDespesa();
        $preEmpenhoDespesa->setFkEmpenhoPreEmpenho($object);
        $preEmpenhoDespesa->setFkOrcamentoContaDespesa($fkOrcamentoContaDespesa);
        $preEmpenhoDespesa->setFkOrcamentoDespesa($fkOrcamentoDespesa);
        $object->setFkEmpenhoPreEmpenhoDespesa($preEmpenhoDespesa);

        // AtributoEmpenhoValor
        $atributos = $this->getAtributosDinamicos();
        foreach ($atributos as $atributo) {
            $field_name = 'Atributo_' . $atributo->cod_atributo . '_' . $atributo->cod_cadastro;

            $atributoEmpenhoValor = new \Urbem\CoreBundle\Entity\Empenho\AtributoEmpenhoValor();
            $atributoEmpenhoValor->setFkEmpenhoPreEmpenho($object);

            $fkAdministracaoAtributoDinamico = $this->entityManager
                ->getRepository(AtributoDinamico::class)
                ->findOneBy(['codModulo' => Empenho::CODMODULO, 'codCadastro' => $atributo->cod_cadastro, 'codAtributo' => $atributo->cod_atributo])
            ;

            $atributoEmpenhoValor->setFkAdministracaoAtributoDinamico($fkAdministracaoAtributoDinamico);
            $atributoEmpenhoValor->setValor($formData->get($field_name)->getData());

            $object->addFkEmpenhoAtributoEmpenhoValores($atributoEmpenhoValor);
        }

        // Empenho
        $codEmpenho = $this->entityManager->getRepository(Empenho::class)->getProximoCodEmpenho();
        $codCategoria = $this->entityManager->getRepository(CategoriaEmpenho::class)->findOneByCodCategoria($empenhoOriginal->cod_categoria);
        $codEntidade = $this->entityManager->getRepository(Entidade::class)
            ->findOneBy(['exercicio' => $formData->get('exercicio')->getData(), 'codEntidade' => $empenhoOriginal->cod_entidade]);

        $empenho = new \Urbem\CoreBundle\Entity\Empenho\Empenho();
        $empenho->setCodEmpenho($codEmpenho);
        $empenho->setDtEmpenho(new DateTimeMicrosecondPK($formData->get('dtEmpenho')->getData()->format('Y-m-d H:i:s.u')));
        $empenho->setDtVencimento(new DateTimeMicrosecondPK($formData->get('dtValidadeFinal')->getData()->format('Y-m-d H:i:s.u')));
        $empenho->setVlSaldoAnterior($empenhoOriginal->vl_saldo_anterior);
        $empenho->setFkOrcamentoEntidade($codEntidade);
        $empenho->setFkEmpenhoPreEmpenho($object);
        $empenho->setFkEmpenhoCategoriaEmpenho($codCategoria);

        try {
            $this->entityManager->persist($empenho);
            $this->entityManager->flush();
            $this->entityManager->refresh($empenho);
        } catch (\Exception $exception) {
            throw new \Exception($exception);
        }

        // EmpenhoComplementar
        $fkEmpenhoEmpenho1 = $this->entityManager->getRepository(Empenho::class)
            ->findOneBy(['codEmpenho' => $formData->get('codEmpenho')->getData(), 'exercicio' => $object->getExercicio(), 'codEntidade' => $codEntidade->getCodEntidade()])
        ;

        $empenhoComplementar = new \Urbem\CoreBundle\Entity\Empenho\EmpenhoComplementar();
        $empenhoComplementar->setFkEmpenhoEmpenho($empenho);
        $empenhoComplementar->setFkEmpenhoEmpenho1($fkEmpenhoEmpenho1);
        $empenho->setFkEmpenhoEmpenhoComplementar($empenhoComplementar);
        $object->setFkEmpenhoEmpenho($empenho);

        try {
            $this->entityManager->persist($object);
            $this->entityManager->flush();
        } catch (\Exception $exception) {
            throw new \Exception($exception);
        }
    }
    
    public function getDadosEmpenho($codPreEmpenho, $exercicio)
    {
        $dadosEmpenho = array();

        $preEmpenho = $this->entityManager->getRepository("CoreBundle:Empenho\PreEmpenho")
        ->findOneBy(
            array(
                'codPreEmpenho' => $codPreEmpenho,
                'exercicio' => $exercicio
            )
        );
        
        $empenho = $this->entityManager->getRepository("CoreBundle:Empenho\Empenho")
        ->findOneBy(
            array(
                'codPreEmpenho' => $preEmpenho->getCodPreEmpenho(),
                'exercicio' => $preEmpenho->getExercicio()
            )
        );

        $categoria = $this->entityManager->getRepository("CoreBundle:Empenho\CategoriaEmpenho")
            ->findOneBy(
                array(
                    'codCategoria' => $empenho->getCodCategoria(),
                )
            );

        $cgmPessoaJuridica = $this->entityManager->getRepository("CoreBundle:SwCgmPessoaJuridica")
        ->findOneByNumcgm($empenho->getFkOrcamentoEntidade()->getFkSwCgm()->getNumcgm());
        
        $preEmpenhoDespesa = $this->entityManager->getRepository("CoreBundle:Empenho\PreEmpenhoDespesa")
        ->findOneBy(
            array(
                'codPreEmpenho' => $preEmpenho->getCodPreEmpenho(),
                'exercicio' => $preEmpenho->getExercicio()
            )
        );

        $despesa = $this->entityManager->getRepository("CoreBundle:Orcamento\Despesa")
        ->findOneByCodDespesa($preEmpenhoDespesa->getCodDespesa());
        
        $orgao = $this->entityManager->getRepository("CoreBundle:Orcamento\Orgao")
        ->findOneBy(
            array(
                'numOrgao' => $despesa->getNumOrgao(),
                'exercicio' => $preEmpenho->getExercicio()
            )
        );

        $unidade = $this->entityManager->getRepository("CoreBundle:Orcamento\Unidade")
        ->findOneBy(
            array(
                'numUnidade' => $despesa->getNumUnidade(),
                'exercicio' => $preEmpenho->getExercicio()
            )
        );
        
        // Entidade
        $dadosEmpenho['nomEntidade'] = $empenho->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm();
        $dadosEmpenho['foneEntidade'] = $empenho->getFkOrcamentoEntidade()->getFkSwCgm()->getFoneResidencial();
        $dadosEmpenho['emailEntidade'] = $empenho->getFkOrcamentoEntidade()->getFkSwCgm()->getEmail();
        $dadosEmpenho['codEntidade'] = $empenho->getCodEntidade();
        $dadosEmpenho['descricao'] = $preEmpenho->getDescricao();
        $dadosEmpenho['logradouro'] = $empenho->getFkOrcamentoEntidade()->getFkSwCgm()->getLogradouroCompleto();
        $dadosEmpenho['cepEntidade'] = DocumentNumberConverterHelper::parseNumberToCep($empenho->getFkOrcamentoEntidade()->getFkSwCgm()->getCep());
        
        $dadosEmpenho['cnpjEntidade'] = '';
        if ($cgmPessoaJuridica) {
            $dadosEmpenho['cnpjEntidade'] = DocumentNumberConverterHelper::parseNumberToCnpj($cgmPessoaJuridica->getCnpj());
        }
        $dadosEmpenho['empenho'] = $empenho->getCodEmpenho() . "/" . $empenho->getExercicio();

        if ($preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last()) {
            $orcamentoUnidadeOrgao = $preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last()->getFkOrcamentoUnidade();
            $dadosEmpenho['orgao'] = $orcamentoUnidadeOrgao->getFkOrcamentoOrgao();
            $dadosEmpenho['unidade'] = $orcamentoUnidadeOrgao;
            $dadosEmpenho['autorizacao'] = $preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last()->getCodAutorizacao()
            . "/"
            . $preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last()->getExercicio();
        } else {
            $dadosEmpenho['orgao'] = $orgao;
            $dadosEmpenho['unidade'] = $unidade;
            $dadosEmpenho['autorizacao'] = "Diversos";
        }

        $dadosEmpenho['tipoEmpenho'] = $preEmpenho->getFkEmpenhoTipoEmpenho()->getNomTipo();

        // Credor
        $dadosEmpenho['cgmCredor'] = $preEmpenho->getFkSwCgm();
        
        $cgmPessoaFisica = $this->entityManager->getRepository("CoreBundle:SwCgmPessoaFisica")
        ->findOneByNumcgm($preEmpenho->getFkSwCgm()->getNumcgm());
        
        $dadosEmpenho['cgcCpfCredor'] = '';
        $dadosEmpenho['numCgmCredor'] = '';
        if ($cgmPessoaFisica) {
            $dadosEmpenho['cgcCpfCredor'] = DocumentNumberConverterHelper::parseNumberToCpf($cgmPessoaFisica->getCpf());
            $dadosEmpenho['numCgmCredor'] = $preEmpenho->getFkSwCgm()->getNumcgm();
        }

        $dadosEmpenho['logradouroCredor'] = $preEmpenho->getFkSwCgm()->getTipoLogradouroAndNumero();
        
        $dadosEmpenho['municipioCredor'] = $preEmpenho->getFkSwCgm()->getFkSwMunicipio()->getNomMunicipio();
        $dadosEmpenho['ufCredor'] = $preEmpenho->getFkSwCgm()->getFkSwMunicipio()->getFkSwUf()->getSiglaUf();
        
        // Empenho
        $dadosEmpenho['dtEmpenho'] = $empenho->getDtEmpenho();
        $dadosEmpenho['dtVencimento'] = $empenho->getDtVencimento();
        $dadosEmpenho['hora'] = $empenho->getHora();

        $dadosEmpenho['setVlSaldoAnterior'] =  $empenho->getVlSaldoAnterior();
        $dadosEmpenho['historico'] = $preEmpenho->getFkEmpenhoHistorico()->getNomHistorico();
        
        // AtributoEmpenhoValor
        $atributos = $this->getAtributosDinamicos();

        foreach ($atributos as $atributo) {
            $field_name = 'Atributo_' . $atributo->cod_atributo . '_' . $atributo->cod_cadastro;
            
            $atributoEmpenhoValor = $this->entityManager->getRepository('CoreBundle:Empenho\AtributoEmpenhoValor')
            ->findOneBy(
                array(
                    'codPreEmpenho' => $preEmpenho->getCodPreEmpenho(),
                    'exercicio' => $preEmpenho->getExercicio(),
                    'codModulo' => Empenho::CODMODULO,
                    'codCadastro' => $atributo->cod_cadastro,
                    'codAtributo' => $atributo->cod_atributo,
                ),
                array(
                    'timestamp' => 'DESC'
                )
            );

            $data = null;
            if ($atributoEmpenhoValor) {
                $data = $atributoEmpenhoValor->getValor();
            }

            $valor = "&nbsp;";
            switch ($atributo->cod_tipo) {
                case 3:
                    $valor_padrao = explode(",", $atributo->valor_padrao);
                    $valor_padrao_desc = explode("[][][]", $atributo->valor_padrao_desc);
            
                    $choices = array();
                    
                    foreach ($valor_padrao_desc as $key => $desc) {
                        $choices[$valor_padrao[$key]] = $desc;
                    }
                    
                    if (! is_null($data)) {
                        $valor = $choices[$data];
                    } else {
                        $valor = "";
                    }
                    break;
                default:
                    if (! is_null($data)) {
                        $valor = $data;
                    } else {
                        $valor = "";
                    }
                    break;
            }
            
            $dadosEmpenho['AtributoEmpenhoValor'][$field_name] = array(
                'label' => $atributo->nom_atributo,
                'value' => $valor
            );
        }

        $categoria = $categoria ? $categoria->getDescricao() : '';
        $dadosEmpenho['AtributoEmpenhoValor']['categoria'] = array(
            'label' => "Categoria",
            'value' => $categoria
        );
        
        $dadosEmpenho['despesa'] = $this->getDespesa($preEmpenho);
        
        $dadosEmpenho['itemPreEmpenho'] = $this->entityManager->getRepository("CoreBundle:Empenho\ItemPreEmpenho")
        ->findBy(
            array(
                'codPreEmpenho' => $preEmpenho->getCodPreEmpenho(),
                'exercicio' => $preEmpenho->getExercicio()
            )
        );
        
        $dadosEmpenho['vlTotal'] = "";
        if ($this->getReservaSaldoPerfil($preEmpenho)) {
            $dadosEmpenho['vlTotal'] = $this->getReservaSaldoPerfil($preEmpenho)->getVlReserva();
        }
        
        $dadosEmpenho['nomPrefeitura'] = $this->entityManager->getRepository("CoreBundle:Administracao\Configuracao")
        ->findOneBy(
            array(
                'parametro' => 'nom_prefeitura',
                'exercicio' => $preEmpenho->getExercicio()
            )
        )->getValor();
        
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        
        $dadosEmpenho['dtEmpenhoLiteral'] = strftime('%d de %B de %Y', strtotime($empenho->getDtEmpenho()));
        
        $dadosEmpenho['vlOrcado'] = $despesa->getVlOriginal();
        
        $dadosEmpenho['saldoAtual'] = $dadosEmpenho['setVlSaldoAnterior'] - $dadosEmpenho['vlTotal'];
        
        $dadosEmpenho['assinaturas'] = $this->entityManager->getRepository("CoreBundle:Empenho\EmpenhoAssinatura")
        ->getAssinaturasPorEmpenho(
            $preEmpenho->getExercicio(),
            $empenho->getCodEntidade(),
            $empenho->getCodEmpenho()
        );
        
        $dadosEmpenho['dotacao'] = $this->getDotacaoFormatada($preEmpenho, $despesa);
        
        $pao = $this->entityManager->getRepository("CoreBundle:Orcamento\Pao")
        ->findOneBy(
            array(
                'exercicio' => $preEmpenho->getExercicio(),
                'numPao' => $despesa->getNumPao()
            )
        );
        
        $dadosEmpenho['pao'] = "";
        if ($pao) {
            $dadosEmpenho['pao'] = $pao->getNumPao() . " - " . $pao->getNomPao();
        }
        
        return $dadosEmpenho;
    }
    
    public function getDadosAutorizacao($codPreEmpenho, $exercicio)
    {
        $dadosAutorizacao = array();

        /** @var PreEmpenho $preEmpenho */
        $preEmpenho = $this->entityManager->getRepository("CoreBundle:Empenho\PreEmpenho")
        ->findOneBy(
            array(
                'codPreEmpenho' => $codPreEmpenho,
                'exercicio' => $exercicio
            )
        );
        
        $autorizacaoEmpenho = $this->entityManager->getRepository("CoreBundle:Empenho\AutorizacaoEmpenho")
        ->findOneBy(
            array(
                'codPreEmpenho' => $preEmpenho->getCodPreEmpenho(),
                'exercicio' => $preEmpenho->getExercicio()
            ),
            array(
                'codAutorizacao' => 'DESC'
            )
        );

        $cgmPessoaJuridica = $this->entityManager->getRepository("CoreBundle:SwCgmPessoaJuridica")
        ->findOneByNumcgm($autorizacaoEmpenho->getFkOrcamentoEntidade()->getFkSwCgm()->getNumcgm());
        
        $preEmpenhoDespesa = $this->entityManager->getRepository("CoreBundle:Empenho\PreEmpenhoDespesa")
        ->findOneBy(
            array(
                'codPreEmpenho' => $preEmpenho->getCodPreEmpenho(),
                'exercicio' => $preEmpenho->getExercicio()
            )
        );

        $despesa = null;
        if ($preEmpenhoDespesa) {
            $despesa = $this->entityManager->getRepository("CoreBundle:Orcamento\Despesa")
                ->findOneByCodDespesa($preEmpenhoDespesa->getCodDespesa());
        }

        $dadosAutorizacao['nomEntidade'] = $autorizacaoEmpenho->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm();
        $dadosAutorizacao['foneEntidade'] = $autorizacaoEmpenho->getFkOrcamentoEntidade()->getFkSwCgm()->getFoneResidencial();
        $dadosAutorizacao['emailEntidade'] = $autorizacaoEmpenho->getFkOrcamentoEntidade()->getFkSwCgm()->getEmail();
        $dadosAutorizacao['codEntidade'] = $autorizacaoEmpenho->getCodEntidade();
        $dadosAutorizacao['descricao'] = $preEmpenho->getDescricao();
        $dadosAutorizacao['logradouro'] = $autorizacaoEmpenho->getFkOrcamentoEntidade()->getFkSwCgm()->getLogradouroCompleto();
        $dadosAutorizacao['cepEntidade'] = DocumentNumberConverterHelper::parseNumberToCep($autorizacaoEmpenho->getFkOrcamentoEntidade()->getFkSwCgm()->getCep());
        
        $dadosAutorizacao['cnpjEntidade'] = '';
        if ($cgmPessoaJuridica) {
            $dadosAutorizacao['cnpjEntidade'] = DocumentNumberConverterHelper::parseNumberToCnpj($cgmPessoaJuridica->getCnpj());
        }
        $dadosAutorizacao['empenho'] = $autorizacaoEmpenho->getCodAutorizacao() . "/" . $autorizacaoEmpenho->getExercicio();

        $orcamentoUnidadeOrgao = $autorizacaoEmpenho->getFkOrcamentoUnidade();

        $dadosAutorizacao['orgao'] = $orcamentoUnidadeOrgao->getFkOrcamentoOrgao();
        $dadosAutorizacao['unidade'] = $orcamentoUnidadeOrgao;
        $dadosAutorizacao['autorizacao'] = $preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last()->getCodAutorizacao()
        . "/"
        . $preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last()->getExercicio();
        
        
        // Credor
        $dadosAutorizacao['cgmCredor'] = $preEmpenho->getFkSwCgm()->getNumcgm() . " - " . $preEmpenho->getFkSwCgm()->getNomcgm();
        
        $cgmPessoaFisica = $this->entityManager->getRepository("CoreBundle:SwCgmPessoaFisica")
        ->findOneByNumcgm($preEmpenho->getFkSwCgm()->getNumcgm());
        
        $dadosAutorizacao['cgcCpfCredor'] = '';
        $dadosAutorizacao['numCgmCredor'] = '';
        if ($cgmPessoaFisica) {
            $dadosAutorizacao['cgcCpfCredor'] = DocumentNumberConverterHelper::parseNumberToCpf($cgmPessoaFisica->getCpf());
            $dadosAutorizacao['numCgmCredor'] = $preEmpenho->getFkSwCgm()->getNumcgm();
        }
        
        $dadosAutorizacao['logradouroCredor'] = $preEmpenho->getFkSwCgm()->getTipoLogradouroAndNumero();


        $dadosAutorizacao['municipioCredor'] = $preEmpenho->getFkSwCgm()->getFkSwMunicipio()->getNomMunicipio();
        $dadosAutorizacao['ufCredor'] = $preEmpenho->getFkSwCgm()->getFkSwMunicipio()->getFkSwUf()->getSiglaUf();
        
        $dadosAutorizacao['despesa'] = $this->getDespesa($preEmpenho);
        
        $dadosAutorizacao['itemPreEmpenho'] = $this->entityManager->getRepository("CoreBundle:Empenho\ItemPreEmpenho")
        ->findBy(
            array(
                'codPreEmpenho' => $preEmpenho->getCodPreEmpenho(),
                'exercicio' => $preEmpenho->getExercicio()
            )
        );
        
        $dadosAutorizacao['vlTotal'] = "";
        if ($this->getReservaSaldoPerfil($preEmpenho)) {
            $dadosAutorizacao['vlTotal'] = $this->getReservaSaldoPerfil($preEmpenho)->getVlReserva();
        }

        $dadosAutorizacao['dtValidadeFinal'] = "";
        $reservaSaldos = null;
        if ($preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last()->getFkEmpenhoAutorizacaoReserva()) {
            $reservaSaldos = $preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last()->getFkEmpenhoAutorizacaoReserva()->getFkOrcamentoReservaSaldos();
        }
        
        $dadosAutorizacao['dtValidadeFinal'] = "";
        if ($reservaSaldos) {
            $dadosAutorizacao['dtValidadeFinal'] = $reservaSaldos->getDtValidadeFinal()->format("d/m/Y");
        }
        
        $dadosAutorizacao['nomPrefeitura'] = $this->entityManager->getRepository("CoreBundle:Administracao\Configuracao")
        ->findOneBy(
            array(
                'parametro' => 'nom_prefeitura',
                'exercicio' => $preEmpenho->getExercicio()
            )
        )->getValor();
        
        $dadosAutorizacao['dotacao'] = ($despesa) ? $this->getDotacaoFormatada($preEmpenho, $despesa) : null;

        $pao = null;
        if ($despesa) {
            $pao = $this->entityManager->getRepository("CoreBundle:Orcamento\Pao")
                ->findOneBy(
                    array(
                        'exercicio' => $preEmpenho->getExercicio(),
                        'numPao' => $despesa->getNumPao()
                    )
                );
        }

        $dadosAutorizacao['pao'] = "";
        if ($pao) {
            $dadosAutorizacao['pao'] = $pao->getNumPao() . " - " . $pao->getNomPao();
        }
        
        $autorizacaoAnulada = $this->entityManager->getRepository("CoreBundle:Empenho\AutorizacaoAnulada")
        ->findOneBy(
            array(
                'exercicio' => $autorizacaoEmpenho->getExercicio(),
                'codEntidade' => $autorizacaoEmpenho->getCodEntidade(),
                'codAutorizacao' => $autorizacaoEmpenho->getCodAutorizacao()
            )
        );
        
        $dadosAutorizacao['dtAnulacao'] = $autorizacaoAnulada->getDtAnulacao();
        $dadosAutorizacao['motivo'] = $autorizacaoAnulada->getMotivo();

        return $dadosAutorizacao;
    }
    
    /**
     * Retorna a dotação formatada, de acordo com o sistema antigo
     * @param  PreEmpenho $preEmpenho
     * @param  Despesa $despesa
     * @return string
     */
    public function getDotacaoFormatada($preEmpenho, $despesa)
    {
        $paoPpaAcao = $this->entityManager->getRepository("CoreBundle:Orcamento\PaoPpaAcao")
        ->findOneBy(
            array(
                'exercicio' => $preEmpenho->getExercicio(),
                'numPao' => $despesa->getNumPao()
            )
        );
        
        if ($paoPpaAcao) {
            $dotacao = $despesa->getNumUnidade()
            . "." . $despesa->getFkOrcamentoFuncao()->getCodFuncao()
            . "." . $despesa->getFkOrcamentoSubfuncao()->getCodSubFuncao()
            . "." . $despesa->getFkOrcamentoPrograma()->getCodPrograma()
            . "." . $paoPpaAcao->getFkPpaAcao()->getCodAcao()
            . "." . str_replace(".", "", $despesa->getFkOrcamentoContaDespesa()->getCodEstrutural());
            
            $dotacaoFormatada = $this->entityManager->getRepository("CoreBundle:Orcamento\Despesa")
            ->getDotacaoFormatada($dotacao, $preEmpenho->getExercicio());

            return $despesa->getCodDespesa()
            . " - " . $despesa->getNumUnidade()
            . $dotacaoFormatada->dotacao_formatada
            . " - " . $despesa->getFkOrcamentoContaDespesa()->getDescricao()
            ;
        } else {
            return "";
        }
    }
    
    /**
     * @param TipoEmpenho $tipoEmpenho
     * @param Fornecedor $fornecedor
     * @param $user
     * @param $exercicio
     * @param Historico $historico
     *
     * @return PreEmpenho
     */
    public function savePreEmpenho(TipoEmpenho $tipoEmpenho, Fornecedor $fornecedor, $user, $exercicio, Historico $historico)
    {
        $codPreEmpenho = $this->getUltimoPreEmpenho($exercicio);
        /** @var PreEmpenho $obtPreEmpenho */
        $obtPreEmpenho = new PreEmpenho();
        $obtPreEmpenho->setFkEmpenhoTipoEmpenho($tipoEmpenho);
        $obtPreEmpenho->setFkSwCgm($fornecedor->getFkSwCgm());
        $obtPreEmpenho->setCgmUsuario($user);
        $obtPreEmpenho->setDescricao('');
        $obtPreEmpenho->setCodPreEmpenho($codPreEmpenho);
        $obtPreEmpenho->setExercicio($exercicio);
        $obtPreEmpenho->setFkEmpenhoHistorico($historico);
        $this->save($obtPreEmpenho);
        return $obtPreEmpenho;
    }
    
    public function getSaldosEmpenho($numCgm, $exercicio, $codEntidade, $numOrgao, $numUnidade, $dtVencimento, $credor, $codRecurso, $codPreEmpenho, $codEmpenho)
    {
        $saldosEmpenho = $this->entityManager->getRepository("CoreBundle:Empenho\Empenho")
        ->getSaldosEmpenho(
            $numCgm,
            $exercicio,
            $codEntidade,
            $numOrgao,
            $numUnidade,
            $dtVencimento,
            $credor,
            $codRecurso,
            $codPreEmpenho,
            $codEmpenho
        );
        
        return $saldosEmpenho;
    }

    /**
     * Verifica se o PreEmpenho tem PreEmpenhoDespesa vinculado
     * Se sim, remove e cadastra um novo
     * Se não, cadastra um novo
     * @param PreEmpenho $preEmpenho
     * @param Form $formData
     */
    protected function newPreEmpenhoDespesa($preEmpenho, $formData)
    {
        if ($preEmpenho->getFkEmpenhoPreEmpenhoDespesa()) {
            $this->entityManager->remove($preEmpenho->getFkEmpenhoPreEmpenhoDespesa());
            $this->entityManager->flush();
        }

        /** @var ContaDespesa $contaDespesa */
        $contaDespesa = $this->entityManager->getRepository(ContaDespesa::class)
            ->findOneBy([
                'exercicio' => $formData->get('exercicio')->getData(),
                'codEstrutural' => $formData->get('codClassificacao')->getData()
            ]);

        /** @var Despesa $despesa */
        $despesa = $this->entityManager->getRepository(Despesa::class)
            ->findOneBy([
                'exercicio' => $formData->get('exercicio')->getData(),
                'codDespesa' => $formData->get('codDespesa')->getData()
            ]);

        $preEmpenhoDespesa = new PreEmpenhoDespesa();
        $preEmpenhoDespesa->setFkOrcamentoContaDespesa($contaDespesa);
        $preEmpenhoDespesa->setFkOrcamentoDespesa($despesa);
        $preEmpenho->setFkEmpenhoPreEmpenhoDespesa($preEmpenhoDespesa);
    }

    /**
     * @param $codAutorizacao
     * @param $exercicio
     * @return \stdClass
     */
    public function getDadosAutorizacaoEmpenho($codAutorizacao, $exercicio)
    {
        $autorizacao = $this->entityManager->getRepository(AutorizacaoEmpenho::class)
            ->findOneBy(
                array(
                    'codAutorizacao' => $codAutorizacao,
                    'exercicio' => $exercicio
                )
            );

        $dadosEmissao = $this->entityManager->getRepository(AutorizacaoEmpenho::class)
            ->findDadosReemitirAutorizacao($autorizacao->getCodEntidade(), $codAutorizacao, $autorizacao->getCodPreEmpenho(), $exercicio, [$this->codModulo, $this->codAtributoJoinValor, $this->codAtributoJoinValorAno]);

        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $dados = new ArrayCollection();
        $objeto = new \stdClass();
        $objeto->itens = clone $dados;

        if (!empty($dadosEmissao)) {
            $auxTotalGeral = 0;
            foreach ($dadosEmissao as $item) {
                $itemObjeto = new \stdClass();
                $itemObjeto->numItem = $item->num_item;
                $itemObjeto->quantidade = $item->quantidade;
                $itemObjeto->centroCusto = sprintf('%s %s', $item->cod_centro, $item->nom_centro);
                $itemObjeto->nomItem = $item->nom_item;
                $itemObjeto->nomUnidade = $item->nom_unidade;
                $itemObjeto->valorUnitario = $item->valor_unitario;
                $itemObjeto->valorTotal = $item->valor_total;

                $objeto->empenho = sprintf('%s/%s', $item->cod_pre_empenho, $item->exercicio);
                $objeto->fornecedor = $item->nom_cgm;
                $objeto->cpfCnpj = $item->cpf_cnpj;
                $objeto->numcgm = $item->numcgm;
                $objeto->endereco = $item->endereco;
                $objeto->telefone = $item->telefone;
                $objeto->cidade = $item->nom_municipio;
                $objeto->uf = $item->sigla_uf;
                $objeto->nomEntidade = $item->nom_entidade;
                $objeto->orgao = $item->num_nom_orgao;
                $objeto->unidade = $item->nom_unidade;
                $objeto->dotacao = $item->dotacao;
                $objeto->pao = $item->nom_pao;
                $objeto->recurso = sprintf('%s %s', $item->cod_recurso, $item->nom_recurso);
                $objeto->validade = $item->dt_validade_final;
                $objeto->descricao = $item->descricao;
                $auxTotalGeral += floatval(trim($item->valor_total));
                $objeto->totalGeral = $auxTotalGeral;
                $objeto->itens->add($itemObjeto);
            }
            $objeto->foneEntidade = $autorizacao->getFkOrcamentoEntidade()->getFkSwCgm()->getFoneResidencial();
            $objeto->emailEntidade = $autorizacao->getFkOrcamentoEntidade()->getFkSwCgm()->getEMail();
            $objeto->logradouro = $autorizacao->getFkOrcamentoEntidade()->getFkSwCgm()->getLogradouro();
            $objeto->cepEntidade = $autorizacao->getFkOrcamentoEntidade()->getFkSwCgm()->getCep();
            $objeto->cnpjEntidade = $autorizacao->getFkOrcamentoEntidade()->getFkSwCgm()->getfkSwCgmPessoaJuridica()->getCnpj();
            $objeto->assinaturas = $autorizacao->getFkEmpenhoAutorizacaoEmpenhoAssinaturas();
            $objeto->dtEmpenhoLiteral = strftime('%d de %B de %Y', strtotime($autorizacao->getDtAutorizacao()));
        }

        return $objeto;
    }
}
