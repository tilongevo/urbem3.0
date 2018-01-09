<?php

namespace Urbem\CoreBundle\Model\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Symfony\Component\HttpFoundation\RedirectResponse;

class IdentificadorUsoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Orcamento\\IdentificadorUso");
    }

    public function verificarCRUD($admin, $codModulo, $parametro)
    {
        $em = $this->entityManager;

        $config = $em->getRepository('CoreBundle:Administracao\Configuracao')
            ->findOneBy([
                'codModulo' => $codModulo,
                'parametro' => $parametro,
                'exercicio' => $admin->getExercicio()
            ]);

        if ($config->getValor() == "false") {
            (new RedirectResponse("/financeiro/orcamento/configuracao/permissao?id=" . $admin->getClassnameLabel()))->send();
            exit;
        }

        return true;
    }
}
