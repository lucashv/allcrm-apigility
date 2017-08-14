<?php

namespace crm\V1\Rest\Plantoes;


use crm\Entity\Plantoes;
use crm\V1\Rest\AbstractService\AbstractService;
use crm\V1\Rest\DateTime\DateTime;
use ZF\ApiProblem\ApiProblem;


class PlantoesService extends AbstractService
{
    protected $tiposPlantoes;
    protected $usuariosRepository;
    protected $abstractPlantoesFactory;

    public function __construct($em,$hydrator, Plantoes $plantoesEntity, AbstractPlantaoFactory $abstractPlantoesFactory)
    {
        $this->em                = $em;
        $this->hydrator          = $hydrator;
        $this->plantoesEntity    = $plantoesEntity;
        $this->repository        = 'crm\Entity\Plantoes';
        $this->usuariosRepository  = 'crm\Entity\Usuarios';
        $this->abstractPlantoesFactory = $abstractPlantoesFactory;
        $this->tiposPlantoes = array(
                                        'saude'      => 1,
                                        'odonto'     => 2,
                                        'presencial' => 3
                                    );
    }

    public function create($data)
    {

        $novoPlantao = $this->abstractPlantoesFactory->create($data);
        $this->em->persist($novoPlantao);

        try {
            $this->em->flush();
            return $this->extract( $novoPlantao );
        } catch (Exception $e) {
            echo(var_dump($e->getMessage()));
            return false;
        }
    }

    /**
     * Retornar os corretores no plantao de acordo com o tipo
     * @param $tipo
     * @return array|ApiProblem
     */
    public function fetchPlantaoDiario($tipo)
    {

        $data = DateTime::getDataAtualMySql();


        $query = "
                  SELECT
                   p,
                   u
                  FROM {$this->repository} p
                  JOIN p.usuarioCorretor u
                  WHERE p.dataCriacao
                  BETWEEN '{$data} 00:08:00' AND  '{$data} 23:59:59'
                  AND
                    p.tipo = {$this->tiposPlantoes[$tipo]}
                  AND
                    p.status = true and u.status = true
                  ORDER BY p.ultimoEnvio, p.posicao ASC";

        //Não valida o plantao do dia.
        if( $tipo != 'saude' )
        {

            $query = "      SELECT
                             p,
                             u
                            FROM {$this->repository} p
                            JOIN
                              p.usuarioCorretor u
                            WHERE
                              p.tipo = {$this->tiposPlantoes[$tipo]}
                            AND
                              p.status = true and u.status = true
                            ORDER BY
                              p.ultimoEnvio, p.posicao ASC";
        }


        $query = $this->em->createQuery($query);


        $plantoes = $query->getResult();

        if(!empty($plantoes[0])) {
            return $this->extractAll($plantoes);
        }
        return new ApiProblem(404, 'Sem plantoes cadastrados');
    }

    public function getPlantaoDia()
    {
        $data = DateTime::getDataAtualMySql();
        $qb = $this->em->createQueryBuilder();

        $qb->select('u.bloqueado, u.dataCriacao, IDENTITY(u.filial) as filialPlantao, IDENTITY(u.tipo) as tipoPlantao')
            ->from($this->repository, 'u')
            ->add('where', $qb->expr()->between(
                                        'u.dataCriacao',
                                        ':de',
                                        ':ate'
                )
            )
            ->setParameters(array('de' => "{$data} 00:08:00", 'ate' => "{$data} 17:59:59"));

        $query = $qb->getQuery();
        $results = $query->getResult();

        if(!is_null($results)) {
            return  $results;
        }
        return new ApiProblem('404', "Recursos não localizados");
    }

    /**
     * Pesquisa os corretores habeis a entrar no plantão
     * @param $nome
     * @return array|bool|ApiProblem
     */
    private function getCorretoresPlantao($nome)
    {

        if(!$nome) {
            return $this->fetchAll();
        }

        $qb    = $this->em->createQueryBuilder();

        $qb->select('p')
            ->from('crm\Entity\Usuarios', 'p')
            ->where($qb->expr()->eq('p.perfil', '2'))
            ->andWhere($qb->expr()->eq('p.status', '1'));

        if(isset($nome)) {
            $qb->andWhere(  $qb->expr()->like('p.nome',      ':nome'));
        }
        $qb->setParameter('nome', "%{$nome}%");
        $results = $qb->getQuery()->getResult();

        if(!is_null($results) || !empty($results)) {
            return $this->extractAll($results);
        }
        return new ApiProblem('404', "Recursos não localizados");
    }

    public function fetchByParams($params){


        if($params->tipo === 'saude') {
            return $this->fetchPlantaoDiario('saude');
        }

        if($params->tipo === 'odonto') {
            return $this->fetchPlantaoDiario('odonto');
        }

        if($params->tipo === 'presencial') {
            return $this->fetchPlantaoDiario('presencial');
        }

        if($params->tipo == 'nome') {
            return $this->getCorretoresPlantao($params->termo);
        }

        if($params->tipo === 'posicao') {
            return $this->em->getRepository($this->repository)->getByPosicao($params);
        }

        return $this->em->getRepository($this->repository)->getCorretoresTodosPlantoes();

    }

    public function fetchAll()
    {
        $query = $this->em->createQuery('SELECT u FROM '.$this->usuariosRepository.' u where u.status = 1 AND u.perfil = 2');
        $results = $query->getResult();
        if(!is_null($results)) {
            return $this->extractAll( $results );
        }
        return new ApiProblem('404', "Recurso não localizado");
    }

    public function update($id,$data)
    {

        if($data->tipoUpdate === 'perdeuLigacao')
        {
            return $this->perdeuLigacao($id,$data);
        }

        if($data->tipoUpdate === 'bloqueio')
        {
            return $this->atualizaBloquei($id,$data);
        }

        if($data->tipoUpdate === 'inativa')
        {
            return $this->inativa($id,$data);
        }

        if($data->tipoUpdate === 'addReposicao')
        {
            return $this->addReposicao($id);
        }

        if($data->tipoUpdate === 'removeReposicao')
        {
            return $this->pagaReposicao($id);
        }

        if($data->tipoUpdate === 'dataUltimoEnvio') {
            return $this->atualizaDataUltimoEnvio($id, $data);
        }

    }

    public function atualizaDataUltimoEnvio($id,$data)
    {
        $this->plantoesEntity = $this->em->getReference($this->repository, $id);
        $this->plantoesEntity->setUltimoEnvio($this->getDataAtual());
        $this->plantoesEntity->setDataEdicao($this->getDataAtual());
        $this->em->persist($this->plantoesEntity);

        try{
            $this->em->flush();
            return $this->extract($this->plantoesEntity);
        }catch (\Exception $e) {
            die(var_dump($e->getMessage()));
        }

    }

    public function pagaReposicao($id)
    {
        $this->plantoesEntity = $this->em->getReference($this->repository, $id);
        $this->em->persist($this->plantoesEntity);
        $reposicaoes = $this->plantoesEntity->getReposicao();
        $reposicaoes = --$reposicaoes;
        $this->plantoesEntity->setReposicao($reposicaoes);
        $this->plantoesEntity->setDataEdicao($this->getDataAtual());
        try{
            $this->em->flush();
            return $this->extract($this->plantoesEntity);
        }catch (\Exception $e) {
            die(var_dump($e->getMessage()));
        }

    }

    public function perdeuLigacao($id,$data)
    {
        $this->plantoesEntity = $this->em->getReference($this->repository, $id);
        $this->em->persist($this->plantoesEntity);
        $this->plantoesEntity->setUltimoEnvio($this->getDataAtual());
        $this->plantoesEntity->setLigacoesPerdidas($this->plantoesEntity->getLigacoesPerdidas() + 1);

        try{
            $this->em->flush();
            return $this->extract($this->plantoesEntity);
        }catch (\Exception $e) {
            die(var_dump($e->getMessage()));
        }
    }

    public function atualizaBloquei($id, $data)
    {
        $this->plantoesEntity = $this->em->getReference($this->repository, $id);
        $this->em->persist($this->plantoesEntity);
        $this->plantoesEntity->setBloqueado(!$this->plantoesEntity->getBloqueado());
        try{
            $this->em->flush();
            return $this->extract($this->plantoesEntity);
        }catch (\Exception $e) {
            die(var_dump($e->getMessage()));
        }
    }

    public function delete($data)
    {   //Delete todos os plantoes de acordo com o tipo;
        return $this->em->getRepository($this->repository)->delete($data);
    }

    public function inativa ($id,$data)
    {
        $this->plantoesEntity = $this->em->getReference($this->repository, $id);

        $this->em->persist($this->plantoesEntity);
        $this->plantoesEntity->setStatus(false);
        $this->plantoesEntity->setDataEdicao($this->getDataAtual());
        try{
            $this->em->flush();
            return $this->extract($this->plantoesEntity);
        }catch (\Exception $e) {
            die(var_dump($e->getMessage()));
        }

    }

    public function addReposicao($id)
    {
        $this->plantoesEntity = $this->em->getReference($this->repository, $id);
        $reposicaoes = $this->plantoesEntity->getReposicao();
        $reposicaoes = ++$reposicaoes;
        $this->plantoesEntity->setReposicao($reposicaoes);

        $this->em->persist($this->plantoesEntity);
        $this->plantoesEntity->setDataEdicao($this->getDataAtual());
        try{
            $this->em->flush();
            return $this->extract($this->plantoesEntity);
        }catch (\Exception $e) {
            die(var_dump($e->getMessage()));
        }

    }

}