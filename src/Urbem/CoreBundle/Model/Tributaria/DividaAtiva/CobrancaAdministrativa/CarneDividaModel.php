<?php

namespace Urbem\CoreBundle\Model\Tributaria\DividaAtiva\CobrancaAdministrativa;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Divida\DividaAtiva;

class CarneDividaModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var DividaAtivaRepository|null  */
    protected $repository = null;
    protected $valorInicial = '0,00';

    /**
     * AutoridadeModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(DividaAtiva::class);
    }

    public function calculaJuroOrMultaParcelasReemissao($numeracao, $exercicio, $codParcela, $dataBase, $tipo)
    {
        $param = [];
        $param['numeracao'] = $numeracao;
        $param['exercicio'] = $exercicio;
        $param['codParcela'] = $codParcela;
        $param['dataBase'] = $dataBase;
        $param['tipo'] = $tipo;

        $calculo = $this->repository->calculaJuroOrMultaParcelasReemissao($param);
        return (reset($calculo)->valor != '00') ?: $this->valorInicial;
    }

    public function getLogoTipo($param)
    {
        $configuracaoList = $this->entityManager->getRepository(Configuracao::class)->getAtributosDinamicosPorModuloeExercicio($param);

        if (!$configuracaoList) {
            return false;
        }

        $configuracao = [];
        foreach ($configuracaoList as $config) {
            $configuracao[$config['parametro']] = $config['valor'];
        }

        return $configuracao['logotipo'];
    }

    public function getValorInicial()
    {
        return $this->valorInicial;
    }
}
