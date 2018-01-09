<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Frota\MotivoInfracao;
use Urbem\CoreBundle\Model;

/**
 * Class InfracaoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Frota
 */
class InfracaoModel extends AbstractModel implements Model\InterfaceModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * InfracaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        if (! $entityManager) {
            global $kernel;
            if ('AppCache' == get_class($kernel)) {
                $kernel = $kernel->getKernel();
            }

            $entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        }
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Frota\Infracao");
    }

    /**
     * @param $object
     * @return bool
     */
    public function canRemove($object)
    {
        $modeloRepository = $this->entityManager->getRepository("CoreBundle:Frota\Modelo");
        $res = $modeloRepository->findOneByCodInfracao($object->getCodInfracao());

        return is_null($res);
    }

    /**
     * @return array
     */
    public function getVeiculo()
    {
        $sql = "
        SELECT veiculo.cod_veiculo,
               veiculo.cod_modelo,
               modelo.nom_modelo,
               marca.nom_marca,
               veiculo.prefixo,
               veiculo.placa,
               CASE
                 WHEN Trim(veiculo.placa) <> '' THEN Substr(veiculo.placa, 1, 3)
                                                     || '-'
                                                     || Substr(veiculo.placa, 4, 4)
               END                            AS placa_masc,
               Substr(veiculo.placa, 1, 3)
               || '-'
               || Substr(veiculo.placa, 4, 4) AS placa_masc,
               tipo_veiculo.nom_tipo          AS tipo_veiculo,
               veiculo.cod_categoria,
               sw_categoria_habilitacao.nom_categoria
        FROM   frota.veiculo
               inner join frota.marca
                       ON marca.cod_marca = veiculo.cod_marca
               inner join frota.modelo
                       ON modelo.cod_modelo = veiculo.cod_modelo
                       AND modelo.cod_marca = marca.cod_marca
               inner join frota.tipo_veiculo
                       ON tipo_veiculo.cod_tipo = veiculo.cod_tipo_veiculo
               inner join sw_categoria_habilitacao
                       ON sw_categoria_habilitacao.cod_categoria = veiculo.cod_categoria
        WHERE  1 = 1
               AND NOT EXISTS (SELECT 1
                               FROM   frota.veiculo_baixado
                               WHERE  veiculo_baixado.cod_veiculo = veiculo.cod_veiculo)
        ORDER  BY veiculo.cod_veiculo;";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        $veiculos = array();
        foreach ($result as $result_key => $veiculo) {
            $descVeiculo = $veiculo->cod_veiculo.' - '.
                $veiculo->placa_masc.' / '.
                $veiculo->nom_marca.' / '.
                $veiculo->nom_modelo;
            $veiculos[$descVeiculo] = $veiculo->cod_veiculo;
        }

        return $veiculos;
    }

    /**
     * @param $codVeiculo
     * @return mixed
     */
    public function getVeiculoByCodVeiculo($codVeiculo)
    {
        return $this->entityManager->getRepository("CoreBundle:Frota\Veiculo")
        ->findOneByCodVeiculo($codVeiculo);
    }

    /**
     * @param $codInfracao
     * @return MotivoInfracao
     */
    public function getInfracaoInfo($codInfracao)
    {
        $motivoInfracao = $this->entityManager->getRepository(MotivoInfracao::class)
            ->findOneBy([
              'codInfracao' => $codInfracao
            ]);

        return $motivoInfracao;
    }
}
