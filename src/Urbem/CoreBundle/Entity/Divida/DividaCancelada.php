<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * DividaCancelada
 */
class DividaCancelada
{
    /**
     * PK
     * @var integer
     */
    private $codInscricao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $motivo;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Divida\ProcessoCancelamento
     */
    private $fkDividaProcessoCancelamento;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Divida\DividaAtiva
     */
    private $fkDividaDividaAtiva;

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
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codInscricao
     *
     * @param integer $codInscricao
     * @return DividaCancelada
     */
    public function setCodInscricao($codInscricao)
    {
        $this->codInscricao = $codInscricao;
        return $this;
    }

    /**
     * Get codInscricao
     *
     * @return integer
     */
    public function getCodInscricao()
    {
        return $this->codInscricao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return DividaCancelada
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return DividaCancelada
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
     * Set motivo
     *
     * @param string $motivo
     * @return DividaCancelada
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return DividaCancelada
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
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return DividaCancelada
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
     * OneToOne (inverse side)
     * Set DividaProcessoCancelamento
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ProcessoCancelamento $fkDividaProcessoCancelamento
     * @return DividaCancelada
     */
    public function setFkDividaProcessoCancelamento(\Urbem\CoreBundle\Entity\Divida\ProcessoCancelamento $fkDividaProcessoCancelamento)
    {
        $fkDividaProcessoCancelamento->setFkDividaDividaCancelada($this);
        $this->fkDividaProcessoCancelamento = $fkDividaProcessoCancelamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkDividaProcessoCancelamento
     *
     * @return \Urbem\CoreBundle\Entity\Divida\ProcessoCancelamento
     */
    public function getFkDividaProcessoCancelamento()
    {
        return $this->fkDividaProcessoCancelamento;
    }

    /**
     * OneToOne (owning side)
     * Set DividaDividaAtiva
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaAtiva $fkDividaDividaAtiva
     * @return DividaCancelada
     */
    public function setFkDividaDividaAtiva(\Urbem\CoreBundle\Entity\Divida\DividaAtiva $fkDividaDividaAtiva)
    {
        $this->exercicio = $fkDividaDividaAtiva->getExercicio();
        $this->codInscricao = $fkDividaDividaAtiva->getCodInscricao();
        $this->fkDividaDividaAtiva = $fkDividaDividaAtiva;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkDividaDividaAtiva
     *
     * @return \Urbem\CoreBundle\Entity\Divida\DividaAtiva
     */
    public function getFkDividaDividaAtiva()
    {
        return $this->fkDividaDividaAtiva;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) 'Erro ao cancelar a divida ativa';
    }
}
