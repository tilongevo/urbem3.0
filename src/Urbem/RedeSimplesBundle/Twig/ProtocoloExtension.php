<?php

namespace Urbem\RedeSimplesBundle\Twig;

use Urbem\CoreBundle\Entity\RedeSimples\Protocolo;
use Urbem\CoreBundle\Entity\RedeSimples\ProtocoloItem;
use Urbem\RedeSimplesBundle\Model\ProtocoloModel;

class ProtocoloExtension extends \Twig_Extension
{
    /**
     * @var ProtocoloModel
     */
    protected $protocoloModel;

    /**
     * ProtocoloExtension constructor.
     * @param ProtocoloModel $protocoloModel
     */
    public function __construct(ProtocoloModel $protocoloModel)
    {
        $this->protocoloModel = $protocoloModel;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('protocoloConvertItemToView', [$this, 'convertItemToView']),
            new \Twig_SimpleFunction('protocoloCanCheckStatus', [$this, 'canCheckStatus']),
        ];
    }

    /**
     * @param ProtocoloItem $protocoloItem
     * @return string
     */
    public function convertItemToView(ProtocoloItem $protocoloItem)
    {
        $value = json_decode($protocoloItem->getValor(), true);

        return (string) (true === is_array($value) ? implode(', ', $value) : $value);
    }

    /**
     * @param Protocolo $protocolo
     * @return boolean
     */
    public function canCheckStatus(Protocolo $protocolo)
    {
        return $this->protocoloModel->canCheckStatus($protocolo);
    }

    public function getName()
    {
        return 'protocolo';
    }
}
