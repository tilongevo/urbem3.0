<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * TetoRemuneratorioControle
 */
class TetoRemuneratorioControle
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $vigencia;

    /**
     * @var integer
     */
    private $teto;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorio
     */
    private $fkTcemgTetoRemuneratorio;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vigencia = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return TetoRemuneratorioControle
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TetoRemuneratorioControle
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set vigencia
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $vigencia
     * @return TetoRemuneratorioControle
     */
    public function setVigencia(\Urbem\CoreBundle\Helper\DatePK $vigencia)
    {
        $this->vigencia = $vigencia;
        return $this;
    }

    /**
     * Get vigencia
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * Set teto
     *
     * @param integer $teto
     * @return TetoRemuneratorioControle
     */
    public function setTeto($teto)
    {
        $this->teto = $teto;
        return $this;
    }

    /**
     * Get teto
     *
     * @return integer
     */
    public function getTeto()
    {
        return $this->teto;
    }

    /**
     * OneToOne (owning side)
     * Set TcemgTetoRemuneratorio
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorio $fkTcemgTetoRemuneratorio
     * @return TetoRemuneratorioControle
     */
    public function setFkTcemgTetoRemuneratorio(\Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorio $fkTcemgTetoRemuneratorio)
    {
        $this->codEntidade = $fkTcemgTetoRemuneratorio->getCodEntidade();
        $this->exercicio = $fkTcemgTetoRemuneratorio->getExercicio();
        $this->vigencia = $fkTcemgTetoRemuneratorio->getVigencia();
        $this->fkTcemgTetoRemuneratorio = $fkTcemgTetoRemuneratorio;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkTcemgTetoRemuneratorio
     *
     * @return \Urbem\CoreBundle\Entity\Tcemg\TetoRemuneratorio
     */
    public function getFkTcemgTetoRemuneratorio()
    {
        return $this->fkTcemgTetoRemuneratorio;
    }
}
