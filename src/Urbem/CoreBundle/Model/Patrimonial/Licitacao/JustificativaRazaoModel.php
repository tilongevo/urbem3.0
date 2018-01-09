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
use Urbem\CoreBundle\Entity\Licitacao\Homologacao;
use Urbem\CoreBundle\Entity\Licitacao\JustificativaRazao;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;

class JustificativaRazaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Licitacao\\JustificativaRazao");
    }

    /**
     *  @param Licitacao $licitacao
     *  @param Homologacao $homologacao
     *  @param array $formData
     */
    public function saveJustificativaRazao(Licitacao $licitacao, Homologacao $homologacao, $formData)
    {
        $justificativa = $this->getJustificativaRazao($licitacao);
        if (is_object($justificativa)) {
            $this->entityManager->remove($justificativa);
            $this->entityManager->flush();
        };
        $obtJustificativaRazao = new JustificativaRazao();
        $obtJustificativaRazao->setFkLicitacaoLicitacao($licitacao);
        $obtJustificativaRazao->setFundamentacaoLegal($formData['fundamentacaoLegal']);
        $obtJustificativaRazao->setJustificativa($formData['justificativa']);
        $obtJustificativaRazao->setRazao($formData['razao']);

        $this->entityManager->persist($obtJustificativaRazao);
    }

    /**
     * @param Licitacao $licitacao
     * @return JustificativaRazao
     */
    public function getJustificativaRazao($licitacao)
    {
        return $this->repository->findOneBy([
            'codLicitacao' => $licitacao->getCodLicitacao(),
            'codModalidade' => $licitacao->getCodModalidade(),
            'codEntidade' => $licitacao->getCodEntidade(),
            'exercicio' => $licitacao->getExercicio()
        ]);
    }
}
