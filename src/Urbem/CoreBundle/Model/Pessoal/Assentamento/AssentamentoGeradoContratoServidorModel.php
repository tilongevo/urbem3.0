<?php
namespace Urbem\CoreBundle\Model\Pessoal\Assentamento;

use Symfony\Component\Translation\TranslatorInterface;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Pessoal\Assentamento;
use Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento;
use Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado;
use Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoContratoServidor;
use Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoNorma;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Repository\Pessoal\AssentamentoGeradoContratoServidorRepository;

/**
 * Class AssentamentoGeradoContratoServidorModel
 * @package Urbem\CoreBundle\Model\Pessoal\Assentamento
 */
class AssentamentoGeradoContratoServidorModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var AssentamentoGeradoContratoServidorRepository  */
    protected $repository = null;
    protected $assentamentoAssentamentoRepository = null;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
        /** @var AssentamentoGeradoContratoServidorRepository repository */
        $this->repository = $this->entityManager->getRepository(AssentamentoGeradoContratoServidor::class);

        $this->assentamentoAssentamentoRepository = $this->entityManager->getRepository(AssentamentoAssentamento::class);
    }

    public function getClassificacaoAssentamento($codContrato, $sonata = false)
    {
        $contrato = $this->entityManager->getRepository('CoreBundle:Pessoal\Contrato')
        ->findOneByCodContrato($codContrato);

        $classificacaoAssentamentoList = $this->entityManager
        ->getRepository("CoreBundle:Pessoal\ClassificacaoAssentamento")
        ->getClassificacaoAssentamento(
            array(
                'registro' => $contrato->getRegistro()
            )
        );

        $options = [];
        foreach ($classificacaoAssentamentoList as $classificacaoAssentamento) {
            if ($sonata) {
                $options[$classificacaoAssentamento->cod_classificacao . " - " . $classificacaoAssentamento->descricao] = $classificacaoAssentamento->cod_classificacao;
            } else {
                $options[$classificacaoAssentamento->cod_classificacao] = $classificacaoAssentamento->cod_classificacao . " - " . $classificacaoAssentamento->descricao;
            }
        }

        return $options;
    }

    public function getAssentamentoByClassificacao($codClassificacao, $sonata = false)
    {
        $assentamentoList = $this->entityManager
        ->getRepository(Assentamento::class)
        ->getAssentamentoFiltro(
            array(
                'cod_classificacao' => $codClassificacao,
            )
        );

        $options = [];
        foreach ($assentamentoList as $assentamento) {
            if ($sonata) {
                $options[$assentamento->cod_assentamento . " - " . $assentamento->descricao] = $assentamento->cod_assentamento;
            } else {
                $options[$assentamento->cod_assentamento] = $assentamento->cod_assentamento . " - " . $assentamento->descricao;
            }
        }

        return $options;
    }

    public function getAssentamentoByClassificacaoMatricula($codContrato, $codClassificacao, $sonata = false)
    {
        $contrato = $this->entityManager->getRepository(Contrato::class)
        ->findOneByCodContrato($codContrato);

        $assentamentoList = $this->entityManager
        ->getRepository(Assentamento::class)
        ->getAssentamento(
            array(
                'cod_classificacao' => $codClassificacao,
                'registro' => $contrato->getRegistro()
            )
        );

        $options = [];
        foreach ($assentamentoList as $assentamento) {
            if ($sonata) {
                $options[$assentamento->cod_assentamento . " - " . $assentamento->descricao] = $assentamento->cod_assentamento;
            } else {
                $options[$assentamento->cod_assentamento] = $assentamento->cod_assentamento . " - " . $assentamento->descricao;
            }
        }

        return $options;
    }

    public function getNormasList($fkPessoalAssentamentoGeradoNormas)
    {
        $normas = array();
        foreach ($fkPessoalAssentamentoGeradoNormas->toArray() as $assentamentoGeradoNorma) {
            $normas[] = $assentamentoGeradoNorma->getFkNormasNorma();
        }

        return $normas;
    }

    /**
     * Cria registro a partir do modulo
     * @param AssentamentoGeradoContratoServidor $object
     * @param $formData
     */
    public function create(AssentamentoGeradoContratoServidor $object, $formData)
    {
        $fkPessoalAssentamentoAssentamento = $this->entityManager
        ->getRepository(AssentamentoAssentamento::class)
        ->findOneBy(
            array(
                'codAssentamento' => $formData->get('codAssentamento')->getData(),
                'codClassificacao' => $formData->get('codClassificacao')->getData(),
            )
        );

        $assentamentoGerado = new AssentamentoGerado();
        $assentamentoGerado->setFkPessoalAssentamentoGeradoContratoServidor($object);
        $assentamentoGerado->setFkPessoalAssentamentoAssentamento($fkPessoalAssentamentoAssentamento);
        $assentamentoGerado->setPeriodoInicial($formData->get('periodoInicial')->getData());
        $assentamentoGerado->setPeriodoFinal($formData->get('periodoFinal')->getData());
        $assentamentoGerado->setObservacao($formData->get('observacao')->getData());

        foreach ($formData->get('codNorma')->getData() as $fkNormasNorma) {
            $assentamentoGeradoNorma = new AssentamentoGeradoNorma();
            $assentamentoGeradoNorma->setFkPessoalAssentamentoGerado($assentamentoGerado);
            $assentamentoGeradoNorma->setFkNormasNorma($fkNormasNorma);
            $this->entityManager->persist($assentamentoGerado);

            $assentamentoGerado->addFkPessoalAssentamentoGeradoNormas($assentamentoGeradoNorma);
        }

        $this->entityManager->persist($assentamentoGerado);
        $this->entityManager->flush();

        $object->addFkPessoalAssentamentoGerados($assentamentoGerado);
    }

    /**
     * Cria registro a partir do modulo contrato dentro de gerenciamento de servidor.
     * @param ContratoServidor $contratoServidor
     * @param TranslatorInterface $translator
     */
    public function gerarAssentamento(ContratoServidor $contratoServidor, TranslatorInterface $translator)
    {
        $assentamentoAssentamento = $this->assentamentoAssentamentoRepository->getAssentamentoByCodSubDivisao([
            'cod_sub_divisao' => $contratoServidor->getCodSubDivisao()
        ]);
        $stObservacao = "";
        $stDataInicioFim = null;
        $stObservacaoDetalhes = [
            '%regime%' => $contratoServidor->getFkPessoalRegime()->getDescricao(),
            '%subdivisao%' => $contratoServidor->getFkPessoalSubDivisao()->getDescricao(),
            '%cargo%' => $contratoServidor->getFkPessoalCargo()->getDescricao()
        ];
        $nomeacaoPosse = $contratoServidor->getFkPessoalContratoServidorNomeacaoPosses()->last();

        if ($assentamentoAssentamento->assentamento_automatico) {
            switch ($assentamentoAssentamento->cod_motivo) {
                case 11:
                    $stDataInicioFim = $nomeacaoPosse->getDtNomeacao();
                    $stObservacao = $translator->trans('label.contratoServidor.observacaoNomeacao', $stObservacaoDetalhes);
                    break;
                case 12:
                    $stDataInicioFim = $nomeacaoPosse->getDtPosse();
                    $stObservacao = $translator->trans('label.contratoServidor.observacaoPosse', $stObservacaoDetalhes);
                    break;
                case 13:
                    $stDataInicioFim = $nomeacaoPosse->getDtAdmissao();
                    $stObservacao = $translator->trans('label.contratoServidor.observacaoAdmissao', $stObservacaoDetalhes);
                    break;
            }
        }

        $fkPessoalAssentamentoAssentamento = $this->assentamentoAssentamentoRepository
            ->findOneByCodAssentamento($assentamentoAssentamento->cod_assentamento);

        /**
         * @var AssentamentoGeradoContratoServidor
         */
        $codAssentamentoGerado = $this->entityManager->getRepository(AssentamentoGeradoContratoServidor::class)
            ->getNextCodAssentamentoGerado($contratoServidor->getCodContrato());

        $assentamentoGeradoContratoServidor = new AssentamentoGeradoContratoServidor();
        $assentamentoGeradoContratoServidor->setCodAssentamentoGerado($codAssentamentoGerado);
        $assentamentoGeradoContratoServidor->setFkPessoalContrato($contratoServidor->getFkPessoalContrato());
        $this->entityManager->persist($assentamentoGeradoContratoServidor);

        /**
         * @var AssentamentoGerado
         */
        $assentamentoGerado = new AssentamentoGerado();
        $assentamentoGerado->setFkPessoalAssentamentoAssentamento($fkPessoalAssentamentoAssentamento);
        $assentamentoGerado->setFkPessoalAssentamentoGeradoContratoServidor($assentamentoGeradoContratoServidor);
        $assentamentoGerado->setPeriodoInicial($stDataInicioFim);
        $assentamentoGerado->setPeriodoFinal($stDataInicioFim);
        $assentamentoGerado->setObservacao($stObservacao);
        $this->entityManager->persist($assentamentoGerado);

        /**
         * @var AssentamentoGeradoNorma
         */
        $assentamentoGeradoNorma = new AssentamentoGeradoNorma();
        $assentamentoGeradoNorma->setFkNormasNorma($contratoServidor->getFkNormasNorma());
        $assentamentoGeradoNorma->setFkPessoalAssentamentoGerado($assentamentoGerado);
        $this->entityManager->persist($assentamentoGeradoNorma);

        $this->entityManager->flush();
    }

    /**
     * @param $codContrato
     * @param $codAssentamento
     * @return bool
     */
    public function registrarEventoPorAssentamento($codContrato, $codAssentamento)
    {
        return $this->repository->registrarEventoPorAssentamento($codContrato, $codAssentamento);
    }
}
