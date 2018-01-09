<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * EmissaoDocumento
 */
class EmissaoDocumento
{
    /**
     * PK
     * @var integer
     */
    private $codLicenca;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * PK
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * PK
     * @var integer
     */
    private $numEmissao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $numcgmDiretor;

    /**
     * @var integer
     */
    private $numcgmUsuario;

    /**
     * @var \DateTime
     */
    private $dtEmissao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Licenca
     */
    private $fkEconomicoLicenca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    private $fkAdministracaoModeloDocumento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return EmissaoDocumento
     */
    public function setCodLicenca($codLicenca)
    {
        $this->codLicenca = $codLicenca;
        return $this;
    }

    /**
     * Get codLicenca
     *
     * @return integer
     */
    public function getCodLicenca()
    {
        return $this->codLicenca;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return EmissaoDocumento
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
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return EmissaoDocumento
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return EmissaoDocumento
     */
    public function setCodTipoDocumento($codTipoDocumento)
    {
        $this->codTipoDocumento = $codTipoDocumento;
        return $this;
    }

    /**
     * Get codTipoDocumento
     *
     * @return integer
     */
    public function getCodTipoDocumento()
    {
        return $this->codTipoDocumento;
    }

    /**
     * Set numEmissao
     *
     * @param integer $numEmissao
     * @return EmissaoDocumento
     */
    public function setNumEmissao($numEmissao)
    {
        $this->numEmissao = $numEmissao;
        return $this;
    }

    /**
     * Get numEmissao
     *
     * @return integer
     */
    public function getNumEmissao()
    {
        return $this->numEmissao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return EmissaoDocumento
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
     * Set numcgmDiretor
     *
     * @param integer $numcgmDiretor
     * @return EmissaoDocumento
     */
    public function setNumcgmDiretor($numcgmDiretor)
    {
        $this->numcgmDiretor = $numcgmDiretor;
        return $this;
    }

    /**
     * Get numcgmDiretor
     *
     * @return integer
     */
    public function getNumcgmDiretor()
    {
        return $this->numcgmDiretor;
    }

    /**
     * Set numcgmUsuario
     *
     * @param integer $numcgmUsuario
     * @return EmissaoDocumento
     */
    public function setNumcgmUsuario($numcgmUsuario)
    {
        $this->numcgmUsuario = $numcgmUsuario;
        return $this;
    }

    /**
     * Get numcgmUsuario
     *
     * @return integer
     */
    public function getNumcgmUsuario()
    {
        return $this->numcgmUsuario;
    }

    /**
     * Set dtEmissao
     *
     * @param \DateTime $dtEmissao
     * @return EmissaoDocumento
     */
    public function setDtEmissao(\DateTime $dtEmissao)
    {
        $this->dtEmissao = $dtEmissao;
        return $this;
    }

    /**
     * Get dtEmissao
     *
     * @return \DateTime
     */
    public function getDtEmissao()
    {
        return $this->dtEmissao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Licenca $fkEconomicoLicenca
     * @return EmissaoDocumento
     */
    public function setFkEconomicoLicenca(\Urbem\CoreBundle\Entity\Economico\Licenca $fkEconomicoLicenca)
    {
        $this->codLicenca = $fkEconomicoLicenca->getCodLicenca();
        $this->exercicio = $fkEconomicoLicenca->getExercicio();
        $this->fkEconomicoLicenca = $fkEconomicoLicenca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoLicenca
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Licenca
     */
    public function getFkEconomicoLicenca()
    {
        return $this->fkEconomicoLicenca;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return EmissaoDocumento
     */
    public function setFkAdministracaoModeloDocumento(\Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento)
    {
        $this->codDocumento = $fkAdministracaoModeloDocumento->getCodDocumento();
        $this->codTipoDocumento = $fkAdministracaoModeloDocumento->getCodTipoDocumento();
        $this->fkAdministracaoModeloDocumento = $fkAdministracaoModeloDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModeloDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    public function getFkAdministracaoModeloDocumento()
    {
        return $this->fkAdministracaoModeloDocumento;
    }
}
