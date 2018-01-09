<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Pessoal\Pensao;
use Urbem\CoreBundle\Entity\Pessoal\PensaoExcluida;
use Urbem\CoreBundle\Entity\Pessoal\ServidorDependente;

class PensaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\Pensao");
    }

    /**
     * @param $param
     * @return int
     */
    public function getNextCodPensao($param)
    {
        /** @var Pensao $pensao */
        $pensao = $this->repository->findBy([
            'codServidor' => $param['cod_servidor'],
            'codDependente' => $param['cod_dependente']
        ]);

        if (!empty($pensao)) {
            return end($pensao)->getCodPensao();
        }

        /** @var Pensao $ultimaPensao */
        $ultimaPensao = end($this->repository->findAll());
        $codigo = $ultimaPensao->getCodPensao() + 1;

        return $codigo;
    }

    /**
     * @param ServidorDependente $servidorDependente
     * @param array $param
     * @return Pensao
     */
    public function savePensao(ServidorDependente $servidorDependente, $param)
    {
        $codPensao = $this->getNextCodPensao([
            'cod_servidor' => $servidorDependente->getCodServidor(),
            'cod_dependente' => $servidorDependente->getCodDependente()
        ]);

        /** @var Pensao $pensao */
        $pensao = new Pensao();
        $pensao
            ->setCodPensao($codPensao)
            ->setObservacao($param['observacao'])
            ->setFkPessoalServidorDependente($servidorDependente)
            ->setTipoPensao($param['pensaoTipo'])
            ->setDtInclusao($param['dtInclusao'])
            ->setDtLimite($param['dtLimite'])
            ->setPercentual($param['percentual']);

        $this->save($pensao);

        return $pensao;
    }

    /**
     * @param Pensao $pensao
     * @return PensaoExcluida
     */
    public function removePensao(Pensao $pensao)
    {
        $pensaoExcluida = new PensaoExcluida();
        $pensaoExcluida
            ->setFkPessoalPensao($pensao);

        $this->save($pensaoExcluida);

        return $pensaoExcluida;
    }
}
