<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * AutenticacaoLivro
 */
class AutenticacaoLivro
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var integer
     */
    private $nrLivro;

    /**
     * @var \DateTime
     */
    private $periodoInicio;

    /**
     * @var \DateTime
     */
    private $periodoTermino;

    /**
     * @var integer
     */
    private $qtdPaginas;

    /**
     * @var string
     */
    private $observacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoDocumento
     */
    private $fkFiscalizacaoAutenticacaoDocumentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    private $fkEconomicoCadastroEconomico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoAutenticacaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return AutenticacaoLivro
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set nrLivro
     *
     * @param integer $nrLivro
     * @return AutenticacaoLivro
     */
    public function setNrLivro($nrLivro)
    {
        $this->nrLivro = $nrLivro;
        return $this;
    }

    /**
     * Get nrLivro
     *
     * @return integer
     */
    public function getNrLivro()
    {
        return $this->nrLivro;
    }

    /**
     * Set periodoInicio
     *
     * @param \DateTime $periodoInicio
     * @return AutenticacaoLivro
     */
    public function setPeriodoInicio(\DateTime $periodoInicio)
    {
        $this->periodoInicio = $periodoInicio;
        return $this;
    }

    /**
     * Get periodoInicio
     *
     * @return \DateTime
     */
    public function getPeriodoInicio()
    {
        return $this->periodoInicio;
    }

    /**
     * Set periodoTermino
     *
     * @param \DateTime $periodoTermino
     * @return AutenticacaoLivro
     */
    public function setPeriodoTermino(\DateTime $periodoTermino)
    {
        $this->periodoTermino = $periodoTermino;
        return $this;
    }

    /**
     * Get periodoTermino
     *
     * @return \DateTime
     */
    public function getPeriodoTermino()
    {
        return $this->periodoTermino;
    }

    /**
     * Set qtdPaginas
     *
     * @param integer $qtdPaginas
     * @return AutenticacaoLivro
     */
    public function setQtdPaginas($qtdPaginas)
    {
        $this->qtdPaginas = $qtdPaginas;
        return $this;
    }

    /**
     * Get qtdPaginas
     *
     * @return integer
     */
    public function getQtdPaginas()
    {
        return $this->qtdPaginas;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return AutenticacaoLivro
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
     * Add FiscalizacaoAutenticacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoDocumento $fkFiscalizacaoAutenticacaoDocumento
     * @return AutenticacaoLivro
     */
    public function addFkFiscalizacaoAutenticacaoDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoDocumento $fkFiscalizacaoAutenticacaoDocumento)
    {
        if (false === $this->fkFiscalizacaoAutenticacaoDocumentos->contains($fkFiscalizacaoAutenticacaoDocumento)) {
            $fkFiscalizacaoAutenticacaoDocumento->setFkFiscalizacaoAutenticacaoLivro($this);
            $this->fkFiscalizacaoAutenticacaoDocumentos->add($fkFiscalizacaoAutenticacaoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoAutenticacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoDocumento $fkFiscalizacaoAutenticacaoDocumento
     */
    public function removeFkFiscalizacaoAutenticacaoDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoDocumento $fkFiscalizacaoAutenticacaoDocumento)
    {
        $this->fkFiscalizacaoAutenticacaoDocumentos->removeElement($fkFiscalizacaoAutenticacaoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoAutenticacaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutenticacaoDocumento
     */
    public function getFkFiscalizacaoAutenticacaoDocumentos()
    {
        return $this->fkFiscalizacaoAutenticacaoDocumentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico
     * @return AutenticacaoLivro
     */
    public function setFkEconomicoCadastroEconomico(\Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoCadastroEconomico->getInscricaoEconomica();
        $this->fkEconomicoCadastroEconomico = $fkEconomicoCadastroEconomico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoCadastroEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    public function getFkEconomicoCadastroEconomico()
    {
        return $this->fkEconomicoCadastroEconomico;
    }
}
