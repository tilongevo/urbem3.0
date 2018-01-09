<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwAndamento
 */
class SwAndamento
{
    /**
     * PK
     * @var integer
     */
    private $codAndamento;

    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * @var integer
     */
    private $codOrgao;

    /**
     * @var integer
     */
    private $codUsuario;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codSituacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\SwRecebimento
     */
    private $fkSwRecebimento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwUltimoAndamento
     */
    private $fkSwUltimoAndamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwDespacho
     */
    private $fkSwDespachos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwSituacaoProcesso
     */
    private $fkSwSituacaoProcesso;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwUltimoAndamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwDespachos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codAndamento
     *
     * @param integer $codAndamento
     * @return SwAndamento
     */
    public function setCodAndamento($codAndamento)
    {
        $this->codAndamento = $codAndamento;
        return $this;
    }

    /**
     * Get codAndamento
     *
     * @return integer
     */
    public function getCodAndamento()
    {
        return $this->codAndamento;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return SwAndamento
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return SwAndamento
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return SwAndamento
     */
    public function setCodOrgao($codOrgao)
    {
        $this->codOrgao = $codOrgao;
        return $this;
    }

    /**
     * Get codOrgao
     *
     * @return integer
     */
    public function getCodOrgao()
    {
        return $this->codOrgao;
    }

    /**
     * Set codUsuario
     *
     * @param integer $codUsuario
     * @return SwAndamento
     */
    public function setCodUsuario($codUsuario)
    {
        $this->codUsuario = $codUsuario;
        return $this;
    }

    /**
     * Get codUsuario
     *
     * @return integer
     */
    public function getCodUsuario()
    {
        return $this->codUsuario;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return SwAndamento
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
     * Set codSituacao
     *
     * @param integer $codSituacao
     * @return SwAndamento
     */
    public function setCodSituacao($codSituacao)
    {
        $this->codSituacao = $codSituacao;
        return $this;
    }

    /**
     * Get codSituacao
     *
     * @return integer
     */
    public function getCodSituacao()
    {
        return $this->codSituacao;
    }

    /**
     * OneToMany (owning side)
     * Add SwUltimoAndamento
     *
     * @param \Urbem\CoreBundle\Entity\SwUltimoAndamento $fkSwUltimoAndamento
     * @return SwAndamento
     */
    public function addFkSwUltimoAndamentos(\Urbem\CoreBundle\Entity\SwUltimoAndamento $fkSwUltimoAndamento)
    {
        if (false === $this->fkSwUltimoAndamentos->contains($fkSwUltimoAndamento)) {
            $fkSwUltimoAndamento->setFkSwAndamento($this);
            $this->fkSwUltimoAndamentos->add($fkSwUltimoAndamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwUltimoAndamento
     *
     * @param \Urbem\CoreBundle\Entity\SwUltimoAndamento $fkSwUltimoAndamento
     */
    public function removeFkSwUltimoAndamentos(\Urbem\CoreBundle\Entity\SwUltimoAndamento $fkSwUltimoAndamento)
    {
        $this->fkSwUltimoAndamentos->removeElement($fkSwUltimoAndamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwUltimoAndamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwUltimoAndamento
     */
    public function getFkSwUltimoAndamentos()
    {
        return $this->fkSwUltimoAndamentos;
    }

    /**
     * OneToMany (owning side)
     * Add SwDespacho
     *
     * @param \Urbem\CoreBundle\Entity\SwDespacho $fkSwDespacho
     * @return SwAndamento
     */
    public function addFkSwDespachos(\Urbem\CoreBundle\Entity\SwDespacho $fkSwDespacho)
    {
        if (false === $this->fkSwDespachos->contains($fkSwDespacho)) {
            $fkSwDespacho->setFkSwAndamento($this);
            $this->fkSwDespachos->add($fkSwDespacho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwDespacho
     *
     * @param \Urbem\CoreBundle\Entity\SwDespacho $fkSwDespacho
     */
    public function removeFkSwDespachos(\Urbem\CoreBundle\Entity\SwDespacho $fkSwDespacho)
    {
        $this->fkSwDespachos->removeElement($fkSwDespacho);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwDespachos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwDespacho
     */
    public function getFkSwDespachos()
    {
        return $this->fkSwDespachos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return SwAndamento
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->anoExercicio = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return SwAndamento
     */
    public function setFkOrganogramaOrgao(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        $this->codOrgao = $fkOrganogramaOrgao->getCodOrgao();
        $this->fkOrganogramaOrgao = $fkOrganogramaOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    public function getFkOrganogramaOrgao()
    {
        return $this->fkOrganogramaOrgao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return SwAndamento
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->codUsuario = $fkAdministracaoUsuario->getNumcgm();
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
     * ManyToOne (inverse side)
     * Set fkSwSituacaoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwSituacaoProcesso $fkSwSituacaoProcesso
     * @return SwAndamento
     */
    public function setFkSwSituacaoProcesso(\Urbem\CoreBundle\Entity\SwSituacaoProcesso $fkSwSituacaoProcesso)
    {
        $this->codSituacao = $fkSwSituacaoProcesso->getCodSituacao();
        $this->fkSwSituacaoProcesso = $fkSwSituacaoProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwSituacaoProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwSituacaoProcesso
     */
    public function getFkSwSituacaoProcesso()
    {
        return $this->fkSwSituacaoProcesso;
    }

    /**
     * OneToOne (inverse side)
     * Set SwRecebimento
     *
     * @param \Urbem\CoreBundle\Entity\SwRecebimento $fkSwRecebimento
     * @return SwAndamento
     */
    public function setFkSwRecebimento(\Urbem\CoreBundle\Entity\SwRecebimento $fkSwRecebimento)
    {
        $fkSwRecebimento->setFkSwAndamento($this);
        $this->fkSwRecebimento = $fkSwRecebimento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkSwRecebimento
     *
     * @return \Urbem\CoreBundle\Entity\SwRecebimento
     */
    public function getFkSwRecebimento()
    {
        return $this->fkSwRecebimento;
    }
}
