<?php
/**
 * Created by PhpStorm.
 * User: longevo
 * Date: 27/07/16
 * Time: 15:40
 */

namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Licitacao\Comissao;
use Urbem\CoreBundle\Entity\Licitacao\ComissaoLicitacao;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;

class ComissaoLicitacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ComissaoLicitacao::class);
    }

    public function selectComissaoLicitacao($object, $objetoComissao, $exercicio)
    {
        $obTLicitacaoComissaoLicitacao = $this->repository->findBy(
            [
                'codLicitacao' => $object->getCodLicitacao(),
                'codModalidade' => $object->getCodModalidade(),
                'codEntidade' => $object->getCodEntidade(),
                'codComissao' => $objetoComissao,
                'exercicio' => $exercicio
            ]
        );

        if (count($obTLicitacaoComissaoLicitacao) > 0) {
            foreach ($obTLicitacaoComissaoLicitacao as $comissaoLicitacao) {
                $this->entityManager->remove($comissaoLicitacao);
                $this->entityManager->flush();
            }
        }

        $this->insertComissaoLicitacao($object, $objetoComissao, $exercicio);
    }

    /**
     * @param Licitacao $licitacao
     * @param $objetoComissao
     * @return ComissaoLicitacao
     */
    public function insertComissaoLicitacao(Licitacao $licitacao, $objetoComissao)
    {
        /** @var Comissao $comissao */
        $comissao = $this->entityManager
            ->getRepository(Comissao::class)
            ->findOneBy([
                'codComissao' => $objetoComissao,
            ]);

        $obTLicitacaoComissaoLicitacao = new ComissaoLicitacao();
        $obTLicitacaoComissaoLicitacao->setFkLicitacaoLicitacao($licitacao);
        $obTLicitacaoComissaoLicitacao->setFkLicitacaoComissao($comissao);

        $this->save($obTLicitacaoComissaoLicitacao);

        return $obTLicitacaoComissaoLicitacao;
    }
}
