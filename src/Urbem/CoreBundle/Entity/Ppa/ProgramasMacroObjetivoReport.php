<?php

namespace Urbem\CoreBundle\Entity\Ppa;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ProgramasMacroObjetivoReport
 */
class ProgramasMacroObjetivoReport
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
    private $tipoPrograma;

    /**
     * @var integer
     */
    private $tipoRelatorio;

    /**
     * @var integer
     */
    private $unidadeExecutora;

    /**
     * @var integer
     */
    private $numOrgao;

    /**
     * @var integer
     */
    private $numUnidade;

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
    public function getTipoPrograma()
    {
        return $this->tipoPrograma;
    }

    /**
     * @param mixed $tipoPrograma
     */
    public function setTipoPrograma($tipoPrograma)
    {
        $this->tipoPrograma = $tipoPrograma;
    }

    /**
     * @return mixed
     */
    public function getTipoRelatorio()
    {
        return $this->tipoRelatorio;
    }

    /**
     * @param mixed $tipoRelatorio
     */
    public function setTipoRelatorio($tipoRelatorio)
    {
        $this->tipoRelatorio = $tipoRelatorio;
    }

    /**
     * @return mixed
     */
    public function getUnidadeExecutora()
    {
        return $this->unidadeExecutora;
    }

    /**
     * @param mixed $unidadeExecutora
     */
    public function setUnidadeExecutora($unidadeExecutora)
    {
        $this->unidadeExecutora = $unidadeExecutora;
    }

    /**
     * @return mixed
     */
    public function getNumOrgao()
    {
        return $this->numOrgao;
    }

    /**
     * @param mixed $numOrgao
     * @return ProgramasMacroObjetivoReport
     */
    public function setNumOrgao($numOrgao)
    {
        $this->numOrgao = $numOrgao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumUnidade()
    {
        return $this->numUnidade;
    }

    /**
     * @param mixed $numUnidade
     * @return ProgramasMacroObjetivoReport
     */
    public function setNumUnidade($numUnidade)
    {
        $this->numUnidade = $numUnidade;
        return $this;
    }
}
