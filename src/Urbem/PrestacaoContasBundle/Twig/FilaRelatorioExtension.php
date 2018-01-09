<?php

namespace Urbem\PrestacaoContasBundle\Twig;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio;
use Urbem\CoreBundle\Model\PrestacaoContas\FilaRelatorioModel;

class FilaRelatorioExtension extends \Twig_Extension
{
    /**
     * @var FilaRelatorioModel
     */
    protected $model;

    /**
     * FilaRelatorioExtension constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->model = new FilaRelatorioModel($entityManager);
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('filaRelatorioCanDownload', [$this, 'canDownload']),
        ];
    }

    /**
     * @param FilaRelatorio $filaRelatorio
     * @return boolean
     */
    public function canDownload(FilaRelatorio $filaRelatorio)
    {
        return $this->model->canDownload($filaRelatorio);
    }

    public function getName()
    {
        return 'filarelatorio';
    }
}
