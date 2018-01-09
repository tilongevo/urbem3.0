<?php

namespace Urbem\CoreBundle\Model\Tesouraria;

use Doctrine\ORM;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\AbstractModel;

class TransferenciaModel extends AbstractModel
{
    const PAGAMENTO_EXTRA = 1;
    const ARRECADACAO_EXTRA = 2;
    const APLICACAO = 3;
    const RESGATE = 4;
    const DEPOSITO = 5;
    const TIPO_LOTE = 'T';
    const TIPO_AUTENTICACAO = 'E ';

    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:Tesouraria\Arrecadacao');
    }

    public static function getTipoTransferencia($tipo)
    {
        return self::getTipoDisponivel()[$tipo];
    }

    public static function getTipoDisponivel()
    {
        return [
            self::PAGAMENTO_EXTRA => 'Pagamento Extra',
            self::ARRECADACAO_EXTRA => 'Arrecadação Extra',
            self::APLICACAO => 'Aplicação',
            self::RESGATE => 'Resgate',
            self::DEPOSITO => 'Depósito',
        ];
    }

    public function parseTransferencia(
        Entity\Tesouraria\Transferencia $transferencia,
        \stdClass $formContent,
        $exercicio,
        $tipoMovimento = self::PAGAMENTO_EXTRA
    ) {
        $tipoLote = 'T';
        $tipoAutenticacao = 'T';

        $em = $this->entityManager;
        $transferenciaRepository = $em->getRepository(Entity\Tesouraria\Transferencia::class);

        $nomLote = sprintf(
            'Transferência - CD: %s | CC: %s',
            $transferencia->getCodPlanoCredito(),
            $transferencia->getCodPlanoDebito()
        );
        // Gera lote
        $codLote = $transferenciaRepository->gerarLote(
            $exercicio,
            $transferencia->getCodEntidade(),
            $nomLote,
            $transferencia->getFkTesourariaBoletim()->getDtBoletim()->format('d/m/Y')
        );

        $LoteModel = new Model\Contabilidade\LoteModel($em);
        $objLote = $LoteModel->findOneBy([
            'codLote' => $codLote,
            'exercicio' => $exercicio,
            'codEntidade' => $transferencia->getCodEntidade(),
            'tipo' => $tipoLote
        ]);
        $transferencia->setFkContabilidadeLote($objLote);

        // Set Exercicio
        // TODO: Filtrar os campos do formulário por Exercicio, para evitar divergencia
        $transferencia->setExercicio($exercicio);

        // Set FkTesourariaUsuarioTerminal
        $transferencia->setFkTesourariaUsuarioTerminal(
            $transferencia->getFkTesourariaBoletim()->getFkTesourariaUsuarioTerminal()
        );

        $tipoTransferenciaModel = new Model\Tesouraria\TipoTransferenciaModel($em);
        $objTipoTransferencia = $tipoTransferenciaModel->findOneBy([
            'codTipo' => $tipoMovimento
        ]);
        $transferencia->setFkTesourariaTipoTransferencia($objTipoTransferencia);

        // Set fkTesourariaAutenticacao
        $repository = $em->getRepository('CoreBundle:Tesouraria\Arrecadacao');

        $dtBoletim = $transferencia->getFkTesourariaBoletim()->getDtBoletim();
        $codAutenticadao = $repository->getCodAutenticacao($dtBoletim->format('d/m/Y'));
        $tipo = $em->getRepository('CoreBundle:Tesouraria\TipoAutenticacao')->find($tipoAutenticacao);

        $autenticacao = new Entity\Tesouraria\Autenticacao();
        $autenticacao->setCodAutenticacao($codAutenticadao);
        $autenticacao->setDtAutenticacao(new DateTimeMicrosecondPK());
        $autenticacao->setTipo($tipo);

        $em->persist($autenticacao);
        $transferencia->setFkTesourariaAutenticacao($autenticacao);

        // Set fkTransferenciaCredor
        if (property_exists($formContent, 'codCredor') && !empty($formContent->codCredor)) {
            $cgmCredor = $em->getRepository(Entity\SwCgm::class)->findOneByNumcgm($formContent->codCredor);

            $objTransferenciaCredor = new Entity\Tesouraria\TransferenciaCredor();
            $objTransferenciaCredor->setFkTesourariaTransferencia($transferencia);
            $objTransferenciaCredor->setFkSwCgm($cgmCredor);
            $transferencia->setFkTesourariaTransferenciaCredor($objTransferenciaCredor);
        }

        // Set fkTransferenciaRecurso
        if (property_exists($formContent, 'codRecurso') && !empty($formContent->codRecurso)) {
            $objTransferenciaRecurso = new Entity\Tesouraria\TransferenciaRecurso();
            $objTransferenciaRecurso->setFkTesourariaTransferencia($transferencia);
            $objTransferenciaRecurso->setCodRecurso($formContent->codRecurso);
            $transferencia->setFkTesourariaTransferenciaRecurso($objTransferenciaRecurso);
        }

        // Set fkReciboExtraTransferencia
        if (property_exists($formContent, 'codRecibo') && !empty($formContent->codRecibo)) {
            $codRecibo = $em->getRepository(Entity\Tesouraria\ReciboExtra::class)->findOneBy(
                ['codReciboExtra' => $formContent->codRecibo, 'exercicio' => $exercicio]
            );

            $objReciboExtraTransferencia = new Entity\Tesouraria\ReciboExtraTransferencia();
            $objReciboExtraTransferencia->setFkTesourariaTransferencia($transferencia);
            $objReciboExtraTransferencia->setFkTesourariaReciboExtra($codRecibo);
            $transferencia->addFkTesourariaReciboExtraTransferencias($objReciboExtraTransferencia);
        }

        // Set FkHistorico
        $codHistorico = $em->getRepository(Entity\Contabilidade\HistoricoContabil::class)->findOneBy(
            ['codHistorico' => $formContent->codHistorico, 'exercicio' => $exercicio]
        );

        $transferencia->setFkContabilidadeHistoricoContabil($codHistorico);

        return $transferencia;
    }

    /**
     * @param $transferencia
     * @param $formData
     * @param $currentUser
     * @param $translator
     * @return string|Entity\Tesouraria\TransferenciaEstornada
     */
    public function realizarArrecadacaoExtraEstorno($transferencia, $formData, $currentUser, $translator)
    {
        try {
            $em = $this->entityManager;

            $boletimEstorno = $formData->get('boletimEstorno')->getData();
            $historicoPadrao = $formData->get('historicoPadrao')->getData();

            $valor = $formData->get('valor')->getData();
            $observacao = $formData->get('observacao')->getData();

            $usuarioTerminal = $em->getRepository(Entity\Tesouraria\UsuarioTerminal::class)
                ->findOneByCgmUsuario($currentUser->getFkSwCgm()->getNumcgm(), array('codTerminal' => 'DESC'));

            $tipoAutenticacao = $em->getRepository(Entity\Tesouraria\TipoAutenticacao::class)
                ->findOneByCodTipoAutenticacao(self::TIPO_AUTENTICACAO);

            $codAutenticacao = $em->getRepository(Entity\Tesouraria\Autenticacao::class)
                ->recuperaUltimoCodigoAutenticacao(
                    array(
                        'dt_autenticacao' => $boletimEstorno->getDtBoletim()->format('d/m/Y')
                    )
                );

            $dtAutenticacao = new DateTimeMicrosecondPK($boletimEstorno->getDtBoletim()->format('Y-m-d'));
            $autenticacao = new Entity\Tesouraria\Autenticacao();
            $autenticacao->setFkTesourariaTipoAutenticacao($tipoAutenticacao);
            $autenticacao->setDtAutenticacao($dtAutenticacao);
            $autenticacao->setCodAutenticacao($codAutenticacao['codigo'] + 1);

            $transferenciaEstornada = new Entity\Tesouraria\TransferenciaEstornada();
            $transferenciaEstornada->setFkTesourariaBoletim($boletimEstorno);
            $transferenciaEstornada->setFkTesourariaTransferencia($transferencia);
            $transferenciaEstornada->setFkTesourariaAutenticacao($autenticacao);
            $transferenciaEstornada->setFkContabilidadeHistoricoContabil($historicoPadrao);
            $transferenciaEstornada->setFkTesourariaUsuarioTerminal($usuarioTerminal);
            $transferenciaEstornada->setObservacao($observacao);
            $transferenciaEstornada->setValor($valor);

            $nomLote = $translator
                ->trans(
                    'nomLote',
                    array(
                        '%contaReceita%' => $transferencia->getCodPlanoCredito(),
                        '%contaCaixaBanco%' => $transferencia->getCodPlanoDebito(),
                    )
                );

            $codLote = $em->getRepository(Entity\Empenho\Empenho::class)->fnInsereLote(
                $transferencia->getExercicio(),
                $transferencia->getCodEntidade(),
                self::TIPO_LOTE,
                $nomLote,
                $boletimEstorno->getDtBoletim()->format('d/m/Y')
            );

            $em->getRepository(Entity\Contabilidade\Lancamento::class)->insereLancamento(
                $transferencia->getExercicio(),
                $transferencia->getCodPlanoCredito(),
                $transferencia->getCodPlanoDebito(),
                $valor,
                $codLote,
                $transferencia->getCodEntidade(),
                $historicoPadrao->getCodHistorico(),
                self::TIPO_LOTE,
                ''
            );

            $lote = $em->getRepository(Entity\Contabilidade\Lote::class)
                ->findOneBy(
                    array(
                        'codLote' => $codLote,
                        'exercicio' => $transferencia->getExercicio(),
                        'tipo' => self::TIPO_LOTE,
                        'codEntidade' => $transferencia->getCodEntidade()
                    )
                );

            $transferenciaEstornada->setFkContabilidadeLote($lote);
            $em->persist($transferenciaEstornada);
            $em->flush();
            return $transferenciaEstornada;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
