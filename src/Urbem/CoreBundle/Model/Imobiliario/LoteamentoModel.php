<?php

namespace Urbem\CoreBundle\Model\Imobiliario;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\Loteamento;
use Urbem\CoreBundle\Entity\Imobiliario\LoteamentoLoteOrigem;
use Urbem\CoreBundle\Entity\Imobiliario\LoteLoteamento;
use Urbem\CoreBundle\Entity\Imobiliario\ProcessoLoteamento;

class LoteamentoModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var ORM\EntityRepository
     */
    protected $repository;

    /**
     * NivelModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Loteamento::class);
    }

    /**
     * @return int
     */
    public function getNextVal()
    {
        return $this->repository->getNextVal();
    }

    /**
     * @param Loteamento $loteamento
     * @param $request
     */
    public function manterLotes(Loteamento $loteamento, $request)
    {
        if ($loteamento->getFkImobiliarioLoteLoteamentos()->count()) {
            /** @var LoteLoteamento $loteLoteamento */
            foreach ($loteamento->getFkImobiliarioLoteLoteamentos() as $loteLoteamento) {
                if (!in_array($this->getObjectIdentifier($loteLoteamento), ($request->get('lotes_old')) ? $request->get('lotes_old') : array())) {
                    $loteamento->getFkImobiliarioLoteLoteamentos()->removeElement($loteLoteamento);
                }
            }
        }

        $lotes = $request->get('lotes');
        $lotesCaucionados = $request->get('lotes_caucionados');

        foreach ($lotes as $key => $lote) {
            if ($lote != '') {
                /** @var Lote $lote */
                $lote = $this->entityManager->getRepository(Lote::class)->find($lote);
                $loteLoteamento = new LoteLoteamento();
                $loteLoteamento->setCaucionado(((int) $lotesCaucionados[$key] == 1) ? true : false);
                $loteLoteamento->setFkImobiliarioLote($lote);
                $loteamento->addFkImobiliarioLoteLoteamentos($loteLoteamento);
            }
        }
    }

    /**
     * @param Loteamento $loteamento
     * @param $form
     * @param $request
     */
    public function popularLoteamento(Loteamento $loteamento, $form, $request)
    {
        $loteamento->setCodLoteamento($this->getNextVal());

        $loteamentoLoteOrigem = new LoteamentoLoteOrigem();
        $loteamentoLoteOrigem->setDtAprovacao($form->get('loteamentoLoteOrigen_dtAprovacao')->getData());
        $loteamentoLoteOrigem->setDtLiberacao($form->get('loteamentoLoteOrigen_dtLiberacao')->getData());
        $loteamentoLoteOrigem->setFkImobiliarioLote($form->get('lote')->getData());
        $loteamento->addFkImobiliarioLoteamentoLoteOrigens($loteamentoLoteOrigem);

        if ($form->get('fkSwProcesso')->getData()) {
            $processoLoteamento = new ProcessoLoteamento();
            $processoLoteamento->setFkSwProcesso($form->get('fkSwProcesso')->getData());
            $loteamento->addFkImobiliarioProcessoLoteamentos($processoLoteamento);
        }

        $this->manterLotes($loteamento, $request);
    }

    /**
     * @param Loteamento $loteamento
     * @param $form
     * @param $request
     */
    public function alterarLoteamento(Loteamento $loteamento, $form, $request)
    {
        $loteamentoLoteOrigem = $loteamento->getFkImobiliarioLoteamentoLoteOrigens()->current();
        $loteamentoLoteOrigem->setDtAprovacao($form->get('loteamentoLoteOrigen_dtAprovacao')->getData());
        $loteamentoLoteOrigem->setDtLiberacao($form->get('loteamentoLoteOrigen_dtLiberacao')->getData());
        $loteamento->addFkImobiliarioLoteamentoLoteOrigens($loteamentoLoteOrigem);

        if (($form->get('fkSwProcesso')->getData()) && (!$loteamento->getFkImobiliarioProcessoLoteamentos()->count())) {
            $processoLoteamento = new ProcessoLoteamento();
            $processoLoteamento->setFkSwProcesso($form->get('fkSwProcesso')->getData());
            $loteamento->addFkImobiliarioProcessoLoteamentos($processoLoteamento);
        }

        $this->manterLotes($loteamento, $request);
    }
}
