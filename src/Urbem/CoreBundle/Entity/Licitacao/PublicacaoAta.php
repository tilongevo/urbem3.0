<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * PublicacaoAta
 */
class PublicacaoAta
{
    /**
     * PK
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $ataId;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var \DateTime
     */
    private $dtPublicacao;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var integer
     */
    private $numPublicacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Ata
     */
    private $fkLicitacaoAta;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade
     */
    private $fkLicitacaoVeiculosPublicidade;


    /**
     * Set id
     *
     * @param integer $id
     * @return PublicacaoAta
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ataId
     *
     * @param integer $ataId
     * @return PublicacaoAta
     */
    public function setAtaId($ataId)
    {
        $this->ataId = $ataId;
        return $this;
    }

    /**
     * Get ataId
     *
     * @return integer
     */
    public function getAtaId()
    {
        return $this->ataId;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return PublicacaoAta
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
     * Set dtPublicacao
     *
     * @param \DateTime $dtPublicacao
     * @return PublicacaoAta
     */
    public function setDtPublicacao(\DateTime $dtPublicacao)
    {
        $this->dtPublicacao = $dtPublicacao;
        return $this;
    }

    /**
     * Get dtPublicacao
     *
     * @return \DateTime
     */
    public function getDtPublicacao()
    {
        return $this->dtPublicacao;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return PublicacaoAta
     */
    public function setObservacao($observacao)
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
     * Set numPublicacao
     *
     * @param integer $numPublicacao
     * @return PublicacaoAta
     */
    public function setNumPublicacao($numPublicacao = null)
    {
        $this->numPublicacao = $numPublicacao;
        return $this;
    }

    /**
     * Get numPublicacao
     *
     * @return integer
     */
    public function getNumPublicacao()
    {
        return $this->numPublicacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoAta
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Ata $fkLicitacaoAta
     * @return PublicacaoAta
     */
    public function setFkLicitacaoAta(\Urbem\CoreBundle\Entity\Licitacao\Ata $fkLicitacaoAta)
    {
        $this->ataId = $fkLicitacaoAta->getId();
        $this->fkLicitacaoAta = $fkLicitacaoAta;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoAta
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Ata
     */
    public function getFkLicitacaoAta()
    {
        return $this->fkLicitacaoAta;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoVeiculosPublicidade
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade
     * @return PublicacaoAta
     */
    public function setFkLicitacaoVeiculosPublicidade(\Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade)
    {
        $this->numcgm = $fkLicitacaoVeiculosPublicidade->getNumcgm();
        $this->fkLicitacaoVeiculosPublicidade = $fkLicitacaoVeiculosPublicidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoVeiculosPublicidade
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade
     */
    public function getFkLicitacaoVeiculosPublicidade()
    {
        return $this->fkLicitacaoVeiculosPublicidade;
    }
}
