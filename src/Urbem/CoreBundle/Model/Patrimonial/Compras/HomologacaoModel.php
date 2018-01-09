<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 19/08/16
 * Time: 16:30
 */

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Config\Definition\Exception\Exception;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Compras\Homologacao;
use Urbem\CoreBundle\Entity\Empenho;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\AbstractModel;

class HomologacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * MapaCotacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\Homologacao::class);
    }

    public function getOneByNumHomologacao($numHomologacao)
    {
        return $this->repository->findOneBy([
            'numHomologacao' => $numHomologacao
        ]);
    }

    /**
     *  @param Adjudicacao $object
     *  @param array $formData
     *  @param ModeloDocumento $documento
     */
    public function saveHomologacao($object, $formData, $documento)
    {
        /** @var Homologacao $obtHomologacao */
        $obtHomologacao = $this->getOneByNumHomologacao($object->num_homologacao);

        if (is_null($obtHomologacao)) {
            /** @var Homologacao $obtHomologacao */
            $obtHomologacao = new Homologacao();
        }

        $statusArray = ["Hologado", "Homologado e Autorizado", "A Homologar"];
        if (in_array($object->status, $statusArray)) {
            $obtHomologacao->setHomologado(true);
        } else {
            $obtHomologacao->setHomologado(false);
        }
        
        $obtHomologacao->setFkAdministracaoModeloDocumento($documento);

        $mapaModel = new MapaModel($this->entityManager);
        /** @var  $mapa Compras\Mapa*/
        $mapa = $mapaModel->getOneMapa($object->cod_mapa, $object->exercicio);
        $compraDireta = $mapa->getFkComprasCompraDiretas()->last();

        $obtHomologacao->setFkComprasCompraDireta($compraDireta);

        $julgamentoItemModel = new JulgamentoItemModel($this->entityManager);
        $julgamentoItem = $julgamentoItemModel->getOneJulgamentoItem(
            $object->exercicio_cotacao,
            $object->cod_cotacao,
            $object->cod_item,
            $object->cgm_fornecedor,
            $object->lote
        );

        $obtHomologacao->setFkComprasJulgamentoItem($julgamentoItem);

        $obtHomologacao->setExercicio($object->exercicio);

        $timestamp = new \DateTime();

        $obtHomologacao->setTimestamp($timestamp);
        $obtHomologacao->setNumHomologacao($this->getUltimoNumHomologacao());
        $this->save($obtHomologacao);
    }

    /**
     * @return int
     *
     */
    public function getUltimoNumHomologacao()
    {
        $sql = "
        SELECT COALESCE(MAX(num_homologacao), 0) AS CODIGO
        FROM compras.homologacao
        ;";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();

        $res = $query->fetch(\PDO::FETCH_OBJ);

        return (int) $res->codigo + 1;
    }
}
