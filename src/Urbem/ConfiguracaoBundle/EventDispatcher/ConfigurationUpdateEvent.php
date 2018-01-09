<?php

namespace Urbem\ConfiguracaoBundle\EventDispatcher;

use Symfony\Component\EventDispatcher\Event;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;

class ConfigurationUpdateEvent extends Event
{
    /**
     * @var Modulo
     */
    protected $module;

    /**
     * @var string
     */
    protected $year;

    public function __construct(Modulo $module, $year)
    {
        $this->module = $module;
        $this->year = (string) $year;
    }

    /**
     * @param $item
     * @return string
     */
    public function get($item)
    {
        /** @var Configuracao $configuration */
        $configuration = $this->module->getFkAdministracaoConfiguracoes($item, $this->year, true);

        if (false === $configuration instanceof Configuracao) {
            return null;
        }

        return (string) $configuration->getValor();
    }
}
