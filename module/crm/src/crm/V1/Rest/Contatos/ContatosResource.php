<?php
namespace crm\V1\Rest\Contatos;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;


class ContatosResource extends AbstractResourceListener
{
    /**
     * @var \crm\V1\Rest\Contatos\ContatosService
     */
    protected $contatoService;

    public function __construct(ContatosService $contatoService)
    {
        $this->contatoService = $contatoService;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return $this->contatoService->create($data);
        return new ApiProblem(405, 'The POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return $this->contatoService->getById($id);
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        $contato = null;


        //Separar o servi�o
        if ( $params->tipo == "nome" )
        {
            $contato =  $this->contatoService->getByNome($params);
        }

        if( $params->tipo == "email" )
        {
            $contato = $this->contatoService->getByEmail($params);
        }

        if($params->tipo == "telefone")
        {
            $contato  = $this->contatoService->getByFone($params);
        }

        if($params->tipo == 'relatorioLigacao') {
            $contato  = $this->contatoService->getRelatorioLigacoes($params);
        }

        if(is_null($contato))
        {
            return $this->contatoService->fetchAll();
        }

        if(is_null($contato))
        {
            return new ApiProblem(404, "Recurso n�o localizado");
        }

        return $contato;


    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return $this->contatoService->update($id,$data);
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
