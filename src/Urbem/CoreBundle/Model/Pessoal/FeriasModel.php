<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\TipoFolha;
use Urbem\CoreBundle\Entity\Pessoal\Assentamento;
use Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento;
use Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado;
use Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoContratoServidor;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Entity\Pessoal\Ferias;
use Urbem\CoreBundle\Entity\Pessoal\FormaPagamentoFerias;
use Urbem\CoreBundle\Entity\Pessoal\LancamentoFerias;

/**
 * Class FeriasModel
 * @package Urbem\CoreBundle\Model\Pessoal
 */
class FeriasModel extends AbstractModel
{
    /**
     * @var EntityManager|null
     */
    protected $entityManager = null;

    /**
     * @var \Doctrine\ORM\EntityRepository|null|\Urbem\CoreBundle\Repository\Pessoal\FeriasRepository
     */
    protected $repository = null;

    /**
     * FeriasModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\Ferias");
    }

    /**
     * @param $formData
     */
    public function concederFerias($formData)
    {
        $fkPessoalFormaPagamentoFerias = $this->admin->getModelManager()->find(FormaPagamentoFerias::class, $formData['codForma']);
        $fkPessoalContratoServidor = $this->admin->getModelManager()->find(ContratoServidor::class, $formData['codContrato']);

        $dtInicialAquisitivo = (new \DateTime())->createFromFormat('d/m/Y', $formData['dtInicial']);
        $dtFinalAquisitivo = (new \DateTime())->createFromFormat('d/m/Y', $formData['dtFinal']);

        $ferias = new Ferias();
        $ferias->setFaltas((int) $formData['faltas']);
        $ferias->setDiasFerias((int) $formData['diasFerias']);
        $ferias->setDiasAbono((int) $formData['diasAbono']);
        $ferias->setDtInicialAquisitivo($dtInicialAquisitivo);
        $ferias->setDtFinalAquisitivo($dtFinalAquisitivo);
        $ferias->setFkPessoalFormaPagamentoFerias($fkPessoalFormaPagamentoFerias);
        $ferias->setFkPessoalContratoServidor($fkPessoalContratoServidor);
        $this->entityManager->persist($ferias);

        $fkFolhapagamentoTipoFolha = $this->admin->getModelManager()->find(TipoFolha::class, $formData['codTipo']);

        $dtInicio = (new \DateTime())->createFromFormat('d/m/Y', $formData['dtInicialFerias']);
        $dtFim = (new \DateTime())->createFromFormat('d/m/Y', $formData['dtTerminoFerias']);
        $dtRetorno = (new \DateTime())->createFromFormat('d/m/Y', $formData['dtRetornoFerias']);
        $pagar13 = (isset($formData['pagar13'])) ? true : false;

        $lancamentoFerias = new LancamentoFerias();
        $lancamentoFerias->setFkFolhapagamentoTipoFolha($fkFolhapagamentoTipoFolha);
        $lancamentoFerias->setDtInicio($dtInicio);
        $lancamentoFerias->setDtFim($dtFim);
        $lancamentoFerias->setDtRetorno($dtRetorno);
        $lancamentoFerias->setMesCompetencia(str_pad($formData['mes'], 2, "0", STR_PAD_LEFT));
        $lancamentoFerias->setAnoCompetencia($formData['ano']);
        $lancamentoFerias->setPagar13($pagar13);
        $lancamentoFerias->setFkPessoalFerias($ferias);

        $this->entityManager->persist($lancamentoFerias);

        $codAssentamentoGerado = $this->entityManager->getRepository(AssentamentoGerado::class)
        ->getNextCodAssentamentoGerado();

        $assentamento = $this->entityManager->getRepository(Assentamento::class)
        ->getAssentamentoPrevidencia($fkPessoalContratoServidor->getCodContrato());

        $fkPessoalAssentamentoAssentamento = $this->admin->getModelManager()
        ->find(
            AssentamentoAssentamento::class,
            $assentamento->cod_assentamento
        );

        $observacao = $this->admin->trans('label.ferias.observacaoAssentamento', [
            '%dtInicial%' => $formData['dtInicial'],
            '%dtFinal%' => $formData['dtFinal'],
            '%mes%' => str_pad($formData['mes'], 2, "0", STR_PAD_LEFT),
            '%ano%' => $formData['ano'],
        ]);

        $assentamentoGerado = new AssentamentoGerado();
        $assentamentoGerado->setCodAssentamentoGerado($codAssentamentoGerado);
        $assentamentoGerado->setFkPessoalAssentamentoAssentamento($fkPessoalAssentamentoAssentamento);
        $assentamentoGerado->setPeriodoInicial($dtInicio);
        $assentamentoGerado->setPeriodoFinal($dtFim);
        $assentamentoGerado->setAutomatico(true);
        $assentamentoGerado->setObservacao($observacao);

        $this->entityManager->persist($assentamentoGerado);

        $assentamentoGeradoContratoServidor = new AssentamentoGeradoContratoServidor();
        $assentamentoGeradoContratoServidor->setCodAssentamentoGerado($codAssentamentoGerado);
        $assentamentoGeradoContratoServidor->addFkPessoalAssentamentoGerados($assentamentoGerado);
        $assentamentoGeradoContratoServidor->setFkPessoalContrato($fkPessoalContratoServidor->getFkPessoalContrato());

        $this->entityManager->persist($assentamentoGeradoContratoServidor);

        $this->entityManager->flush();
    }

    /**
     * @param $codFerias
     * @return null|object
     */
    public function recuperaFaltasPorCodFerias($codFerias)
    {
        $ferias = $this->repository->findOneBy(['codFerias' => $codFerias]);
        return $ferias->getFaltas();
    }

    /**
     * @param $codFerias
     * @return int
     */
    public function recuperaForma($codFerias)
    {
        /** @var Ferias $ferias */
        $ferias = $this->repository->findOneBy(['codFerias' => $codFerias]);
        $formaPagamentoFerias = $ferias->getFkPessoalFormaPagamentoFerias();
        return $formaPagamentoFerias->getCodForma();
    }

    /**
     * @param $codFerias
     * @return int
     */
    public function recuperaDias($codFerias)
    {
        /** @var Ferias $ferias */
        $ferias = $this->repository->findOneBy(['codFerias' => $codFerias]);
        $formaPagamentoFerias = $ferias->getFkPessoalFormaPagamentoFerias();
        return $formaPagamentoFerias->getDias();
    }

    /**
     * @param $codFerias
     * @return int
     */
    public function recuperaAbono($codFerias)
    {
        /** @var Ferias $ferias */
        $ferias = $this->repository->findOneBy(['codFerias' => $codFerias]);
        $formaPagamentoFerias = $ferias->getFkPessoalFormaPagamentoFerias();
        return $formaPagamentoFerias->getAbono();
    }

    /**
     * @param $codFerias
     * @return \DateTime
     */
    public function recuperaDtInicioFerias($codFerias)
    {
        /** @var Ferias $ferias */
        $ferias = $this->repository->findOneBy(['codFerias' => $codFerias]);
        return $ferias->getFkPessoalLancamentoFerias()->getDtInicio()->format('d/m/Y');
    }

    /**
     * @param $codFerias
     * @return \DateTime
     */
    public function recuperaDtFimFerias($codFerias)
    {
        /** @var Ferias $ferias */
        $ferias = $this->repository->findOneBy(['codFerias' => $codFerias]);
        return $ferias->getFkPessoalLancamentoFerias()->getDtFim()->format('d/m/Y');
    }

    /**
     * @param $codFerias
     * @return \DateTime
     */
    public function recuperaDtRetorno($codFerias)
    {
        /** @var Ferias $ferias */
        $ferias = $this->repository->findOneBy(['codFerias' => $codFerias]);
        return $ferias->getFkPessoalLancamentoFerias()->getDtRetorno()->format('d/m/Y');
    }

    /**
     * @param $codFerias
     * @return string
     */
    public function recuperaTipoFolha($codFerias)
    {
        $ferias = $this->repository->findOneBy(['codFerias' => $codFerias]);
        return $ferias
                    ->getFkPessoalLancamentoFerias()
                    ->getFkFolhapagamentoTipoFolha()
                    ->getDescricao();
    }

    /**
     * @param $codFerias
     * @return bool
     */
    public function recuperaPagar13($codFerias)
    {
        /** @var Ferias $ferias */
        $ferias = $this->repository->findOneBy(['codFerias' => $codFerias]);
        return $ferias->getFkPessoalLancamentoFerias()->getPagar13();
    }

    /**
     * @param $codFerias
     * @return Ferias
     */
    public function recuperaFeriasPorCodFerias($codFerias)
    {
        /** @var Ferias $ferias */
        return $this->repository->findOneBy(['codFerias' => $codFerias]);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getDadosRelatorioServidor(array $params)
    {
        return $this->repository->getDadosRelatorioServidor($params);
    }
}
