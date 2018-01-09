<?php
/**
 * Created by PhpStorm.
 * User: longevo
 * Date: 27/07/16
 * Time: 15:40
 */

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Compras\CompraDireta;
use Urbem\CoreBundle\Entity\Compras\JustificativaRazao;

class JustificativaRazaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Compras\\JustificativaRazao");
    }

    /**
     *  @param Urbem\CoreBundle\Entity\Compras\CompraDireta $object
     *
     *
     */
    public function saveJustificativaRazao($object, $formData)
    {
        $justificativa = $this->getJustificativaRazao($object);
        if (is_object($justificativa)) {
            $obtJustificativaRazao = $justificativa;
        } else {
            $obtJustificativaRazao = new JustificativaRazao();
        }

        $obtJustificativaRazao->setFkComprasCompraDireta($object);
        $obtJustificativaRazao->setFundamentacaoLegal($formData['fundamentacao_legal']);
        $obtJustificativaRazao->setJustificativa($formData['justificativa']);
        $obtJustificativaRazao->setRazao($formData['razao']);

        $this->save($obtJustificativaRazao);
    }

    /**
     * @param CompraDireta $object
     * @return null|object
     */
    public function getJustificativaRazao($object)
    {
        return $this->repository->findOneBy([
            'codCompraDireta' => $object->getCodCompraDireta(),
            'codModalidade' => $object->getCodModalidade(),
            'codEntidade' => $object->getCodEntidade(),
            'exercicioEntidade' => $object->getExercicioEntidade()
        ]);
    }
}
