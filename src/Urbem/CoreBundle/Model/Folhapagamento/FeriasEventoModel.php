<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoFerias;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FeriasEventoModel
 * @package Urbem\CoreBundle\Model\Folhapagamento
 */
class FeriasEventoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(FeriasEvento::class);
    }

    /**
     * A edição na verdade é um inserção para manter o histórico de configurações
     * @param  array $formData
     * @param  \Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento $object
     * @param  object $modelManager
     */
    public function persistFeriasEvento($formData, \Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento $object, $modelManager)
    {
        $fields = $this->entityManager->getRepository("CoreBundle:Folhapagamento\TipoEventoFerias")
        ->findAll();

        foreach ($fields as $field) {
            $fkFolhaPagamentoEvento = $modelManager
            ->find(Evento::class, $formData['stInner_Cod_' . $field->getCodTipo()]);

            $feriasEvento = new FeriasEvento();
            $feriasEvento->setFkFolhapagamentoTipoEventoFerias($field);
            $feriasEvento->setFkFolhapagamentoEvento($fkFolhaPagamentoEvento);
            $this->entityManager->persist($feriasEvento);
        }

        $this->entityManager->flush();
    }

    public function getEventosByNaturezaQuery(Request $request)
    {
        $natureza = $request->get('natureza', false);

        $eventos = (new EventoModel($this->entityManager))
        ->getApiEventoPorNatureza([
            'q' => $request->get('q'),
            'natureza' => $request->get('natureza')
        ]);

        $eventoIdArray = [];

        foreach ($eventos as $evento) {
            $codEventoArray[] = $evento->cod_evento;
        }

        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select('e')
            ->from(Evento::class, 'e')
            ->where(
                $queryBuilder->expr()->in('e.codEvento', $codEventoArray)
            )
            ->orderBy('e.descricao')
        ;

        return $queryBuilder;
    }
}
