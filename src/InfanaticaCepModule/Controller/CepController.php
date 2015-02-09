<?php
namespace InfanaticaCepModule\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use InfanaticaCepModule\Service\CepService;
use Zend\Http\Response;
class CepController extends AbstractActionController
{
    /** @var  CepService */
    protected $cepService;

    /** @var  Response */
    protected $httpResponse;

    public function __construct(CepService $cepService, Response $httpResponse)
    {
        $this->cepService = $cepService;
        $this->httpResponse = $httpResponse;
    }

    public function indexAction()
    {

        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function getEnderecobyCepAction()
    {

        $cep = $this->params()->fromRoute('cep');
        $formato = $this->params()->fromRoute('formato');
        try {
            $endereco = $this->cepService->getEnderecoByCep($cep,$formato);
            return $this->responseEnderecoComFormatado($endereco, $formato);
        } catch(\Exception $e){
            $response = $this->httpResponse;
            $mensagem = $e->getMessage();
            $response->setContent($mensagem);
            return $response;
        }




    }

    private function responseEnderecoComFormatado($endereco, $formato)
    {
        $arrayFormatos = array(
            'xml'=>'text/xml; charset=utf-8',
            'json'=>
        );
        $response = $this->httpResponse;
        $response->getHeaders()->addHeaderLine('Content-Type', 'text/xml; charset=utf-8');

    }
}