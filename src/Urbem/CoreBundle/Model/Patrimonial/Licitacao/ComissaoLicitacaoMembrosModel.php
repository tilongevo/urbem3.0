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
use Urbem\CoreBundle\Entity\Licitacao;

class ComissaoLicitacaoMembrosModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Licitacao\ComissaoLicitacaoMembros::class);
    }

    public function selectComissaoLicitacaoMembros($object, $objetoComissao, $exercicio)
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
    }

    /**
     * @param Licitacao\ComissaoLicitacao $obTLicitacaoComissaoLicitacao
     * @param Licitacao\ComissaoMembros $comissaoMembros
     */
    public function insertComissaMembros(Licitacao\ComissaoLicitacao $obTLicitacaoComissaoLicitacao, Licitacao\ComissaoMembros $comissaoMembros)
    {
        $obTLicitacaoComissaoLicitacaoMembros = new Licitacao\ComissaoLicitacaoMembros();
        $obTLicitacaoComissaoLicitacaoMembros->setFkLicitacaoComissaoLicitacao($obTLicitacaoComissaoLicitacao);
        $obTLicitacaoComissaoLicitacaoMembros->setFkLicitacaoComissaoMembros($comissaoMembros);

        $this->save($obTLicitacaoComissaoLicitacaoMembros);
    }
}
