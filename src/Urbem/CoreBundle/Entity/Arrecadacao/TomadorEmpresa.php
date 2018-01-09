<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * TomadorEmpresa
 */
class TomadorEmpresa
{
    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa
     */
    private $fkArrecadacaoNotaAvulsa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    private $fkEconomicoCadastroEconomico;


    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return TomadorEmpresa
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return TomadorEmpresa
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico
     * @return TomadorEmpresa
     */
    public function setFkEconomicoCadastroEconomico(\Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoCadastroEconomico->getInscricaoEconomica();
        $this->fkEconomicoCadastroEconomico = $fkEconomicoCadastroEconomico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoCadastroEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    public function getFkEconomicoCadastroEconomico()
    {
        return $this->fkEconomicoCadastroEconomico;
    }

    /**
     * OneToOne (owning side)
     * Set ArrecadacaoNotaAvulsa
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa $fkArrecadacaoNotaAvulsa
     * @return TomadorEmpresa
     */
    public function setFkArrecadacaoNotaAvulsa(\Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa $fkArrecadacaoNotaAvulsa)
    {
        $this->codNota = $fkArrecadacaoNotaAvulsa->getCodNota();
        $this->fkArrecadacaoNotaAvulsa = $fkArrecadacaoNotaAvulsa;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkArrecadacaoNotaAvulsa
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\NotaAvulsa
     */
    public function getFkArrecadacaoNotaAvulsa()
    {
        return $this->fkArrecadacaoNotaAvulsa;
    }
}
