<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * PublicacaoEdital
 */
class PublicacaoEdital
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dataPublicacao;

    /**
     * PK
     * @var integer
     */
    private $numEdital;

    /**
     * PK
     * @var string
     */
    private $exercicio;

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
     * @var \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade
     */
    private $fkLicitacaoVeiculosPublicidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Licitacao\Edital
     */
    private $fkLicitacaoEdital;

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return PublicacaoEdital
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
     * Set dataPublicacao
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dataPublicacao
     * @return PublicacaoEdital
     */
    public function setDataPublicacao(\Urbem\CoreBundle\Helper\DatePK $dataPublicacao)
    {
        $this->dataPublicacao = $dataPublicacao;
        return $this;
    }

    /**
     * Get dataPublicacao
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDataPublicacao()
    {
        return $this->dataPublicacao;
    }

    /**
     * Set numEdital
     *
     * @param integer $numEdital
     * @return PublicacaoEdital
     */
    public function setNumEdital($numEdital)
    {
        $this->numEdital = $numEdital;
        return $this;
    }

    /**
     * Get numEdital
     *
     * @return integer
     */
    public function getNumEdital()
    {
        return $this->numEdital;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PublicacaoEdital
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
     * Set observacao
     *
     * @param string $observacao
     * @return PublicacaoEdital
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
     * Set numPublicacao
     *
     * @param integer $numPublicacao
     * @return PublicacaoEdital
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
     * Set fkLicitacaoVeiculosPublicidade
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade $fkLicitacaoVeiculosPublicidade
     * @return PublicacaoEdital
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
     * ManyToOne (inverse side)
     * Set fkLicitacaoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital
     * @return PublicacaoEdital
     */
    public function setFkLicitacaoEdital(\Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital)
    {
        $this->numEdital = $fkLicitacaoEdital->getNumEdital();
        $this->exercicio = $fkLicitacaoEdital->getExercicio();
        $this->fkLicitacaoEdital = $fkLicitacaoEdital;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLicitacaoEdital
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Edital
     */
    public function getFkLicitacaoEdital()
    {
        return $this->fkLicitacaoEdital;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->getFkLicitacaoEdital()) {
            return sprintf('%s - %s', $this->getFkLicitacaoVeiculosPublicidade()->getFkSwCgm(), $this->getDataPublicacao()->format('d/m/Y'));
        } else {
            return (string) "Publicação do Edital";
        }
    }
}
