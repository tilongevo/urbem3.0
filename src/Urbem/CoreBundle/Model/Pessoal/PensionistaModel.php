<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\Previdencia;
use Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista;
use Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaContaSalario;
use Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaOrgao;
use Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaPrevidencia;
use Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaProcesso;
use Urbem\CoreBundle\Entity\Pessoal\Pensionista;
use Urbem\CoreBundle\Entity\Pessoal\PensionistaCid;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Entity\Pessoal\AtributoContratoPensionista;
use Urbem\RecursosHumanosBundle\Helper\Constants\Pessoal\Pensionista as PensionistaConstants;

class PensionistaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;
    const ENTIDADES_VERIFICACAO = [
        'CoreBundle:Folhapagamento\ConcessaoDecimo',
        'CoreBundle:Folhapagamento\ContratoServidorComplementar',
        'CoreBundle:Folhapagamento\ContratoServidorPeriodo',
        'CoreBundle:Folhapagamento\DescontoExternoIrrf',
        'CoreBundle:Folhapagamento\DescontoExternoPrevidencia'
    ];

    /**
     * PensionistaModel constructor.
     *
     * @param ORM\EntityManager $entityManager
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Pensionista::class);
    }

    /**
     * @param $object
     *
     * @return bool
     */
    public function canRemove($object)
    {
        $codContrato = $object->getFkPessoalContratoPensionistas()->last()->getCodContrato();
        foreach (self::ENTIDADES_VERIFICACAO as $entidade) {
            $hasData = $this->entityManager->getRepository($entidade)
                ->findOneByCodContrato($codContrato);

            if ($hasData) {
                return false;
            }
        }
    }

    /**
     * Lista as agências pelo código do banco
     *
     * @param  integer $codBanco
     * @param  boolean $sonata
     *
     * @return array
     */
    public function getAgenciasByCodBanco($codBanco, $sonata = false)
    {
        $agenciaList = $this->entityManager->getRepository(Agencia::class)
            ->findByCodBanco($codBanco);

        $options = [];
        foreach ($agenciaList as $agencia) {
            if ($sonata) {
                $options[$agencia->getNumAgencia() . " - " . $agencia->getNomAgencia()] = $agencia->getCodAgencia();
            } else {
                $options[$agencia->getCodAgencia()] = $agencia->getNumAgencia() . " - " . $agencia->getNomAgencia();
            }
        }

        return $options;
    }

    /**
     * Retorna a opções de previdências
     *
     * @param      $codContrato
     * @param bool $sonata
     *
     * @return array
     */
    public function getPrevidencias($codContrato, $sonata = false)
    {
        $previdenciaList = $this->entityManager->getRepository(PrevidenciaPrevidencia::class)
            ->getPrevidenciaPrevidencia([
                'cod_contrato' => $codContrato
            ]);

        $options = [];
        foreach ($previdenciaList as $previdencia) {
            if ($sonata) {
                $options[$previdencia->cod_previdencia . " - " . $previdencia->descricao] = $previdencia->cod_previdencia;
            } else {
                $options[] = [
                    'codPrevidencia' => $previdencia->cod_previdencia,
                    'descricao' => $previdencia->cod_previdencia . " - " . $previdencia->descricao
                ];
            }
        }

        return $options;
    }

    /**
     * @param Pensionista $object
     * @param             $formData
     */
    public function savePensionistaCid(Pensionista $object, $formData)
    {
        if ($formData->get('codCid')->getData()) {
            if ($object->getfkPessoalPensionistaCid()) {
                $fkPessoalPensionistaCid = $object->getfkPessoalPensionistaCid();
            } else {
                $fkPessoalPensionistaCid = new PensionistaCid();
            }
            $fkPessoalPensionistaCid->setFkPessoalPensionista($object);
            $fkPessoalPensionistaCid->setFkPessoalCid($formData->get('codCid')->getData());
            $fkPessoalPensionistaCid->setDataLaudo($formData->get('dtLaudo')->getData());
            $this->entityManager->persist($fkPessoalPensionistaCid);
        }
    }

    /**
     * @param Pensionista $object
     * @param             $formData
     *
     * @return mixed|ContratoPensionista
     */
    public function saveContratoPensionista(Pensionista $object, $formData)
    {
        if (!$object->getFkPessoalContratoPensionistas()->isEmpty()) {
            $contratoPensionista = $object->getFkPessoalContratoPensionistas()->last();
        } else {
            $codContrato = $this->entityManager->getRepository(Contrato::class)->getNextCodContrato();
            $registro = $this->entityManager->getRepository(Contrato::class)->getNextRegistro();

            $contrato = new Contrato();
            $contrato->setCodContrato($codContrato);
            $contrato->setRegistro($registro);
            $this->entityManager->persist($contrato);

            $contratoPensionista = new ContratoPensionista();
            $contratoPensionista->setFkPessoalContrato($contrato);
        }

        $contratoPensionista->setFkPessoalPensionista($object);
        $contratoPensionista->setFkPessoalTipoDependencia($formData->get('fkPessoalTipoDependencia')->getData());
        $contratoPensionista->setDtInicioBeneficio($formData->get('dtInicioBeneficio')->getData());
        $contratoPensionista->setDtEncerramento($formData->get('dtEncerramento')->getData());
        $contratoPensionista->setNumBeneficio($formData->get('numBeneficio')->getData());
        $contratoPensionista->setPercentualPagamento($formData->get('percentualPagamento')->getData());
        $contratoPensionista->setMotivoEncerramento($formData->get('motivoEncerramento')->getData());
        $this->entityManager->persist($contratoPensionista);

        return $contratoPensionista;
    }

    /**
     * @param Pensionista         $object
     * @param                     $formData
     * @param ContratoPensionista $contratoPensionista
     */
    public function saveContratoPensionistaContaSalario(Pensionista $object, $formData, ContratoPensionista $contratoPensionista)
    {
        $fkMonetarioAgencia = $this->entityManager->getRepository(Agencia::class)
            ->findOneBy(
                [
                    'codAgencia' => $formData->get('codAgencia')->getData(),
                    'codBanco' => $formData->get('codBanco')->getData()->getCodBanco(),
                ]
            );

        if (!$object->getFkPessoalContratoPensionistas()->isEmpty()) {
            $contratoPensionistaContaSalario = $object->getFkPessoalContratoPensionistas()->last()
                ->getFkPessoalContratoPensionistaContaSalarios()->last();
        } else {
            $contratoPensionistaContaSalario = new ContratoPensionistaContaSalario();
        }
        $contratoPensionistaContaSalario->setFkMonetarioAgencia($fkMonetarioAgencia);
        $contratoPensionistaContaSalario->setFkPessoalContratoPensionista($contratoPensionista);
        $contratoPensionistaContaSalario->setNrConta($formData->get('nrConta')->getData());
        $this->entityManager->persist($contratoPensionistaContaSalario);
    }

    /**
     * @param Pensionista         $object
     * @param                     $formData
     * @param ContratoPensionista $contratoPensionista
     */
    public function saveContratoPensionistaProcesso(Pensionista $object, $formData, ContratoPensionista $contratoPensionista)
    {
        if ($formData->get('codProcesso')->getData()) {
            preg_match('/^(\d+)[\/~](\d+)/', $formData->get('codProcesso')->getData(), $codProcesso);

            $fkSwProcesso = $this->entityManager->getRepository(SwProcesso::class)
                ->findOneBy(
                    array(
                        'codProcesso' => $codProcesso[1],
                        'anoExercicio' => $codProcesso[2]
                    )
                );

            if (!$object->getFkPessoalContratoPensionistas()->isEmpty()) {
                $contratoPensionistaProcesso = $object->getFkPessoalContratoPensionistas()->last()
                    ->getFkPessoalContratoPensionistaProcesso();
            } else {
                $contratoPensionistaProcesso = new ContratoPensionistaProcesso();
            }
            $contratoPensionistaProcesso->setFkPessoalContratoPensionista($contratoPensionista);
            $contratoPensionistaProcesso->setFkSwProcesso($fkSwProcesso);
            $this->entityManager->persist($contratoPensionistaProcesso);
        }
    }

    /**
     * @param Pensionista         $object
     * @param                     $orgao
     * @param ContratoPensionista $contratoPensionista
     */
    public function saveContratoPensionistaOrgao(Pensionista $object, $orgao, ContratoPensionista $contratoPensionista)
    {
        if (!$object->getFkPessoalContratoPensionistas()->isEmpty()) {
            $contratoPensionistaOrgao = $object->getFkPessoalContratoPensionistas()->last()
                ->getFkPessoalContratoPensionistaOrgoes()->last();
        } else {
            $contratoPensionistaOrgao = new ContratoPensionistaOrgao();
        }
        $contratoPensionistaOrgao->setFkPessoalContratoPensionista($contratoPensionista);
        $contratoPensionistaOrgao->setFkOrganogramaOrgao($orgao->getFkOrganogramaOrgao());
        $this->entityManager->persist($contratoPensionistaOrgao);
    }

    /**
     * @param                     $formData
     * @param ContratoPensionista $contratoPensionista
     */
    public function saveContratoPensionistaPrevidencia($formData, ContratoPensionista $contratoPensionista)
    {
        if ($formData->get('codPrevidencia')->getData()) {
            foreach ($formData->get('codPrevidencia')->getData() as $codPrevidencia) {
                $fkFolhapagamentoPrevidencia = $this->entityManager->getRepository(Previdencia::class)
                    ->findOneByCodPrevidencia($codPrevidencia);

                $contratoPensionistaPrevidencia = new ContratoPensionistaPrevidencia();
                $contratoPensionistaPrevidencia->setFkPessoalContratoPensionista($contratoPensionista);
                $contratoPensionistaPrevidencia->setFkFolhapagamentoPrevidencia($fkFolhapagamentoPrevidencia);
                $this->entityManager->persist($contratoPensionistaPrevidencia);
            }
        }
    }

    /**
     * @param                     $formData
     * @param ContratoPensionista $contratoPensionista
     */
    public function saveAtributoContratoPensionista($formData, ContratoPensionista $contratoPensionista)
    {
        $atributosDinamicos = $this->entityManager->getRepository(AtributoDinamico::class)
            ->findBy([
                'codModulo' => PensionistaConstants::COD_MODULO,
                'codCadastro' => PensionistaConstants::COD_CADASTRO
            ]);

        foreach ($atributosDinamicos as $atributo) {
            $fieldName = 'Atributo_' . $atributo->getCodAtributo() . '_' . $atributo->getCodCadastro();
            switch ($atributo->getCodTipo()) {
                case 5:
                    $valor = (!is_null($formData->get($fieldName)->getData())) ? $formData->get($fieldName)->getData()->format('d/m/Y') : null;
                    break;
                default:
                    $valor = $formData->get($fieldName)->getData();
                    break;
            }

            $atributoContratoPensionista = $this->entityManager->getRepository(AtributoContratoPensionista::class)
                ->findOneBy([
                    'codContrato' => $contratoPensionista->getCodContrato(),
                    'codAtributo' => $atributo->getCodAtributo(),
                    'codCadastro' => $atributo->getCodCadastro(),
                    'codModulo' => $atributo->getCodModulo()
                ]);

            if (!$atributoContratoPensionista) {
                $atributoContratoPensionista = new AtributoContratoPensionista();
            }

            if (!is_null($valor)) {
                $atributoContratoPensionista->setFkAdministracaoAtributoDinamico($atributo);
                $atributoContratoPensionista->setFkPessoalContratoPensionista($contratoPensionista);
                $atributoContratoPensionista->setValor($valor);
                $this->entityManager->persist($atributoContratoPensionista);
            }
        }
    }

    /**
     * @TODO: Se não encontrar o CGM vinculado no ContratoServidor gerar um alerta
     * e impedir a gravação.
     *
     * @param Pensionista $object
     * @param             $formData
     * @param             $orgao
     */
    public function manualPersist(Pensionista $object, $formData, $orgao)
    {
        $this->savePensionistaCid($object, $formData);
        $contratoPensionista = $this->saveContratoPensionista($object, $formData);
        $this->saveContratoPensionistaContaSalario($object, $formData, $contratoPensionista);
        $this->saveContratoPensionistaProcesso($object, $formData, $contratoPensionista);
        $this->saveContratoPensionistaOrgao($object, $orgao, $contratoPensionista);
        $this->saveContratoPensionistaPrevidencia($formData, $contratoPensionista);
        $this->saveAtributoContratoPensionista($formData, $contratoPensionista);

        $this->entityManager->flush();
    }

    /**
     * Atualiza o módulo, procurando por registros existentes e atualizando
     *
     * @param Pensionista $object
     * @param             $formData
     * @param             $orgao
     */
    public function manualUpdate(Pensionista $object, $formData, $orgao)
    {
        $this->savePensionistaCid($object, $formData);
        $contratoPensionista = $this->saveContratoPensionista($object, $formData);
        $this->saveContratoPensionistaContaSalario($object, $formData, $contratoPensionista);
        $this->saveContratoPensionistaProcesso($object, $formData, $contratoPensionista);
        $this->saveContratoPensionistaOrgao($object, $orgao, $contratoPensionista);
        $this->saveContratoPensionistaPrevidencia($formData, $contratoPensionista);
        $this->saveAtributoContratoPensionista($formData, $contratoPensionista);

        $this->entityManager->flush();
    }
}
