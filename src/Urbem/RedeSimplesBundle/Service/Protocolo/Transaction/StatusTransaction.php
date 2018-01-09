<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Transaction;

use Urbem\CoreBundle\Entity\RedeSimples\Protocolo;
use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherParameters;
use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherResult;
use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherResultInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\ParameterBag;
use Urbem\RedeSimplesBundle\Service\Protocolo\ProtocoloException;

class StatusTransaction extends AbstractTransaction
{
    /**
     * @param Protocolo $protocolo
     * @return Protocolo
     * @throws ProtocoloException
     */
    public function transact(Protocolo $protocolo)
    {
        if (false === $this->protocoloModel->canCheckStatus($protocolo)) {
            throw new \OutOfBoundsException(sprintf(
                '%s can be checked, please check ProtocoloModel.canCheckStatus',
                $protocolo->getProtocolo()
            ));
        }

        $result = $this->fetcher->fetch(new FetcherParameters([
            FetcherParameters::ENDPOINT => $this->parameters->get(ParameterBag::ENDPOINT_STATUS),
            FetcherParameters::ENDPOINT => $this->parameters->get(ParameterBag::ENDPOINT_STATUS),
            FetcherParameters::TOKEN => $this->parameters->get(ParameterBag::ENDPOINT_TOKEN),
            FetcherParameters::METHOD => 'POST',
            FetcherParameters::POST_FIELDS => ['protocol' => $protocolo->getProtocolo()]
        ]));

        if (false === is_object($result) || false === is_subclass_of($result, FetcherResultInterface::class)) {
            throw ProtocoloException::expectedMethodReturnType(FetcherInterface::class, 'fetch', FetcherResultInterface::class, $result);
        }

        if (FetcherResult::OK !== $result->getCode()) {
            throw ProtocoloException::invalidResponse($result);
        }

        return $this->protocoloModel->setChecked($protocolo, $this->processor->process($result, $this->parser));
    }
}
