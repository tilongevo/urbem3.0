<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Doctrine\ORM\Query;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficio;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficioFornecedor;
use Urbem\CoreBundle\Entity\Folhapagamento\BeneficioEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoBeneficio;

class ConfiguracaoBeneficioModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;
    const COD_CONFIGURACAO = 1;
    const COD_TIPO_EVENTO = 1;
    const COD_TIPO_EVENTO_PLANO_SAUDE = 2;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\ConfiguracaoBeneficio");
    }
    
    /**
     * A edição na verdade é um inserção para manter o histórico de configurações
     * @param  array $formData
     * @param  \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficio $object
     * @param  object $modelManager
     */
    public function persistConfiguracaoBeneficio($formData, \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficio $object, $modelManager)
    {
        $timestamp = (new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK());
        $configuracaoBeneficio = new ConfiguracaoBeneficio();
        $configuracaoBeneficio->setCodConfiguracao(self::COD_CONFIGURACAO);
        $configuracaoBeneficio->setTimestamp($timestamp);
        
        $tipoEventoBeneficio = $modelManager->find(TipoEventoBeneficio::class, self::COD_TIPO_EVENTO);
        $evento = $modelManager->find(Evento::class, $formData['codEventoValeTransporte']);
        
        $beneficioEvento = new BeneficioEvento();
        $beneficioEvento->setFkFolhapagamentoTipoEventoBeneficio($tipoEventoBeneficio);
        $beneficioEvento->setFkFolhapagamentoEvento($evento);
        
        $configuracaoBeneficio->addFkFolhapagamentoBeneficioEventos($beneficioEvento);
        
        $this->entityManager->persist($configuracaoBeneficio);
        $this->entityManager->persist($beneficioEvento);
        
        $codConfiguracao = self::COD_CONFIGURACAO;
        foreach ($formData['fkFolhapagamentoBeneficioEventos'] as $beneficioPlanoSaude) {
            if (isset($beneficioPlanoSaude['_delete'])) {
                continue;
            }
            
            $codConfiguracao++;
            
            $configuracaoBeneficio = new ConfiguracaoBeneficio();
            $configuracaoBeneficio->setCodConfiguracao($codConfiguracao);
            $configuracaoBeneficio->setTimestamp($timestamp);
            
            $tipoEventoBeneficio = $modelManager->find(TipoEventoBeneficio::class, self::COD_TIPO_EVENTO_PLANO_SAUDE);
            $evento = $modelManager->find(Evento::class, $beneficioPlanoSaude['fkFolhapagamentoEvento']);
            $cgmFornecedor = $modelManager->find(LayoutFornecedor::class, $beneficioPlanoSaude['cgmFornecedor']);
            
            $beneficioEvento = new BeneficioEvento();
            $beneficioEvento->setFkFolhapagamentoTipoEventoBeneficio($tipoEventoBeneficio);
            $beneficioEvento->setFkFolhapagamentoEvento($evento);
            
            $configuracaoBeneficio->addFkFolhapagamentoBeneficioEventos($beneficioEvento);
            
            $configuracaoBeneficioFornecedor = new ConfiguracaoBeneficioFornecedor();
            $configuracaoBeneficioFornecedor->setFkBeneficioLayoutFornecedor($cgmFornecedor);
            
            $configuracaoBeneficio->setFkFolhapagamentoConfiguracaoBeneficioFornecedor($configuracaoBeneficioFornecedor);
            
            $this->entityManager->persist($configuracaoBeneficio);
            $this->entityManager->persist($beneficioEvento);
            $this->entityManager->persist($configuracaoBeneficioFornecedor);
        }
        
        $this->entityManager->flush();
    }
}
