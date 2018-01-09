<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * AssinaturaCrc
 */
class AssinaturaCrc
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var string
     */
    private $inscCrc;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Administracao\Assinatura
     */
    private $fkAdministracaoAssinatura;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return AssinaturaCrc
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return AssinaturaCrc
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return AssinaturaCrc
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AssinaturaCrc
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set inscCrc
     *
     * @param string $inscCrc
     * @return AssinaturaCrc
     */
    public function setInscCrc($inscCrc)
    {
        $this->inscCrc = $inscCrc;
        return $this;
    }

    /**
     * Get inscCrc
     *
     * @return string
     */
    public function getInscCrc()
    {
        return $this->inscCrc;
    }

    /**
     * OneToOne (owning side)
     * Set AdministracaoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Assinatura $fkAdministracaoAssinatura
     * @return AssinaturaCrc
     */
    public function setFkAdministracaoAssinatura(\Urbem\CoreBundle\Entity\Administracao\Assinatura $fkAdministracaoAssinatura)
    {
        $this->exercicio = $fkAdministracaoAssinatura->getExercicio();
        $this->codEntidade = $fkAdministracaoAssinatura->getCodEntidade();
        $this->numcgm = $fkAdministracaoAssinatura->getNumcgm();
        $this->timestamp = $fkAdministracaoAssinatura->getTimestamp();
        $this->fkAdministracaoAssinatura = $fkAdministracaoAssinatura;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkAdministracaoAssinatura
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Assinatura
     */
    public function getFkAdministracaoAssinatura()
    {
        return $this->fkAdministracaoAssinatura;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->inscCrc;
    }
}
