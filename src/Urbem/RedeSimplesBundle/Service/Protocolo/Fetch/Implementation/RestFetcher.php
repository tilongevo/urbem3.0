<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\Implementation;

use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherParameters;
use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherResult;
use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherResultInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\ParameterBagInterface;

class RestFetcher implements FetcherInterface
{
    /**
     * @param ParameterBagInterface $parameters
     * @return FetcherResultInterface
     */
    public function fetch(ParameterBagInterface $parameters)
    {
        $ch = curl_init($parameters->get(FetcherParameters::ENDPOINT));

        $headers = [
            'User-Agent: Urbem-RedeSimples1.0',
            'Content-Type: application/json',
            'Cache-Control: no-cache',
            'Accept: application/json',
        ];

        if ($parameters->has(FetcherParameters::TOKEN)) {
            $headers[] = sprintf('X-ST: %s', $parameters->get(FetcherParameters::TOKEN));
        }
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($parameters->has(FetcherParameters::METHOD)) {
            if ($parameters->get(FetcherParameters::METHOD) === 'POST') {
                curl_setopt($ch, CURLOPT_POST, true);
            }
        }

        if ($parameters->has(FetcherParameters::POST_FIELDS)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($parameters->get(FetcherParameters::POST_FIELDS)));
        }

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = new FetcherResult(curl_exec($ch));
        $result->setCode(curl_getinfo($ch, CURLINFO_HTTP_CODE));

        curl_close($ch);

        return $result;
    }
}
