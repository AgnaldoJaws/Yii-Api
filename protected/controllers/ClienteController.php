<?php

class ClienteController extends Controller
{
    /**
    * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
    * using two-column layout. See 'protected/views/layouts/column2.php'.
    */
    public $layout='//layouts/main';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to access 'index' and 'view' actions.
                'actions'=>array('create','update','view','index','delete'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated users to access all actions
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /* Body:
      {
        "idEndereco":"11",       
        "nome":"agnaldo bernardo junior",
        "email":"agnaldo@codemaker.com.br"      
    }
    */
    public function actionCreate()
    {        
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
          
            //Criamos o model do cliente
            $model                 = new Cliente;      
            $model->idEndereco     = $data['idEndereco'];
            $model->nome           = $data['nome'];
            $model->email          = $data['email'];            
           
            // Validamos os dados de Cliente
            $valid = $model->validate();
           
            // Se todas as validações foram realizadas sem retorno de erro
            if($valid)
            {
                // Salvamos os dados do Cliente
                if($model->save())
                {
                    
                    $return = array(
                        "success" => true,
                        "message" => "Record Created",
                        "data"    => array(
                            "totalCount" => 1,
                            "cliente"    => array(
                                "id"              => $model->id,
                                "idEndereco"      => $model->idEndereco,
                                "nome"            => $model->nome,
                                "email"           => $model->email                               
                            )
                        )
                    );
                    header('HTTP/1.1 201 Record Created', true, 201);
                    echo json_encode($return, JSON_PRETTY_PRINT);
                }
                else
                {
                    echo Api::internalServerError();
                }

            // Se retornou algum erro na validação
            } else {

                $i = 0;

                if($model->errors)
                {
                    $errors[$i++] = $model->errors;
                }

                if(isset($modelEndereco))
                {
                    foreach ($modelEndereco as $key => $endereco) {
                        if($endereco->errors)
                            $errors[$i++] = $endereco->errors;
                    }
                }

                $return = array(
                    "success" => false,
                    "message" => CJSON::encode($errors),
                    "data"    => array(
                        "errorCode" => 400,
                        "message"   => CJSON::encode($errors)
                    )
                );

                header('HTTP/1.1 400 ' . CJSON::encode($errors), true, 400);
                echo json_encode($return, JSON_PRETTY_PRINT);
            }
        
        
    }

    
    public function actionUpdate()
    {

        
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            $model = Cliente::model()->findByAttributes(array('id'=>$_GET['id']));

            if($model)
            {

            $model->idEndereco     = isset($data['idEndereco'])? $data['idEndereco'] : $model->idEndereco;
            $model->nome           = isset($data['nome'])? $data['nome'] : $model->nome;
            $model->email          = isset($data['email'])? $data['email'] : $model->email;              
                

                // Validamos os dados de Cliente
                $valid = $model->validate();
                

                // Se todas as validações foram realizadas sem retorno de erro
                if($valid)
                {
                    // Salvamos os dados do Cliente
                    if($model->save())
                    {
                       
                       
                        $return = array(
                            "success" => true,
                            "message" => "Record Updated",
                            "data"    => array(
                                "totalCount" => 1,
                                "cliente"    => array(
                                    "id"              => $model->id,
                                    "idEndereco"  => $model->idEndereco,
                                    "nome"      => $model->nome,
                                    "email"         => $model->email                                  
                                )
                            )
                        );
                        header('HTTP/1.1 200 Record Updated', true, 200);
                        echo json_encode($return, JSON_PRETTY_PRINT);
                    }
                    else
                    {
                        echo Api::internalServerError();
                    }

                // Se retornou algum erro na validação
                } else {

                    $i = 0;

                    if($model->errors)
                    {
                        $errors[$i++] = $model->errors;
                    }

                    if(isset($modelEndereco))
                    {
                        foreach ($modelEndereco as $key => $endereco) {
                            if($endereco->errors)
                                $errors[$i++] = $endereco->errors;
                        }
                    }

                    $return = array(
                        "success" => false,
                        "message" => CJSON::encode($errors),
                        "data"    => array(
                            "errorCode" => 400,
                            "message"   => CJSON::encode($errors)
                        )
                    );

                    header('HTTP/1.1 400 ' . CJSON::encode($errors), true, 400);
                    echo json_encode($return, JSON_PRETTY_PRINT);
                }
            }
        
        
    }

    public function actionView()
    {


        
    $model = Cliente::model()->findByAttributes(array('id'=>$_GET['id']));

            if($model)
            {
                
                $return = array(
                    "success" => true,
                    "message" => "Record Found",
                    "data"    => array(
                        "totalCount" => 1,
                        "cliente"    => array(
                            "id"              => $model->id,
                            "idEndereco"  => $model->idEndereco,
                            "nome"      => $model->nome,
                            "email"         => $model->email
                            
                        )
                    )
                );
                header('HTTP/1.1 200 Record Found', true, 200);
                echo json_encode($return, JSON_PRETTY_PRINT);
            }
            else
            {
                echo Api::notFound();
            }
        
        


    }

    public function actionIndex()
    {

        

             $model = Cliente::model()->findAll();

            if($model)
            {
                // Criamos um array para receber os dados dos clientes
                $cliente = array();

                foreach ($model as $i => $cli)
                {
                        $cliente[$i] = array(
                        "id"              => $cli->id,
                        "idEndereco"  => $cli->idEndereco,
                        "nome"      => $cli->nome,
                        "email"         => $cli->email                        
                    );
                }

                $return = array(
                    "success" => true,
                    "message" => "Record(s) Found",
                    "data"    => array(
                        "totalCount" => count($model),
                        "cliente"    => $cliente
                    )
                );
                header('HTTP/1.1 200 Record Found', true, 200);
                echo json_encode($return, JSON_PRETTY_PRINT);
            }
            else
            {
                echo Api::notFound();
            }
        
        
    }

    /**
    * Deletes a particular model.
    * If deletion is successful, the browser will be redirected to the 'admin' page.
    * @param integer $id the ID of the model to be deleted
    */
    public function actionDelete()
    {
        echo Api::internalServerError();
    }

    /**
    * Deletes a particular model.
    * If deletion is successful, the browser will be redirected to the 'admin' page.
    * @param integer $id the ID of the model to be deleted
    */
    /*public function actionDelete()
    {
        if(Api::model()->_checkAuth())
        {
            // Buscamos pelo registro no banco e dados
            $model = Cliente::model()->findByAttributes(array('id'=>$_GET['id'], 'idLoja'=>LOJA_ID));

            // Se encontramos o registro
            if($model)
            {
                // Se existem endereços, preparamos o array para retornarmos o endereço na chamada da API
                if($model->enderecos)
                {
                    // Criamos um array para receber os dados dos endereços
                    $enderecos = array();

                    foreach ($model->enderecos as $key => $endereco)
                    {
                        $enderecos[$key]['tipo']        = $endereco->tipo;
                        $enderecos[$key]['logradouro']  = $endereco->logradouro;
                        $enderecos[$key]['numero']      = $endereco->numero;
                        $enderecos[$key]['complemento'] = $endereco->complemento;
                        $enderecos[$key]['bairro']      = $endereco->bairro;
                        $enderecos[$key]['cidade']      = $endereco->cidade;
                        $enderecos[$key]['estado']      = $endereco->estado;
                        $enderecos[$key]['cep']         = $endereco->cep;
                    }
                } else {
                    $enderecos = NULL;
                }

                if($model->delete())
                {
                    $return = array(
                        "success" => true,
                        "message" => "Record Deleted",
                        "data"    => array(
                            "totalCount" => 1,
                            "cliente"    => array(
                                "id"              => $model->id,
                                "idClienteGrupo"  => $model->idClienteGrupo,
                                "tipoPessoa"      => $model->tipoPessoa,
                                "cnpjCpf"         => $model->cnpjCpf,
                                "ieRg"            => $model->ieRg,
                                "nome"            => $model->nome,
                                "email"           => $model->email,
                                "telefone"        => $model->telefone,
                                "celular"         => $model->celular,
                                "sexo"            => $model->sexo,
                                "dataNascimento"  => $model->dataNascimento,
                                "informativo"     => $model->informativo,
                                "status"          => $model->status,
                                "dataCadastro"    => $model->dataCadastro,
                                "dataModificacao" => $model->dataModificacao,
                                "enderecos"       => $enderecos
                            )
                        )
                    );
                    header('HTTP/1.1 200 Record Deleted', true, 200);
                    echo json_encode($return, JSON_PRETTY_PRINT);
                }
                else
                {
                    echo Api::internalServerError();
                }
            }
            else
            {
                echo Api::notFound();
            }
        }
        else
        {
            echo Api::unauthorized();
        }
    }*/
}