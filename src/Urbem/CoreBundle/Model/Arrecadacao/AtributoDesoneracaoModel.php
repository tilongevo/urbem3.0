<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracao;
use Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao;

/**
 * Class AtributoDesoneracaoModel
 * @package Urbem\CoreBundle\Model\Arrecadacao
 */
class AtributoDesoneracaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * AtributoDesoneracaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(AtributoDesoneracao::class);
    }

    /**
     * @param Desoneracao $desoneracao
     * @param array $fkArrecadacaoAtributoDesoneracoes
     */
    public function saveAtributoDesoneracao(Desoneracao $desoneracao, $fkArrecadacaoAtributoDesoneracoes = array())
    {
        $atributoDesoneracoes = array();
        if ($desoneracao->getFkArrecadacaoAtributoDesoneracoes()->count()) {
            foreach ($desoneracao->getFkArrecadacaoAtributoDesoneracoes() as $atributo) {
                $atributoDesoneracoes[$atributo->getCodAtributo()] = $atributo;
            }
        }

        foreach ($fkArrecadacaoAtributoDesoneracoes as $valor) {
            if (!isset($atributoDesoneracoes[$valor->getCodAtributo()])) {
                $atributoDesoneracao = new AtributoDesoneracao();
                $atributoDesoneracao->setFkAdministracaoAtributoDinamico($valor);
                $atributoDesoneracao->setFkArrecadacaoDesoneracao($desoneracao);
                $this->entityManager->persist($atributoDesoneracao);
                $this->entityManager->flush();
                unset($atributoDesoneracoes[$valor->getCodAtributo()]);
            } else {
                $atributoDesoneracoes[$valor->getCodAtributo()]->setAtivo(true);
                $this->entityManager->persist($atributoDesoneracoes[$valor->getCodAtributo()]);
                $this->entityManager->flush();
                unset($atributoDesoneracoes[$valor->getCodAtributo()]);
            }
        }

        if ($atributoDesoneracoes) {
            foreach ($atributoDesoneracoes as $atributo) {
                $atributo->setAtivo(false);
                $this->entityManager->persist($atributo);
                $this->entityManager->flush();
            }
        }
    }
}
