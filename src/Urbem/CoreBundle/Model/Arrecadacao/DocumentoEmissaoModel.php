<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao;
use Urbem\CoreBundle\Repository\Arrecadacao\DocumentoEmissaoRepository;

/**
 * Class DocumentoEmissaoModel
 * @package Urbem\CoreBundle\Model\Arrecadacao
 */
class DocumentoEmissaoModel extends AbstractModel
{
    protected $entityManager = null;

    /**
     * @var ORM\EntityRepository|null
     */
    protected $repository = null;

    /**
     * DocumentoEmissaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(DocumentoEmissao::class);
    }

    /**
     * @param DocumentoEmissao $documentoEmissao
     * @return mixed
     */
    public function findDocumentoEmissao($filtro)
    {

        $res = $this->repository->findDocumentoEmissao($filtro);
        return $res;
    }

    /**
     * @param DocumentoEmissao $documentoEmissao
     * @return mixed
     */
    public function getDocumentosEmitidos($filtro)
    {
        $res = $this->repository->getDocumentosEmitidos($filtro);
        return $res;
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getNextVal($params)
    {
        return $this->repository->getNextVal($params);
    }

    /**
     * @param $dados
     * @return array
     */
    public function dadosDocumentoEmissao($dados)
    {
        return [
            'cpf' => !is_null($dados['cpf']) ? $dados['cpf'] : '',
            'cnpj' => !is_null($dados['cnpj']) ? $dados['cnpj'] : '',
            'endereco' => !is_null($dados['endereco']) ? $dados['endereco'] : '',
            'bairro' => !is_null($dados['bairro']) ? $dados['bairro'] : '',
            'cep' => !is_null($dados['cep']) ? $dados['cep'] : $dados['cep'],
            'municipio' => !is_null($dados['municipio']) ? $dados['municipio'] : $dados['municipio'],
            'numcgm' => !is_null($dados['numcgm']) ? $dados['numcgm'] : '',
            'contribuinte' => !is_null($dados['contribuinte']) ? $dados['contribuinte'] : '',
            'inscricao_municipal' => !is_null($dados['inscricao_municipal']) ? $dados['inscricao_municipal'] : '',
            'inscricao_economica' => !is_null($dados['inscricao_economica']) ? $dados['inscricao_economica'] : '',
            'num_documento' => !is_null($dados['num_documento']) ? $dados['num_documento'] : '',
            'exercicio' => !is_null($dados['exercicio']) ? $dados['exercicio'] : '',
            'cod_documento' => !is_null($dados['cod_documento']) ? $dados['cod_documento'] : '',
            'cod_tipo_documento' => !is_null($dados['cod_tipo_documento']) ? $dados['cod_tipo_documento'] : '',
            'numcgm' => !is_null($dados['numcgm']) ? $dados['numcgm'] : '',
            'descricao' => !is_null($dados['descricao']) ? $dados['descricao'] : '',
            'dt_emissao' => !is_null($dados['dt_emissao']) ? $dados['dt_emissao'] : ''
        ];
    }
}
