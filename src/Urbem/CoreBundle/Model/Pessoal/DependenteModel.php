<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Pessoal\CarteiraVacinacao;
use Urbem\CoreBundle\Entity\Pessoal\Dependente;
use Urbem\CoreBundle\Entity\Pessoal\DependenteCarteiraVacinacao;
use Urbem\CoreBundle\Entity\Pessoal\DependenteCid;
use Urbem\CoreBundle\Entity\Pessoal\DependenteComprovanteMatricula;
use Urbem\CoreBundle\Entity\Pessoal\Servidor;
use Urbem\CoreBundle\Entity\Pessoal\ServidorDependente;

/**
 * Class DependenteModel
 * @package Urbem\CoreBundle\Model\Pessoal
 */
class DependenteModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;
    protected $servidorRepository = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Dependente::class);
        $this->servidorRepository = $entityManager->getRepository(Servidor::class);
    }

    /**
     * @param Dependente $dependente
     * @param $formData
     */
    public function saveServidorDependente(Dependente $dependente, $formData)
    {
        $fkPessoalServidor = $this->servidorRepository
        ->findOneByCodServidor($formData->get('servidor')->getData());

        $servidorDependente = new ServidorDependente();
        $servidorDependente->setFkPessoalServidor($fkPessoalServidor);
        $servidorDependente->setFkPessoalDependente($dependente);

        $this->entityManager->persist($servidorDependente);
    }

    /**
     * @param Dependente $dependente
     * @param $formData
     */
    public function saveDependenteCid(Dependente $dependente, $formData)
    {
        $fkPessoalCid = $formData->get('codCid')->getData();

        if ($fkPessoalCid) {
            $dependenteCid = new DependenteCid();
            $dependenteCid->setFkPessoalCid($fkPessoalCid);
            $dependenteCid->setFkPessoalDependente($dependente);

            $this->entityManager->persist($dependenteCid);
        }
    }

    /**
     * @param Dependente $dependente
     * @param $formData
     */
    public function buildDependente(Dependente $dependente, $formData)
    {
        $this->saveServidorDependente($dependente, $formData);
        $this->saveDependenteCid($dependente, $formData);
        $this->entityManager->flush();
    }

    /**
     * @param Dependente $dependente
     * @param $formData
     */
    public function updateDependente(Dependente $dependente, $formData)
    {
        $this->saveDependenteCid($dependente, $formData);
        $this->entityManager->flush();
    }

    /**
     * @param $codDependente
     */
    public function verificaDocumentosApresentados($codDependente)
    {
        /** @var Dependente $dependente */
        $dependente = $this->repository->findOneBy(['codDependente' => $codDependente]);

        if ($this->hasCarteira($dependente) and $this->hasCarteiraApresentada($dependente)) {
            $dependente
                ->setCarteiraVacinacao(true);
        } else {
            $dependente
                ->setCarteiraVacinacao(false);
        }

        if ($this->hasComprovanteMatricula($dependente) and $this->hasComprovanteApresentado($dependente)) {
            $dependente
                ->setComprovanteMatricula(true);
        } else {
            $dependente
                ->setComprovanteMatricula(false);
        }

        $this->save($dependente);
    }

    /**
     * @param Dependente $dependente
     * @return bool
     */
    private function hasCarteira(Dependente $dependente)
    {
        if ($dependente->getFkPessoalDependenteCarteiraVacinacoes()->count() > 0) {
            return true;
        }
        return false;
    }

    /**
     * @param Dependente $dependente
     * @return bool
     */
    private function hasCarteiraApresentada(Dependente $dependente)
    {
        $apresentada = false;
        $carteiras = $dependente->getFkPessoalDependenteCarteiraVacinacoes();

        /** @var DependenteCarteiraVacinacao $dependenteCarteiraVacinacao */
        foreach ($carteiras as $dependenteCarteiraVacinacao) {
            $carteira = $dependenteCarteiraVacinacao->getFkPessoalCarteiraVacinacao();

            if ($carteira->getApresentada() == true) {
                $apresentada = true;
            }
        }

        return $apresentada;
    }

    /**
     * @param Dependente $dependente
     * @return bool
     */
    private function hasComprovanteMatricula(Dependente $dependente)
    {
        if ($dependente->getFkPessoalDependenteComprovanteMatriculas()->count() > 0) {
            return true;
        }
        return false;
    }

    /**
     * @param Dependente $dependente
     * @return bool
     */
    private function hasComprovanteApresentado(Dependente $dependente)
    {
        $apresentada = false;
        $comprovantes = $dependente->getFkPessoalDependenteComprovanteMatriculas();

        /** @var DependenteComprovanteMatricula $dependenteComprovante */
        foreach ($comprovantes as $dependenteComprovante) {
            $comprovante = $dependenteComprovante->getFkPessoalComprovanteMatricula();
            if ($comprovante->getApresentada()) {
                $apresentada = true;
            }
        }

        return $apresentada;
    }
}
