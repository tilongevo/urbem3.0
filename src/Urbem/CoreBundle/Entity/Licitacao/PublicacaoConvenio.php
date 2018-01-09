<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * PublicacaoConvenio
 */
class PublicacaoConvenio
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $numConvenio;

    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtPublicacao;

    /**
     * @var integer
     */
    private $numPublicacao;

    /**
     * @var string
     */
    private $observacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    private $fkLicitacaoConvenio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade
     */
    private $fkLicitacaoVeiculosPublicidade;

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PublicacaoConvenio
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
     * Set numConvenio
     *
     * @param integer $numConvenio
     * @return PublicacaoConvenio
     */
    public function setNumConvenio($numConvenio)
    {
        $this->numConvenio = $numConvenio;
        return $this;
    }

    /**
     * Get numConvenio
     *
     * @return integer
     */
    public function getNumConvenio()
    {
        return $this->numConvenio;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return PublicacaoConvenio
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
     * @param \Urbem\CoreBundle\Helper\DatePK $dtPublicacao
     * @return PublicacaoConvenio
     */
    public function setDtPublicacao(\Urbem\CoreBundle\Helper\DatePK $dtPublicacao)
    {
        $this->dtPublicacao = $dtPublicacao;
        return $this;
    }

    /**
     * Get dtPublicacao
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtPublicacao()
    {
        return $this->dtPublicacao;
    }

    /**
     * Set numPublicacao
     *
     * @param integer $numPublicacao
     * @return PublicacaoConvenio
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
     * Set observacao
     *
     * @param string $observacao
     * @return PublicacaoConvenio
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
     * ManyToOne (inverse side)
     * Set fkLicitacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio
     * @return PublicacaoConvenio
     */
    public function setFkLicitacaoConvenio(\Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio)
    {
        $this->numConvenio = $fkLicitacaoConvenio->getNumConvenio();
        $this->exercicio = $fkLicitacaoConvenio->getExercicio();
        $this->fkLicitacaoConvenio = $fkLicitacaoConvenio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    public function getFkLicitacaoConvenio()
    {
        return $this->fkLicitacaoConvenio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLicitacaoVeiculosPublicidade
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade
     * @return PublicacaoConvenio
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

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->numPublicacao.' - '.$this->fkLicitacaoVeiculosPublicidade;
    }
}
