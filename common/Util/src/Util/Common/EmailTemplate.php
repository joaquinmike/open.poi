<?php

namespace Util\Common;

use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver;

class EmailTemplate
{
    private $_renderer;
    private $_dir;

    public function __construct()
    {
        $this->_dir = __DIR__ . '/../../../view/util/mail/';

        $this->_renderer = new PhpRenderer();

        $map = new Resolver\TemplateMapResolver($this->_getMap());

        $resolver = new Resolver\TemplateMapResolver($map);

        $this->_renderer->setResolver($resolver);
    }

    public function getApplicationExceptionTemplate(\Exception $e)
    {
        $model = new ViewModel();
        $model->setVariable('exception', $e);
        $model->setTemplate('exception-template');

        return $this->_renderer->render($model);
    }

    public function getLogicalExceptionTemplate(\Exception $e)
    {
        $model = new ViewModel();
        $model->setVariable('exception', $e);
        $model->setTemplate('logical-template');

        return $this->_renderer->render($model);
    }

    public function getDebugTemplate($data, $e)
    {
        $model = new ViewModel();
        $model->setVariable('exception', $e);
        $model->setVariable('data', $data);
        $model->setTemplate('debug-template');

        return $this->_renderer->render($model);
    }

    private function _getMap()
    {
        return array(
            'exception-template' => "{$this->_dir}/error.phtml",
            'logical-template' => "{$this->_dir}/logical.phtml",
            'debug-template' => "{$this->_dir}/debug.phtml",
        );
    }

}