<?php

namespace Urbem\CoreBundle\Model\Tesouraria;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\Entity\Tesouraria;
use Urbem\CoreBundle\Repository\Financeiro\Tesouraria\ArrecadacaoRepository;
use Urbem\CoreBundle\Repository\Financeiro\Tesouraria\AutenticacaoRepository;

/**
 * Class AutenticacaoModel
 * @package Urbem\CoreBundle\Model\Tesouraria
 */
class AutenticacaoModel extends Model
{
    protected $entityManager = null;

    /** @var AutenticacaoRepository|null */
    protected $repository = null;

    /**
     * AutenticacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Tesouraria\Autenticacao::class);
    }

    /**
     * @param Tesouraria\Bordero $bordero
     * @return Tesouraria\Autenticacao
     */
    public function buildOneBasedBordero(Tesouraria\Bordero $bordero)
    {
        $tipoAutenticacao = $this->entityManager
            ->getRepository(Tesouraria\TipoAutenticacao::class)
            ->find('BR');

        $data = $bordero->getFkTesourariaBoletim()->getDtBoletim();

        $repositoryRes = $this->repository->recuperaUltimoCodigoAutenticacao([
            'dt_autenticacao' => $data->format('d/m/Y')
        ]);

        $codAutenticacao = $repositoryRes['codigo'] + 1;

        $autenticacao = new Tesouraria\Autenticacao();
        $autenticacao->setCodAutenticacao($codAutenticacao);
        $autenticacao->setTipo($tipoAutenticacao);

        $this->entityManager->persist($autenticacao);
        $this->entityManager->flush();

        return $autenticacao;
    }
}
