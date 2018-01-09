<?php

namespace Urbem\CoreBundle\Model\Pessoal\Assentamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class AssentamentoAssentamentoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var ORM\EntityRepository|null|\Urbem\CoreBundle\Repository\Pessoal\AssentamentoAssentamentoRepository  */
    protected $repository = null;

    /**
     * AssentamentoAssentamentoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\AssentamentoAssentamento");
    }

    public function hasAfastamentoTemporarioDuracao($id)
    {
        $assentamento = $this->repository->find($id);
        return (bool) !is_null($assentamento->getAssentamentoAfastamentoTemporarioDuracao());
    }

    public function hasAssentamentoVantagem($id)
    {
        $assentamento = $this->repository->find($id);
        return (bool) !is_null($assentamento->getAssentamentoVantagem());
    }

    public function hasAfastamentoTemporario($id)
    {
        $assentamento = $this->repository->find($id);
        return (bool) !is_null($assentamento->getAssentamentoAfastamentoTemporario());
    }
    
    /**
     * Retorna o valor do campo Subdivisão
     * @param  \Doctrine\ORM\PersistentCollection $assentamentoSubDivisoes
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSubDivisoes(\Doctrine\ORM\PersistentCollection $assentamentoSubDivisoes)
    {
        $subDivisao = new \Doctrine\Common\Collections\ArrayCollection();
        foreach ($assentamentoSubDivisoes as $assentamentoSubDivisao) {
            $subDivisao->add($assentamentoSubDivisao->getFkPessoalSubDivisao());
        }
        return $subDivisao;
    }
    
    /**
     * Retorna o(s) valor(es) do campo Evento
     * @param  \Doctrine\ORM\PersistentCollection $assentamentoSubDivisoes
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getEventos(\Doctrine\ORM\PersistentCollection $fkPessoalAssentamentoEventos)
    {
        $eventos = new \Doctrine\Common\Collections\ArrayCollection();
        foreach ($fkPessoalAssentamentoEventos as $fkPessoalAssentamentoEvento) {
            $eventos->add($fkPessoalAssentamentoEvento->getFkFolhapagamentoEvento());
        }
        return $eventos;
    }
    
    /**
     * Retorna o(s) valor(es) do campo Evento Proporcional
     * @param  \Doctrine\ORM\PersistentCollection $assentamentoSubDivisoes
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getEventosProporcionais(\Doctrine\ORM\PersistentCollection $fkPessoalAssentamentoEventoProporcionais)
    {
        $eventosProporcionais = new \Doctrine\Common\Collections\ArrayCollection();
        foreach ($fkPessoalAssentamentoEventoProporcionais as $fkPessoalAssentamentoEventoProporcional) {
            $eventosProporcionais->add($fkPessoalAssentamentoEventoProporcional->getFkFolhapagamentoEvento());
        }
        return $eventosProporcionais;
    }
    
    /**
     * @param  \Urbem\CoreBundle\Pessoal\AssentamentoAssentamento $object
     * @param  object $formData
     */
    public function create($object, $formData)
    {
        $assentamento = new \Urbem\CoreBundle\Entity\Pessoal\Assentamento();
        $assentamento->setGradeEfetividade($formData->get('gradeEfetividade')->getData());
        $assentamento->setRelFuncaoGratificada($formData->get('relFuncaoGratificada')->getData());
        $assentamento->setEventoAutomatico($formData->get('eventoAutomatico')->getData());
        $assentamento->setAssentamentoInicio($formData->get('assentamentoInicio')->getData());
        $assentamento->setAssentamentoAutomatico($formData->get('assentamentoAutomatico')->getData());
        $assentamento->setQuantDiasOnusEmpregador($formData->get('quantDiasOnusEmpregador')->getData());
        $assentamento->setQuantDiasLicencaPremio($formData->get('quantDiasLicencaPremio')->getData());
        $assentamento->setFkPessoalEsferaOrigem($formData->get('codEsfera')->getData());
        $assentamento->setFkPessoalAssentamentoAssentamento($object);
        $this->entityManager->persist($assentamento);
        
        $assentamentoValidade = new \Urbem\CoreBundle\Entity\Pessoal\AssentamentoValidade();
        $assentamentoValidade->setFkPessoalAssentamento($assentamento);
        $assentamentoValidade->setDtInicial($formData->get('dtInicial')->getData());
        $assentamentoValidade->setDtFinal($formData->get('dtFinal')->getData());
        $assentamentoValidade->setCancelarDireito($formData->get('cancelarDireito')->getData());
        $this->entityManager->persist($assentamentoValidade);
        
        foreach ($formData->get('assentamentoEvento')->getData() as $evento) {
            $assentamentoEvento = new \Urbem\CoreBundle\Entity\Pessoal\AssentamentoEvento();
            $assentamentoEvento->setFkPessoalAssentamento($assentamento);
            $assentamentoEvento->setFkFolhapagamentoEvento($evento);
            $assentamentoEvento->setVigencia($formData->get('dtFinal')->getData());
            $this->entityManager->persist($assentamentoEvento);
        }
        
        foreach ($formData->get('assentamentoEventoProporcional')->getData() as $eventoProporcional) {
            $assentamentoEventoProporcional = new \Urbem\CoreBundle\Entity\Pessoal\AssentamentoEventoProporcional();
            $assentamentoEventoProporcional->setFkPessoalAssentamento($assentamento);
            $assentamentoEventoProporcional->setFkFolhapagamentoEvento($eventoProporcional);
            $this->entityManager->persist($assentamentoEventoProporcional);
        }
        
        foreach ($formData->get('codSubDivisao')->getData() as $subDivisao) {
            $assentamentoSubDivisao = new \Urbem\CoreBundle\Entity\Pessoal\AssentamentoSubDivisao();
            $assentamentoSubDivisao->setFkPessoalAssentamento($assentamento);
            $assentamentoSubDivisao->setFkPessoalSubDivisao($subDivisao);
            $assentamentoSubDivisao->setVigencia($formData->get('dtFinal')->getData());
            $this->entityManager->persist($assentamentoSubDivisao);
        }
        
        $this->entityManager->flush();
    }
    
    /**
     * Ao alterar os perfis de Configuração de Assentamento é necessário clonar
     * a entidade, porque no sistema legado, toda alteração gera um novo registro
     * no banco
     *
     * @param  \Urbem\CoreBundle\Pessoal\Assentamento $object
     */
    public function cloneAssentamento($object)
    {
        $assentamento = clone $object;
        $this->entityManager->persist($assentamento);
        
        $assentamentoValidade = clone $assentamento->getFkPessoalAssentamentoValidade();
        $assentamentoValidade->setFkPessoalAssentamento($assentamento);
        $this->entityManager->persist($assentamentoValidade);
        
        foreach ($object->getFkPessoalAssentamentoEventos() as $fkPessoalAssentamentoEvento) {
            $assentamentoEvento = clone $fkPessoalAssentamentoEvento;
            $assentamentoEvento->setFkPessoalAssentamento($assentamento);
            $this->entityManager->persist($assentamentoEvento);
        }
        
        foreach ($object->getFkPessoalAssentamentoEventoProporcionais() as $fkPessoalAssentamentoEventoProporcional) {
            $assentamentoEventoProporcional = clone $fkPessoalAssentamentoEventoProporcional;
            $assentamentoEventoProporcional->setFkPessoalAssentamento($assentamento);
            $this->entityManager->persist($assentamentoEventoProporcional);
        }
        
        foreach ($object->getFkPessoalAssentamentoSubDivisoes() as $fkPessoalAssentamentoSubDivisao) {
            $assentamentoSubDivisao = clone $fkPessoalAssentamentoSubDivisao;
            $assentamentoSubDivisao->setFkPessoalAssentamento($assentamento);
            $this->entityManager->persist($assentamentoSubDivisao);
        }
        
        $this->entityManager->flush();
        return $assentamento;
    }

    /**
     * @param $codClassificacao
     * @return mixed
     */
    public function getAssentamentosByCodClassificacao($codClassificacao)
    {
        $assentamentoList = $this->repository->getAssentamentosByCodClassificacao($codClassificacao);

        $options = [];
        foreach ($assentamentoList as $assentamento) {
            $options[$assentamento->cod_assentamento] = $assentamento->cod_assentamento . " - " . $assentamento->descricao;
        }

        return $options;
    }

    /**
     * @param $codContrato
     * @param $dtInicial
     * @param $dtFinal
     * @return array
     */
    public function recuperaRelacionamento($codContrato, $dtInicial, $dtFinal)
    {
        return $this->repository->recuperaRelacionamento($codContrato, $dtInicial, $dtFinal);
    }
}
