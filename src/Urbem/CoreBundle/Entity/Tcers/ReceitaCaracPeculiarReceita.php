<?php
 
namespace Urbem\CoreBundle\Entity\Tcers;

/**
 * ReceitaCaracPeculiarReceita
 */
class ReceitaCaracPeculiarReceita
{
    /**
     * PK
     * @var integer
     */
    private $codReceita;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codCaracteristica;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceita;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcers\CaracPeculiarReceita
     */
    private $fkTcersCaracPeculiarReceita;


    /**
     * Set codReceita
     *
     * @param integer $codReceita
     * @return ReceitaCaracPeculiarReceita
     */
    public function setCodReceita($codReceita)
    {
        $this->codReceita = $codReceita;
        return $this;
    }

    /**
     * Get codReceita
     *
     * @return integer
     */
    public function getCodReceita()
    {
        return $this->codReceita;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ReceitaCaracPeculiarReceita
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
     * Set codCaracteristica
     *
     * @param integer $codCaracteristica
     * @return ReceitaCaracPeculiarReceita
     */
    public function setCodCaracteristica($codCaracteristica)
    {
        $this->codCaracteristica = $codCaracteristica;
        return $this;
    }

    /**
     * Get codCaracteristica
     *
     * @return integer
     */
    public function getCodCaracteristica()
    {
        return $this->codCaracteristica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcersCaracPeculiarReceita
     *
     * @param \Urbem\CoreBundle\Entity\Tcers\CaracPeculiarReceita $fkTcersCaracPeculiarReceita
     * @return ReceitaCaracPeculiarReceita
     */
    public function setFkTcersCaracPeculiarReceita(\Urbem\CoreBundle\Entity\Tcers\CaracPeculiarReceita $fkTcersCaracPeculiarReceita)
    {
        $this->codCaracteristica = $fkTcersCaracPeculiarReceita->getCodCaracteristica();
        $this->fkTcersCaracPeculiarReceita = $fkTcersCaracPeculiarReceita;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcersCaracPeculiarReceita
     *
     * @return \Urbem\CoreBundle\Entity\Tcers\CaracPeculiarReceita
     */
    public function getFkTcersCaracPeculiarReceita()
    {
        return $this->fkTcersCaracPeculiarReceita;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return ReceitaCaracPeculiarReceita
     */
    public function setFkOrcamentoReceita(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita)
    {
        $this->exercicio = $fkOrcamentoReceita->getExercicio();
        $this->codReceita = $fkOrcamentoReceita->getCodReceita();
        $this->fkOrcamentoReceita = $fkOrcamentoReceita;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkOrcamentoReceita
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    public function getFkOrcamentoReceita()
    {
        return $this->fkOrcamentoReceita;
    }
}
