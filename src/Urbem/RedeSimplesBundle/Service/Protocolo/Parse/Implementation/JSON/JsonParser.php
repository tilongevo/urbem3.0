<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo\Parse\Implementation\JSON;

use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherResultInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\Parse\ParserInterface;

class JsonParser implements ParserInterface
{
    /**
     * @param FetcherResultInterface $result
     *
     * @return array
     */
    public function parse(FetcherResultInterface $result)
    {
        try {
            $json = json_decode($result->getData(), true);

            if (JSON_ERROR_NONE !== json_last_error()) {
                throw new \Exception();
            }

        } catch (\Exception $e) {
            throw new \InvalidArgumentException(sprintf(
                '%s->getData() expected a valid json as return. The following error
                was found during json_decode: %s',
                get_class($result),
                json_last_error_msg()
            ));
        }

        return $json;
    }
}
