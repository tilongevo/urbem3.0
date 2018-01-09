<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * DependenteCarteiraVacinacao
 */
class DependenteCarteiraVacinacao
{
    /**
     * PK
     * @var integer
     */
    private $codDependente;

    /**
     * PK
     * @var integer
     */
    private $codCarteira;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Dependente
     */
    private $fkPessoalDependente;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\CarteiraVacinacao
     */
    private $fkPessoalCarteiraVacinacao;


    /**
     * Set codDependente
     *
     * @param integer $codDependente
     * @return DependenteCarteiraVacinacao
     */
    public function setCodDependente($codDependente)
    {
        $this->codDependente = $codDependente;
        return $this;
    }

    /**
     * Get codDependente
     *
     * @return integer
     */
    public function getCodDependente()
    {
        return $this->codDependente;
    }

    /**
     * Set codCarteira
     *
     * @param integer $codCarteira
     * @return DependenteCarteiraVacinacao
     */
    public function setCodCarteira($codCarteira)
    {
        $this->codCarteira = $codCarteira;
        return $this;
    }

    /**
     * Get codCarteira
     *
     * @return integer
     */
    public function getCodCarteira()
    {
        return $this->codCarteira;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalDependente
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente
     * @return DependenteCarteiraVacinacao
     */
    public function setFkPessoalDependente(\Urbem\CoreBundle\Entity\Pessoal\Dependente $fkPessoalDependente)
    {
        $this->codDependente = $fkPessoalDependente->getCodDependente();
        $this->fkPessoalDependente = $fkPessoalDependente;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalDependente
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Dependente
     */
    public function getFkPessoalDependente()
    {
        return $this->fkPessoalDependente;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCarteiraVacinacao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CarteiraVacinacao $fkPessoalCarteiraVacinacao
     * @return DependenteCarteiraVacinacao
     */
    public function setFkPessoalCarteiraVacinacao(\Urbem\CoreBundle\Entity\Pessoal\CarteiraVacinacao $fkPessoalCarteiraVacinacao)
    {
        $this->codCarteira = $fkPessoalCarteiraVacinacao->getCodCarteira();
        $this->fkPessoalCarteiraVacinacao = $fkPessoalCarteiraVacinacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCarteiraVacinacao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\CarteiraVacinacao
     */
    public function getFkPessoalCarteiraVacinacao()
    {
        return $this->fkPessoalCarteiraVacinacao;
    }
}
