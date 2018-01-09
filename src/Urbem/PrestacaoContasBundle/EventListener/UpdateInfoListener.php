<?php

namespace Urbem\PrestacaoContasBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\Event;
use Urbem\ConfiguracaoBundle\EventDispatcher\ConfigurationUpdateEvent;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\PrestacaoContasBundle\Service\WritePrefeituraInfo;

/**
 * Class WritePrefeituraInfo
 *
 * @package Urbem\PrestacaoContasBundle\Service
 */
class UpdateInfoListener extends Event
{
    /**
     * @var WritePrefeituraInfo
     */
    protected $writer;

    /**
     * @var
     */
    protected $entityManager;

    /**
     * UpdateInfoListener constructor.
     * @param \Urbem\PrestacaoContasBundle\Service\WritePrefeituraInfo $writer
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(WritePrefeituraInfo $writer, EntityManager $entityManager)
    {
        $this->writer = $writer;
        $this->entityManager = $entityManager;
    }

    /**
     * @param $codUf
     * @return string
     */
    private function getSiglaUf($codUf)
    {
        $repository = $this->entityManager->getRepository(SwUf::class);

        $param = ['siglaUf' => $codUf];
        if (is_numeric($codUf)) {
            $param = ['codUf' => $codUf];
        }

        $swUf = $repository->findOneBy($param);
        return !empty($swUf) ? $swUf->getSiglaUf() : '';
    }

    /**
     * @param \Urbem\ConfiguracaoBundle\EventDispatcher\ConfigurationUpdateEvent $event
     */
    public function onUpdate(ConfigurationUpdateEvent $event)
    {
        $this->writer->write('nome', $event->get('nom_prefeitura'));
        $this->writer->write('email', $event->get('e_mail'));
        $this->writer->write('uf', $this->getSiglaUf($event->get('cod_uf')));
    }
}
