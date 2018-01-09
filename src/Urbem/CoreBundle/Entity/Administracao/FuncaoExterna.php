<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * FuncaoExterna
 */
class FuncaoExterna
{
    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * PK
     * @var integer
     */
    private $codBiblioteca;

    /**
     * PK
     * @var integer
     */
    private $codFuncao;

    /**
     * @var string
     */
    private $comentario;

    /**
     * @var string
     */
    private $corpoPl;

    /**
     * @var string
     */
    private $corpoLn = '';

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    private $fkAdministracaoFuncao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\FuncaoReferencia
     */
    private $fkAdministracaoFuncaoReferencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\CorpoFuncaoExterna
     */
    private $fkAdministracaoCorpoFuncaoExternas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoFuncaoReferencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoCorpoFuncaoExternas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return FuncaoExterna
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set codBiblioteca
     *
     * @param integer $codBiblioteca
     * @return FuncaoExterna
     */
    public function setCodBiblioteca($codBiblioteca)
    {
        $this->codBiblioteca = $codBiblioteca;
        return $this;
    }

    /**
     * Get codBiblioteca
     *
     * @return integer
     */
    public function getCodBiblioteca()
    {
        return $this->codBiblioteca;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return FuncaoExterna
     */
    public function setCodFuncao($codFuncao)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     * @return FuncaoExterna
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
        return $this;
    }

    /**
     * Get comentario
     *
     * @return string
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set corpoPl
     *
     * @param string $corpoPl
     * @return FuncaoExterna
     */
    public function setCorpoPl($corpoPl = null)
    {
        $this->corpoPl = $corpoPl;
        return $this;
    }

    /**
     * Get corpoPl
     *
     * @return string
     */
    public function getCorpoPl()
    {
        return $this->corpoPl;
    }

    /**
     * Set corpoLn
     *
     * @param string $corpoLn
     * @return FuncaoExterna
     */
    public function setCorpoLn($corpoLn = null)
    {
        $this->corpoLn = $corpoLn;
        return $this;
    }

    /**
     * Get corpoLn
     *
     * @return string
     */
    public function getCorpoLn()
    {
        return $this->corpoLn;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoFuncaoReferencia
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\FuncaoReferencia $fkAdministracaoFuncaoReferencia
     * @return FuncaoExterna
     */
    public function addFkAdministracaoFuncaoReferencias(\Urbem\CoreBundle\Entity\Administracao\FuncaoReferencia $fkAdministracaoFuncaoReferencia)
    {
        if (false === $this->fkAdministracaoFuncaoReferencias->contains($fkAdministracaoFuncaoReferencia)) {
            $fkAdministracaoFuncaoReferencia->setFkAdministracaoFuncaoExterna($this);
            $this->fkAdministracaoFuncaoReferencias->add($fkAdministracaoFuncaoReferencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoFuncaoReferencia
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\FuncaoReferencia $fkAdministracaoFuncaoReferencia
     */
    public function removeFkAdministracaoFuncaoReferencias(\Urbem\CoreBundle\Entity\Administracao\FuncaoReferencia $fkAdministracaoFuncaoReferencia)
    {
        $this->fkAdministracaoFuncaoReferencias->removeElement($fkAdministracaoFuncaoReferencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoFuncaoReferencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\FuncaoReferencia
     */
    public function getFkAdministracaoFuncaoReferencias()
    {
        return $this->fkAdministracaoFuncaoReferencias;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoCorpoFuncaoExterna
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\CorpoFuncaoExterna $fkAdministracaoCorpoFuncaoExterna
     * @return FuncaoExterna
     */
    public function addFkAdministracaoCorpoFuncaoExternas(\Urbem\CoreBundle\Entity\Administracao\CorpoFuncaoExterna $fkAdministracaoCorpoFuncaoExterna)
    {
        if (false === $this->fkAdministracaoCorpoFuncaoExternas->contains($fkAdministracaoCorpoFuncaoExterna)) {
            $fkAdministracaoCorpoFuncaoExterna->setFkAdministracaoFuncaoExterna($this);
            $this->fkAdministracaoCorpoFuncaoExternas->add($fkAdministracaoCorpoFuncaoExterna);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoCorpoFuncaoExterna
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\CorpoFuncaoExterna $fkAdministracaoCorpoFuncaoExterna
     */
    public function removeFkAdministracaoCorpoFuncaoExternas(\Urbem\CoreBundle\Entity\Administracao\CorpoFuncaoExterna $fkAdministracaoCorpoFuncaoExterna)
    {
        $this->fkAdministracaoCorpoFuncaoExternas->removeElement($fkAdministracaoCorpoFuncaoExterna);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoCorpoFuncaoExternas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\CorpoFuncaoExterna
     */
    public function getFkAdministracaoCorpoFuncaoExternas()
    {
        return $this->fkAdministracaoCorpoFuncaoExternas;
    }

    /**
     * OneToOne (owning side)
     * Set AdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     * @return FuncaoExterna
     */
    public function setFkAdministracaoFuncao(\Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao)
    {
        $this->codModulo = $fkAdministracaoFuncao->getCodModulo();
        $this->codBiblioteca = $fkAdministracaoFuncao->getCodBiblioteca();
        $this->codFuncao = $fkAdministracaoFuncao->getCodFuncao();
        $this->fkAdministracaoFuncao = $fkAdministracaoFuncao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkAdministracaoFuncao
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    public function getFkAdministracaoFuncao()
    {
        return $this->fkAdministracaoFuncao;
    }
}
