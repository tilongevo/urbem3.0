<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * AssinaturaModulo
 */
class AssinaturaModulo
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
     * @var integer
     */
    private $codModulo;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Assinatura
     */
    private $fkAdministracaoAssinatura;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    private $fkAdministracaoModulo;

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
     * @return AssinaturaModulo
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
     * @return AssinaturaModulo
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
     * @return AssinaturaModulo
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return AssinaturaModulo
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return AssinaturaModulo
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
     * ManyToOne (inverse side)
     * Set fkAdministracaoAssinatura
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Assinatura $fkAdministracaoAssinatura
     * @return AssinaturaModulo
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
     * ManyToOne (inverse side)
     * Get fkAdministracaoAssinatura
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Assinatura
     */
    public function getFkAdministracaoAssinatura()
    {
        return $this->fkAdministracaoAssinatura;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModulo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo
     * @return AssinaturaModulo
     */
    public function setFkAdministracaoModulo(\Urbem\CoreBundle\Entity\Administracao\Modulo $fkAdministracaoModulo)
    {
        $this->codModulo = $fkAdministracaoModulo->getCodModulo();
        $this->fkAdministracaoModulo = $fkAdministracaoModulo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModulo
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Modulo
     */
    public function getFkAdministracaoModulo()
    {
        return $this->fkAdministracaoModulo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->fkAdministracaoModulo;
    }
}
