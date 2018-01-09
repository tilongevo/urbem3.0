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

class ComissaoMembrosModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Licitacao\ComissaoMembros::class);
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

    public function selectComissaoMembros(Licitacao\ComissaoLicitacao $obTLicitacaoComissaoLicitacao, $objetoComissao)
    {

        $obTLicitacaoComissaoLicitacaoMembros = $this->repository->findBy(
            [
                'codNorma' => $objetoComissao->getCodNorma(),
                'cod_entidade' => $obTLicitacaoComissaoLicitacao->getCodEntidade(),
                'codModalidade' => $obTLicitacaoComissaoLicitacao->getCodModalidade(),
                'codLicitacao' => $obTLicitacaoComissaoLicitacao->getCodLicitacao(),
            ]
        );

        if (count($obTLicitacaoComissaoLicitacaoMembros) > 0) {
            foreach ($obTLicitacaoComissaoLicitacaoMembros as $comissaoMembros) {
                $this->entityManager->remove($comissaoMembros);
                $this->entityManager->flush();
            }
        }
    }
}
