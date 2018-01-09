<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Repository\Patrimonio\Compras\NotaFiscalFornecedorRepository;

/**
 * Class NotaFiscalFornecedorModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Compras
 */
class NotaFiscalFornecedorModel extends AbstractModel
{
    /** @var ORM\EntityManager|null  */
    protected $entityManager = null;

    /** @var NotaFiscalFornecedorRepository|null  */
    protected $repository = null;

    /**
     * MapaCotacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\NotaFiscalFornecedor::class);
    }

    /**
     * @param int $cgmFornecedor
     * @return int
     */
    public function buildCodNota($cgmFornecedor)
    {
        return $this->repository->nextCodNota($cgmFornecedor);
    }

    /**
     * @param Compras\Fornecedor $fornecedor
     * @param Almoxarifado\NaturezaLancamento $naturezaLancamento
     * @param array $dados
     * @return Compras\NotaFiscalFornecedor
     * @throws \Exception
     */
    public function buildOne(Compras\Fornecedor $fornecedor, Almoxarifado\NaturezaLancamento $naturezaLancamento, array $dados)
    {
        $arrayKeys = ['numeroNotaFiscal', 'dtNotaFiscal', 'numeroSerie', 'observacaoNotaFiscal', 'tipo'];

        if (false == ArrayHelper::arrayMultiKeysExists($arrayKeys, $dados)) {
            throw new \Exception(sprintf(
                'Some mandatory parameters are missing ("%s")',
                implode('", "', $arrayKeys)
            ));
        }

        $notaFiscalFornecedor = new Compras\NotaFiscalFornecedor();
        $notaFiscalFornecedor->setFkComprasFornecedor($fornecedor);
        $notaFiscalFornecedor->setFkAlmoxarifadoNaturezaLancamento($naturezaLancamento);

        $codNota = $this->buildCodNota($fornecedor->getCgmFornecedor());
        $notaFiscalFornecedor->setCodNota($codNota);

        $dtNotaFiscal = \DateTime::createFromFormat('d/m/Y', $dados['dtNotaFiscal']);
        $notaFiscalFornecedor->setDtNota($dtNotaFiscal);

        $notaFiscalFornecedor->setTipo($dados['tipo']);
        $notaFiscalFornecedor->setNumSerie($dados['numeroSerie']);
        $notaFiscalFornecedor->setNumNota($dados['numeroNotaFiscal']);
        $notaFiscalFornecedor->setObservacao($dados['observacaoNotaFiscal']);

        $this->save($notaFiscalFornecedor);

        return $notaFiscalFornecedor;
    }

    /**
     * @param Almoxarifado\NaturezaLancamento $naturezaLancamento
     * @return null|Compras\NotaFiscalFornecedor
     */
    public function getNotaFiscalFornecedorBasedNaturezaLancamento(Almoxarifado\NaturezaLancamento $naturezaLancamento)
    {
        return $this->entityManager->getRepository(Compras\NotaFiscalFornecedor::class)
            ->findOneBy([
                'fkAlmoxarifadoNaturezaLancamento' => $naturezaLancamento
            ]);
    }
}
