<?php

namespace Urbem\CoreBundle\Model\Pessoal\Assentamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class AssentamentoVantagemModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\AssentamentoVantagem");
    }
    
    /**
     * Ao criar um AssentamentoVantagem é necessário criar registro em
     * AssentamentoFaixaCorrecao
     *
     * @param  object $formData
     */
    public function createAssentamentoFaixaCorrecao($formData)
    {
        $fkPessoalAssentamentoVantagem = $this->entityManager
        ->getRepository("CoreBundle:Pessoal\AssentamentoVantagem")
        ->findOneBy(
            array(
                'codAssentamento' => $formData->get('codAssentamento')->getData()
            ),
            array(
                'timestamp' => 'DESC'
            )
        );
        
        $codFaixa = $this->entityManager->getRepository("CoreBundle:Pessoal\AssentamentoFaixaCorrecao")
        ->getProximoCodFaixa($formData->get('codAssentamento')->getData());
        
        $assentamentoFaixaCorrecao = new \Urbem\CoreBundle\Entity\Pessoal\AssentamentoFaixaCorrecao();
        $assentamentoFaixaCorrecao->setCodFaixa($codFaixa);
        $assentamentoFaixaCorrecao->setQuantMeses($formData->get('quantMeses')->getData());
        $assentamentoFaixaCorrecao->setPercentualCorrecao($formData->get('percentualCorrecao')->getData());
        $assentamentoFaixaCorrecao->setFkPessoalAssentamentoVantagem($fkPessoalAssentamentoVantagem);
        $this->entityManager->persist($assentamentoFaixaCorrecao);
        $this->entityManager->flush();
    }
}
