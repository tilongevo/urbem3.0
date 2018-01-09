<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwAndamentoPadrao
 */
class SwAndamentoPadrao
{
    /**
     * PK
     * @var integer
     */
    private $numPassagens;

    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * PK
     * @var integer
     */
    private $codAssunto;

    /**
     * PK
     * @var integer
     */
    private $codOrgao;

    /**
     * PK
     * @var integer
     */
    private $ordem;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $numDia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwAssunto
     */
    private $fkSwAssunto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;


    /**
     * Set numPassagens
     *
     * @param integer $numPassagens
     * @return SwAndamentoPadrao
     */
    public function setNumPassagens($numPassagens)
    {
        $this->numPassagens = $numPassagens;
        return $this;
    }

    /**
     * Get numPassagens
     *
     * @return integer
     */
    public function getNumPassagens()
    {
        return $this->numPassagens;
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return SwAndamentoPadrao
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set codAssunto
     *
     * @param integer $codAssunto
     * @return SwAndamentoPadrao
     */
    public function setCodAssunto($codAssunto)
    {
        $this->codAssunto = $codAssunto;
        return $this;
    }

    /**
     * Get codAssunto
     *
     * @return integer
     */
    public function getCodAssunto()
    {
        return $this->codAssunto;
    }

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return SwAndamentoPadrao
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
     * Set ordem
     *
     * @param integer $ordem
     * @return SwAndamentoPadrao
     */
    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
        return $this;
    }

    /**
     * Get ordem
     *
     * @return integer
     */
    public function getOrdem()
    {
        return $this->ordem;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return SwAndamentoPadrao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set numDia
     *
     * @param integer $numDia
     * @return SwAndamentoPadrao
     */
    public function setNumDia($numDia)
    {
        $this->numDia = $numDia;
        return $this;
    }

    /**
     * Get numDia
     *
     * @return integer
     */
    public function getNumDia()
    {
        return $this->numDia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwAssunto
     *
     * @param \Urbem\CoreBundle\Entity\SwAssunto $fkSwAssunto
     * @return SwAndamentoPadrao
     */
    public function setFkSwAssunto(\Urbem\CoreBundle\Entity\SwAssunto $fkSwAssunto)
    {
        $this->codAssunto = $fkSwAssunto->getCodAssunto();
        $this->codClassificacao = $fkSwAssunto->getCodClassificacao();
        $this->fkSwAssunto = $fkSwAssunto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwAssunto
     *
     * @return \Urbem\CoreBundle\Entity\SwAssunto
     */
    public function getFkSwAssunto()
    {
        return $this->fkSwAssunto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return SwAndamentoPadrao
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
}
