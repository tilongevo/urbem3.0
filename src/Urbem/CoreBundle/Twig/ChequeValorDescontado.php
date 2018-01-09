<?php

namespace Urbem\CoreBundle\Twig;

class ChequeValorDescontado extends \Twig_Extension
{

    private $chequeService;

    public function __construct($chequeService)
    {
        $this->chequeService = $chequeService;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('chequeValorDescontado', array($this, 'chequeValorDescontado')),
        );
    }

    public function chequeValorDescontado($object)
    {
        $array = explode('\\', get_class($object));
        $valor = null;
        switch (end($array)) {
            case 'Transferencia':
                $valor = $this->chequeService->getValorChequeEmissaoTransferencia($object->getCodLote(), $object->getExercicio(), $object->getCodEntidade(), $object->getTipo());
                break;
            case 'OrdemPagamento':
                $valor = $this->chequeService->getValorChequeEmissao($object->getCodOrdem(), $object->getExercicio(), $object->getCodEntidade());
                break;
        }

        if (!empty($valor)) {
            $valor = number_format($valor, 2, ',', '.');
        }

        return $valor;
    }

    public function getName()
    {
        return 'cheque_cheque_descontado_extension';
    }
}
