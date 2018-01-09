<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\ORM;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Entity\Frota\Posto;
use Urbem\CoreBundle\Model;

class PostoModel implements Model\InterfaceModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Frota\\Posto");
    }

    public function canRemove($object)
    {
    }

    public function searchByCgmPosto(ProxyQuery $proxyQuery, $value, $rootAlias)
    {
        $proxyQuery
            ->leftJoin(sprintf("%s.fkSwCgmPessoaJuridica", $rootAlias), "swCgmJuridica")
            ->andWhere("lower(swCgmJuridica.nomFantasia) like lower(:cnpj)")
            ->setParameter('cnpj', '%'.$value.'%')
        ;
    }

    /**
     * @param Posto $posto
     * @param array $form
     */
    public function savePostoResponsavel(Posto &$posto, array $form)
    {
        if ($form['fkSwCgmPessoaJuridica']) {
            $pessoaJuridica = $form['fkSwCgmPessoaJuridica'];
            $swCgmModel = new Model\SwCgmPessoaJuridicaModel($this->entityManager);
            $cgm = $swCgmModel->getNumCgmByNumCgm($pessoaJuridica);
            $posto->setFkSwCgmPessoaJuridica($cgm);
        }
    }
}
