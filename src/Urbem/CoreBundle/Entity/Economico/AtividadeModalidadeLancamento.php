<?php

namespace Urbem\CoreBundle\Entity\Economico;

/**
 * AtividadeModalidadeLancamento
 */
class AtividadeModalidadeLancamento
{
    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtInicio;

    /**
     * @var \DateTime
     */
    private $dtBaixa;

    /**
     * @var string
     */
    private $motivoBaixa;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var boolean
     */
    private $percentual;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeIndicador
     */
    private $fkEconomicoAtividadeModalidadeIndicadores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeMoeda
     */
    private $fkEconomicoAtividadeModalidadeMoedas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Atividade
     */
    private $fkEconomicoAtividade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\ModalidadeLancamento
     */
    private $fkEconomicoModalidadeLancamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoAtividadeModalidadeIndicadores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoAtividadeModalidadeMoedas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtInicio = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return AtividadeModalidadeLancamento
     */
    public function setCodAtividade($codAtividade)
    {
        $this->codAtividade = $codAtividade;
        return $this;
    }

    /**
     * Get codAtividade
     *
     * @return integer
     */
    public function getCodAtividade()
    {
        return $this->codAtividade;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return AtividadeModalidadeLancamento
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set dtInicio
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtInicio
     * @return AtividadeModalidadeLancamento
     */
    public function setDtInicio(\Urbem\CoreBundle\Helper\DatePK $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set dtBaixa
     *
     * @param \DateTime $dtBaixa
     * @return AtividadeModalidadeLancamento
     */
    public function setDtBaixa(\DateTime $dtBaixa = null)
    {
        $this->dtBaixa = $dtBaixa;
        return $this;
    }

    /**
     * Get dtBaixa
     *
     * @return \DateTime
     */
    public function getDtBaixa()
    {
        return $this->dtBaixa;
    }

    /**
     * Set motivoBaixa
     *
     * @param string $motivoBaixa
     * @return AtividadeModalidadeLancamento
     */
    public function setMotivoBaixa($motivoBaixa = null)
    {
        $this->motivoBaixa = $motivoBaixa;
        return $this;
    }

    /**
     * Get motivoBaixa
     *
     * @return string
     */
    public function getMotivoBaixa()
    {
        return $this->motivoBaixa;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return AtividadeModalidadeLancamento
     */
    public function setValor($valor = null)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set percentual
     *
     * @param boolean $percentual
     * @return AtividadeModalidadeLancamento
     */
    public function setPercentual($percentual)
    {
        $this->percentual = $percentual;
        return $this;
    }

    /**
     * Get percentual
     *
     * @return boolean
     */
    public function getPercentual()
    {
        return $this->percentual;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtividadeModalidadeIndicador
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeIndicador $fkEconomicoAtividadeModalidadeIndicador
     * @return AtividadeModalidadeLancamento
     */
    public function addFkEconomicoAtividadeModalidadeIndicadores(\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeIndicador $fkEconomicoAtividadeModalidadeIndicador)
    {
        if (false === $this->fkEconomicoAtividadeModalidadeIndicadores->contains($fkEconomicoAtividadeModalidadeIndicador)) {
            $fkEconomicoAtividadeModalidadeIndicador->setFkEconomicoAtividadeModalidadeLancamento($this);
            $this->fkEconomicoAtividadeModalidadeIndicadores->add($fkEconomicoAtividadeModalidadeIndicador);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtividadeModalidadeIndicador
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeIndicador $fkEconomicoAtividadeModalidadeIndicador
     */
    public function removeFkEconomicoAtividadeModalidadeIndicadores(\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeIndicador $fkEconomicoAtividadeModalidadeIndicador)
    {
        $this->fkEconomicoAtividadeModalidadeIndicadores->removeElement($fkEconomicoAtividadeModalidadeIndicador);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtividadeModalidadeIndicadores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeIndicador
     */
    public function getFkEconomicoAtividadeModalidadeIndicadores()
    {
        return $this->fkEconomicoAtividadeModalidadeIndicadores;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtividadeModalidadeMoeda
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeMoeda $fkEconomicoAtividadeModalidadeMoeda
     * @return AtividadeModalidadeLancamento
     */
    public function addFkEconomicoAtividadeModalidadeMoedas(\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeMoeda $fkEconomicoAtividadeModalidadeMoeda)
    {
        if (false === $this->fkEconomicoAtividadeModalidadeMoedas->contains($fkEconomicoAtividadeModalidadeMoeda)) {
            $fkEconomicoAtividadeModalidadeMoeda->setFkEconomicoAtividadeModalidadeLancamento($this);
            $this->fkEconomicoAtividadeModalidadeMoedas->add($fkEconomicoAtividadeModalidadeMoeda);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtividadeModalidadeMoeda
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeMoeda $fkEconomicoAtividadeModalidadeMoeda
     */
    public function removeFkEconomicoAtividadeModalidadeMoedas(\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeMoeda $fkEconomicoAtividadeModalidadeMoeda)
    {
        $this->fkEconomicoAtividadeModalidadeMoedas->removeElement($fkEconomicoAtividadeModalidadeMoeda);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtividadeModalidadeMoedas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeModalidadeMoeda
     */
    public function getFkEconomicoAtividadeModalidadeMoedas()
    {
        return $this->fkEconomicoAtividadeModalidadeMoedas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade
     * @return AtividadeModalidadeLancamento
     */
    public function setFkEconomicoAtividade(\Urbem\CoreBundle\Entity\Economico\Atividade $fkEconomicoAtividade)
    {
        $this->codAtividade = $fkEconomicoAtividade->getCodAtividade();
        $this->fkEconomicoAtividade = $fkEconomicoAtividade;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoAtividade
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Atividade
     */
    public function getFkEconomicoAtividade()
    {
        return $this->fkEconomicoAtividade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoModalidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ModalidadeLancamento $fkEconomicoModalidadeLancamento
     * @return AtividadeModalidadeLancamento
     */
    public function setFkEconomicoModalidadeLancamento(\Urbem\CoreBundle\Entity\Economico\ModalidadeLancamento $fkEconomicoModalidadeLancamento)
    {
        $this->codModalidade = $fkEconomicoModalidadeLancamento->getCodModalidade();
        $this->fkEconomicoModalidadeLancamento = $fkEconomicoModalidadeLancamento;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoModalidadeLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Economico\ModalidadeLancamento
     */
    public function getFkEconomicoModalidadeLancamento()
    {
        return $this->fkEconomicoModalidadeLancamento;
    }

    /**
    * @return string
    */
    public function __toString()
    {
        if (!$this->codAtividade) {
            return '';
        }

        return sprintf(
            '%s - %s',
            $this->getFkEconomicoAtividade()->getCodEstrutural(),
            $this->getFkEconomicoAtividade()->getNomAtividade()
        );
    }
}
