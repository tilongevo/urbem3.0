<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * FormatoImportacao
 */
class FormatoImportacao
{
    /**
     * PK
     * @var integer
     */
    private $codFormato;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $referenciaCadastro;

    /**
     * @var string
     */
    private $formatoColunas;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\FormatoDelimitador
     */
    private $fkPontoFormatoDelimitador;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\FormatoTamanhoFixo
     */
    private $fkPontoFormatoTamanhoFixos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ImportacaoPontoErro
     */
    private $fkPontoImportacaoPontoErros;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ImportacaoPonto
     */
    private $fkPontoImportacaoPontos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPontoFormatoTamanhoFixos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoImportacaoPontoErros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoImportacaoPontos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFormato
     *
     * @param integer $codFormato
     * @return FormatoImportacao
     */
    public function setCodFormato($codFormato)
    {
        $this->codFormato = $codFormato;
        return $this;
    }

    /**
     * Get codFormato
     *
     * @return integer
     */
    public function getCodFormato()
    {
        return $this->codFormato;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return FormatoImportacao
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
     * Set referenciaCadastro
     *
     * @param string $referenciaCadastro
     * @return FormatoImportacao
     */
    public function setReferenciaCadastro($referenciaCadastro)
    {
        $this->referenciaCadastro = $referenciaCadastro;
        return $this;
    }

    /**
     * Get referenciaCadastro
     *
     * @return string
     */
    public function getReferenciaCadastro()
    {
        return $this->referenciaCadastro;
    }

    /**
     * Set formatoColunas
     *
     * @param string $formatoColunas
     * @return FormatoImportacao
     */
    public function setFormatoColunas($formatoColunas)
    {
        $this->formatoColunas = $formatoColunas;
        return $this;
    }

    /**
     * Get formatoColunas
     *
     * @return string
     */
    public function getFormatoColunas()
    {
        return $this->formatoColunas;
    }

    /**
     * OneToMany (owning side)
     * Add PontoFormatoTamanhoFixo
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FormatoTamanhoFixo $fkPontoFormatoTamanhoFixo
     * @return FormatoImportacao
     */
    public function addFkPontoFormatoTamanhoFixos(\Urbem\CoreBundle\Entity\Ponto\FormatoTamanhoFixo $fkPontoFormatoTamanhoFixo)
    {
        if (false === $this->fkPontoFormatoTamanhoFixos->contains($fkPontoFormatoTamanhoFixo)) {
            $fkPontoFormatoTamanhoFixo->setFkPontoFormatoImportacao($this);
            $this->fkPontoFormatoTamanhoFixos->add($fkPontoFormatoTamanhoFixo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoFormatoTamanhoFixo
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FormatoTamanhoFixo $fkPontoFormatoTamanhoFixo
     */
    public function removeFkPontoFormatoTamanhoFixos(\Urbem\CoreBundle\Entity\Ponto\FormatoTamanhoFixo $fkPontoFormatoTamanhoFixo)
    {
        $this->fkPontoFormatoTamanhoFixos->removeElement($fkPontoFormatoTamanhoFixo);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoFormatoTamanhoFixos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\FormatoTamanhoFixo
     */
    public function getFkPontoFormatoTamanhoFixos()
    {
        return $this->fkPontoFormatoTamanhoFixos;
    }

    /**
     * OneToMany (owning side)
     * Add PontoImportacaoPontoErro
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ImportacaoPontoErro $fkPontoImportacaoPontoErro
     * @return FormatoImportacao
     */
    public function addFkPontoImportacaoPontoErros(\Urbem\CoreBundle\Entity\Ponto\ImportacaoPontoErro $fkPontoImportacaoPontoErro)
    {
        if (false === $this->fkPontoImportacaoPontoErros->contains($fkPontoImportacaoPontoErro)) {
            $fkPontoImportacaoPontoErro->setFkPontoFormatoImportacao($this);
            $this->fkPontoImportacaoPontoErros->add($fkPontoImportacaoPontoErro);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoImportacaoPontoErro
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ImportacaoPontoErro $fkPontoImportacaoPontoErro
     */
    public function removeFkPontoImportacaoPontoErros(\Urbem\CoreBundle\Entity\Ponto\ImportacaoPontoErro $fkPontoImportacaoPontoErro)
    {
        $this->fkPontoImportacaoPontoErros->removeElement($fkPontoImportacaoPontoErro);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoImportacaoPontoErros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ImportacaoPontoErro
     */
    public function getFkPontoImportacaoPontoErros()
    {
        return $this->fkPontoImportacaoPontoErros;
    }

    /**
     * OneToMany (owning side)
     * Add PontoImportacaoPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ImportacaoPonto $fkPontoImportacaoPonto
     * @return FormatoImportacao
     */
    public function addFkPontoImportacaoPontos(\Urbem\CoreBundle\Entity\Ponto\ImportacaoPonto $fkPontoImportacaoPonto)
    {
        if (false === $this->fkPontoImportacaoPontos->contains($fkPontoImportacaoPonto)) {
            $fkPontoImportacaoPonto->setFkPontoFormatoImportacao($this);
            $this->fkPontoImportacaoPontos->add($fkPontoImportacaoPonto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoImportacaoPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ImportacaoPonto $fkPontoImportacaoPonto
     */
    public function removeFkPontoImportacaoPontos(\Urbem\CoreBundle\Entity\Ponto\ImportacaoPonto $fkPontoImportacaoPonto)
    {
        $this->fkPontoImportacaoPontos->removeElement($fkPontoImportacaoPonto);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoImportacaoPontos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ImportacaoPonto
     */
    public function getFkPontoImportacaoPontos()
    {
        return $this->fkPontoImportacaoPontos;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoFormatoDelimitador
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FormatoDelimitador $fkPontoFormatoDelimitador
     * @return FormatoImportacao
     */
    public function setFkPontoFormatoDelimitador(\Urbem\CoreBundle\Entity\Ponto\FormatoDelimitador $fkPontoFormatoDelimitador)
    {
        $fkPontoFormatoDelimitador->setFkPontoFormatoImportacao($this);
        $this->fkPontoFormatoDelimitador = $fkPontoFormatoDelimitador;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoFormatoDelimitador
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\FormatoDelimitador
     */
    public function getFkPontoFormatoDelimitador()
    {
        return $this->fkPontoFormatoDelimitador;
    }
}
