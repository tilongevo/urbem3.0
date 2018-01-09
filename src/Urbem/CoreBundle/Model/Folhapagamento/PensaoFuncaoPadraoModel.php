<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;

class PensaoFuncaoPadraoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;
    const COD_TIPO_PENSAO_ALIMENTICIA = 1;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\PensaoFuncaoPadrao");
    }

    public function consultaPensaoFuncaoPadrao($object)
    {
        return $this->repository->consultaPensaoFuncaoPadrao($object);
    }

    public function deletePensaoFuncaoPadrao($object)
    {
        return $this->repository->deletePensaoFuncaoPadrao($object);
    }

    public function recuperaPensaoFuncaoPadrao($entity = false)
    {
        $funcaoPadraoArr = $this->repository->recuperaPensaoFuncaoPadrao();
        $result = $funcaoPadraoArr;

        if ($entity) {
            $result = $this->entityManager
                ->getRepository('CoreBundle:Administracao\Funcao')
                ->findOneBy([
                    "codFuncao" => $funcaoPadraoArr[0]->cod_funcao,
                    "codBiblioteca" => $funcaoPadraoArr[0]->cod_biblioteca,
                    "codModulo" => $funcaoPadraoArr[0]->cod_modulo
                ]);
        }

        return $result;
    }
    
    /**
     * A edição na verdade é um inserção para manter o histórico de configurações
     * @param  array $formData
     * @param  \Urbem\CoreBundle\Entity\Folhapagamento\PensaoFuncaoPadrao $object
     * @param  object $modelManager
     */
    public function persistPensaoFuncaoPadrao($formData, \Urbem\CoreBundle\Entity\Folhapagamento\PensaoFuncaoPadrao $object, $modelManager)
    {
        $fkAdministracaoFuncao = $modelManager->find(Funcao::class, $formData['fkAdministracaoFuncao']);
        $fkFolhapagamentoEvento = $modelManager->find(Evento::class, $formData['codConfiguracaoPensao']);
        
        $fkFolhapagamentoTipoEventoPensao = $this->entityManager
        ->getRepository("CoreBundle:Folhapagamento\TipoEventoPensao")
        ->findOneByCodTipo(self::COD_TIPO_PENSAO_ALIMENTICIA);
        
        $pensaoFuncaoPadrao = new \Urbem\CoreBundle\Entity\Folhapagamento\PensaoFuncaoPadrao();
        $pensaoFuncaoPadrao->setFkAdministracaoFuncao($fkAdministracaoFuncao);
        $pensaoFuncaoPadrao->setTimestamp((new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK));
        $pensaoFuncaoPadrao->setCodConfiguracaoPensao($formData['codConfiguracaoPensao']);
        
        $pensaoEvento = new \Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento();
        $pensaoEvento->setFkFolhapagamentoEvento($fkFolhapagamentoEvento);
        $pensaoEvento->setFkFolhapagamentoTipoEventoPensao($fkFolhapagamentoTipoEventoPensao);
        
        $pensaoFuncaoPadrao->addFkFolhapagamentoPensaoEventos($pensaoEvento);
        
        $this->entityManager->persist($pensaoFuncaoPadrao);
        $this->entityManager->persist($pensaoEvento);
        $this->entityManager->flush();
    }
}
