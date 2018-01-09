<?php
namespace Urbem\CoreBundle\Entity\Ldo;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MetasPrioridadesReport
 */
class MetasPrioridadesReport
{
    /**
     * PK
     * @var integer
     */
    private $codFake;

    /**
     * @var integer
     */
    private $ppa;

    /**
     * @var integer
     */
    private $acaoDe;

    /**
     * @var integer
     */
    private $acaoAte;

    /**
     * @var integer
     */
    private $demonstrarNaoOrcamentaria;

    /**
     * @var integer
     */
    private $programa;

    /**
     * @var integer
     */
    private $exercicioLdo;

    /**
     * @return int
     */
    public function getCodFake()
    {
        return $this->codFake;
    }

    /**
     * @param int $codFake
     */
    public function setCodFake($codFake)
    {
        $this->codFake = $codFake;
    }

    /**
     * @return mixed
     */
    public function getPpa()
    {
        return $this->ppa;
    }

    /**
     * @param mixed $ppa
     */
    public function setPpa($ppa)
    {
        $this->ppa = $ppa;
    }

    /**
     * @return mixed
     */
    public function getAcaoDe()
    {
        return $this->acaoDe;
    }

    /**
     * @param mixed $acaoDe
     */
    public function setAcaoDe($acaoDe)
    {
        $this->acaoDe = $acaoDe;
    }

    /**
     * @return mixed
     */
    public function getAcaoAte()
    {
        return $this->acaoAte;
    }

    /**
     * @param mixed $acaoAte
     */
    public function setAcaoAte($acaoAte)
    {
        $this->acaoAte = $acaoAte;
    }

    /**
     * @return mixed
     */
    public function getDemonstrarNaoOrcamentaria()
    {
        return $this->demonstrarNaoOrcamentaria;
    }

    /**
     * @param mixed $demonstrarNaoOrcamentaria
     */
    public function setDemonstrarNaoOrcamentaria($demonstrarNaoOrcamentaria)
    {
        $this->demonstrarNaoOrcamentaria = $demonstrarNaoOrcamentaria;
    }

    /**
     * @return mixed
     */
    public function getPrograma()
    {
        return $this->programa;
    }

    /**
     * @param mixed $programa
     */
    public function setPrograma($programa)
    {
        $this->programa = $programa;
    }

    /**
     * @return mixed
     */
    public function getExercicioLdo()
    {
        return $this->exercicioLdo;
    }

    /**
     * @param mixed $exercicioLdo
     */
    public function setExercicioLdo($exercicioLdo)
    {
        $this->exercicioLdo = $exercicioLdo;
    }
}
