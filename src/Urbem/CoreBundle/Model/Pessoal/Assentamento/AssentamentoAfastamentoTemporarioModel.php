<?php

namespace Urbem\CoreBundle\Model\Pessoal\Assentamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class AssentamentoAfastamentoTemporarioModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\AssentamentoAfastamentoTemporario");
    }
    
    /**
     * Retorna as causa do afastamento permanente
     * @param  \Doctrine\ORM\PersistentCollection $assentamentoSubDivisoes
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCausaRecisaoPermanente(\Doctrine\ORM\PersistentCollection $fkPessoalAssentamentoCausaRescisoes)
    {
        $causaRecisoes = new \Doctrine\Common\Collections\ArrayCollection();
        foreach ($fkPessoalAssentamentoCausaRescisoes as $fkPessoalAssentamentoCausaRescisao) {
            $causaRecisoes->add($fkPessoalAssentamentoCausaRescisao->getFkPessoalCausaRescisao());
        }
        
        return $causaRecisoes;
    }
    
    /**
     * Cria registros para entidade Assentamento Causa Recisão
     * @param  \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporario $object
     * @param  object $formData
     * @param  \Urbem\CoreBundle\Entity\Pessoal\Assentamento $fkPessoalAssentamento
     */
    public function create($object, $formData, $fkPessoalAssentamento)
    {
        foreach ($fkPessoalAssentamento->getFkPessoalAssentamentoCausaRescisoes() as $fkPessoalAssentamentoCausaRescisao) {
            $this->entityManager->remove($fkPessoalAssentamentoCausaRescisao);
        }
        foreach ($formData->get('causaRescisao')->getData() as $fkPessoalCausaRescisao) {
            $timestamp = (new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK());
            $assentamentoCausaRescisao = new \Urbem\CoreBundle\Entity\Pessoal\AssentamentoCausaRescisao();
            $assentamentoCausaRescisao->setVigencia($fkPessoalAssentamento->getFkPessoalAssentamentoValidade()->getDtInicial());
            $assentamentoCausaRescisao->setFkPessoalAssentamento($fkPessoalAssentamento);
            $assentamentoCausaRescisao->setFkPessoalCausaRescisao($fkPessoalCausaRescisao);
            $this->entityManager->persist($assentamentoCausaRescisao);
        }
        $this->entityManager->flush();
    }
    
    /**
     * Depois de salvar/atualizar AssentamentoAfastamentoTemporario, é preciso
     * criar registros nas seguintes entidades
     *
     * - AssentamentoMovSefipSaida
     * - AssentamentoRaisAfastamento
     * - AssentamentoAfastamentoTemporarioDuracao
     *
     * @param  object $formData
     */
    public function createAssentamentoAfastamentoTemporario($formData)
    {
        $fkPessoalAssentamentoAfastamentoTemporario = $this->entityManager
        ->getRepository("CoreBundle:Pessoal\AssentamentoAfastamentoTemporario")
        ->findOneBy(
            array(
                'codAssentamento' => $formData->get('codAssentamento')->getData()
            ),
            array(
                'timestamp' => 'DESC'
            )
        );
        
        $movSefipSaida = $formData->get('movSefipSaida')->getData();
        $assentamentoMovSefipSaida = $fkPessoalAssentamentoAfastamentoTemporario->getFkPessoalAssentamentoMovSefipSaida();
        
        if (! is_null($movSefipSaida)) {
            if (is_null($assentamentoMovSefipSaida)) {
                $assentamentoMovSefipSaida = new \Urbem\CoreBundle\Entity\Pessoal\AssentamentoMovSefipSaida();
            }
            
            $assentamentoMovSefipSaida->setFkPessoalMovSefipSaida($movSefipSaida);
            $assentamentoMovSefipSaida->setFkPessoalAssentamentoAfastamentoTemporario($fkPessoalAssentamentoAfastamentoTemporario);
            $this->entityManager->persist($assentamentoMovSefipSaida);
        }
        
        $raisAfastamento = $formData->get('raisAfastamento')->getData();
        $assentamentoRaisAfastamento = $fkPessoalAssentamentoAfastamentoTemporario->getFkPessoalAssentamentoRaisAfastamento();
        
        if (! is_null($raisAfastamento)) {
            if (is_null($assentamentoRaisAfastamento)) {
                $assentamentoRaisAfastamento = new \Urbem\CoreBundle\Entity\Pessoal\AssentamentoRaisAfastamento();
            }

            $assentamentoRaisAfastamento->setFkPessoalRaisAfastamento($raisAfastamento);
            $assentamentoRaisAfastamento->setFkPessoalAssentamentoAfastamentoTemporario($fkPessoalAssentamentoAfastamentoTemporario);
            $this->entityManager->persist($assentamentoRaisAfastamento);
        }
        
        $qtdeDias = $formData->get('qtdeDias')->getData();
        $assentamentoAfastamentoTemporarioDuracao = $fkPessoalAssentamentoAfastamentoTemporario->getFkPessoalAssentamentoAfastamentoTemporarioDuracao();
        
        if (! is_null($qtdeDias)) {
            if (is_null($assentamentoAfastamentoTemporarioDuracao)) {
                $assentamentoAfastamentoTemporarioDuracao = new \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAfastamentoTemporarioDuracao();
            }

            $assentamentoAfastamentoTemporarioDuracao->setDia($qtdeDias);
            $assentamentoAfastamentoTemporarioDuracao->setFkPessoalAssentamentoAfastamentoTemporario($fkPessoalAssentamentoAfastamentoTemporario);
            $this->entityManager->persist($assentamentoAfastamentoTemporarioDuracao);
        }
        
        $this->entityManager->flush();
    }
}
