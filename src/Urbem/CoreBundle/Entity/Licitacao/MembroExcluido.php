<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * MembroExcluido
 */
class MembroExcluido
{
    /**
     * PK
     * @var integer
     */
    private $codNorma;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $codComissao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros
     */
    private $fkLicitacaoComissaoMembros;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return MembroExcluido
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return MembroExcluido
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
     * Set codComissao
     *
     * @param integer $codComissao
     * @return MembroExcluido
     */
    public function setCodComissao($codComissao)
    {
        $this->codComissao = $codComissao;
        return $this;
    }

    /**
     * Get codComissao
     *
     * @return integer
     */
    public function getCodComissao()
    {
        return $this->codComissao;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return MembroExcluido
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToOne (owning side)
     * Set LicitacaoComissaoMembros
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros $fkLicitacaoComissaoMembros
     * @return MembroExcluido
     */
    public function setFkLicitacaoComissaoMembros(\Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros $fkLicitacaoComissaoMembros)
    {
        $this->codComissao = $fkLicitacaoComissaoMembros->getCodComissao();
        $this->numcgm = $fkLicitacaoComissaoMembros->getNumcgm();
        $this->codNorma = $fkLicitacaoComissaoMembros->getCodNorma();
        $this->fkLicitacaoComissaoMembros = $fkLicitacaoComissaoMembros;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkLicitacaoComissaoMembros
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros
     */
    public function getFkLicitacaoComissaoMembros()
    {
        return $this->fkLicitacaoComissaoMembros;
    }
}
