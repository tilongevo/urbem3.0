<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * EditalAnulado
 */
class EditalAnulado
{
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
    private $justificativa;

    /**
     * @var \DateTime
     */
    private $dtAnulacao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\Edital
     */
    private $fkLicitacaoEdital;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtAnulacao = new \DateTime;
    }

    /**
     * Set numEdital
     *
     * @param integer $numEdital
     * @return EditalAnulado
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
     * @return EditalAnulado
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
     * Set justificativa
     *
     * @param string $justificativa
     * @return EditalAnulado
     */
    public function setJustificativa($justificativa)
    {
        $this->justificativa = $justificativa;
        return $this;
    }

    /**
     * Get justificativa
     *
     * @return string
     */
    public function getJustificativa()
    {
        return $this->justificativa;
    }

    /**
     * Set dtAnulacao
     *
     * @param \DateTime $dtAnulacao
     * @return EditalAnulado
     */
    public function setDtAnulacao(\DateTime $dtAnulacao)
    {
        $this->dtAnulacao = $dtAnulacao;
        return $this;
    }

    /**
     * Get dtAnulacao
     *
     * @return \DateTime
     */
    public function getDtAnulacao()
    {
        return $this->dtAnulacao;
    }

    /**
     * OneToOne (owning side)
     * Set LicitacaoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital
     * @return EditalAnulado
     */
    public function setFkLicitacaoEdital(\Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital)
    {
        $this->numEdital = $fkLicitacaoEdital->getNumEdital();
        $this->exercicio = $fkLicitacaoEdital->getExercicio();
        $this->fkLicitacaoEdital = $fkLicitacaoEdital;
        return $this;
    }

    /**
     * OneToOne (owning side)
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
        return (string) $this->numEdital;
    }
}
