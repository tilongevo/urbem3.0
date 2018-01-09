<?php

namespace Urbem\CoreBundle\Model\Tesouraria\Terminal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Tesouraria\Abertura;
use Urbem\CoreBundle\Entity\Tesouraria\Fechamento;
use Urbem\CoreBundle\Entity\Tesouraria\TerminalDesativado;

class TerminalModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * TerminalModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:Tesouraria\\Terminal');
    }

    public function findOneBy($formRequest)
    {
        return $this->repository->findOneBy($formRequest);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * Popula o objeto TerminalDesativado
     * @param $terminal
     * @return mixed
     */
    public function dadosDesativarTerminal($terminal)
    {
        $terminalDesativado = new TerminalDesativado();
        $terminalDesativado->setFkTesourariaTerminal($terminal);
        $terminal->setFkTesourariaTerminalDesativado($terminalDesativado);
        return $terminal;
    }

    /**
     * Popula o objeto Fechamento
     * @param $abertura
     * @return mixed
     */
    public function dadosFechamento($abertura)
    {
        $fechamento = new Fechamento();
        $fechamento->setFkTesourariaUsuarioTerminal($abertura->getFkTesourariaUsuarioTerminal());
        $fechamento->setFkTesourariaAbertura($abertura);
        $fechamento->setFkTesourariaBoletim($abertura->getFkTesourariaBoletim());
        $abertura->addFkTesourariaFechamentos($fechamento);
        return $abertura;
    }


    /**
     * Popula o objeto Abertura
     * @param $aberturaFechada
     * @param $terminal
     * @return mixed
     */
    public function dadosAbertura($aberturaFechada, $terminal)
    {
        $aberturaBoletim = new Abertura();
        $aberturaBoletim->setFkTesourariaUsuarioTerminal($aberturaFechada->getFkTesourariaUsuarioTerminal());
        $aberturaBoletim->setFkTesourariaTerminal($aberturaFechada->getFkTesourariaTerminal());
        $aberturaBoletim->setFkTesourariaBoletim($aberturaFechada->getFkTesourariaBoletim());
        $terminal->addFkTesourariaAberturas($aberturaBoletim);
        return $terminal;
    }


    /**
     * Seleciona as aberturas por codBoletim, para não serem duplicadas
     * @param $terminal
     * @return mixed
     */
    public function populaTerminalReabertura($terminal)
    {
        $auxiliar = 0;
        foreach ($terminal->getFkTesourariaAberturas() as $abertura) {
            if ($auxiliar != $abertura->getCodBoletim()) {
                $this->dadosAbertura($abertura, $terminal);
            }
            $auxiliar = $abertura->getCodBoletim();
        }
        return $terminal;
    }

    /**
     * verificar nos terminais a situacao dos boletins, não podem estar abertos ou reabertos, para que o terminal seja fechado
     * @param $terminal
     * @return bool
     */
    public function verificarSeTemBoletinsAbertos($terminal)
    {
        foreach ($terminal->getFkTesourariaAberturas() as $abertura) {
            $listaStatus = $this->repository->verificarSeTemBoletmAberto($abertura->getCodBoletim(), $abertura->getExercicioBoletim(), $abertura->getCodEntidade());
            if (!empty($listaStatus)) {
                foreach ($listaStatus as $status) {
                    if ($status['situacao'] == "aberto" || $status['situacao'] == "reaberto") {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Popula um objeto fechamento
     * Popula um terminal
     * @param $terminal
     */
    public function populaFechamento($terminal)
    {
        foreach ($terminal->getFkTesourariaAberturas() as $abertura) {
            //Se a abertura não tiver fechamento
            if (empty($abertura->getFkTesourariaFechamentos()->current())) {
                $this->dadosFechamento($abertura);
            }
        }
    }

    /**
     * Popula muitos(N) objetos fechamentos
     * @param $terminais
     */
    public function populaNFechamento($terminais)
    {
        foreach ($terminais as $terminal) {
            $this->populaFechamento($terminal);
        }
    }

    /**
     * Fecha todos os terminais
     * @param $terminais
     * @throws \Exception
     */
    public function fecharNTerminais($terminais)
    {
        foreach ($terminais as $terminal) {
            try {
                $this->entityManager->persist($terminal);
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        }

        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


    /**
     * Verifica se o terminal esta ativo ou inativo
     * @param $terminal
     * @return mixed
     */
    public function verificaAtivoInativo($terminal)
    {
        $status = $this->repository->statusTerminal($terminal->getCodTerminal());
        if (!empty($status)) {
            $status = $status['situacao'];
        }

        return $status;
    }
}
