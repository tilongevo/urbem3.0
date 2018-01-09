<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia;
use Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaRegimeRat;
use Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoPrevidencia;
use Urbem\CoreBundle\Helper\NumberHelper;

class PrevidenciaPrevidenciaModel extends AbstractModel
{
    const EVENTO_DESCONTO = 'D';
    const EVENTO_TIPO_DESCONTO = 1;
    const EVENTO_BASE = 'B';
    const EVENTO_TIPO_BASE = 2;

    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\PrevidenciaPrevidencia");
    }

    public function canRemove($object)
    {
        $checkContratoServidor = $this->entityManager->getRepository("CoreBundle:Pessoal\\ContratoServidorPrevidencia");
        $resContratoServidor = $checkContratoServidor->findOneByCodPrevidencia($object->getCodPrevidencia());

        return is_null($resContratoServidor);
    }

    public function saveAliquota(PrevidenciaPrevidencia $previdenciaPrevidencia, Form $form, $id)
    {
        if (!is_null($id)) {
            $aliquota = $previdenciaPrevidencia->getFkFolhapagamentoPrevidenciaRegimeRat();
            $aliquota = (null === $aliquota)
                ? $this->createNewRegimeRat($previdenciaPrevidencia)
                : $aliquota
            ;
        } else {
            $aliquota = $this->createNewRegimeRat($previdenciaPrevidencia);
        }

        $aliquotaRat = NumberHelper::floatToDatabase($form->get('aliquota_rat')->getData());
        $aliquotaFap = NumberHelper::floatToDatabase($form->get('aliquota_fap')->getData());

        $aliquota
            ->setAliquotaFap($aliquotaFap)
            ->setAliquotaRat($aliquotaRat)
            ->setFkFolhapagamentoPrevidenciaPrevidencia($previdenciaPrevidencia)
        ;

        $this->entityManager->persist($aliquota);
        $this->entityManager->flush();
    }

    private function createNewRegimeRat(PrevidenciaPrevidencia $previdenciaPrevidencia)
    {
        return (new PrevidenciaRegimeRat())->setFkFolhapagamentoPrevidenciaPrevidencia($previdenciaPrevidencia);
    }

    public function saveEvents(PrevidenciaPrevidencia $previdenciaPrevidencia, Form $form, $id)
    {
        if (! is_null($id)) {
            // Edit
            $ped = $this->entityManager
                ->getRepository(PrevidenciaEvento::class)
                ->findOneBy([
                    'fkFolhapagamentoPrevidenciaPrevidencia' => $previdenciaPrevidencia,
                    'codTipo' => self::EVENTO_TIPO_DESCONTO,
                ]);
            $peb = $this->entityManager
                ->getRepository(PrevidenciaEvento::class)
                ->findOneBy([
                    'fkFolhapagamentoPrevidenciaPrevidencia' => $previdenciaPrevidencia,
                    'codTipo' => self::EVENTO_TIPO_BASE,
                ]);
        } else {
            $ped = new PrevidenciaEvento();
            $peb = new PrevidenciaEvento();
        }

        // Salvando eventos
        $desconto = $form->get('cod_evento_d_cod')->getData();
        $base = $form->get('cod_evento_b_cod')->getData();

        $objEventoDesconto = $this->entityManager->getRepository(Evento::class)->findOneBy(['codEvento' => $desconto]);
        $objEventoBase = $this->entityManager->getRepository(Evento::class)->findOneBy(['codEvento' => $base]);

        $eventoDesconto = $this->entityManager->getRepository(TipoEventoPrevidencia::class)
            ->findOneBy([
                'codTipo' => self::EVENTO_TIPO_DESCONTO
            ]);

        $eventoBase = $this->entityManager->getRepository(TipoEventoPrevidencia::class)
            ->findOneBy([
                'codTipo' => self::EVENTO_TIPO_BASE
            ]);

        $ped->setFkFolhapagamentoPrevidenciaPrevidencia($previdenciaPrevidencia)
            ->setFkFolhapagamentoEvento($objEventoDesconto)
            ->setFkFolhapagamentoTipoEventoPrevidencia($eventoDesconto)
        ;

        $peb->setFkFolhapagamentoPrevidenciaPrevidencia($previdenciaPrevidencia)
            ->setFkFolhapagamentoEvento($objEventoBase)
            ->setFkFolhapagamentoTipoEventoPrevidencia($eventoBase)
        ;

        $this->entityManager->persist($peb);
        $this->entityManager->persist($ped);

        $this->entityManager->flush();
    }

    /**
     * @param string $natureza
     *
     * @return bool
     */
    public function getEvents($natureza)
    {
        if (!in_array($natureza, ['D', 'B'])) {
            return false;
        }

        $em = $this->entityManager->getConnection();
        $sql = "SELECT
          FPE.cod_evento
          , FPE.codigo
          , TRIM(FPE.descricao) as descricao
          , FPE.natureza
          , FPE.sigla
          , CASE WHEN FPE.natureza = 'P' THEN 'Proventos'
            WHEN FPE.natureza = 'I' THEN 'Informativos'
            WHEN FPE.natureza = 'B' THEN 'Base'
            ELSE 'Descontos'
            END AS proventos_descontos
          , FPE.tipo
          , FPE.fixado
          , FPE.limite_calculo
          , FPE.apresenta_parcela
          , FPE.evento_sistema
          , FPEE.timestamp
          , FPEE.valor_quantidade
          , FPEE.unidade_quantitativa
          , FPEE.observacao
          , FSCE.cod_sequencia
          , FPE.cod_verba
          , FPE.apresentar_contracheque
FROM folhapagamento.evento AS FPE
  , folhapagamento.evento_evento AS FPEE
  LEFT JOIN folhapagamento.sequencia_calculo_evento AS FSCE
    ON FSCE.cod_evento = FPEE.cod_evento
  , (   SELECT FPEE.cod_evento
          , MAX (FPEE.timestamp) AS timestamp
        FROM folhapagamento.evento_evento FPEE
        GROUP BY FPEE.cod_evento
    ) AS MAX_FPEE
WHERE FPE.cod_evento  = MAX_FPEE.cod_evento
      AND FPEE.timestamp  = MAX_FPEE.timestamp
      AND FPE.cod_evento  = FPEE.cod_evento
      AND natureza = :natureza AND evento_sistema = true Order by codigo;";

        $s = $em->prepare($sql);
        $s->bindParam(':natureza', $natureza, \PDO::PARAM_STR);
        $s->execute();


        return $s->fetchAll();
    }
}
