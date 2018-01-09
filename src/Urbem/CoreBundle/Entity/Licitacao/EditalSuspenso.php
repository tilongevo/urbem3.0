<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * EditalSuspenso
 */
class EditalSuspenso
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
     * @var \DateTime
     */
    private $dtSuspensao;

    /**
     * @var string
     */
    private $justificativa;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\Edital
     */
    private $fkLicitacaoEdital;


    /**
     * Set numEdital
     *
     * @param integer $numEdital
     * @return EditalSuspenso
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
     * @return EditalSuspenso
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
     * Set dtSuspensao
     *
     * @param \DateTime $dtSuspensao
     * @return EditalSuspenso
     */
    public function setDtSuspensao(\DateTime $dtSuspensao)
    {
        $this->dtSuspensao = $dtSuspensao;
        return $this;
    }

    /**
     * Get dtSuspensao
     *
     * @return \DateTime
     */
    public function getDtSuspensao()
    {
        return $this->dtSuspensao;
    }

    /**
     * Set justificativa
     *
     * @param string $justificativa
     * @return EditalSuspenso
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
     * OneToOne (owning side)
     * Set LicitacaoEdital
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Edital $fkLicitacaoEdital
     * @return EditalSuspenso
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
