<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Pessoal\AdidoCedido;
use Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoLocal;
use Urbem\CoreBundle\Entity\Pessoal\AdidoCedidoExcluido;

class AdidoCedidoModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct($entityManager = null)
    {
        if (! $entityManager) {
            global $kernel;
            if ('AppCache' == get_class($kernel)) {
                $kernel = $kernel->getKernel();
            }

            $entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        }
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\AdidoCedido");
    }

    public function getCodAdidoCedidoByCodAdidoCedido($codAdidoCedido)
    {
        return $this->repository->findOneByCodAdidoCedido($codAdidoCedido);
    }

    public function getAdidoCedidoLocal($adidoCedido)
    {
        return $this->entityManager->getRepository('CoreBundle:Pessoal\AdidoCedidoLocal')
        ->findOneBy(
            array(
                'timestamp' => $adidoCedido->getTimestamp(),
                'codNorma' => $adidoCedido->getCodNorma(),
                'codContrato' => $adidoCedido->getCodContrato()
            )
        );
    }

    public function manualPersist($object)
    {
        try {
            $this->entityManager->beginTransaction();

            $adidoCedido = new AdidoCedido();
            $adidoCedido->setDtInicial($object->get('dtDataInicialAto')->getData());
            $adidoCedido->setDtFinal($object->get('dtDataFinalAto')->getData());
            $adidoCedido->setTipoCedencia($object->get('stTipoCedencia')->getData());
            $adidoCedido->setIndicativoOnus($object->get('stIndicativoOnus')->getData());
            $adidoCedido->setNumConvenio($object->get('inCodConvenioTxt')->getData());
            $adidoCedido->setCgmCedenteCessionario($object->get('inCGM')->getData());
            $adidoCedido->setCodNorma($object->get('stNrNormaTxt')->getData());
            $adidoCedido->setCodContrato($object->get('inContrato')->getData());

            $this->entityManager->persist($adidoCedido);
            $this->entityManager->flush();

            $adidoCedidoLocal = new AdidoCedidoLocal();
            $adidoCedidoLocal->setTimestamp($adidoCedido->getTimestamp());
            $adidoCedidoLocal->setCodNorma($object->get('stNrNormaTxt')->getData()->getCodNorma());
            $adidoCedidoLocal->setCodContrato($object->get('inContrato')->getData()->getCodContrato());
            $adidoCedidoLocal->setCodLocal($object->get('inCodLocal')->getData());

            $this->entityManager->persist($adidoCedidoLocal);
            $this->entityManager->flush();

            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function manualUpdate($object, $id)
    {

        try {
            $this->entityManager->beginTransaction();

            $adidoCedido = $this->getCodAdidoCedidoByCodAdidoCedido($id);
            $adidoCedidoLocal = $this->getAdidoCedidoLocal($adidoCedido);

            $adidoCedido->setDtInicial($object->get('dtDataInicialAto')->getData());
            $adidoCedido->setDtFinal($object->get('dtDataFinalAto')->getData());
            $adidoCedido->setTipoCedencia($object->get('stTipoCedencia')->getData());
            $adidoCedido->setIndicativoOnus($object->get('stIndicativoOnus')->getData());
            $adidoCedido->setNumConvenio($object->get('inCodConvenioTxt')->getData());
            $adidoCedido->setCgmCedenteCessionario($object->get('inCGM')->getData());
            $adidoCedido->setCodNorma($object->get('stNrNormaTxt')->getData());
            $adidoCedido->setCodContrato($object->get('inContrato')->getData());

            $this->entityManager->persist($adidoCedido);
            $this->entityManager->flush();

            if ($adidoCedidoLocal) {
                $adidoCedidoLocal->setCodNorma($object->get('stNrNormaTxt')->getData()->getCodNorma());
                $adidoCedidoLocal->setCodContrato($object->get('inContrato')->getData()->getCodContrato());
                $adidoCedidoLocal->setCodLocal($object->get('inCodLocal')->getData());

                $this->entityManager->persist($adidoCedidoLocal);
                $this->entityManager->flush();
            }

            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw new \Exception($e->getMessage());
        }
    }

    public function manualRemove($object, $id)
    {
        try {
            $this->entityManager->beginTransaction();

            $adidoCedido = $this->getCodAdidoCedidoByCodAdidoCedido($id);
            $adidoCedidoLocal = $this->getAdidoCedidoLocal($adidoCedido);

            $adidoCedidoExcluido = new AdidoCedidoExcluido();
            $adidoCedidoExcluido->setCodNorma($adidoCedido->getCodNorma()->getCodNorma());

            if ($adidoCedido->getCodContrato()) {
                $adidoCedidoExcluido->setCodContrato($adidoCedido->getCodContrato()->getCodContrato());
            }
            $adidoCedidoExcluido->setTimestampCedidoAdido($adidoCedido->getTimestamp());

            $this->entityManager->persist($adidoCedidoExcluido);
            $this->entityManager->flush();

            if ($adidoCedidoLocal) {
                $this->entityManager->remove($adidoCedidoLocal);
                $this->entityManager->flush();
            }

            $this->entityManager->remove($adidoCedido);
            $this->entityManager->flush();

            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function recuperaAdidosCedidosSEFIP()
    {
        return $this->repository->recuperaAdidosCedidosSEFIP();
    }

    /**
     * @param bool $filtro
     *
     * @return mixed
     */
    public function recuperaAdidosCedidosSEFIPContratos($filtro = false)
    {
        return $this->repository->recuperaAdidosCedidosSEFIPContratos($filtro);
    }
}
