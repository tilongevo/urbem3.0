<?php
 
namespace Urbem\CoreBundle\Entity\Tceam;

/**
 * EsferaConvenio
 */
class EsferaConvenio
{
    /**
     * PK
     * @var integer
     */
    private $numConvenio;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $esfera;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    private $fkLicitacaoConvenio;


    /**
     * Set numConvenio
     *
     * @param integer $numConvenio
     * @return EsferaConvenio
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return EsferaConvenio
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
     * Set esfera
     *
     * @param string $esfera
     * @return EsferaConvenio
     */
    public function setEsfera($esfera)
    {
        $this->esfera = $esfera;
        return $this;
    }

    /**
     * Get esfera
     *
     * @return string
     */
    public function getEsfera()
    {
        return $this->esfera;
    }

    /**
     * OneToOne (owning side)
     * Set LicitacaoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio
     * @return EsferaConvenio
     */
    public function setFkLicitacaoConvenio(\Urbem\CoreBundle\Entity\Licitacao\Convenio $fkLicitacaoConvenio)
    {
        $this->numConvenio = $fkLicitacaoConvenio->getNumConvenio();
        $this->exercicio = $fkLicitacaoConvenio->getExercicio();
        $this->fkLicitacaoConvenio = $fkLicitacaoConvenio;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkLicitacaoConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Licitacao\Convenio
     */
    public function getFkLicitacaoConvenio()
    {
        return $this->fkLicitacaoConvenio;
    }
}
