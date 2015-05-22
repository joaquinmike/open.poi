<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Util\Controller\BaseController;
use Zend\View\Model\ViewModel;


class IndexController extends BaseController
{
    public function indexAction()
    {
        $userId = $this->layout()->dataUser['us_id'];
        $userEmail = $this->layout()->dataUser['us_email'];
        return new ViewModel(array(
            'userId' => $userId,
            'userEmail' => $userEmail,
        ));
    }
}
