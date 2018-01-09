<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * ConfiguracaoRelogioPontoExclusao
 */
class ConfiguracaoRelogioPontoExclusao
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * @var \DateTime
     */
    private $timestampExclusao;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPonto
     */
    private $fkPontoConfiguracaoRelogioPonto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestampExclusao = new \DateTime;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoRelogioPontoExclusao
     */
    public function setCodConfiguracao($codConfiguracao)
    {
        $this->codConfiguracao = $codConfiguracao;
        return $this;
    }

    /**
     * Get codConfiguracao
     *
     * @return integer
     */
    public function getCodConfiguracao()
    {
        return $this->codConfiguracao;
    }

    /**
     * Set timestampExclusao
     *
     * @param \DateTime $timestampExclusao
     * @return ConfiguracaoRelogioPontoExclusao
     */
    public function setTimestampExclusao(\DateTime $timestampExclusao)
    {
        $this->timestampExclusao = $timestampExclusao;
        return $this;
    }

    /**
     * Get timestampExclusao
     *
     * @return \DateTime
     */
    public function getTimestampExclusao()
    {
        return $this->timestampExclusao;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ConfiguracaoRelogioPontoExclusao
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
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return ConfiguracaoRelogioPontoExclusao
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->numcgm = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * OneToOne (owning side)
     * Set PontoConfiguracaoRelogioPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPonto $fkPontoConfiguracaoRelogioPonto
     * @return ConfiguracaoRelogioPontoExclusao
     */
    public function setFkPontoConfiguracaoRelogioPonto(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPonto $fkPontoConfiguracaoRelogioPonto)
    {
        $this->codConfiguracao = $fkPontoConfiguracaoRelogioPonto->getCodConfiguracao();
        $this->fkPontoConfiguracaoRelogioPonto = $fkPontoConfiguracaoRelogioPonto;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPontoConfiguracaoRelogioPonto
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPonto
     */
    public function getFkPontoConfiguracaoRelogioPonto()
    {
        return $this->fkPontoConfiguracaoRelogioPonto;
    }
}
