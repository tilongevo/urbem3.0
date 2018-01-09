<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Pensao
 */
class Pensao
{
    /**
     * PK
     * @var integer
     */
    private $codPensao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codDependente;

    /**
     * @var integer
     */
    private $codServidor;

    /**
     * @var string
     */
    private $tipoPensao;

    /**
     * @var \DateTime
     */
    private $dtInclusao;

    /**
     * @var \DateTime
     */
    private $dtLimite;

    /**
     * @var integer
     */
    private $percentual;

    /**
     * @var string
     */
    private $observacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\PensaoExcluida
     */
    private $fkPessoalPensaoExcluida;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\PensaoBanco
     */
    private $fkPessoalPensaoBanco;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\PensaoFuncao
     */
    private $fkPessoalPensaoFuncao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ResponsavelLegal
     */
    private $fkPessoalResponsavelLegal;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\PensaoValor
     */
    private $fkPessoalPensaoValor;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\PensaoIncidencia
     */
    private $fkPessoalPensaoIncidencias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ServidorDependente
     */
    private $fkPessoalServidorDependente;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalPensaoIncidencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codPensao
     *
     * @param integer $codPensao
     * @return Pensao
     */
    public function setCodPensao($codPensao)
    {
        $this->codPensao = $codPensao;
        return $this;
    }

    /**
     * Get codPensao
     *
     * @return integer
     */
    public function getCodPensao()
    {
        return $this->codPensao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Pensao
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
     * Set codDependente
     *
     * @param integer $codDependente
     * @return Pensao
     */
    public function setCodDependente($codDependente)
    {
        $this->codDependente = $codDependente;
        return $this;
    }

    /**
     * Get codDependente
     *
     * @return integer
     */
    public function getCodDependente()
    {
        return $this->codDependente;
    }

    /**
     * Set codServidor
     *
     * @param integer $codServidor
     * @return Pensao
     */
    public function setCodServidor($codServidor)
    {
        $this->codServidor = $codServidor;
        return $this;
    }

    /**
     * Get codServidor
     *
     * @return integer
     */
    public function getCodServidor()
    {
        return $this->codServidor;
    }

    /**
     * Set tipoPensao
     *
     * @param string $tipoPensao
     * @return Pensao
     */
    public function setTipoPensao($tipoPensao)
    {
        $this->tipoPensao = $tipoPensao;
        return $this;
    }

    /**
     * Get tipoPensao
     *
     * @return string
     */
    public function getTipoPensao()
    {
        return $this->tipoPensao;
    }

    /**
     * Set dtInclusao
     *
     * @param \DateTime $dtInclusao
     * @return Pensao
     */
    public function setDtInclusao(\DateTime $dtInclusao)
    {
        $this->dtInclusao = $dtInclusao;
        return $this;
    }

    /**
     * Get dtInclusao
     *
     * @return \DateTime
     */
    public function getDtInclusao()
    {
        return $this->dtInclusao;
    }

    /**
     * Set dtLimite
     *
     * @param \DateTime $dtLimite
     * @return Pensao
     */
    public function setDtLimite(\DateTime $dtLimite = null)
    {
        $this->dtLimite = $dtLimite;
        return $this;
    }

    /**
     * Get dtLimite
     *
     * @return \DateTime
     */
    public function getDtLimite()
    {
        return $this->dtLimite;
    }

    /**
     * Set percentual
     *
     * @param integer $percentual
     * @return Pensao
     */
    public function setPercentual($percentual = null)
    {
        $this->percentual = $percentual;
        return $this;
    }

    /**
     * Get percentual
     *
     * @return integer
     */
    public function getPercentual()
    {
        return $this->percentual;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return Pensao
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalPensaoIncidencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\PensaoIncidencia $fkPessoalPensaoIncidencia
     * @return Pensao
     */
    public function addFkPessoalPensaoIncidencias(\Urbem\CoreBundle\Entity\Pessoal\PensaoIncidencia $fkPessoalPensaoIncidencia)
    {
        if (false === $this->fkPessoalPensaoIncidencias->contains($fkPessoalPensaoIncidencia)) {
            $fkPessoalPensaoIncidencia->setFkPessoalPensao($this);
            $this->fkPessoalPensaoIncidencias->add($fkPessoalPensaoIncidencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalPensaoIncidencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\PensaoIncidencia $fkPessoalPensaoIncidencia
     */
    public function removeFkPessoalPensaoIncidencias(\Urbem\CoreBundle\Entity\Pessoal\PensaoIncidencia $fkPessoalPensaoIncidencia)
    {
        $this->fkPessoalPensaoIncidencias->removeElement($fkPessoalPensaoIncidencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalPensaoIncidencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\PensaoIncidencia
     */
    public function getFkPessoalPensaoIncidencias()
    {
        return $this->fkPessoalPensaoIncidencias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalServidorDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorDependente $fkPessoalServidorDependente
     * @return Pensao
     */
    public function setFkPessoalServidorDependente(\Urbem\CoreBundle\Entity\Pessoal\ServidorDependente $fkPessoalServidorDependente)
    {
        $this->codServidor = $fkPessoalServidorDependente->getCodServidor();
        $this->codDependente = $fkPessoalServidorDependente->getCodDependente();
        $this->fkPessoalServidorDependente = $fkPessoalServidorDependente;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalServidorDependente
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ServidorDependente
     */
    public function getFkPessoalServidorDependente()
    {
        return $this->fkPessoalServidorDependente;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalPensaoExcluida
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\PensaoExcluida $fkPessoalPensaoExcluida
     * @return Pensao
     */
    public function setFkPessoalPensaoExcluida(\Urbem\CoreBundle\Entity\Pessoal\PensaoExcluida $fkPessoalPensaoExcluida)
    {
        $fkPessoalPensaoExcluida->setFkPessoalPensao($this);
        $this->fkPessoalPensaoExcluida = $fkPessoalPensaoExcluida;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalPensaoExcluida
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\PensaoExcluida
     */
    public function getFkPessoalPensaoExcluida()
    {
        return $this->fkPessoalPensaoExcluida;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalPensaoBanco
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\PensaoBanco $fkPessoalPensaoBanco
     * @return Pensao
     */
    public function setFkPessoalPensaoBanco(\Urbem\CoreBundle\Entity\Pessoal\PensaoBanco $fkPessoalPensaoBanco)
    {
        $fkPessoalPensaoBanco->setFkPessoalPensao($this);
        $this->fkPessoalPensaoBanco = $fkPessoalPensaoBanco;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalPensaoBanco
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\PensaoBanco
     */
    public function getFkPessoalPensaoBanco()
    {
        return $this->fkPessoalPensaoBanco;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalPensaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\PensaoFuncao $fkPessoalPensaoFuncao
     * @return Pensao
     */
    public function setFkPessoalPensaoFuncao(\Urbem\CoreBundle\Entity\Pessoal\PensaoFuncao $fkPessoalPensaoFuncao)
    {
        $fkPessoalPensaoFuncao->setFkPessoalPensao($this);
        $this->fkPessoalPensaoFuncao = $fkPessoalPensaoFuncao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalPensaoFuncao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\PensaoFuncao
     */
    public function getFkPessoalPensaoFuncao()
    {
        return $this->fkPessoalPensaoFuncao;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalResponsavelLegal
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ResponsavelLegal $fkPessoalResponsavelLegal
     * @return Pensao
     */
    public function setFkPessoalResponsavelLegal(\Urbem\CoreBundle\Entity\Pessoal\ResponsavelLegal $fkPessoalResponsavelLegal)
    {
        $fkPessoalResponsavelLegal->setFkPessoalPensao($this);
        $this->fkPessoalResponsavelLegal = $fkPessoalResponsavelLegal;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalResponsavelLegal
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ResponsavelLegal
     */
    public function getFkPessoalResponsavelLegal()
    {
        return $this->fkPessoalResponsavelLegal;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalPensaoValor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\PensaoValor $fkPessoalPensaoValor
     * @return Pensao
     */
    public function setFkPessoalPensaoValor(\Urbem\CoreBundle\Entity\Pessoal\PensaoValor $fkPessoalPensaoValor)
    {
        $fkPessoalPensaoValor->setFkPessoalPensao($this);
        $this->fkPessoalPensaoValor = $fkPessoalPensaoValor;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalPensaoValor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\PensaoValor
     */
    public function getFkPessoalPensaoValor()
    {
        return $this->fkPessoalPensaoValor;
    }
}
