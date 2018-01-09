<?php

namespace Urbem\CoreBundle\Model\Tesouraria;

use Doctrine\ORM;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\AbstractModel;

class ArrecadacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:Tesouraria\Arrecadacao');
    }

    public function isValidBoletimMes($exercicio, $mesBoletim)
    {
        // valida a utilização da rotina de encerramento do mês contábil
        $paramsWhere = [
            "cod_modulo = 9",
            "parametro = 'utilizar_encerramento_mes'",
            sprintf("exercicio = '%s'", $exercicio),
        ];
        $configuracaoRepository = $this->entityManager->getRepository('CoreBundle:Administracao\Configuracao');
        $encerramentoMesRepository = $this->entityManager->getRepository('CoreBundle:Contabilidade\EncerramentoMes');
        $encerramentoMes = current($configuracaoRepository->getConfiguracao($paramsWhere, "order by exercicio desc limit 1"));
        $ultimoMesEncerrado = $encerramentoMesRepository->getUltimoMesEncerrado($exercicio);

        if ($encerramentoMes && $encerramentoMes->valor == 'true' && $ultimoMesEncerrado && $ultimoMesEncerrado->mes >= $mesBoletim) {
            return false;
        }

        return true;
    }

    /**
     * @param $codArrecadacao
     * @param $exercicio
     * @param $timestampArrecadacao
     * @return null|object
     */
    public function getOneArrecadacao($codArrecadacao, $exercicio, $timestampArrecadacao)
    {
        $arrecadacao = $this->repository->findOneBy([
            'codArrecadacao' => $codArrecadacao,
            'exercicio' => $exercicio,
            'timestampArrecadacao' => $timestampArrecadacao
        ]);

        return $arrecadacao;
    }
}
