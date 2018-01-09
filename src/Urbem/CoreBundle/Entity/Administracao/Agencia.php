<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Agencia
 */
class Agencia
{
    /**
     * PK
     * @var string
     */
    private $codAgencia;

    /**
     * PK
     * @var string
     */
    private $codBanco;

    /**
     * @var string
     */
    private $nomAgencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Banco
     */
    private $fkAdministracaoBanco;


    /**
     * Set codAgencia
     *
     * @param string $codAgencia
     * @return Agencia
     */
    public function setCodAgencia($codAgencia)
    {
        $this->codAgencia = $codAgencia;
        return $this;
    }

    /**
     * Get codAgencia
     *
     * @return string
     */
    public function getCodAgencia()
    {
        return $this->codAgencia;
    }

    /**
     * Set codBanco
     *
     * @param string $codBanco
     * @return Agencia
     */
    public function setCodBanco($codBanco)
    {
        $this->codBanco = $codBanco;
        return $this;
    }

    /**
     * Get codBanco
     *
     * @return string
     */
    public function getCodBanco()
    {
        return $this->codBanco;
    }

    /**
     * Set nomAgencia
     *
     * @param string $nomAgencia
     * @return Agencia
     */
    public function setNomAgencia($nomAgencia)
    {
        $this->nomAgencia = $nomAgencia;
        return $this;
    }

    /**
     * Get nomAgencia
     *
     * @return string
     */
    public function getNomAgencia()
    {
        return $this->nomAgencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Banco $fkAdministracaoBanco
     * @return Agencia
     */
    public function setFkAdministracaoBanco(\Urbem\CoreBundle\Entity\Administracao\Banco $fkAdministracaoBanco)
    {
        $this->codBanco = $fkAdministracaoBanco->getCodBanco();
        $this->fkAdministracaoBanco = $fkAdministracaoBanco;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoBanco
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Banco
     */
    public function getFkAdministracaoBanco()
    {
        return $this->fkAdministracaoBanco;
    }
}
